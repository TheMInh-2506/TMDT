<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/CuaHangNoiThat/my-css.css">
    <title><?php echo $title; ?></title>
</head>

<body>
    <div class="header">
        <div class="address">
            <i class="fa fa-map-marker"> Hồ Chí Minh, Việt Nam</i>
            <i class="fa fa-envelope"> milfuniture@gmail.com</i>
        </div>
    </div>
    <nav class="navbar sticky-top navbar-expand-md navbar-light ">
        <div class="container-fluid">
            <a class="navar-branch" style="cursor: pointer;" href="/CuaHangNoiThat/TrangChu">
                <img src="/CuaHangNoiThat/public/image/logo.png" alt="logo" height="60px">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav mx-auto " id="lsp">
                    <li class="nav-item active">
                        <a class="nav-link a active" style="cursor: pointer;" href="/CuaHangNoiThat/TrangChu">TRANG CHỦ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link a" style="cursor: pointer;" href="/CuaHangNoiThat/TrangTri">TRANG TRÍ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link a" style="cursor: pointer;" href="/CuaHangNoiThat/PhongNgu">PHÒNG NGỦ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link a" style="cursor: pointer;" href="/CuaHangNoiThat/PhongLamViec">PHÒNG LÀM VIỆC</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link a" style="cursor: pointer;" href="/CuaHangNoiThat/PhongKhach">PHÒNG KHÁCH</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link a" style="cursor: pointer;" href="/CuaHangNoiThat/PhongAn">PHÒNG ĂN</a>
                    </li>
                </ul>
            </div>
            <?php if (isset($_SESSION['account'])) {
                echo "<div style='margin-top:2rem;'> Hello, " . $_SESSION['account']['TENKH'] . '</div>';
            } ?>

            <div class="user-nav">
                <div class="dropdown">
                    <i class="fa fa-user"></i><i class="fa fa-angle-down"></i>
                    <div class="dropdown-content user" style="margin-top: -0.5rem;">
                        <?php 
                            if (!isset($_SESSION['account'])) {
                                echo '<a href="/CuaHangNoiThat/DangNhap">Đăng nhập</a>';
                                echo '<a href="/CuaHangNoiThat/DangKy">Đăng ký</a>';
                            }
                            else{
                                echo '<a href="/CuaHangNoiThat/ThayDoiThongTin">Thay đổi thông tin</a>
                                <a href="/CuaHangNoiThat/DoiMatKhau">Đổi mật khẩu</a>
                                <a href="/CuaHangNoiThat/LichSuGioHang">Lịch sử</a>
                                <a href="/CuaHangNoiThat/TrangChu/Logout">Đăng xuất</a>';
                            }
                        ?>                        
                    </div>
                </div>
                <a href="/CuaHangNoiThat/GioHang" style="cursor: pointer;"><i class="fa fa-shopping-cart"></i></a>
                <span id="counter">
                    <?php
                    if (isset($_SESSION['cart'])) {
                        $count = 0;
                        foreach ($_SESSION['cart'] as $value) {
                            $count += $value['amount'];
                        }
                        echo $count;
                    } else {
                        echo 0;
                    }
                    ?>
                </span>
            </div>
        </div>
    </nav>
    <div>
        <fieldset>
            <legend><i class="fa fa-user-circle-o" aria-hidden="true"></i></legend>
            <p>THAY ĐỔI THÔNG TIN</p>
            <label for="exampleInputEmail1">Tên Khách Hàng</label>
            <div class="form-group" style="width: 80%;margin-left:10%;">
                <input style="font-family: 'Times New Roman', Times, serif;" type="text" class="form-control" id="nameCus" value="<?php echo $data['TENKH']; ?>">
            </div>
            <label for="exampleInputEmail1">Ngày Sinh</label>
            <div class="form-group" style="width: 80%;margin-left:10%;">
                <input style="font-family: 'Times New Roman', Times, serif;" type="date" class="form-control" id="birthday" value="<?php echo $data['NGAYSINH']; ?>">
            </div>
            <label for="exampleInputEmail1">Địa chỉ</label>
            <div class="form-group" style="width: 80%;margin-left:10%;">
                <input style="font-family: 'Times New Roman', Times, serif;" type="text" class="form-control" id="addressCus" value="<?php echo $data['DIACHI']; ?>">
            </div>
            <label for="exampleInputEmail1">Số điện thoại</label>
            <div class="form-group" style="width: 80%;margin-left:10%;">
                <input style="font-family: 'Times New Roman', Times, serif;" type="text" class="form-control" id="phoneCus" value="<?php echo $data['SDT']; ?>">
            </div>
            <label for="exampleInputEmail1">Giới tính</label>
            <div class="form-group" style="width: 80%;margin-left:10%;">
                <select style="font-family: 'Times New Roman', Times, serif;" class="form-control" id="sexCus">
                    <option value="Nam" <?php if ($data['GIOITINH'] == 'Nam') {
                                            echo "selected";
                                        } ?>>Nam</option>
                    <option value="Nữ" <?php if ($data['GIOITINH'] == 'Nữ') {
                                            echo "selected";
                                        } ?>>Nữ</option>
                </select>
            </div>
            <button style="float: right;margin-right: 10%;font-size: 1.5rem;width: 10rem;color: white;font-family: 'Times New Roman', Times, serif;margin: 1rem;" onclick="saveInfo();" class="btn btn-primary">Lưu</button>
        </fieldset>
    </div>
    <script>
        function saveInfo() {
            $name = $("#nameCus").val();
            $address = $("#addressCus").val();
            $phone = $("#phoneCus").val();
            $sex = $("#sexCus").val();
            $birthday = $("#birthday").val();

            if ($name == '') {
                alert("Tên khách hàng không được để trống")
                return
            }
            if ($address == 'Địa chỉ khách hàng không được để trống') {
                alert("")
                return
            }
            if ($phone == '' || $phone.length != 10 || !checkPhonne($phone)) {
                alert("Số điện thoại không hợp lệ. Số điện thoại không được chứa ký tự đặc biệt và có độ dài 10 ký tự")
                return
            }

            const arr = new Array($name, $address, $phone, $sex,$birthday);
            $.ajax({
                url: '/CuaHangNoiThat/Admin/saveInfoAccount/'+ JSON.stringify(arr),
                success: function(data) {
                    var data = JSON.parse(data);
                    alert(data.SMS);
                    if(data.SMS === 'Cập nhật thành công'){
                        window.location.href = '/CuaHangNoiThat';
                    }
                }
            });
        }

        function checkPhonne($phone) {
            for (var i = 0; i < $phone.length; i++) {
                if (isNaN($phone[i])) {
                    return false;
                }
            }
            return true;
        }
    </script>
</body>