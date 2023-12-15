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
        <h2 style="width: 100%;text-align: center;color: #0066cc;font-weight: 600;">Sửa Nhân Viên</h2>
        
        <div class="form-group">
            <label for="exampleInputEmail1">Mã nhân viên</label>
            <input type="text" class="form-control" id="idStaff" readonly value="<?php echo $data['Staff']['MANV']; ?>">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Tên nhân viên</label>
            <input type="text" class="form-control" id="nameStaff" value="<?php echo $data['Staff']['TENNV']; ?>">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Ngày Sinh</label>
            <input type="date" class="form-control" id="birthdayStaff" value="<?php echo $data['Staff']['NGAYSINH']; ?>">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Giới Tính</label>
            <select class="form-control" id="sexStaff">
                <option value="Nam" <?php if ($data['Staff']['GIOITINH'] == 'Nam') {
                                        echo 'selected';
                                    } ?>>Nam</option>
                <option value="Nữ" <?php if ($data['Staff']['GIOITINH'] == 'Nữ') {
                                        echo 'selected';
                                    } ?>>Nữ</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Địa Chỉ</label>
            <input type="text" class="form-control" id="addressStaff" value="<?php echo $data['Staff']['DIACHI']; ?>">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">SĐT</label>
            <input type="text" class="form-control" id="phoneStaff" value="<?php echo $data['Staff']['SDT']; ?>">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Quyền</label>
            <select class="form-control" id="rightStaff">
                <?php
                foreach ($data['Right'] as $value) {
                    if ($value['MAQUYEN'] == $data['Staff']['MAQUYEN']) {
                        echo "<option value='$value[MAQUYEN]' selected>$value[TENQUYEN]</option>";
                    } else {
                        echo "<option value='$value[MAQUYEN]'>$value[TENQUYEN]</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Tên đăng nhập</label>
            <input type="text" class="form-control" id="usernameStaff" value="<?php echo $data['Staff']['TENDN']; ?>">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Mật khẩu</label>
            <input type="text" class="form-control" id="passwordStaff" value="">
        </div>

        <a href="/CuaHangNoiThat/Admin/NhanVien">
            <button type="submit" class="btn btn-primary" style="background-color: white;color: #0066cc;font-size: 1.5rem;margin-top: 2rem;">Trở về </button>
        </a>
        <button onclick="editStaff();" type="submit" class="btn btn-primary" style="background-color: #0066cc;color: white;font-size: 1.5rem;margin-top: 2rem;float: right;">Sửa Nhân Viên</button>
    </div>
    <script>
        function editStaff() {
            $idStaff = $("#idStaff").val();
            $nameStaff = $("#nameStaff").val();
            $birthdayStaff = $("#birthdayStaff").val();
            $sexStaff = $("#sexStaff").val();
            $addressStaff = $("#addressStaff").val();
            $phoneStaff = $("#phoneStaff").val();
            $rightStaff = $("#rightStaff").val();
            $usernameStaff = $("#usernameStaff").val();
            $passwordStaff = $("#passwordStaff").val();

            //Kiem tra loi
            if($nameStaff == ''){
                alert('Tên Nhân Viên Không được để trống');
                return;
            }
            if($birthdayStaff == ''){
                alert('Ngày sinh Nhân Viên Không được để trống');
                return;
            }
            if($addressStaff == ''){
                alert('Địa chỉ Nhân Viên Không được để trống');
                return;
            }
            if($phoneStaff == ''){
                alert('SĐT Nhân Viên Không được để trống');
                return;
            }
            if($usernameStaff == ''){
                alert('Tên đăng nhập Nhân Viên Không được để trống');
                return;
            }
            if($passwordStaff == ''){
                alert('Mật khẩu Nhân Viên Không được để trống');
                return;
            }

            $obj = {
                'MANV': $idStaff,
                'TENNV': $nameStaff,
                'NGAYSINH': $birthdayStaff,
                'GIOITINH': $sexStaff,
                'DIACHI': $addressStaff,
                'SDT': $phoneStaff,
                'MAQUYEN': $rightStaff,
                'TENDN': $usernameStaff,
                'MATKHAU': $passwordStaff
            }

            $.ajax({
                url:'/CuaHangNoiThat/Admin/updateInfoStaff',
                method:'post',
                data:{data:$obj},
                success: function(data){
                    alert(data);
                }
            });
        }
    </script>
</body>

</html>