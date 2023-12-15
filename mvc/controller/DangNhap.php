<?php
    class DangNhap extends Controller{
        function display(){
            $this->View('DangNhap');
        }

        function checkLogin(){
            return true;
        }
    }

?>