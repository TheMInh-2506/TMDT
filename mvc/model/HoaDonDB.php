<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Ho_Chi_Minh');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//Model
class HoaDonDB extends ConnectionDB
{
    //Lay hoa don
    function getBillById($billId)
    {
        $data = array();
        $query = "SELECT * FROM hoadon WHERE MaHD = '" . $billId . "'";
        $rs = mysqli_query($this->conn, $query);
        $data[] = mysqli_fetch_assoc($rs);
        return $data;
    }
    function getBillByCusId($billId)
    {
        $data = array();
        $query = "SELECT * FROM hoadon WHERE `MaKH` = '" . $billId . "'";
        $rs = mysqli_query($this->conn, $query);
        while ($row = mysqli_fetch_assoc($rs)) {
            $data[] = $row;
        }
        return $data;
    }

    function getBillByYear($year){
        $data = $this->getAllBill();
        $result = array();

        foreach($data as $value){
            $date = explode('-',$value['NGAYLAP'])[0];
            if($date == $year){
                $result[] = $value;
            }
        }

        return $result;
    }

    //Lay chi tiet hoa don
    function getBillDetailById($billId)
    {
        $data = array();
        $query = "SELECT * FROM `ct_hoadon` WHERE MAHD = '" . $billId . "'";
        $rs = mysqli_query($this->conn, $query);
        
        while ($row = mysqli_fetch_array($rs)) {
            $data[] = $row;
        }
        return $data;
    }

    function getBillDetailByIdStored($billId)
    {
        $data = array();
        $query = "CALL `getBillDetailById`('$billId');";
        $rs = mysqli_query($this->conn, $query);

        echo '<br>';
        print_r($rs);
        
        while ($row = mysqli_fetch_assoc($rs)) {
            $data[] = $row;
        }
        return $data;
    }

    //Lay tat ca chi tiet hoa don
    function getAllBillDetail()
    {
        $data = array();
        $query = "SELECT * FROM ct_hoadon;";
        $rs = mysqli_query($this->conn, $query);
        while ($row = mysqli_fetch_assoc($rs)) {
            $data[] = $row;
        }
        return $data;
    }
    //Lay tat ca hoa don
    function getAllBill()
    {
        $data = array();
        $query = "SELECT * FROM `hoadon`";
        $rs = mysqli_query($this->conn, $query);
        while ($row = mysqli_fetch_assoc($rs)) {
            $data[] = $row;
        }
        return $data;
    }

    function getAllBillFT($from,$to)
    {
        $data = $this->getAllBill();
        $result = array();
        foreach($data as $value){
            if(strtotime($from) <= strtotime($value['NGAYLAP']) && strtotime($to) >= strtotime($value['NGAYLAP'])){
                $result[] = $value;
            }
        }
        return $result;
    }

    function getAllBillInMonth($month){
        $data = $this->getAllBill();
        $result = array();
        foreach($data as $value){
            if(strpos($value['NGAYLAP'],$month) !== false){
                $result[] = $value;
            }
        }
        return $result;
    }

    function getAllBillStored($from,$to){
        $data = array();
        $query = "CALL `getAllBillFromTo`('$from', '$to');";
        $rs = mysqli_query($this->conn, $query);

        while ($row = mysqli_fetch_array($rs)) {
            $data[] = $row;
        }
        return $data;
    }
    
    //Tao ma hoa don tiep theo
    function createNextBillId()
    {
        $data = $this->getAllBill();
        $lastBillId = empty($data) ? array() : end($data);
        
        if (empty($lastBillId)) {
            return 'HD01';
        }
        $nextId = substr($lastBillId['MAHD'], 2) + 1;
        
        if (strlen($nextId) < 2) {
            $nextId = '0' . $nextId;
        }
        return substr($lastBillId['MAHD'], 0, 2) . $nextId;
    }
    //Lay hoadon theo khach hang
    function getBilByCustomerId($cusId)
    {
        $data = array();
        $query = "SELECT * FROM hoadon WHERE MAKH = '" . $cusId . "'";
        $rs = mysqli_query($this->conn, $query);
        while ($row = mysqli_fetch_assoc($rs)) {
            $data[] = $row;
        }
        return $data;
    }
    //Lay hoadon theo nhanvien
    function getBilByStaffId($cusId)
    {
        $data = array();
        $query = "SELECT * FROM hoadon WHERE MaNV = '" . $cusId . "'";
        $rs = mysqli_query($this->conn, $query);
        while ($row = mysqli_fetch_assoc($rs)) {
            $data[] = $row;
        }
        return $data;
    }
    //Tinh Tong tien trong chi tiet
    function getPriceInBillDetail($billId)
    {
        $data = 0;
        $query = "SELECT SUM(GIA) FROM `ct_hoadon` WHERE MAHD = '" . $billId . "'";
        $rs = mysqli_query($this->conn, $query);
        while ($row = mysqli_fetch_assoc($rs)) {
            $data[0] = $row;
        }

        return $data[0];
    }

