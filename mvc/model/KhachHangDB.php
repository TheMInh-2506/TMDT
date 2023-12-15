<?php
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class KhachHangDB extends ConnectionDB
{
    //Lay khachhang bang maKH
    function getCutomerById($customerId)
    {

        $qry = "SELECT * FROM khachhang WHERE MAKH ='$customerId';";
        $rs = mysqli_query($this->conn, $qry);
        while ($row =  mysqli_fetch_assoc($rs)) {
           return $row;
        }
        return array();
    }
    //Lay khachhang bang tendn
    function getCutomerByUser($customerUser)
    {

        $qry = "SELECT * FROM khachhang WHERE TENDN ='$customerUser';";
        $rs = mysqli_query($this->conn, $qry);
        if ($row =  mysqli_fetch_assoc($rs)) {
           return $row;
        }
        return array();
    }
    //Lay tat ca khach hang
    function getAllCustomer($isDisable = false)
    {
        $data = array();
        $query = "SELECT * FROM khachhang;";
        //$query = "CALL `getAllCustomer`();";
        $rs = mysqli_query($this->conn, $query);
        while ($row = mysqli_fetch_assoc($rs)) {
            $data[] = $row;
        }
        return $data;
    }

function getAllCustomer_Stored()
{
    $data = array();
    $query = "CALL getAllCustomer();";
    $rs = mysqli_query($this->conn, $query);

    if ($rs === false) {
        // Handle stored procedure execution error
        throw new Exception("Stored procedure execution failed: " . mysqli_error($this->conn));
    }

    while ($row = mysqli_fetch_assoc($rs)) {
        $data[] = $row;
    }

    return $data;
}
    //Cap nhat thong tin khach hang
    function updateInformationCustomer($customer)
    {
        $id = $customer['id'];
        $name = $customer['name'];
        $address = $customer['address'];
        $phone = $customer['phone'];
        $sex = $customer['sex'];
        

        $qry = "UPDATE `khachhang` SET `TENKH`='$name',`GIOITINH`='$sex',`DIACHI`='$address',`SDT`='$phone',`NGAYSINH`='$customer[birthday]' WHERE `MAKH` = '$id';";

        if(mysqli_query($this->conn,$qry)){
            $cus = $this->getCutomerById($id);
            $_SESSION['account'] = $cus;
            return true;
        }
        return false;
    }
    //Tao ma khach hang tiep theo
    function createNextCustomerId(){
        $data = $this->getAllCustomer();
        $lastItem = empty($data) ? array() : end($data);
        if (empty($lastItem)) {
            return 'KH01';
        } else {
            $lastId = $lastItem['MAKH'];
            $nextIdCount = (int)substr($lastId, 2) + 1;
            while (strlen($nextIdCount) < 2) {
                $nextIdCount = '0' . $nextIdCount;
            }
            return 'KH' . $nextIdCount;
        }
    }
    //Them khach hang
    function addNewCustomer($customer)
    {
        $cusId = $customer['MAKH'];
        $cusName = $customer['TENKH'];
        $cusNameLogin = $customer['TENDN'];
        $cusPass = $customer['MATKHAU'];
        $cusAddr = $customer['DIACHI'];
        $cusPhone = $customer['SDT'];
        $cusStatus = $customer['TRANGTHAI'];

        $qry = "INSERT INTO khachhang (MAKH, TENKH,NGAYSINH,GIOITINH, TENDN, MATKHAU, DIACHI, SDT, TRANGTHAI) VALUES ('$cusId', '$cusName','$customer[NGAYSINH]','$customer[GIOITINH]', '$cusNameLogin', '$cusPass', '$cusAddr', '$cusPhone', $cusStatus);";
        if (mysqli_query($this->conn, $qry) == false) {
            return false;
        }
        return true;
    }
    //Sua trang thai khach hang
    function block_unblockCutomer($customerId){
        $customer = $this->getCutomerById($customerId);
        $currentStatus = $customer['TRANGTHAI'];
        $inverseStatus = ($currentStatus == 1 ? 'false':'true');
        $qry = "UPDATE `khachhang` SET `TRANGTHAI`=$inverseStatus WHERE `MAKH`='$customerId';";

        if(mysqli_query($this->conn,$qry)){
            return true;
        }
        return false;
    }
    //Cap nhat tendangnhap va matkhau
    function updateAccountCutomer($id, $password)
    {
        $qry = "UPDATE `khachhang` SET `MATKHAU`='$password' WHERE `MAKH`='$id';";
        return mysqli_query($this->conn,$qry);
    }

    function exportExcel()
    {
        $result = array();
        $result['NAME'] = '';
        $result['ERROR'] = 0;
        
        try {
            //Data
            $staffList = $this->getAllCustomer();
            
            //First sheet
            $objPHPExcel = new Spreadsheet();
            
             // Add new sheet
            $objWorkSheet = $objPHPExcel->createSheet(0); //Setting index when creating
            $objWorkSheet->setTitle("Nhân Viên");
            $numRow = 1;

            $objWorkSheet
            ->setCellValue('A'.$numRow, 'Mã Khách hàng')
            ->setCellValue('B'.$numRow, 'Tên Khách Hàng')
            ->setCellValue('C'.$numRow, 'Giới Tính')
            ->setCellValue('D'.$numRow, 'Tên Đăng Nhập')
            ->setCellValue('E'.$numRow, 'Địa Chỉ')
            ->setCellValue('F'.$numRow, 'SĐT')
            ->setCellValue('G'.$numRow, 'Trạng Thái');
            

            foreach($staffList as $value){
                ++$numRow;
                $objWorkSheet
                ->setCellValue('A'.$numRow, $value['MAKH'])
                ->setCellValue('B'.$numRow, $value['TENKH'])
                ->setCellValue('C'.$numRow, $value['GIOITINH'])
                ->setCellValue('D'.$numRow, $value['TENDN'])
                ->setCellValue('E'.$numRow, $value['DIACHI'])
                ->setCellValue('F'.$numRow, $value['SDT'])
                ->setCellValue('G'.$numRow, $value['TRANGTHAI']);
            }

            $objPHPExcel->setActiveSheetIndex(0);
            $objWriter = new Xlsx($objPHPExcel);
            $filename = 'Customer'.date("dmY_His").'.xlsx';
            $objWriter->save('./public/excel/'.$filename);
            $result['NAME'] = '/CuaHangNoiThat/public/excel/'.$filename;
        } catch (Exception $e) {
            $result['ERROR'] = $e->getMessage();
        }
        return $result;
    }
}
?>