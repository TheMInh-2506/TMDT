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
    <h2 style="width: 100%;text-align: center;color: #0066cc;font-weight: 600;">Thêm Nhân Viên</h2>
    <input type="file" name="readfile" class="form-control-file" id="readDetailFromFile" style="width: auto;margin-bottom: 1rem;" multiple>
    <div class="form-group">
      <label for="exampleInputEmail1">Tên nhân viên</label>
      <input type="text" class="form-control" id="nameStaff" value="">
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Ngày Sinh</label>
      <input type="date" class="form-control" id="birthdayStaff" value="">
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Giới Tính</label>
      <select class="form-control" id="sexStaff">
        <option value="Nam">Nam</option>
        <option value="Nữ">Nữ</option>
      </select>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Địa Chỉ</label>
      <input type="text" class="form-control" id="addressStaff" value="">
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">SĐT</label>
      <input type="text" class="form-control" id="phoneStaff" value="">
    </div>
    
    <div class="form-group">
      <label for="exampleInputEmail1">Tên đăng nhập</label>
      <input type="text" class="form-control" id="usernameStaff" value="">
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Mật khẩu</label>
      <input type="text" class="form-control" id="passwordStaff" value="">
    </div>

    <a href="/CuaHangNoiThat/Admin/NhanVien">
      <button type="submit" class="btn btn-primary" style="background-color: white;color: #0066cc;font-size: 1.5rem;margin-top: 2rem;">Trở về </button>
    </a>
    <button onclick="addNewStaff();" type="submit" class="btn btn-primary" style="background-color: #0066cc;color: white;font-size: 1.5rem;margin-top: 2rem;float: right;">Thêm Nhân Viên</button>
  </div>
  <script>
    function addNewStaff() {
      $nameStaff = $("#nameStaff").val();
      $birthdayStaff = $("#birthdayStaff").val();
      $sexStaff = $("#sexStaff").val();
      $addressStaff = $("#addressStaff").val();
      $phoneStaff = $("#phoneStaff").val();
      
      $usernameStaff = $("#usernameStaff").val();
      $passwordStaff = $("#passwordStaff").val();

      //Kiem tra loi
      if ($nameStaff == '') {
        alert('Tên Nhân Viên Không được để trống');
        $("#nameStaff").focus();
        return;
      }
      if ($birthdayStaff == '') {
        alert('Ngày sinh Nhân Viên Không được để trống');
        $("#birthdayStaff").focus();
        return;
      }
      if ($addressStaff == '') {
        alert('Địa chỉ Nhân Viên Không được để trống');
        $("#addressStaff").focus();
        return;
      }
      if ($phoneStaff == '') {
        alert('SĐT Nhân Viên Không được để trống');
        $("#phoneStaff").focus();
        return;
      }
      if (!checkPhoneNumber($phoneStaff)) {
        alert('SĐT Nhân Viên không hợp lệ');
        $("#phoneStaff").focus();
        $("#phoneStaff").val("");
        return;
      }
      if ($usernameStaff == '') {
        alert('Tên đăng nhập Nhân Viên Không được để trống');
        $("#usernameStaff").focus();
        return;
      }
      if ($passwordStaff == '') {
        alert('Mật khẩu Nhân Viên Không được để trống');
        $("#passwordStaff").focus();
        return;
      }

      $obj = {
        'TENNV': $nameStaff,
        'NGAYSINH': $birthdayStaff,
        'GIOITINH': $sexStaff,
        'DIACHI': $addressStaff,
        'SDT': $phoneStaff,
        'TENDN': $usernameStaff,
        'MATKHAU': $passwordStaff
      }

      $.ajax({
        url: '/CuaHangNoiThat/Admin/addNewStaff',
        method: 'post',
        data: {
          data: $obj
        },
        success: function(data) {
          if (data == 0) {
            alert('Thêm Nhân Viên thành công');
            $("#nameStaff").val("");
            $("#birthdayStaff").val("");
            $("#sexStaff").val('Nam');
            $("#addressStaff").val("");
            $("#phoneStaff").val("");
            $("#usernameStaff").val("");
            $("#passwordStaff").val("");
          } else {
            alert('Không thể thêm');
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
          url: '/CuaHangNoiThat/Admin/readExcelStaff',
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

              for (var subkey in dataDB) {
                $subobj = dataDB[subkey];
                if ($obj.MANV.localeCompare($subobj.MANV) == 0) {
                  $check = true;
                  break;
                }
              }

              //Neu da ton tai MANV
              if ($check) {
                $sms = 'Nhân viên này đã tồn tại trong cơ sở dữ liệu\nBạn có muốn ghi đè:\n' +
                  '{' + $subobj.MANV + ',' + $subobj.TENNV + ',' + $subobj.NGAYSINH + ',' + $subobj.GIOITINH + ',' + $subobj.DIACHI + ',' + $subobj.SDT + ',' + $subobj.MAQUYEN + ',' + $subobj.TENDN + ',' + $subobj.MATKHAU + '}' +
                  '\nThành : \n' +
                  '{' + $obj.MANV + ',' + $obj.TENNV + ',' + $obj.NGAYSINH + ',' + $obj.GIOITINH + ',' + $obj.DIACHI + ',' + $obj.SDT + ',' + $obj.MAQUYEN + ',' + $obj.TENDN + ',' + $obj.MATKHAU + '}' +
                  '\nhay không ?';

                if (confirm($sms)) {
                  //updateStaff_withData($obj);
                }
              } else {
                $sms = 'Bạn có muốn thêm mới Nhân Viên này hay không ?\n' +
                  '{' + $obj.MANV + ',' + $obj.TENNV + ',' + $obj.NGAYSINH + ',' + $obj.GIOITINH + ',' + $obj.DIACHI + ',' + $obj.SDT + ',' + $obj.MAQUYEN + ',' + $obj.TENDN + ',' + $obj.MATKHAU + '}';

                if (confirm($sms)) {
                  $obj = {
                    'MANV':$obj.MANV,
                    'TENNV': $obj.MANV,
                    'NGAYSINH': $obj.NGAYSINH,
                    'GIOITINH': $obj.GIOITINH,
                    'DIACHI': $obj.DIACHI,
                    'SDT': $obj.SDT,
                    'MAQUYEN': $obj.MAQUYEN,
                    'TENDN': $obj.TENDN,
                    'MATKHAU': $obj.MATKHAU
                  }

                  $.ajax({
                    url: '/CuaHangNoiThat/Admin/addNewStaffWithId',
                    method: 'post',
                    data: {
                      data: $obj
                    },
                    success: function(data) {
                      if (data == 0) {
                        alert('Thêm Nhân Viên thành công');
                        $("#nameStaff").val("");
                        $("#birthdayStaff").val("");
                        $("#sexStaff").val('Nam');
                        $("#addressStaff").val("");
                        $("#phoneStaff").val("");
                        $("#rightStaff").val(1);
                        $("#usernameStaff").val("");
                        $("#passwordStaff").val("");
                      } else {
                        alert('Không thể thêm');
                      }
                    }
                  });
                }
              }
            }
            $("#readDetailFromFile").val("");

          }
        });
      });
    });
  </script>
</body>

</html>