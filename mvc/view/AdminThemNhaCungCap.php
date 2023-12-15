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
    <h2 style="width: 100%;color: #0066cc;font-weight: 600;">Thêm Nhà Cung Cấp</h2>
    <input type="file" name="readfile" class="form-control-file" id="readDetailFromFile" style="width: auto;margin-bottom: 1rem;" multiple>
    <div class="form-group">
      <label for="exampleInputEmail1">Tên Nhà Cung Cấp</label>
      <input type="text" class="form-control" id="nameSupplier">
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Địa Chỉ</label>
      <input type="text" class="form-control" id="addressSupllier">
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">SĐT</label>
      <input type="text" class="form-control" id="phoneSupplier">
    </div>


    <a href="/CuaHangNoiThat/Admin/NhaCungCap">
      <button type="submit" class="btn btn-primary" style="background-color: white;color: #0066cc;font-size: 1.5rem;margin-top: 2rem;">Trở về </button>
    </a>
    <button onclick="addNewSupplier();" type="submit" class="btn btn-primary" style="background-color: #0066cc;color: white;font-size: 1.5rem;margin-top: 2rem;float: right;">Thêm Nhà Cung Cấp</button>
  </div>
  <script>
    function addNewSupplier() {
      $nameSupplier = $("#nameSupplier").val();
      $addressSupplier = $("#addressSupllier").val();
      $phoneSupplier = $("#phoneSupplier").val();

      //Check valid input
      if ($nameSupplier == '') {
        alert("Vui lòng nhập tên nhà cung cấp");
        $("#nameSupplier").focus();
        return;
      } else if ($addressSupplier == '') {
        alert("Vui lòng nhập địa chỉ nhà cung cấp");
        $("#addressSupplier").focus();
        return;
      } else if ($phoneSupplier == '') {
        alert("Vui lòng nhập SĐT nhà cung cấp");
        $("#phoneSupplier").focus();
        return;
      } else if (!checkPhoneNumber($phoneSupplier)) {
        alert("SĐT nhà cung cấp không hợp lệ. SĐt phải có độ dài từ 10-11 số, bắt đầu bằng số 0 và chỉ chứa chữ số");
        $("#phoneSupplier").focus();
        return;
      }
      $objSupplier = {
        'TENNCC': $nameSupplier,
        'DIACHI': $addressSupplier,
        'SDT': $phoneSupplier
      };
      $.ajax({
        url: '/CuaHangNoiThat/Admin/addNewSupplier',
        data: {
          data: $objSupplier
        },
        method: 'post',
        success: function(data) {
          if (data == 0) {
            alert("Thêm NCC thành công");
          } else {
            alert("Không thể thêm");
          }
        }
      });
    }

    $(document).ready(function() {
      $("#readDetailFromFile").change(function() {
        $file = $("#readDetailFromFile").val();
        $extension = $file.substring($file.length - 4);
        if ($extension != 'xlsx') {
          alert('Chỉ chấp nhận file excel (.xlsx)');
          return;
        }
        var file_data = $('#readDetailFromFile').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        $.ajax({
          url: '/CuaHangNoiThat/Admin/readExcelSupplier',
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
              $check = false;
              
              for(var subkey in dataDB){
                $subobj = dataDB[subkey];
                if($obj.MANCC.localeCompare($subobj.MANCC) == 0){
                  $check = true;
                  break;
                }
              }

              //Neu da ton tai NCC
              if($check){
                $sms = 'Nhà cung cấp này đã tồn tại trong cơ sở dữ liệu\nBạn có muốn ghi đè:\n' +
                  '{' + $subobj.MANCC + ',' + $subobj.TENNCC + ',' + $subobj.DIACHI + ',' + $subobj.SDT + '}' +
                  '\nThành : \n' +
                  '{' + $obj.MANCC + ',' + $obj.TENNCC + ',' + $obj.DIACHI + ',' + $obj.SDT + '}' +
                  '\nhay không ?';

                if (confirm($sms)) {
                  updateSupplier_wtihData($obj);
                }
              }
              else{
                $sms = 'Bạn có muốn thêm mới NCC này hay không ?\n' +
                '{' + $obj.MANCC + ',' + $obj.TENNCC + ',' + $obj.DIACHI + ',' + $obj.SDT + '}';

                if (confirm($sms)) {
                  addNewSupplier_wtihData($obj);
                }
              }
            }
            $("#readDetailFromFile").val("");
            
          }
        });
      });
    });

    function addNewSupplier_wtihData($obj) {
      $.ajax({
        url: '/CuaHangNoiThat/Admin/addNewSupplier',
        data: {
          data: $obj
        },
        method: 'post',
        success: function(data) {
          if (data == 0) {
            return true;
          } else {
            return false;
          }
        }
      });
    }

    function updateSupplier_wtihData($obj) {
      $.ajax({
        url: '/CuaHangNoiThat/Admin/updateInformationSupplier',
        data: {
          data: $obj
        },
        method: 'post',
        success: function(data) {
          if (data == 0) {
            return true;
          } else {
            return false;
          }
        }
      });
    }
  </script>
</body>

</html>