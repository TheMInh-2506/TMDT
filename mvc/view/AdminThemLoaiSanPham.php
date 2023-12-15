<!doctype html>
<html lang="en">

<head>
  <title><?php echo $title; ?></title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body style="background-image: radial-gradient(#b3b3b3, #ffffff);">

  <div style="width: 30%;margin-left: 35%;font-size: 1.5rem;background-color: white;padding: 2rem;border-radius: 1rem;color:#0066cc;margin-top: 2rem;">
    <h2 style="width: 100%;color: #0066cc;font-weight: 600;">Thêm Loại Sản Phẩm</h2>
    <input type="file" name="readfile" class="form-control-file" id="readFromFile" style="width: auto;margin-bottom: 1rem;" multiple>

    <div class="form-group">
      <label for="exampleInputEmail1">Tên Loại Sản Phẩm</label>
      <input type="text" class="form-control" id="nameTypeProduct">
    </div>
    <label for="exampleInputEmail1">Mô Tả</label>
    <textarea id="descriptionTypeProduct" style="width: 100%;" rows="10"></textarea>

    <a href="/CuaHangNoiThat/Admin/LoaiSanPham">
      <button type="submit" class="btn btn-primary" style="background-color: white;color: #0066cc;font-size: 1.5rem;margin-top: 2rem;">Trở về </button>
    </a>
    <button onclick="addNewTypeProduct();" type="submit" class="btn btn-primary" style="background-color: #0066cc;color: white;font-size: 1.5rem;margin-top: 2rem;float: right;">Thêm Loại Sản Phẩm</button>
  </div>

  <script>
    function addNewTypeProduct() {
      $nameTypeProduct = $("#nameTypeProduct").val();
      $descriptionTypeProduct = $("#descriptionTypeProduct").val();

      if ($nameTypeProduct == '') {
        alert('Tên loại sản phẩm không được để trống');
        return;
      }

      if ($descriptionTypeProduct == '') {
        alert('Mô tả loại sản phẩm không được để trống');
        return;
      }

      $obj = {
        'TENLOAI': $nameTypeProduct,
        'MOTA': $descriptionTypeProduct
      }

      $.ajax({
        url: '/CuaHangNoiThat/Admin/addNewTypeProduct',
        data: {
          data: $obj
        },
        method: 'post',
        success: function(data) {
          if (data == 0) {
            alert("Thêm thành công");
          } else {
            alert("Không thể Thêm");
          }
        }
      });
    }

    $(document).ready(function() {
      $("#readFromFile").change(function() {
        $file = $("#readFromFile").val();
        $extension = $file.substring($file.length - 4);
        if ($extension != 'xlsx') {
          alert('Chỉ chấp nhận file excel (.xlsx)');
          $("#readFromFile").val("");
          return;
        }
        var file_data = $('#readFromFile').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        $.ajax({
          url: '/CuaHangNoiThat/Admin/readExcelTypeProduct',
          cache: false,
          contentType: false,
          processData: false,
          data: form_data,
          type: 'post',
          success: function(data) {
            var data = JSON.parse(data);
            var dataDB = data['dataDB'];
            data = data['data'];

            for (var key in data) {
              $obj = data[key];
              //Kiem tra xem ma loai SP da ton tai hay chua
              $check = false;
              for (var subkey in dataDB) {
                $subobj = dataDB[subkey];
                if ($obj.MALOAI.localeCompare($subobj.MALOAI) == 0) {
                  $check = true;
                  break;
                }
              }
              if ($check) {
                $sms = 'Loại sản phẩm này đã tồn tại trong cơ sở dữ liệu\nBạn có muốn ghi đè:\n' +
                  '{' + $subobj.MALOAI + ',' + $subobj.TENLOAI + ',' + $subobj.MOTA + '}' +
                  '\nThành : \n' +
                  '{' + $obj.MALOAI + ',' + $obj.TENLOAI + ',' + $obj.MOTA + '}' +
                  '\nhay không ?';

                if (confirm($sms)) {
                  updateInfoTypeProduct($subobj);
                }
              } else {
                // Thong bao them moi
                $sms = 'Bạn có muốn thêm mới Loại sản phẩm này hay không ?\n' +
                  '{' + $obj.MALOAI + ',' + $obj.TENLOAI + ',' + $obj.MOTA + '}';

                if (confirm($sms)) {
                  addNewTypeProduct($obj);
                }
              }
            }
            $("#readFromFile").val("");
          }
        });
      });
    });


    function updateInfoTypeProduct($subobj) {
      $.ajax({
        url: '/CuaHangNoiThat/Admin/updateInformationProductType/'+$subobj,
        data: {
          data: $obj
        },
        method: 'post'
      });
    }

    function addNewTypeProduct($obj) {
      
      $.ajax({
        url: '/CuaHangNoiThat/Admin/addNewTypeProduct/'+$obj,
        data: {
          data: $obj
        },
        method: 'post'
      });
    }
  </script>
</body>

</html>