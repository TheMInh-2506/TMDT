<?php
class KhuyenMaiDB extends ConnectionDB
{
    //Lay khuyen mai
    function getSaleById($saleId)
    {
        $qry = "SELECT * FROM `khuyenmai` WHERE `MAKM` = '$saleId';";
        return mysqli_fetch_assoc(mysqli_query($this->conn, $qry));
    }
    //Lay tat ca khuyen mai
    function getAllSales()
    {
        $data = array();
        $qry = "SELECT * FROM khuyenmai";
        $rs = mysqli_query($this->conn, $qry);
        while ($row = mysqli_fetch_assoc($rs)) {
            /*if ($row['MAKM'] != 'KM00') {
                $data[] = $row;
            }*/

            $data[] = $row;
        }
        return $data;
    }
    //Cap nhat thong tin khuyenmai
    function updateInformationSale($sale)
    {
        $qry = "UPDATE `khuyenmai` SET `NGAYBD`='$sale[NGAYBD]',`NGAYKT`='$sale[NGAYKT]' WHERE `MAKM` = '$sale[MAKM]'";
        if (mysqli_query($this->conn, $qry)) {
            return true;
        }
        return false;
    }
    //Tao ma khuyen mai tiep theo
    function createNextSaleId()
    {
        $data = $this->getAllSales();
        $lastItem = empty($data) ? array() : end($data);
        if (empty($lastItem)) {
            return 'KM01';
        } else {
            $lastId = $lastItem['MAKM'];
            $nextIdCount = (int)substr($lastId, 2) + 1;
            while (strlen($nextIdCount) < 2) {
                $nextIdCount = '0' . $nextIdCount;
            }
            return 'KM' . $nextIdCount;
        }
    }
    //Them khuyen mai
    function addNewSale($sale){
        $nextId = $this->createNextSaleId();
        $qry = "INSERT INTO `khuyenmai`(`MAKM`, `NGAYBD`, `NGAYKT`, `PHANTRAMGIAM`,`TRANGTHAI`) VALUES ('$nextId','$sale[NGAYBD]','$sale[NGAYKT]',$sale[PHANTRAMGIAM],1);";
        if (mysqli_query($this->conn, $qry)) {
            return true;
        }
        return false;
    }

    function getSaleinCurrent(){
        $sale = $this->getAllSales();
        
        $currrentTime = date("Y-m-d");
        
        foreach($sale as $value){
            
            /*if($value['NGAYBD'] <= $currrentTime && $value['NGAYKT'] >= $currrentTime && $value['TRANGTHAI'] == 1 && $value['MAKM'] != 'KM00'){
                
            }*/

            if($this->compareDate($currrentTime,$value['NGAYBD']) && $this->compareDate($value['NGAYKT'],$currrentTime) && $value['TRANGTHAI'] == 1 && $value['MAKM'] != 'KM00'){
                return $value;
            }
        }
        $sale[0]['NGAYBD'] = $sale[0]['NGAYKT'] = 'Không khuyến mãi';
        return $sale[0];
    }

    function compareDate($date1,$date2){
        $strDate1 = explode('-',$date1);
        $strDate2 = explode('-',$date2);
        $length = count($strDate1);

        for($i = 0;$i < $length;$i++){
            if((int)$strDate2[$i] > (int)$strDate1[$i]){
                return false;
            }
        }
        return true;
    }

    function disabledSale($id){
        $qry = "UPDATE `khuyenmai` SET `TRANGTHAI`=false WHERE `MAKM` = '$id'";
        if (mysqli_query($this->conn, $qry)) {
            return true;
        }
        return false;
    }
}
