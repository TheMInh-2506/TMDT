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
    <title>Đăng nhập</title>
    <style>
        /* Styles for desktop */
        fieldset {
            width: 400px;
            margin: 20 auto;
        }

        legend {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .input-group {
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="password"] {
            width: 90%;
        }

        .error-message {
            font-size: 18px;
            text-align: left;
            color: red;
            margin-left: 20%;
            display: none;
        }

        .btn-log {
            margin-top: 10px;
            width: 90%;
            padding: 10px;
        }

        .reg {
            margin-top: 10px;
            text-align: center;
        }

        /* Styles for mobile */
        @media (max-width: 480px) {
            fieldset {
                width: 90%;
            }

            .error-message {
                margin-left: 0;
            }
        }
    </style>
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
    <fieldset>
        <legend><i class="fa fa-user-circle-o" aria-hidden="true"></i></legend>
        <p>ĐĂNG NHẬP</p>
        <div class="input-group">
            <input type="text" id="uname" name="uname" placeholder="a@gmail.com">
            <p class="error-message" id="errorUname">Tên đăng nhập không hợp lệ</p>
        </div>
        <div class="input-group">
            <input type="password" id="pass" name="pass" placeholder="*********">
            <p class="error-message" id="errorPass">Mật khẩu không hợp lệ</p>
        </div>
        <p id="errorMessage"></p>
        <input type="submit" id="submitbtn" value="ĐĂNG NHẬP" class="btn-log">
        <div class="reg">Bạn chưa có tài khoản? <a href="/CuaHangNoiThat/DangKy">Đăng ký</a></div>
    </fieldset>

</body>
<script>
    $(document).ready(function() {
        $("#errorUname").hide();
        $("#errorPass").hide();
    });

    $("#submitbtn").click(function() {
        $("#errorUname").hide();
        $("#errorPass").hide();
        $("#errorMessage").hide();

        $uname = $("#uname").val();
        $pass = $("#pass").val();

        if ($uname === "" || !$uname.includes("@gmail.com")) {
            $("#errorUname").show();
            return;
        }
        if ($pass === "") {
            $("#errorPass").show();
            return;
        }

        $.ajax({
            url: '/CuaHangNoiThat/Admin/checkLoginCustomer/' + $uname + '/' + $pass,
            method: 'POST',
            data: {
                url: window.location.href
            },
            success: function(data) {
                var data = JSON.parse(data);
                $result = data.RESULT;
                if ($result === "NOT_EXISTS") {
                    $("#errorMessage").html("Tài khoản không tồn tại");
                    $("#errorMessage").show();
                } else if ($result === "WRONG_PASSWORD") {
                    $("#errorMessage").html("Mật khẩu không chính xác");
                    $("#errorMessage").show();
                } else if($result === 'BLOCK'){
                    $("#errorMessage").html("Tài khoản bạn đã bị khóa. Vui lòng liên hệ mildstore@gmail.com để biết thêm chi tiết");
                    $("#errorMessage").show();
                }
                 else {
                    window.location.href = "./" + data.URL;
                }
            }
        });

    });
</script>

</html>