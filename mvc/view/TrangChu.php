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
    <title>Trang Chủ</title>
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
                        } else {
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
    <div class="banner">
        <img src="/CuaHangNoiThat/public/image/BANNER_CHINH_1.jpg" alt="">
    </div>

    <h2 class="title">
        <span>Sản phẩm giảm giá</span>
    </h2>

    <div style="margin-top: 2rem;width: 80%;margin-left: 10%;margin-top: 2rem;" id="sale_product">
        <!-- <div class="card border-primary mb-3" style="float: left;width: 20rem;margin-right: 1rem;">
            <div class="card-body text-primary">
                <img src="/CuaHangNoiThat/public/image/HINHANH/sofa.jpg" alt="no image" style="width: 18rem;height: 18rem;">
                <p style="width: auto;height: auto;color: red;font-size: 1.8rem;position: absolute;top: 10%;left: 80%;background-color: yellow;border-radius: 0.2rem;font-weight: bolder;">-5%</p>
            </div>
            <div class="card-header" style="height: 5rem;"></div>
        </div> -->
    </div>

    <h2 class="title">
        <span>Nội thất cho ngôi nhà hiện đại</span>
    </h2>
    <p class="content">
        Cozy được hình thành từ năm 1995 với sứ mệnh mang đến những bộ sưu tập nội thất có thiết kế đương đại,
        chất lượng vượt trội từ các nước Italy, Đức, Nhật Bản với giá thành hợp lý nhất. Các sản phẩm từ sofa,
        bàn ăn đến từng lọ hoa trang trí,... tất cả được các Designers đến từ Italy và Australia thiết kế đồng bộ,
        tạo nên những không gian sống hoàn chỉnh và tinh tế nhất.
    </p>
    <div class="category-container">
        <div class="category">
            <a href="/CuaHangNoiThat/TrangTri">
                <img src="/CuaHangNoiThat/public/image/cate-5.jpg" alt="cate-1">
                <p>Trang trí</p>
            </a>
        </div>
        <div class="category">
            <a href="/CuaHangNoiThat/PhongNgu">
                <img src="/CuaHangNoiThat/public/image/cate-4.jpg" alt="cate-2">
                <p>Phòng ngủ</p>
            </a>
        </div>
        <div class="category">
            <a href="/CuaHangNoiThat/PhongLamViec">
                <img src="/CuaHangNoiThat/public/image/cate-3.jpg" alt="cate-3">
                <p>Phòng làm việc</p>
            </a>
        </div>
        <div class="category">
            <a href="/CuaHangNoiThat/PhongKhach">
                <img src="/CuaHangNoiThat/public/image/cate-2.jpg" alt="cate-4">
                <p>Phòng khách</p>
            </a>
        </div>
        <div class="category">
            <a href="/CuaHangNoiThat/PhongAn">
                <img src="/CuaHangNoiThat/public/image/cate-1.jpg" alt="cate-5">
                <p>Phòng ăn</p>
            </a>
        </div>
    </div>
    <h2 class="title">
        <span>Hàng nhập khẩu từ các thương hiệu trên thế giới</span>
    </h2>
    <div id="carouselId" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselId" data-slide-to="0" class="active"></li>
            <li data-target="#carouselId" data-slide-to="1" class=""></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
                <img src="/CuaHangNoiThat/public/image/Banner_phu_2.jpg" alt="1" width="100%" height="100%">
            </div>
            <div class="carousel-item">
                <img src="/CuaHangNoiThat/public/image/banner_phu_3.jpg" alt="2" width="100%" height="100%">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselId" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselId" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div><br><br>
    <div class="info-container">
        <div class="info">
            <img src="/CuaHangNoiThat/public/image/Banner_phu_1.jpg" alt="">
        </div>
        <div class="info">
            <h2>THIẾT KẾ HIỆN ĐẠI</h2><br>
            <p>MILD là thương hiệu tiên phong phân phối các sản phẩm bàn ăn cao cấp với mẫu mã và chất liệu đa dạng kết hợp công năng tiện nghi.</p>
            <p>Các mẫu bàn Ceramic đang được đặc biệt ưa chuộng bởi các đặc điểm ưu việt. Ceramic đã qua xử lý kỹ thuật và được sử dụng trong nội thất cao cấp nhờ tính thẩm mỹ, chống trầy, và độ bền vượt trội, an toàn thân thiện với môi trường, không gây kích ứng khi sử dụng.
                MILD độc quyền phân phối các sản phẩm nội thất Ceramic Ý cao cấp có độ bóng gấp 3 lần ceramic thông thường.</p>
            <p>Các mẫu bàn đá marble nguyên khối tự nhiên của MILD được phủ lớp sơn mài bóng chống thấm ẩm, được chế tác thủ công tỉ mỉ đến từng đường nét nhằm đảm bảo độ bền và tính thẩm mỹ cao.</p>
            <p>Tất cả các bộ sưu tập bàn ăn của MILD đều có thiết kế kết hợp công năng tiện nghi đáp ứng linh hoạt nhiều nhu cầu của khách hàng. Bàn ăn thông minh kéo dãn nhiều cấp độ là sự lựa chọn hoàn hảo cho không gian sang trọng và lịch lãm.</p>
        </div>
    </div><br>
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
        $(document).ready(function() {
            $.ajax({
                url: '/CuaHangNoiThat/Admin/getSaleProduct/5',
                success: function(data) {
                    var data = JSON.parse(data)
                    $xhtml = "";
                    var lastItem = data.at(-1)
                    for (var key in data) {
                        $obj = data[key]
                        $xhtml += '<div class="card border-primary mb-3" style="'+($obj.MASP == lastItem.MASP ? '':'float: left;')+'width: 20rem;margin-right: 1rem;">' +
                            '<div class="card-body text-primary">' +
                            '<a href="/CuaHangNoiThat/ChiTietSanPham/SanPham/'+$obj.MASP+'"><img src="/CuaHangNoiThat/public/image/HINHANH/'+$obj.HINHANH+'" alt="no image" style="width: 18rem;height: 18rem;"></a>' +
                            '<p style="width: auto;height: auto;color: red;font-size: 1.8rem;position: absolute;top: 10%;left: 80%;background-color: yellow;border-radius: 0.2rem;font-weight: bolder;">-'+$obj.PHANTRAMGIAM+'%</p>' +
                            '</div>' +
                            '<div class="card-header" style="height: 5rem;">'+$obj.TENSP+'</div>' +
                            '</div>';
                    }
                    $("#sale_product").html($xhtml);

                }
            })
        })
    </script>

    
</body>

</html>