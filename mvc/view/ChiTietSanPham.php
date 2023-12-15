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
    <title>Trang Trí</title>
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

    <div class="product-info">
        <div class="product-info-item">
            <img src="/CuaHangNoiThat/public/image/HINHANH/<?php echo $data['product']['HINHANH']; ?>" alt="">
        </div>
        <div class="product-info-item">
            <div class="product-info-text">
                <div class="product-name"><?php echo $data['product']['TENSP']; ?></div>
                <div style="font-size: 25px;">Giá gốc :
                    <div class="price"><?php echo number_format($data['product']['GIA']); ?> <sup>đ</sup></div>
                </div>
                <?php
                if ($data['product']['PHANTRAMGIAM'] != 0) {
                    echo '<div style="font-size: 25px;">Giá khuyến mãi :
                            <div class="price">' . number_format($data['product']['GIA'] * (1 - $data['product']['PHANTRAMGIAM'] / 100)) . ' <sup>đ</sup> (- ' . number_format($data['product']['GIA'] * ($data['product']['PHANTRAMGIAM'] / 100)) . ' <sup>đ</sup>)</div>
                            </div>';
                }
                ?>

                <button class="buy-btn" onclick="addToCart('<?php echo $data['product']['MASP']; ?>');">Thêm vào giỏ hàng</button>
            </div>
        </div>
    </div><br><br>
    <h2 class="title">
        <span>TẠI SAO NÊN CHỌN MILD</span>
    </h2>
    <div class="wrapper">
        <div class="wrapper-item">
            <img src="/CuaHangNoiThat/public/image/THIET_KE.jpg" alt="">
            <div class="text">
                <h3>THIẾT KẾ ĐẲNG CẤP</h3>
                <p>Nội thất MILD được sáng lập dựa trên tâm huyết và tài năng của các nhà thiết kế đến từ Ý, cái nôi của ngành mỹ học, thời trang, thiết kế, các sản phẩm về da và công nghệ thuộc da hàng đầu thế giới.
                    Những sản phẩm mang đậm phong cách đương đại Italia của MILD chắt lọc tinh hoa của lịch sử và một nền văn hoá đặc trưng không thể nhầm lẫn. Các nghệ nhân chế tác sofa người Ý đã đúc kết kinh nghiệm qua hàng thế kỷ,
                    hoàn thiện quy trình thiết kế để đạt được đỉnh cao về chuyên môn ngày nay. Các sản phẩm Sofa Ý của MILD có thiết kế lịch lãm, sang trọng với những chi tiết và đường nét thẩm mỹ vượt thời gian.</p>
            </div>
        </div>
        <div class="wrapper-item">
            <img src="/CuaHangNoiThat/public/image/CHAT_LUONG.jpg" alt="">
            <div class="text">
                <h3>CHẤT LƯỢNG ĐỈNH CAO</h3>
                <p>Các sản phẩm được phân phối bởi MILD phải trải qua các công đoạn kiểm tra chất lượng vô cùng gắt gao.
                    Nguyên liệu thô được chọn lọc kỹ càng từ những tấm da bò cao cấp được thuộc da theo phương pháp Veg-tan
                    (thảo mộc) hoàn toàn tự nhiên, thân thiện môi trường, cùng công nghệ xử lý da Eco tuân thủ nghiêm ngặt theo
                    quy định về kiểm soát Ngành Công nghiệp thuộc da của Liên minh Châu Âu. Bộ khung sườn sản phẩm được làm từ những
                    loại gỗ đặc chủng dành cho nội thất cao cấp như gỗ mahogany, gỗ golden birch với khả năng chống cong vênh mối mọt
                    và độ bền lên đến 25 năm sử dụng.</p>
            </div>
        </div>
    </div>
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
        function addToCart($productId) {
            if (!confirm("Bạn có muốn thêm sản phẩm vào giỏ hàng ?")) {
                return;
            }
            $.ajax({
                url: '/CuaHangNoiThat/Admin/addToCart/' + $productId,
                success: function(data) {
                    var data = JSON.parse(data);
                    alert(data.SMS);
                    loadCountCart();
                }
            });
        }

        function loadCountCart() {
            $.ajax({
                url: '/CuaHangNoiThat/Admin/countCart',
                success: function(data) {
                    var data = JSON.parse(data);
                    $("#counter").html(data.COUNT)
                }
            })
        }
    </script>
</body>

</html>