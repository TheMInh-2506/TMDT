<?php
    // echo '<pre>';
    // print_r($_SESSION);
    // echo '</pre>';

?>


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
    <script src="/CuaHangNoiThat/processFunc.js"></script>

    <title>Lịch sử mua hàng</title>
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
    </nav><br>
    <h2 class="title">
        <span>LỊCH SỬ MUA HÀNG</span>
    </h2><br>

    <table style="width: 70%;margin-left: 15%;font-family: 'Times New Roman', Times, serif;font-size: 1.5rem;font-weight: normal;" class="shopping-cart" id="shopping-cart-id">
    </table>
    <div class="footer-container">
        <div class="footer">
            <img src="/CuaHangNoiThat/public/image/logo.png" alt="">
        </div>
        <div class="footer">
            <a href="">GIAO HÀNG</a><br>
            <a href="">BẢO HÀNH</a><br>
            <a href="">BẢO DƯỠNG</a><br>
            <a href="">ĐẶT HÀNG</a><br>
            <a href="">CỬA HÀNG</a><br>
            <a href="">LIÊN HỆ</a><br>
        </div>
        <div class="footer">
            <a href="">VỀ MILD</a><br>
            <a href="">TẠI SAO LẠI CHỌN MILD</a><br>
        </div>
        <div class="footer">
            <h3>ĐĂNG KÝ NHẬN TIN</h3><br>
            <input type="text">
            <button class="footer-btn">ĐĂNG KÝ</button>
        </div>
    </div>

    <script>
        function viewDetail($id) {
            window.location.href = "/CuaHangNoiThat/LichSuGioHang/XemChiTiet/" + $id;
        }

        function submitBill($id) {
            if (!confirm("Bạn đã nhận được hàng ?")) {
                return;
            }

            $.ajax({
                url: '/CuaHangNoiThat/Admin/submitBill/' + $id,
                success: function(data) {
                    var data = JSON.parse(data);
                    alert(data.SMS);

                    loadTable();
                }
            })
        }

        function destroyBill($id){
            if (!confirm("Bạn muốn hủy đơn hàng ?")) {
                return;
            }

            $.ajax({
                url: '/CuaHangNoiThat/Admin/destroyBill/' + $id,
                success: function(data) {
                    var data = JSON.parse(data);
                    alert(data.SMS);

                    loadTable();
                }
            })
        }
        loadTable();

        function loadTable() {
            $.ajax({
                url: '/CuaHangNoiThat/Admin/getCusBillAndDetailBill',
                success: function(data) {
                    var data = JSON.parse(data);
                    $xhtml = '<tr>' +
                        '<th style="width: 10rem;">Mã Hóa Đơn</th>' +
                        '<th style="width: 10rem;">Ngày Đặt</th>' +
                        '<th style="width: 10rem;">Giờ Đặt</th>' +
                        '<th>Tổng Tiền</th>' +
                        '<th>Trạng Thái</th>' +
                        '<th style="width: 10rem;">Chức Năng</th>' +
                        '</tr>';
                    for (var key in data) {
                        $obj = data[key];
                        $xhtml += '<tr style="background-color:#e6e6e6;height:6rem;">' +
                            '<td>' + $obj.MAHD + '</td>' +
                            '<td>' + $obj.NGAYLAP + '</td>' +
                            '<td>' + $obj.GIOLAP + '</td>';
                        if ($obj.TONG == $obj.LAST_PRICE) {
                            $xhtml += '<td> ' + formatter.format($obj.TONG) + '</td>';
                        } else {
                            $xhtml += '<td> ' + formatter.format($obj.LAST_PRICE) + ' <p style="font-weight:800;text-decoration: line-through;">' + formatter.format($obj.TONG) + '</p></td>';
                        }

                        switch ($obj.MATRANGTHAI) {
                            case 'TT01': {
                                $xhtml += '<td style="padding:0.3rem;">Đang chờ cửa hàng xác nhận</td>' +
                                    '<td><button style="border-radius:0.5rem;margin: 0.2rem;width: 10rem;background-color: white;color: #2478ff;font-family: "Times New Roman", Times, serif;" onclick="viewDetail(\'' + $obj.MAHD + '\');">Xem Chi Tiết</button><button style="border-radius:0.5rem;margin: 0.2rem;width: 10rem;background-color: black;color: white;font-family: "Times New Roman", Times, serif;" onclick="destroyBill(\'' + $obj.MAHD + '\');">Hủy đơn hàng</button></td>';
                                break;
                            }
                            case 'TT02': {
                                $xhtml += '<td>Bạn đã nhận được hàng? Vui lòng xác nhận</td>' +
                                    '<td>' +
                                    '<button style="border-radius:0.5rem;margin: 0.2rem;width: 10rem;background-color: red;color: white;font-family: "Times New Roman", Times, serif;" onclick="submitBill(\'' + $obj.MAHD + '\')">Xác nhận</button>' +
                                    '<button style="border-radius:0.5rem;margin: 0.2rem;width: 10rem;background-color: white;color: #2478ff;font-family: "Times New Roman", Times, serif;" onclick="viewDetail(\'' + $obj.MAHD + '\');">Xem Chi Tiết</button>' +
                                    '</td>';
                                break;
                            }
                            case 'TT03': {
                                $xhtml += '<td>Đơn hàng hoàn tất</td>' +
                                    '<td>' +
                                    '<button style="border-radius:0.5rem;margin: 0.2rem;width: 10rem;background-color: white;color: #2478ff;font-family: "Times New Roman", Times, serif;" onclick="viewDetail(\'' + $obj.MAHD + '\');">Xem Chi Tiết</button>' +
                                    '</td>';
                                break;
                            }
                            case 'TT04': {
                                $xhtml += '<td style="color:red;">Bạn đã hủy đơn hàng</td>' +
                                    '<td>' +
                                    '<button style="border-radius:0.5rem;margin: 0.2rem;width: 10rem;background-color: white;color: #2478ff;font-family: "Times New Roman", Times, serif;" onclick="viewDetail(\'' + $obj.MAHD + '\');">Xem Chi Tiết</button>' +
                                    '</td>';
                                break;
                            }
                            case 'TT05': {
                                $xhtml += '<td style="color:red;">Đơn hàng đã bị admin hủy</td>' +
                                    '<td>' +
                                    '<button style="border-radius:0.5rem;margin: 0.2rem;width: 10rem;background-color: white;color: #2478ff;font-family: "Times New Roman", Times, serif;" onclick="viewDetail(\'' + $obj.MAHD + '\');">Xem Chi Tiết</button>' +
                                    '</td>';
                                break;
                            }
                            case 'TT06': {
                                $xhtml += '<td style="color:red;">Đã xác nhận, đang chờ xuất kho</td>' +
                                    '<td>' +
                                    '<button style="border-radius:0.5rem;margin: 0.2rem;width: 10rem;background-color: white;color: #2478ff;font-family: "Times New Roman", Times, serif;" onclick="viewDetail(\'' + $obj.MAHD + '\');">Xem Chi Tiết</button>' +
                                    '</td>';
                                break;
                            }
                        }
                        $xhtml += '<tr><td style="height:2.5rem;"></td></tr>';
                    }
                    $("#shopping-cart-id").html($xhtml);
                }
            })
        }
    </script>
</body>

</html>