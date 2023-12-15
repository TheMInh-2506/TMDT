<?php
class GioHang extends Controller
{
    function display()
    {
        $this->View('GioHang');
    }

    function ThanhToan(){
        $this->View('ThanhToan');
    }
}
