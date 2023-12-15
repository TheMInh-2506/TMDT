<?php
class TrangChu extends Controller
{
    function display()
    {
        $this->View('TrangChu');
    }

    function Logout()
    {
        unset($_SESSION['account']);
        unset($_SESSION['cart']);
        echo '<script>window.location.href="../";alert("Đăng xuất thành công");</script>';
    }

    function viewCart()
    {
        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';
    }

    function clear(){
        session_destroy();
    }
}
