<?php
    class TrangThaiDB extends ConnectionDB{
        function getStatusNameById($idStatus){
            $name = "";
            $query = "SELECT `MOTATRANGTHAI` FROM `trangthaidonhang` WHERE `MATRANGTHAI`='$idStatus';";
            $rs = mysqli_query($this->conn,$query);
            $name = mysqli_fetch_assoc($rs);
            return $name;
        }
    }

?>