<?php
    class QuyenDB extends ConnectionDB{
        function getAllRight(){
            $sql = 'SELECT * FROM `quyen`';
            $rs = mysqli_query($this->conn,$sql);

            return $this->getDataFromResultSet($rs);
        }

        function getRightById($id){
            $sql = "SELECT * FROM `quyen` WHERE `MAQUYEN` = '$id'";
            $rs = mysqli_query($this->conn,$sql);

            return mysqli_fetch_assoc($rs);
        }
    }
?>