    //Them hoa don
    function addBillAndDetail($billQry, $detailQry)
    {
        if (mysqli_query($this->conn, $billQry)) {
            if (mysqli_query($this->conn, $detailQry)) {
                return true;
            }
            else{
                echo $detailQry;
            }
        }
        return false;
    }
    //Them hoa don
    function addBillAndDetail_Data($bill, $detail,$pay)
    {
        $query1 = "INSERT INTO `hoadon` (`MAHD`, `MANV`, `MAKH`, `NGAYLAP`, `GIOLAP`, `TONG`, `MATRANGTHAI`,`MAKM`,`PAYPAL`) 
        VALUES ('$bill[0]', '$bill[1]', '$bill[2]', '$bill[3]', '$bill[4]', '$bill[5]', '$bill[6]',$pay)";

        $query2 = "INSERT INTO `ct_hoadon` (`MAHD`, `MASP`, `SOLUONG`, `GIA`) VALUES";
        foreach ($detail as $value) {
            $idBill = $value['MAHD'];
            $idProduct = $value['MASP'];
            $amount = $value['SOLUONG'];
            $price = $value['GIA'];
            $query2 .= "('$idBill','$idProduct',$amount,$price),";
        }
        $query2 = substr($query2, 0, strlen($query2) - 1) . ';';
        echo $query1 . '<br>';
        echo $query2;
        if (mysqli_query($this->conn, $query1) && mysqli_query($this->conn, $query2)) {
            return true;
        }
        return false;
    }

    function updateBillStatus($id,$staffId,$status)
    {
        $qry = "UPDATE `hoadon` SET `MATRANGTHAI`='$status',`MANV`='$staffId' WHERE `MAHD`='$id';";
        if (mysqli_query($this->conn, $qry)) {
            return true;
        }
        return false;
    }

    function updateBillStatus_Ex($id,$staffId,$status)
    {
        $qry = "UPDATE `hoadon` SET `MATRANGTHAI`='$status',`MANV_XUAT`='$staffId' WHERE `MAHD`='$id';";
        if (mysqli_query($this->conn, $qry)) {
            return true;
        }
        return false;
    }

    function updateBillStatus_Cus($id,$statusId)
    {
        $qry = "UPDATE `hoadon` SET `MATRANGTHAI`='$statusId' WHERE `MAHD`='$id';";
        if (mysqli_query($this->conn, $qry)) {
            return true;
        }
        return false;
    }
    function exportExcel()
    {
        $result = array();
        $result['NAME'] = '';
        $result['ERROR'] = 0;
        
        try {
            //Data
            $bill = $this->getAllBill();
            $bilDetail = $this->getAllBillDetail();
            //First sheet
            $objPHPExcel = new Spreadsheet();
            
             // Add new sheet
            $objWorkSheet = $objPHPExcel->createSheet(0); //Setting index when creating
            $objWorkSheet->setTitle("Hóa Đơn");
            $numRow = 1;

            $objWorkSheet
            ->setCellValue('A'.$numRow, 'Mã Hóa Đơn')
            ->setCellValue('B'.$numRow, 'Mã Nhân Viên')
            ->setCellValue('C'.$numRow, 'Mã Khách Hàng')
            ->setCellValue('D'.$numRow, 'Ngày Lập')
            ->setCellValue('E'.$numRow, 'Giờ Lập')
            ->setCellValue('F'.$numRow, 'Tổng Tiền')
            ->setCellValue('G'.$numRow, 'Mã Trạng Thái')
            ->setCellValue('H'.$numRow, 'Mã KM');

            foreach($bill as $value){
                ++$numRow;
                $objWorkSheet
                ->setCellValue('A'.$numRow, $value['MAHD'])
                ->setCellValue('B'.$numRow, $value['MANV'])
                ->setCellValue('C'.$numRow, $value['MAKH'])
                ->setCellValue('D'.$numRow, $value['NGAYLAP'])
                ->setCellValue('E'.$numRow, $value['GIOLAP'])
                ->setCellValue('F'.$numRow, $value['TONG'])
                ->setCellValue('G'.$numRow, $value['MATRANGTHAI'])
                ->setCellValue('H'.$numRow, $value['MAKM']);
            }

            // Add new sheet
             $objWorkSheet = $objPHPExcel->createSheet(1); //Setting index when creating
             $objWorkSheet->setTitle("CT Hóa Đơn");
             $numRow = 1;
            $objWorkSheet
            ->setCellValue('A'.$numRow, 'Mã Hóa Đơn')
            ->setCellValue('B'.$numRow, 'Mã Sản Phẩm')
            ->setCellValue('C'.$numRow, 'Số Lượng')
            ->setCellValue('D'.$numRow, 'Giá')
            ->setCellValue('E'.$numRow, 'Phần Trăm Giảm');

            foreach($bilDetail as $value){
                ++$numRow;
                $objWorkSheet
                ->setCellValue('A'.$numRow, $value['MAHD'])
                ->setCellValue('B'.$numRow, $value['MASP'])
                ->setCellValue('C'.$numRow, $value['SOLUONG'])
                ->setCellValue('D'.$numRow, $value['GIA'])
                ->setCellValue('E'.$numRow, $value['PHANTRAMGIAM']);
            }

            $objPHPExcel->setActiveSheetIndex(0);
            $objWriter = new Xlsx($objPHPExcel);
            $filename = 'Bill'.date("dmY_His").'.xlsx';
            $objWriter->save('./public/excel/'.$filename);
            $result['NAME'] = '/CuaHangNoiThat/public/excel/'.$filename;
        } catch (Exception $e) {
            $result['ERROR'] = $e->getMessage();
        }
        return $result;
    }


    function updateStaffExport($id){

    }
}
