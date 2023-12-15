<?php
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class LoaiSanPhamDB extends ConnectionDB
{
    //Lay loai san pham
    function getProductTypeById($typeId)
    {
        $sql = "SELECT * FROM `loaisanpham` WHERE MALOAI = '$typeId'";
        $query = mysqli_query($this->conn, $sql);
        $row = array();
        $row = mysqli_fetch_assoc($query);
        return $row;
    }
    //Lay tat ca loai san pham
    function getAllProductType()
    {
        $sql = "SELECT * FROM `loaisanpham`";
        $query = mysqli_query($this->conn, $sql);
        $arr = array();
        while ($row = mysqli_fetch_assoc($query))
            array_push($arr, $row);
        return $arr;
    }
    //Cap nhat thong tin loai san pham
    function updateInformationProductType($productType)
    {
        $sql = "UPDATE `loaisanpham` 
            SET `TENLOAI` = '$productType[TENLOAI]', `MOTA` = '$productType[MOTA]'
            WHERE `MALOAI` = '$productType[MALOAI]' LIMIT 1 ";
        if (mysqli_query($this->conn, $sql)) {
            return true;
        }
        return false;
    }
    //Tao ma loai san pham tiep theo
    function createNextProductTypeId(){
        $data = $this->getAllProductType();
        $lastItem = empty($data) ? array() : end($data);
        if (empty($lastItem)) {
            return 'LSP01';
        } else {
            $lastId = $lastItem['MALOAI'];
            $nextIdCount = (int)substr($lastId, 3) + 1;
            while (strlen($nextIdCount) < 2) {
                $nextIdCount = '0' . $nextIdCount;
            }
            return 'LSP' . $nextIdCount;
        }
    }
    //Them loai san pham
    function addNewProductType($productType)
    {
        $nextId = $this->createNextProductTypeId();
        $sql = "INSERT INTO `loaisanpham` (`MALOAI` , `TENLOAI` ,`MOTA`)
            VALUES ('$nextId', '$productType[TENLOAI]', '$productType[MOTA]')";
        //echo $sql.'<br>';
        if (mysqli_query($this->conn, $sql)) {
            return true;
        }
        return false;
    }
    //Xoa
    function disableProductType($typeId, $status = false)
    {
        $sql = "DELETE FROM `loaisanpham` WHERE MALOAI = '$typeId'";
        $kq = mysqli_query($this->conn, $sql);
        if ($kq > 0) {
            $status = true;
        }
        return $status;
    }

    function exportExcel()
    {
        $result = array();
        $result['NAME'] = '';
        $result['ERROR'] = 0;
        
        try {
            //Data
            $supplierList = $this->getAllProductType();
            
            //First sheet
            $objPHPExcel = new Spreadsheet();
            
             // Add new sheet
            $objWorkSheet = $objPHPExcel->createSheet(0); //Setting index when creating
            $objWorkSheet->setTitle("Loại Sản Phẩm");
            $numRow = 1;

            $objWorkSheet
            ->setCellValue('A'.$numRow, 'Mã Loại Sản Phẩm')
            ->setCellValue('B'.$numRow, 'Tên Loại Sản Phẩm')
            ->setCellValue('C'.$numRow, 'Mô Tả');
            

            foreach($supplierList as $value){
                ++$numRow;
                $objWorkSheet
                ->setCellValue('A'.$numRow, $value['MALOAI'])
                ->setCellValue('B'.$numRow, $value['TENLOAI'])
                ->setCellValue('C'.$numRow, $value['MOTA']);
            }

            $objPHPExcel->setActiveSheetIndex(0);
            $objWriter = new Xlsx($objPHPExcel);
            $filename = 'TypeProduct'.date("dmY_His").'.xlsx';
            $objWriter->save('./public/excel/'.$filename);
            $result['NAME'] = '/CuaHangNoiThat/public/excel/'.$filename;
        } catch (Exception $e) {
            $result['ERROR'] = $e->getMessage();
        }
        return $result;
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
                'MALOAI'=>$value['A'],
                'TENLOAI'=>$value['B'],
                'MOTA'=>$value['C']
            );
        }

       return $data;
   }
}

?>