<?php
//Model
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PhieuNhapDB extends ConnectionDB
{
    //Lay phieu nhap
    function getReceiptById($receiptId)
    {
        $query = "SELECT * FROM phieunhap WHERE MAPN = '$receiptId'";
        $rs = mysqli_query($this->conn, $query);
        $data[] = mysqli_fetch_assoc($rs);
        return $data;
    }
    //Lay chi tiet phieu nhap
    function getReceiptDetailById($receiptId){
        $data = array();
        $query = "SELECT * FROM ct_phieunhap WHERE MAPN = '$receiptId'";
        $rs = mysqli_query($this->conn, $query);
        while ($row = mysqli_fetch_assoc($rs)) {
            $data[] = $row;
        }
        
        return $data;
    }

    function getReceiptByYear($year){
        $data = $this->getAllReceipt();
        $result = array();

        foreach($data as $value){
            $date = explode('-',$value['NGAYLAP'])[0];
            if($date == $year){
                $result[] = $value;
            }
        }

        return $result;
    }
    //Lay chi tiet phieu nhap
    function getAllReceiptDetail(){
        $data = array();
        $query = "SELECT * FROM ct_phieunhap;";
        $rs = mysqli_query($this->conn, $query);
        while ($row = mysqli_fetch_assoc($rs)) {
            $data[] = $row;
        }
        
        return $data;
    }
    //Lay tat ca phieunhap
    function getAllReceipt()
    {
        $data = array();
        $query = "SELECT * FROM `phieunhap`";
        $rs = mysqli_query($this->conn, $query);
        while ($row = mysqli_fetch_assoc($rs)) {
            $data[] = $row;
        }
        return $data;
    }

    function getAllReceiptFT($from,$to)
    {
        $data = $this->getAllReceipt();
        $result = array();
        foreach($data as $value){
            if(strtotime($from) <= strtotime($value['NGAYLAP']) && strtotime($to) >= strtotime($value['NGAYLAP'])){
                $result[] = $value;
            }
        }
        return $result;
    }
    //Tao maphieunhap tiep theo
    function createNextReceiptId()
    {
        $data = $this->getAllReceipt();

        $lastItem = empty($data) ? array() : end($data);
        if (empty($lastItem)) {
            return 'PN01';
        } else {
            $lastId = $lastItem['MAPN'];
            $nextIdCount = (int)substr($lastId, 2) + 1;
            while (strlen($nextIdCount) < 2) {
                $nextIdCount = '0' . $nextIdCount;
            }
            return 'PN' . $nextIdCount;
        }
    }
    //Lay phieunhap theo nhanvien
    function getBilByStaffId($staffId)
    {
        $query = "SELECT * FROM phieunhap WHERE MANV = '" . $staffId . "'";
        $rs = mysqli_query($this->conn, $query);
        while ($row = mysqli_fetch_assoc($rs)) {
            $data[] = $row;
        }
        return $data;
    }
    //Lay phieunhap theo nhacungcap
    function getBilBySupplierId($supplierId)
    {
        $query = "SELECT * FROM phieunhap WHERE MANCC = '" . $supplierId . "'";
        $rs = mysqli_query($this->conn, $query);
        while ($row = mysqli_fetch_assoc($rs)) {
            $data[] = $row;
        }
        return $data;
    }
    //Tinh Tong tien trong chitietphieunhap
    function getPriceInReceiptDetail($detailId)
    {
        $query = "SELECT SUM(GIA) FROM `ct_phieunhap` WHERE MAPH = '" . $detailId . "'";
        $rs = mysqli_query($this->conn, $query);
        while ($row = mysqli_fetch_assoc($rs)) {
            $data[0] = $row;
        }

        return $data[0];
    }
    //Them phieunhap
    function AddReceiptAndDetail($receipt, $detail)
    {
        $qry = "INSERT INTO `phieunhap`(`MAPN`, `MANV`, `MANCC`, `NGAYLAP`, `GIOLAP`, `TONG`) VALUES ('$receipt[MAPN]','$receipt[MANV]','$receipt[MANCC]','$receipt[NGAYLAP]','$receipt[GIOLAP]',$receipt[TONG]);";
        $rs = mysqli_query($this->conn, $qry);
        if (!$rs) {
            return false;
        }
        $subQry = "INSERT INTO `ct_phieunhap`(`MAPN`, `MASP`, `SOLUONG`, `GIA`) VALUES ";
        foreach ($detail as $value) {
            $subQry .= " ('$value[MAPN]','$value[MASP]',$value[SOLUONG],$value[GIA]),";
        }
        $subQry = substr($subQry, 0, strlen($subQry) - 1);
        if (mysqli_multi_query($this->conn, $subQry)) {
            return true;
        }
        return false;
    }
    function readFileAndConvertToArray($data)
    {
        $filename = date("dny_hsi") . $data['name'];
        move_uploaded_file($data['tmp_name'], './public/fileInput/' . $filename);

        $dataRs = array();
        $myfile = fopen('./public/fileInput/' . $filename, 'r');
        if (!$myfile) {
            return false;
        }
        $newItem = array();
        $count = 1;
        while ($line = fgets($myfile)) {
            $newItem[] = $line;
            $count++;
            if ($count == 7) {
                $count = 1;
                $dataRs[] = $newItem;
                $newItem = array();
            }
        }
        $dataRs[] = $newItem;

        fseek($myfile, 0);
        fclose($myfile);

        $result = array();
        //Chuyen du lieu ve dang theo csdl
        foreach ($dataRs as $key => $value) {
            $masp = isset($value[0]) ? $this->removeSpace($value[0]) : "";
            $tensp = isset($value[1]) ? $this->removeSpace($value[1]) : "";
            $maloai = isset($value[2]) ? $this->removeSpace($value[2]) : "";
            $gia = isset($value[3]) ? $this->removeSpace($value[3]) : "";
            $soluong = isset($value[4]) ? $this->removeSpace($value[4]) : "";
            $hinhanh = isset($value[5]) ? $this->removeSpace($value[5]) : "";

            $result[] = array(
                'MASP' => $masp,
                'TENSP' => $tensp,
                'MALOAI' => $maloai,
                'GIA' => $gia,
                'SOLUONG' => $soluong,
                'HINHANH' => $hinhanh,
            );
        }

        return $result;
    }

    function removeSpace($input)
    {
        return trim(preg_replace('/\s+/', ' ', $input));
    }

    function readExcel($data=array()){
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
                'MASP'=>$value['A'],
                'TENSP'=>$value['B'],
                'MALOAI'=>$value['C'],
                'GIA'=>$value['D'],
                'SOLUONG'=>$value['E'],
                'HINHANH'=>$value['F']
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
            $receipt = $this->getAllReceipt();
            $receiptDetail = $this->getAllReceiptDetail();
            //First sheet
            $objPHPExcel = new Spreadsheet();
            
             // Add new sheet
            $objWorkSheet = $objPHPExcel->createSheet(0); //Setting index when creating
            $objWorkSheet->setTitle("Phiếu Nhập");
            $numRow = 1;

            $objWorkSheet
            ->setCellValue('A'.$numRow, 'Mã Phiếu Nhập')
            ->setCellValue('B'.$numRow, 'Mã Nhân Viên')
            ->setCellValue('C'.$numRow, 'Mã Nhà Cung Cấp')
            ->setCellValue('D'.$numRow, 'Ngày Lập')
            ->setCellValue('E'.$numRow, 'Giờ Lập')
            ->setCellValue('F'.$numRow, 'Tổng Tiền');
            

            foreach($receipt as $value){
                ++$numRow;
                $objWorkSheet
                ->setCellValue('A'.$numRow, $value['MAPN'])
                ->setCellValue('B'.$numRow, $value['MANV'])
                ->setCellValue('C'.$numRow, $value['MANCC'])
                ->setCellValue('D'.$numRow, $value['NGAYLAP'])
                ->setCellValue('E'.$numRow, $value['GIOLAP'])
                ->setCellValue('F'.$numRow, $value['TONG']);
            }

            // Add new sheet
             $objWorkSheet = $objPHPExcel->createSheet(1); //Setting index when creating
             $objWorkSheet->setTitle("CT Phiếu Nhập");
             $numRow = 1;
            $objWorkSheet
            ->setCellValue('A'.$numRow, 'Mã Phiếu Nhập')
            ->setCellValue('B'.$numRow, 'Mã Sản Phẩm')
            ->setCellValue('C'.$numRow, 'Số Lượng')
            ->setCellValue('D'.$numRow, 'Giá');

            foreach($receiptDetail as $value){
                ++$numRow;
                $objWorkSheet
                ->setCellValue('A'.$numRow, $value['MAPN'])
                ->setCellValue('B'.$numRow, $value['MASP'])
                ->setCellValue('C'.$numRow, $value['SOLUONG'])
                ->setCellValue('D'.$numRow, $value['GIA']);
            }

            $objPHPExcel->setActiveSheetIndex(0);
            $objWriter = new Xlsx($objPHPExcel);
            $filename = 'Receipt'.date("dmY_His").'.xlsx';
            $objWriter->save('./public/excel/'.$filename);
            $result['NAME'] = '/CuaHangNoiThat/public/excel/'.$filename;
        } catch (Exception $e) {
            $result['ERROR'] = $e->getMessage();
        }
        return $result;
    }


    function getAllReceiptInMonth($month){
        $data = $this->getAllReceipt();
        $result = array();
        foreach($data as $value){
            if(strpos($value['NGAYLAP'],$month) !== false){
                $result[] = $value;
            }
        }
        return $result;
    }
}
