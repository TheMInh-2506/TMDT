<?php
    class ThayDoiThongTin extends Controller{
        function display(){
            if(!isset($_SESSION['account'])){
                echo '<script>alert("Bạn chưa đăng nhập. Vui lòng đăng nhập để tiếp tục");window.location.href="./DangNhap";</script>';
                return;
            }
            
            $this->View('ThayDoiThongTin',"Thay đổi thông tin khách hàng",$_SESSION['account']);
        }
    }

?>


