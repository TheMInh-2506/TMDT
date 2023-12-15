<?php
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class NhaCungCapDB extends ConnectionDB
{
    //Lay nha cung cap
    function getSupplierById($supplierId)
    {
        $sql = "SELECT * FROM `nhacungcap` WHERE MANCC = '$supplierId'";
        $query = mysqli_query($this->conn, $sql);
        $row = mysqli_fetch_assoc($query);
        return $row;
    }
    //Lay tat ca loai san pham
    function getAllSupplier()
    {
        $sql = "SELECT * FROM `nhacungcap`";
        $query = mysqli_query($this->conn, $sql);
        $arr = array();
        while ($row = mysqli_fetch_assoc($query))
            array_push($arr, $row);
        return $arr;
    }
    //Cap nhat thong tin loai nha cung cap
    function updateInformationSupplier($supplier)
    {
        $sql = "UPDATE `nhacungcap` 
            SET `TENNCC` = '$supplier[TENNCC]', `DIACHI` = '$supplier[DIACHI]',
            `SDT` = '$supplier[SDT]' 
            WHERE `MANCC` = '$supplier[MANCC]' LIMIT 1 ";

        if (mysqli_query($this->conn, $sql)) {
            return true;
        }
        return false;
    }
    //Tao ma nhacungcap tiep theo
    function createNextSupplierId()
    {
        $data = $this->getAllSupplier();
        $lastItem = empty($data) ? array() : end($data);
        if (empty($lastItem)) {
            return 'NCC01';
        } else {
            $lastId = $lastItem['MANCC'];
            $nextIdCount = (int)substr($lastId, 3) + 1;
            while (strlen($nextIdCount) < 2) {
                $nextIdCount = '0' . $nextIdCount;
            }
            return 'NCC' . $nextIdCount;
        }
    }
    //Them nha cung cap
    function addNewSupplier($supplier)
    {
        $id = $this->createNextSupplierId();
        $sql = "INSERT INTO `nhacungcap` (`MANCC` , `TENNCC` ,`DIACHI` ,`SDT` ,`TRANGTHAI`)
            VALUES ('$id', '$supplier[TENNCC]', '$supplier[DIACHI]',
            '$supplier[SDT]', true)";

        if(mysqli_query($this->conn, $sql)){
            return true;
        }
        return false;
    }
    //Xoa nha cung cap
    function block_unblockSupplier($supplierId)
    {
        //Get current status
        $supplier = $this->getSupplierById($supplierId);
        $status = $supplier['TRANGTHAI'];
        $status = $status == 1 ? 0 : 1;
        $sql = "UPDATE `nhacungcap` SET `TRANGTHAI`= $status WHERE MANCC = '$supplierId'";
        $kq = mysqli_query($this->conn, $sql);
        $status = false;
        if ($kq) {
            $status = true;
        }
        return $status;
    }

    function readExcel($data =array()){
         //Upload file to server
         $filename = date("dny_hsi") . $data['name'];
         move_uploaded_file($data['tmp_name'], './public/fileInput/' . $filename);
 
         //create directly an object instance of the IOFactory class, and load the xlsx file
         $fxls = './public/fileInput/'.$filename;
         $spreadsheet = IOFactory::load($fxls);
         //read excel data and store it into an array
         $xls_data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
         //Format to Receipt Array
         array_shift($xls_data);
         array_filter($xls_data);

         $data = array();
         foreach($xls_data as $value){
             $data[] = array(
                 'MANCC'=>$value['A'],
                 'TENNCC'=>$value['B'],
                 'DIACHI'=>$value['C'],
                 'SDT'=>$value['D']
             );
         }
 
        return $data;
    }

    function exportExcel()
    {
        $result = array();
        $result['NAME'] = '';
        $result['ERROR'] = 0;
        
        try {
            //Data
            $supplierList = $this->getAllSupplier();
            
            //First sheet
            $objPHPExcel = new Spreadsheet();
            
             // Add new sheet
            $objWorkSheet = $objPHPExcel->createSheet(0); //Setting index when creating
            $objWorkSheet->setTitle("Nhà Cung Cấp");
            $numRow = 1;

            $objWorkSheet
            ->setCellValue('A'.$numRow, 'Mã Nhà Cung Cấp')
            ->setCellValue('B'.$numRow, 'Tên Nhà Cung Cấp')
            ->setCellValue('C'.$numRow, 'Địa Chỉ')
            ->setCellValue('D'.$numRow, 'SĐT');
            

            foreach($supplierList as $value){
                ++$numRow;
                $objWorkSheet
                ->setCellValue('A'.$numRow, $value['MANCC'])
                ->setCellValue('B'.$numRow, $value['TENNCC'])
                ->setCellValue('C'.$numRow, $value['DIACHI'])
                ->setCellValue('D'.$numRow, $value['SDT']);
            }

            $objPHPExcel->setActiveSheetIndex(0);
            $objWriter = new Xlsx($objPHPExcel);
            $filename = 'Supplier'.date("dmY_His").'.xlsx';
            $objWriter->save('./public/excel/'.$filename);
            $result['NAME'] = '/CuaHangNoiThat/public/excel/'.$filename;
        } catch (Exception $e) {
            $result['ERROR'] = $e->getMessage();
        }
        return $result;
    }
}
?>