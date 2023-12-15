<?php
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class NhanVienDB extends ConnectionDB
{
    //Lay nhan vien
    function getStaffById($staffId)
    {
        $qry = "SELECT * FROM `nhanvien` WHERE `MANV`='$staffId';";
        return mysqli_fetch_assoc(mysqli_query($this->conn, $qry));
    }

    function getStaffByUser($staffId)
    {
        $qry = "SELECT * FROM `nhanvien` WHERE `TENDN`='$staffId';";
        return mysqli_fetch_assoc(mysqli_query($this->conn, $qry));
    }
    //Lay tat ca nhan vien
    function getAllStaff($isDisable = false)
    {
        $qry = "SELECT * FROM `nhanvien`";
        $data = array();
        $rs = mysqli_query($this->conn, $qry);
        while ($row = mysqli_fetch_assoc($rs)) {
            $data[] = $row;
        }
        return $data;
    }
    //Cap nhat thong tin nhanvien
    function updateInformationStaff($staff){
        $qry = "UPDATE `nhanvien` SET `TENNV`='$staff[TENNV]',`NGAYSINH`='$staff[NGAYSINH]',`GIOITINH`='$staff[GIOITINH]',`DIACHI`='$staff[DIACHI]',`SDT`='$staff[SDT]',`MAQUYEN`='$staff[MAQUYEN]',`TENDN`='$staff[TENDN]',`MATKHAU`='$staff[MATKHAU]' WHERE `MANV`='$staff[MANV]';";
        
        if(mysqli_query($this->conn,$qry)){
            return true;
        }
        return false;
    }

    function updateStatusStaff($id){
        $qry = "UPDATE `nhanvien` SET `TRANGTHAI`=false WHERE `MANV`='$id';";
        
        if(mysqli_query($this->conn,$qry)){
            return true;
        }
        return false;
    }
    //Tao ma nhanvien tiep theo
    function createNextStaffId(){
        $data = $this->getAllStaff();
        $lastItem = empty($data) ? array() : end($data);
        if (empty($lastItem)) {
            return 'NV01';
        } else {
            $lastId = $lastItem['MANV'];
            $nextIdCount = (int)substr($lastId, 2) + 1;
            while (strlen($nextIdCount) < 2) {
                $nextIdCount = '0' . $nextIdCount;
            }
            return 'NV' . $nextIdCount;
        }
    }
    //Them nhan vien
    function addNewStaff($staff){
        $id = $this->createNextStaffId();
        $hashPassword = md5($staff['MATKHAU']);
        $sql = "INSERT INTO `nhanvien`(`MANV`, `TENNV`, `NGAYSINH`, `GIOITINH`, `DIACHI`, `SDT`, `MAQUYEN`, `TENDN`, `MATKHAU`, `TRANGTHAI`) VALUES ('$id','$staff[TENNV]','$staff[NGAYSINH]','$staff[GIOITINH]','$staff[DIACHI]','$staff[SDT]','','$staff[TENDN]','$hashPassword',true);";

        if(mysqli_query($this->conn, $sql)){
            return true;
        }
        return false;
    }

    function addNewStaffWithId($staff){
        $id = $staff['MANV'];
        $hashPassword = md5($staff['MATKHAU']);
        $sql = "INSERT INTO `nhanvien`(`MANV`, `TENNV`, `NGAYSINH`, `GIOITINH`, `DIACHI`, `SDT`, `MAQUYEN`, `TENDN`, `MATKHAU`, `TRANGTHAI`) VALUES ('$id','$staff[TENNV]','$staff[NGAYSINH]','$staff[GIOITINH]','$staff[DIACHI]','$staff[SDT]','','$staff[TENDN]','$hashPassword',true);";

        if(mysqli_query($this->conn, $sql)){
            return true;
        }
        return false;
    }

    function updateRightOfStaff($id,$right){
        $qry = "UPDATE `nhanvien` SET `QUYEN`='$right' WHERE `MANV`='$id';";
        if(mysqli_query($this->conn,$qry)){
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
            $staffList = $this->getAllStaff();
            
            //First sheet
            $objPHPExcel = new Spreadsheet();
            
             // Add new sheet
            $objWorkSheet = $objPHPExcel->createSheet(0); //Setting index when creating
            $objWorkSheet->setTitle("Nhân Viên");
            $numRow = 1;

            $objWorkSheet
            ->setCellValue('A'.$numRow, 'Mã Nhân Viên')
            ->setCellValue('B'.$numRow, 'Tên Nhân Viên')
            ->setCellValue('C'.$numRow, 'Ngày Sinh')
            ->setCellValue('D'.$numRow, 'Giới Tính')
            ->setCellValue('E'.$numRow, 'Địa Chỉ')
            ->setCellValue('F'.$numRow, 'SĐT')
            ->setCellValue('G'.$numRow, 'Mã Quyền')
            ->setCellValue('H'.$numRow, 'Tên Đăng Nhập')
            ->setCellValue('I'.$numRow, 'Mật Khẩu')
            ->setCellValue('J'.$numRow, 'Trạng Thái');
            

            foreach($staffList as $value){
                ++$numRow;
                $objWorkSheet
                ->setCellValue('A'.$numRow, $value['MANV'])
                ->setCellValue('B'.$numRow, $value['TENNV'])
                ->setCellValue('C'.$numRow, $value['NGAYSINH'])
                ->setCellValue('D'.$numRow, $value['GIOITINH'])
                ->setCellValue('E'.$numRow, $value['DIACHI'])
                ->setCellValue('F'.$numRow, $value['SDT'])
                ->setCellValue('G'.$numRow, $value['MAQUYEN'])
                ->setCellValue('H'.$numRow, $value['TENDN'])
                ->setCellValue('I'.$numRow, $value['MATKHAU'])
                ->setCellValue('J'.$numRow, $value['TRANGTHAI']);
            }

            $objPHPExcel->setActiveSheetIndex(0);
            $objWriter = new Xlsx($objPHPExcel);
            $filename = 'Staff'.date("dmY_His").'.xlsx';
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
                'MANV'=>$value['A'],
                'TENNV'=>$value['B'],
                'NGAYSINH'=>$value['C'],
                'GIOITINH'=>$value['D'],
                'DIACHI'=>$value['E'],
                'SDT'=>$value['F'],
                'MAQUYEN'=>$value['G'],
                'TENDN'=>$value['H'],
                'MATKHAU'=>$value['I']
            );
        }

       return $data;
   }
}
?>