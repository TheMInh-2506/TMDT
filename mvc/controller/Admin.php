<?php

use LDAP\Result;

use function Complex\add;

class Admin extends Controller
{
    function display()
    {
        $objProduct = $this->getModel('SanPhamDB');
        $objBill = $this->getModel('HoaDonDB');
        $objCustomer = $this->getModel('KhachHangDB');
        $objStaff = $this->getModel('NhanVienDB');

        $result = array(
            'countProduct' => count($objProduct->getAllProduct()),
            'countBill' => count($objBill->getAllBill()),
            'countCustomer' => count($objCustomer->getAllCustomer()),
            'countStaff' => count($objStaff->getAllStaff())
        );

        require_once('./menuadmin.php');
        $this->View('AdminTrangChu', 'Trang Chủ', $result);
    }

    /* ===========================HOA DON================================ */
    function HoaDon()
    {
        require_once('./menuadmin.php');
        $this->View('AdminHoaDon', 'Admin Hóa Đơn');
    }

    function XemChiTietHD($id)
    {
        $objBillDetail = $this->getModel('HoaDonDB');
        $bill = $objBillDetail->getBillById($id)[0];
        $objProduct = $this->getModel('SanPhamDB');
        $objSale = $this->getModel('KhuyenMaiDB');
        $data = $objBillDetail->getBillDetailById($id);
        foreach ($data as $key => $value) {
            $product = $objProduct->getProductById($value['MASP']);
            $data[$key]['TENSP'] = $product['TENSP'];
            $data[$key]['HINHANH'] = $product['HINHANH'];
        }
        $data['data'] = $data;
        $data['sale'] = $objSale->getSaleById($bill['MAKM']);
        require_once('./menuadmin.php');
        $this->View('AdminChiTietHoaDon', 'Admin Chi Tiết HĐ', $data);
    }
    function TimKiemHoaDon()
    {
        require_once('./menuadmin.php');
        $this->View('AdminTimKiemHoaDon', 'Tìm kiếm hóa đơn');
    }

    function getAllBill()
{
    $obj = $this->getModel('HoaDonDB');
    $objStatus = $this->getModel('TrangThaiDB');
    $objStaff = $this->getModel('NhanVienDB');
    $objCustomer = $this->getModel('KhachHangDB');
    $objSale = $this->getModel('KhuyenMaiDB');

    $data = $obj->getAllBill();
    foreach ($data as $key => $value) {
        $staff = $objStaff->getStaffById($value['MANV']);
        $exStaff = $objStaff->getStaffById($value['MANV_XUAT']);
        $status = $value['MATRANGTHAI'];
        $customer = $objCustomer->getCutomerById($value['MAKH']);
        $data[$key]['MOTATRANGTHAI'] = $objStatus->getStatusNameById($status)['MOTATRANGTHAI'];
        $data[$key]['TENNV'] = $staff['TENNV'];
        $data[$key]['TENNV_XUAT'] = $exStaff['TENNV'];
        $data[$key]['TENKH'] = $customer['TENKH'];
        $data[$key]['PHANTRAMGIAM'] = $objSale->getSaleById($value['MAKM'])['PHANTRAMGIAM'];
    }

    echo json_encode($data);
}

    function getBillAndDetail()
    {
        if (!isset($_POST['id'])) {
            echo -1;
            return;
        }
        $id = $_POST['id'];
        $objBill = $this->getModel("HoaDonDB");
        $objStaff = $this->getModel('NhanVienDB');
        $objCustomer = $this->getModel('KhachHangDB');
        $objProduct = $this->getModel('SanPhamDB');
        $objSale = $this->getModel('KhuyenMaiDB');


        $data = array();
        $data['bill'] = $objBill->getBillById($id)[0];
        $data['bill']['TENNV'] = $objStaff->getStaffById($data['bill']['MANV'])['TENNV'];
        $data['bill']['TENNV_XUAT'] = $objStaff->getStaffById($data['bill']['MANV_XUAT'])['TENNV'];
        $data['bill']['TENKH'] = $objCustomer->getCutomerById($data['bill']['MAKH'])['TENKH'];
        $data['bill']['SALE'] = $objSale->getSaleById($data['bill']['MAKM']);
        $data['detail'] = $objBill->getBillDetailById($id);
        foreach ($data['detail'] as $key => $value) {
            $product = $objProduct->getProductById($value['MASP']);
            $data['detail'][$key]['TENSP'] = $product['TENSP'];
            $data['detail'][$key]['MASP'] = $product['MASP'];
        }
        echo json_encode($data);
    }


    function getReceiptAndDetail()
    {
        if (!isset($_POST['id'])) {
            echo -1;
            return;
        }
        $id = $_POST['id'];
        $objReceipt = $this->getModel("PhieuNhapDB");
        $objStaff = $this->getModel('NhanVienDB');
        $objSupplier = $this->getModel('NhaCungCapDB');
        $objProduct = $this->getModel('SanPhamDB');


        $data = array();
        $data['receipt'] = $objReceipt->getReceiptById($id)[0];
        $data['receipt']['TENNV'] = $objStaff->getStaffById($data['receipt']['MANV'])['TENNV'];
        $data['receipt']['TENNCC'] = $objSupplier->getSupplierById($data['receipt']['MANCC'])['TENNCC'];

        $data['detail'] = $objReceipt->getReceiptDetailById($id);
        foreach ($data['detail'] as $key => $value) {
            $product = $objProduct->getProductById($value['MASP']);
            $data['detail'][$key]['TENSP'] = $product['TENSP'];
        }
        echo json_encode($data);
    }

    
    function updateBillStatus($status = 'TT02')
    {

        if (!isset($_POST['id'])) {
            echo -1;
            return;
        }
        $id = $_POST['id'];
        $idStaff = $_SESSION['staff']['MANV'];
        $objBill = $this->getModel("HoaDonDB");
        $objProduct = $this->getModel('SanPhamDB');
        if ($objBill->updateBillStatus_Ex($id, $idStaff, $status)) {
            echo 0;
            if($status == 'TT02'){
                $billDetail = $objBill->getBillDetailById($id);
                foreach($billDetail as $key=>$value){
                    $billDetail[$key]['amount'] = $value['SOLUONG'];
                    if($objProduct->updateNumberListProduct($billDetail)){
                        echo 0;
                    }
                }
            }
            return;
        }
        echo -1;
    }

    function exportBillToExcel()
    {
        $objBill = $this->getModel('HoaDonDB');
        $data = $objBill->exportExcel();
        echo json_encode($data);
    }

    function submitBill($id)
    {
        $objBill = $this->getModel("HoaDonDB");
        $result = array();
        $result['SMS'] = 'Lỗi khi cập nhật';
        if ($objBill->updateBillStatus_Cus($id, 'TT03')) {
            $result['SMS'] = 'Cập nhật thành công';
        }

        echo json_encode($result);
    }

    function destroyBill($id)
    {
        $objBill = $this->getModel("HoaDonDB");
        $result = array();
        $result['SMS'] = 'Lỗi khi hủy';
        if ($objBill->updateBillStatus_Cus($id, 'TT04')) {
            $result['SMS'] = 'Hủy thành công';
        }

        echo json_encode($result);
    }

    function getCusBillAndDetailBill()
    {
        if (!isset($_SESSION['account'])) {
            echo json_encode(array());
            return;
        }
        $obj = $this->getModel('HoaDonDB');
        $objSale = $this->getModel("KhuyenMaiDB");

        $data = $obj->getBillByCusId($_SESSION['account']['MAKH']);
        foreach ($data as $key => $value) {
            $sumBill = 0;
            foreach ($obj->getBillDetailById($value['MAHD']) as $subvalue) {
                $sumBill += $subvalue['GIA'] * $subvalue['SOLUONG'] * (1 - $subvalue['PHANTRAMGIAM'] / 100);
            }

            $saleId = $value['MAKM'];

            $sale = $objSale->getSaleById($saleId);
            $data[$key]['LAST_PRICE'] = (1 - $sale['PHANTRAMGIAM'] / 100) * $sumBill;
        }

        echo json_encode($data);
    }
    /*===================================================================== */
    /* ===========================KHACH HANG================================ */
    function KhachHang()
    {
        require_once('./menuadmin.php');
        $this->View('AdminKhachHang', 'Admin Khách Hàng');
    }
    function ThemKhachHang()
    {
        require_once('./menuadmin.php');
        $this->View('AdminThemKhachHang', 'Admin Thêm Khách Hàng');
    }
    function TimKiemKhachHang()
    {
        require_once('./menuadmin.php');
        $this->View('AdminTimKiemKhachHang', 'Admin Tìm kiếm khách hàng');
    }
    function SuaKhachHang($id)
    {
        require_once('./menuadmin.php');
        $this->View('AdminSuaKhachHang', 'Admin sửa khách hàng', $id);
    }

    function getAllCustomer()
    {
        $objCus = $this->getModel('KhachHangDB');

        echo json_encode($objCus->getAllCustomer_Stored());
    }

    function block_unblockCutomer($id)
    {
        if (!isset($_SESSION['staff']) ) {
            echo '<script>alert("Bạn không có quyền thực hiên chức năng này !!!");window.location.href="./";</script>';
            return;
        }
        $objCus = $this->getModel('KhachHangDB');
        if ($objCus->block_unblockCutomer($id)) {
            echo '0';
        } else {
            echo -1;
        }
    }

    function exportCustomerToExcel()
    {
        $objCustomer = $this->getModel('KhachHangDB');
        $data = $objCustomer->exportExcel();
        echo json_encode($data);
    }

    function checkLoginCustomer($user, $pass)
    {
        $objCustomer = $this->getModel('KhachHangDB');
        $cus = $objCustomer->getCutomerByUser($user);
        $pass = hash('md5', $pass);
        $result = array();
        $result['URL'] = 'TrangChu';
        if (empty($cus)) {
            $result['RESULT'] = "NOT_EXISTS";
        } else {
            if ($pass == $cus['MATKHAU']) {
                $result['RESULT'] = "SUCCESS";
                $result['DATA'] = $cus;
                $_SESSION['account'] = $cus;
                if ($cus['TRANGTHAI'] == 0) {
                    $result['RESULT'] = "BLOCK";
                }
            } else {
                $result['RESULT'] = "WRONG_PASSWORD";
            }
        }
        echo json_encode($result);
    }

    function saveInfoAccount($data)
    {
        $data = json_decode($data);
        $objCustomer = $this->getModel("KhachHangDB");
        $cusId = $_SESSION['account']['MAKH'];
        $customer = array(
            'id' => $cusId,
            'name' => $data[0],
            'address' => $data[1],
            'phone' => $data[2],
            'sex' => $data[3],
            'birthday' => $data[4]
        );

        $result = array();

        $result['SMS'] = 'Cập nhật không thành công';
        if ($objCustomer->updateInformationCustomer($customer)) {
            $result['SMS'] = 'Cập nhật thành công';
        }
        echo json_encode($result);
    }
    /*===================================================================== */
    /*============================== KHUYEN MAI ============================ */
    function KhuyenMai()
    {
        require_once('./menuadmin.php');
        $this->View('AdminKhuyenMai', 'Admin Khuyến Mãi');
    }
    function ThemKhuyenMai()
    {
        if (!isset($_SESSION['staff']) ) {
            echo '<script>alert("Bạn không có quyền thực hiên chức năng này !!!");window.location.href="./KhuyenMai";</script>';
            return;
        }
        require_once('./menuadmin.php');
        $this->View('AdminThemKhuyenMai', 'Admin Thêm Khuyến mãi');
    }
    function TimKiemKhuyenMai()
    {
        require_once('./menuadmin.php');
        $this->View('AdminTimKiemKhuyenMai', 'Admin Tìm kiếm Khuyến mãi');
    }
    function SuaKhuyenMai($id)
    {
        if (!isset($_SESSION['staff']) ) {
            echo '<script>alert("Bạn không có quyền thực hiên chức năng này !!!");window.location.href="../KhuyenMai";</script>';
            return;
        }
        $objSale = $this->getModel('KhuyenMaiDB');
        $sale = $objSale->getSaleById($id);
        require_once('./menuadmin.php');
        $this->View('AdminSuaKhuyenMai', 'Admin sửa Khuyến mãi', $sale);
    }

    function getAllSale()
    {
        $objSale = $this->getModel('KhuyenMaiDB');
        echo json_encode($objSale->getAllSales());
    }

    function updateInforSale()
    {
        $sale = $_POST['data'];
        $objSale = $this->getModel('KhuyenMaiDB');
        if ($objSale->updateInformationSale($sale)) {
            echo 'Sửa Thành Công';
        } else {
            echo 'Không thể sửa';
        }
    }

    function addNewSale()
    {
        $sale = $_POST['data'];
        $objSale = $this->getModel('KhuyenMaiDB');
        if ($objSale->addNewSale($sale)) {
            echo 'Thêm Thành Công';
        } else {
            echo 'Không thể thêm';
        }
    }

    function disabledSale($id)
    {
        $objSale = $this->getModel('KhuyenMaiDB');
        $result = array();

        if ($objSale->disabledSale($id)) {
            $result['SMS'] = 'Xóa thành công';
        } else {
            $result['SMS'] = 'Lỗi khi xóa';
        }

        echo json_encode($result);
    }
    /*===================================================================== */
    /*============================== LOAI SAN PHAM ============================ */
    function LoaiSanPham()
    {
        require_once('./menuadmin.php');
        $this->View('AdminLoaiSanPham', 'Admin Loại Sản Phẩm');
    }
    function ThemLoaiSanPham()
    {
        if (!isset($_SESSION['staff']) ) {
            echo '<script>alert("Bạn không có quyền thực hiên chức năng này !!!");window.location.href="./LoaiSanPham";</script>';
            return;
        }
        require_once('./menuadmin.php');
        $this->View('AdminThemLoaiSanPham', 'Admin Thêm Loại Sản Phẩm');
    }
    function SuaLoaiSanPham($id)
    {
        if (!isset($_SESSION['staff']) ) {
            echo '<script>alert("Bạn không có quyền thực hiên chức năng này !!!");window.location.href="../LoaiSanPham";</script>';
            return;
        }
        $objType = $this->getModel('LoaiSanPhamDB');
        $typeProduct = $objType->getProductTypeById($id);
        require_once('./menuadmin.php');
        $this->View('AdminSuaLoaiSanPham', 'Admin Sửa Loại Sản Phẩm', $typeProduct);
    }

    function getAllProductType()
    {
        $objType = $this->getModel('LoaiSanPhamDB');
        echo json_encode($objType->getAllProductType());
    }

    function updateInformationProductType($typeProduct = array())
    {
        if (isset($_POST['data'])) {
            $typeProduct = $_POST['data'];
        }
        $objType = $this->getModel('LoaiSanPhamDB');

        if ($objType->updateInformationProductType($typeProduct)) {
            echo 0;
        } else {
            echo -1;
        }
    }

    function addNewTypeProduct($typeProduct = array())
    {
        if (isset($_POST['data'])) {
            $typeProduct = $_POST['data'];
        }
        $objType = $this->getModel('LoaiSanPhamDB');

        if ($objType->addNewProductType($typeProduct)) {
            echo 0;
        } else {
            echo -1;
        }
    }

    function exportTypeProductToExcel()
    {
        $typeProduct = $this->getModel('LoaiSanPhamDB');
        $data = $typeProduct->exportExcel();
        echo json_encode($data);
    }

    function readExcelTypeProduct()
    {
        $typeProduct = $this->getModel("LoaiSanPhamDB");
        $data = $typeProduct->readExcel($_FILES['file']);

        //Check valid data
        foreach ($data as $key => $value) {
            if ($value['MALOAI'] == '') {
                unset($data[$key]);
                continue;
            }
            if ($value['TENLOAI'] == '') {
                unset($data[$key]);
                continue;
            }
            if ($value['MOTA'] == '') {
                unset($data[$key]);
                continue;
            }
        }
        array_filter($data);
        echo json_encode(array('data' => $data, 'dataDB' => $typeProduct->getAllProductType()));
    }

    /*========================================================================= */
    /*============================== NHA CUNG CAP ============================ */
    function NhaCungCap()
    {
        if (!isset($_SESSION['staff'])) {
            echo '<script>alert("Bạn không có quyền thực hiên chức năng này !!!");window.location.href="./";</script>';
            return;
        }
        require_once('./menuadmin.php');
        $this->View('AdminNhaCungCap', 'Admin Nhà Cung Cấp');
    }
    function ThemNhaCungCap()
    {
        require_once('./menuadmin.php');
        $this->View('AdminThemNhaCungCap', 'Admin Thêm Nhà Cung Cấp');
    }
    function SuaNhaCungCap($id)
    {
        $objSupplier = $this->getModel("NhaCungCapDB");
        $supplier = $objSupplier->getSupplierById($id);
        require_once('./menuadmin.php');
        $this->View('AdminSuaNhaCungCap', 'Admin Sửa Nhà Cung Cấp', $supplier);
    }

    function getAllSupplier()
    {
        $objSupplier = $this->getModel("NhaCungCapDB");
        echo json_encode($objSupplier->getAllSupplier());
    }

    function block_unblockSupplier($idSupplier)
    {
        $objSupplier = $this->getModel("NhaCungCapDB");
        if ($objSupplier->block_unblockSupplier($idSupplier)) {
            echo 0;
        } else {
            echo -1;
        }
    }

    function updateInformationSupplier()
    {
        $supplier = $_POST['data'];
        $objSupplier = $this->getModel("NhaCungCapDB");
        if ($objSupplier->updateInformationSupplier($supplier)) {
            echo 0;
        } else {
            echo -1;
        }
    }

    function addNewSupplier()
    {
        $objSupplier = $this->getModel("NhaCungCapDB");
        $supplier = $_POST['data'];
        if ($objSupplier->addNewSupplier($supplier)) {
            echo 0;
        } else {
            echo -1;
        }
    }

    function readExcelSupplier()
    {
        $objSupplier = $this->getModel("NhaCungCapDB");
        $data = $objSupplier->readExcel($_FILES['file']);

        //print_r($data);
        //Check valid data
        foreach ($data as $key => $value) {
            if ($value['TENNCC'] == '') {
                unset($data[$key]);
                continue;
            }
            if ($value['DIACHI'] == '') {
                unset($data[$key]);
                continue;
            }
            if (strlen($value['SDT']) < 10 || strlen($value['SDT']) > 11 || $value['SDT'][0] != '0' || !is_numeric($value['SDT'])) {
                unset($data[$key]);
                continue;
            }
        }
        array_filter($data);
        echo json_encode(array('data' => $data, 'dataDB' => $objSupplier->getAllSupplier()));
    }

    function exportSupplierToExcel()
    {
        $objSupplier = $this->getModel('NhaCungCapDB');
        $data = $objSupplier->exportExcel();
        echo json_encode($data);
    }
    /*========================================================================= */

    /* =========================NHAN VIEN===================================*/
    function NhanVien()
    {
        /*if (!isset($_SESSION['staff']) ) {
            echo '<script>alert("Bạn không có quyền thực hiên chức năng này !!!");window.location.href="./";</script>';
            return;
        }
        $obj = $this->getModel('QuyenDB');
        $data = array();
        $data['Right'] = $obj->getAllRight();*/
        require_once('./menuadmin.php');
        $this->View('AdminNhanVien', 'Admin Nhân Viên');
    }
    function ThemNhanVien()
    {
        $data = array();
        $obj = $this->getModel('QuyenDB');
        require_once('./menuadmin.php');
        $this->View('AdminThemNhanVien', 'Admin Thêm Nhân Viên', $data);
    }
    function TimKiemNhanVien()
    {
        require_once('./menuadmin.php');
        $this->View('AdminTimKiemNhanVien', 'Admin Tìm kiếm nhân viên');
    }
    function SuaNhanVien($id)
    {
        $data = array();
        $objRight = $this->getModel('QuyenDB');
        $objStaff = $this->getModel('NhanVienDB');

        $data['Right'] = $objRight->getAllRight();
        $data['Staff'] = $objStaff->getStaffById($id);
        require_once('./menuadmin.php');
        $this->View('AdminSuaNhanVien', 'Admin sửa nhân viên', $data);
    }

    function getAllStaff()
    {
        $objStaff = $this->getModel('NhanVienDB');
        $objRight = $this->getModel('QuyenDB');
        $data = $objStaff->getAllStaff();
        //getRightById
        foreach ($data as $key => $value) {
            //$data[$key]['RIGHT'] = $objRight->getRightById($value['MAQUYEN']);
            $data[$key]['STAFF_LOGIN'] = $_SESSION['staff']['MANV'];
        }
        echo json_encode($data);
    }

    function updateInfoStaff()
    {
        $staff = $_POST['data'];
        $staff['MATKHAU'] = md5($staff['MATKHAU']);
        $objStaff = $this->getModel('NhanVienDB');
        if ($objStaff->updateInformationStaff($staff)) {
            echo 'Cập nhật thành công';
        } else {
            echo 'Không thể cập nhật';
        }
    }

    function updateStatusStaff()
    {
        $staffId = $_POST['data'];
        $objStaff = $this->getModel('NhanVienDB');
        if ($objStaff->updateStatusStaff($staffId)) {
            echo 'Cập nhật thành công';
        } else {
            echo 'Không thể cập nhật';
        }
    }

    function exportStaffToExcel()
    {
        $objSupplier = $this->getModel('NhanVienDB');
        $data = $objSupplier->exportExcel();
        echo json_encode($data);
    }

    function addNewStaff()
    {
        $staff = $_POST['data'];
        $objStaff = $this->getModel('NhanVienDB');
        if ($objStaff->addNewStaff($staff)) {
            echo 0;
        } else {
            echo -1;
        }
    }

    function addNewStaffWithId()
    {
        $staff = $_POST['data'];
        $objStaff = $this->getModel('NhanVienDB');
        if ($objStaff->addNewStaffWithId($staff)) {
            echo 0;
        } else {
            echo -1;
        }
    }

    function updateRightOfStaff()
    {
        $objStaff = $this->getModel('NhanVienDB');
        if ($objStaff->updateRightOfStaff($_POST['id'], $_POST['right'])) {
            echo 0;
        } else {
            echo -1;
        }
    }

    function readExcelStaff()
    {
        $objSupplier = $this->getModel("NhanVienDB");
        $data = $objSupplier->readExcel($_FILES['file']);


        //print_r($data);
        //Check valid data
        foreach ($data as $key => $value) {
            if ($value['MANV'] == '') {
                unset($data[$key]);
                continue;
            }
            if ($value['TENNV'] == '') {
                unset($data[$key]);
                continue;
            }
            if ($value['NGAYSINH'] == '') {
                unset($data[$key]);
                continue;
            }
            if ($value['GIOITINH'] == '') {
                unset($data[$key]);
                continue;
            }
            if ($value['DIACHI'] == '') {
                unset($data[$key]);
                continue;
            }
            if (strlen($value['SDT']) < 10 || strlen($value['SDT']) > 11 || $value['SDT'][0] != '0' || !is_numeric($value['SDT'])) {
                unset($data[$key]);
                continue;
            }
            if ($value['MAQUYEN'] == '') {
                unset($data[$key]);
                continue;
            }
            if ($value['TENDN'] == '') {
                unset($data[$key]);
                continue;
            }
            if ($value['MATKHAU'] == '') {
                unset($data[$key]);
                continue;
            }
        }
        array_filter($data);
        echo json_encode(array('data' => $data, 'dataDB' => $objSupplier->getAllStaff()));
    }

    /* ============================================================*/
    /* ========================== PHIEU NHAP==================================*/
    function PhieuNhap()
    {
        if (!isset($_SESSION['staff'])) {
            echo '<script>alert("Bạn không có quyền thực hiên chức năng này !!!");window.location.href="./";</script>';
            return;
        }
        require_once('./menuadmin.php');
        $this->View('AdminPhieuNhap', 'Admin Quản Kho');
    }
    function ThemPhieuNhap()
    {
        $data = array();
        $objTypeProduct = $this->getModel('LoaiSanPhamDB');
        $objSupplier = $this->getModel('NhaCungCapDB');
        $objProduct = $this->getModel('SanPhamDB');

        $data['NCC'] = $objSupplier->getAllSupplier();
        $data['TypeProduct'] = $objTypeProduct->getAllProductType();
        $data['Product'] = $objProduct->getAllProduct();
        $data['NEXT_ID'] = $objProduct->createNextproductId();
        require_once('./menuadmin.php');
        $this->View('AdminThemPhieuNhap', 'Admin Thêm Phiếu Nhập', $data);
    }
    function TimKiemPhieuNhap()
    {
        require_once('./menuadmin.php');
        $this->View('AdminTimKiemPhieuNhap', 'Admin Tìm Kiếm Phiếu Nhập');
    }
    function XemCHiTietPhieuNhap($id)
    {
        $objReceiptDetail = $this->getModel('PhieuNhapDB');
        $objProduct = $this->getModel('SanPhamDB');
        $objSale = $this->getModel('KhuyenMaiDB');
        $data = $objReceiptDetail->getReceiptDetailById($id);
        foreach ($data as $key => $value) {
            $product = $objProduct->getProductById($value['MASP']);
            $data[$key]['TENSP'] = $product['TENSP'];
            $data[$key]['HINHANH'] = $product['HINHANH'];
        }
        $data['data'] = $data;

        require_once('./menuadmin.php');
        $this->View('AdminChiTietPhieuNhap', 'Admin Chi Tiết Phiếu Nhập', $data);
    }

    function getAllReceipt()
    {
        $objReceipt = $this->getModel('PhieuNhapDB');
        $objStaff = $this->getModel('NhanVienDB');
        $objSupplier = $this->getModel('NhaCungCapDB');

        $data = $objReceipt->getAllReceipt();
        foreach ($data as $key => $value) {
            $data[$key]['TENNV'] = $objStaff->getStaffById($value['MANV'])['TENNV'];

            $data[$key]['TENNCC'] = $objSupplier->getSupplierById($value['MANCC'])['TENNCC'];
        }

        echo json_encode($data);
    }

    function AddReceiptToDb()
    {
        $dataProduct = $_POST['data'];
        $objReceipt = $this->getModel('PhieuNhapDB');
        $objProduct = $this->getModel('SanPhamDB');
        //Count sum of receipt
        $sum = 0;
        foreach ($dataProduct as $value) {
            $sum += $value['GIA'] * $value['SOLUONG'];
        }

        $receipt = array(
            'MANV' => $_POST['staffid'],
            'MANCC' => $_POST['supplierId'],
            'MAPN' => $objReceipt->createNextReceiptId(),
            'NGAYLAP' => date('Y-m-d'),
            'GIOLAP' => date('h:i:s'),
            'TONG' => $sum
        );

        //detail of receipt
        $detailReceipt = array();
        //New product
        $newProduct = array();
        //Exist Product
        $existProduct = array();
        foreach ($dataProduct as $value) {
            if (empty($objProduct->getProductById($value['MASP']))) {
                $newProduct[] = $value;
            } else {
                $existProduct[] = array(
                    'MASP' => $value['MASP'],
                    'SOLUONG' => $value['SOLUONG']
                );
            }
            $detailReceipt[] = array(
                'MAPN' => $receipt['MAPN'],
                'MASP' => $value['MASP'],
                'SOLUONG' => $value['SOLUONG'],
                'GIA' => $value['GIA']
            );
        }

        //Update product
        if (!empty($newProduct)) {
            $result = $objProduct->addNewProduct($newProduct);
            if (!$result) {
                echo 'ERROR_ADD_NEW';
                return;
            }
        }

        if (!empty($existProduct)) {
            $result = $objProduct->updateNumberListProduct_Receipt($existProduct);
            if (!$result) {
                echo 'ERROR_ADD_EXIST';
                return;
            }
        }
        //Update receipt
        $result = $objReceipt->AddReceiptAndDetail($receipt, $detailReceipt);
        echo $result ? 0 : "ERROR_ADD_RECEIPT_AND_DETAIL";
    }

    function compareTo($detail1, $detail2)
    {
        if (
            $detail1['MASP'] != $detail2['MASP'] ||
            $detail1['TENSP'] != $detail2['TENSP'] ||
            $detail1['MALOAI'] != $detail2['MALOAI'] ||
            $detail1['GIA'] != $detail2['GIA'] ||
            $detail1['HINHANH'] != $detail2['HINHANH']
        ) {
            return false;
        }
        if (
            strcmp($detail1['MASP'], $detail2['MASP']) != 0 ||
            strcmp($detail1['TENSP'], $detail2['TENSP']) != 0 ||
            strcmp($detail1['MALOAI'], $detail2['MALOAI']) != 0 ||
            $detail1['MASP'] != $detail2['MASP'] ||
            strcmp($detail1['HINHANH'], $detail2['HINHANH']) != 0
        ) {
            return false;
        }
        return true;
    }

    function readDetailReceiptFromFile()
    {
        $objReceipt = $this->getModel("PhieuNhapDB");
        $objProduct = $this->getModel("SanPhamDB");
        $objTypeProduct = $this->getModel("LoaiSanPhamDB");
        $data = $objReceipt->readExcel($_FILES['file']);


        $countArray = array(
            'sumRow' => count($data),
            'sumFilterRow' => 0,
            'sumInvalidRow' => 0,
            'sumValidRow' => 0,
            'sumExistRow' => 0,
            'sumNewRow' => 0
        );

        // Group number of product same as id
        $tmp = $data;
        $data = array();
        while (!empty($tmp)) {
            $item = end($tmp);
            $sumOfNumber = 0;
            foreach ($tmp as $key => $value) {
                if ($this->compareTo($item, $value)) {
                    $sumOfNumber += $value['SOLUONG'];
                    unset($tmp[$key]);
                }
            }
            $item['SOLUONG'] = $sumOfNumber;
            $data[] = $item;
        }

        $countArray['sumFilterRow'] = count($data);
        //Kiem tra hop le du lieu
        foreach ($data as $key => $value) {
            if ($value['MASP'] == '' || strpos($value['MASP'], "SP") === false || strlen($value['MASP']) <= 2) {
                unset($data[$key]);
                $countArray['sumInvalidRow']++;
                continue;
            }
            if ($value['TENSP'] == '' || $value['TENSP'] == '' || strlen($value['TENSP']) < 4) {
                unset($data[$key]);
                $countArray['sumInvalidRow']++;
                continue;
            }

            if (
                $value['MALOAI'] == '' ||
                strpos($value['MALOAI'], 'LSP') === false ||
                empty($objTypeProduct->getProductTypeById($value['MALOAI'])) || strlen($value['MALOAI']) < 4
            ) {
                unset($data[$key]);
                $countArray['sumInvalidRow']++;
                continue;
            }
            if ($value['GIA'] == '' || !is_numeric($value['GIA']) || abs((int)$value['GIA']) != $value['GIA']) {
                unset($data[$key]);
                $countArray['sumInvalidRow']++;
                continue;
            }
            if ($value['SOLUONG'] == '' || !is_numeric($value['SOLUONG']) || abs((int)$value['SOLUONG']) != $value['SOLUONG']) {
                unset($data[$key]);
                $countArray['sumInvalidRow']++;
                continue;
            }
            if ($value['HINHANH'] == '' || strpos($value['HINHANH'], 'jpg') === false && strpos($value['HINHANH'], 'png') === false) {
                unset($data[$key]);
                $countArray['sumInvalidRow']++;
                continue;
            }
        }

        //Kiem tra tinh dung dan cua san pham da co trong db
        foreach ($data as $key => $value) {
            $product = $objProduct->getProductById($value['MASP']);
            if (!empty($product)) {
                if (
                    strcmp($value['TENSP'], $product['TENSP']) != 0 ||
                    strcmp($value['MALOAI'], $product['MALOAI']) != 0 ||
                    $value['GIA'] != $product['GIA'] ||
                    strcmp($value['HINHANH'], $product['HINHANH']) != 0
                ) {
                    $countArray['sumInvalidRow']++;
                    unset($data[$key]);
                }
            }
        }

        foreach ($data as $key => $value) {
            $product = $objProduct->getProductById($value['MASP']);
            if (!empty($product)) {
                $countArray['sumExistRow']++;
            }
        }
        $countArray['sumValidRow'] = $countArray['sumFilterRow'] - $countArray['sumInvalidRow'];
        $countArray['sumNewRow'] = $countArray['sumValidRow'] - $countArray['sumExistRow'];
        echo json_encode(array($data, $countArray));
    }

    function exportReceiptToExcel()
    {
        $objBill = $this->getModel('PhieuNhapDB');
        $data = $objBill->exportExcel();
        echo json_encode($data);
    }


    function PhieuXuatKho(){
        require_once('./menuadmin.php');
        $this->View('AdminPhieuXuatKho', 'Phiếu Xuất Kho');
    }

    function XemChiTietPX($id){
        $objBillDetail = $this->getModel('HoaDonDB');
        $bill = $objBillDetail->getBillById($id)[0];
        $objProduct = $this->getModel('SanPhamDB');
        $objSale = $this->getModel('KhuyenMaiDB');
        $data = $objBillDetail->getBillDetailById($id);
        foreach ($data as $key => $value) {
            $product = $objProduct->getProductById($value['MASP']);
            $data[$key]['TENSP'] = $product['TENSP'];
            $data[$key]['HINHANH'] = $product['HINHANH'];
        }
        $data['data'] = $data;
        $data['sale'] = $objSale->getSaleById($bill['MAKM']);
        require_once('./menuadmin.php');
        $this->View('AdminChiTietPhieuXuat', 'Admin Chi Tiết Phiếu Xuất Kho', $data);
    }
    /* ============================================================*/
    /* =========================SAN PHAM===================================*/
    function SanPham()
    {
        $objTypeProduct = $this->getModel("LoaiSanPhamDB");
        $data = array();
        $data['type'] = $objTypeProduct->getAllProductType();
        require_once('./menuadmin.php');
        $this->View('AdminSanPham', 'Admin Sản Phẩm', $data);
    }
    function ThemSanPham()
    {
        require_once('./menuadmin.php');
        $this->View('AdminThemSanPham', 'Admin Thêm Sản Phẩm');
    }
    function TimKiemSanPham()
    {
        require_once('./menuadmin.php');
        $this->View('AdminTimKiemSanPham', 'Admin Tìm Kiếm Sản Phẩm');
    }
    function SuaSanPham($id)
    {
        if (!isset($_SESSION['staff'])) {
            echo '<script>alert("Bạn không có quyền thực hiên chức năng này !!!");window.location.href="../SanPham";</script>';
        }
        $data = array();
        $objProduct = $this->getModel("SanPhamDB");
        $objTypeProduct = $this->getModel("LoaiSanPhamDB");

        $data['id'] = $id;
        $data['product'] = $objProduct->getProductById($id);
        $data['type'] = $objTypeProduct->getAllProductType();
        require_once('./menuadmin.php');
        $this->View('AdminSuaSanPham', 'Admin Sửa Sản Phẩm', $data);
    }
    function GoiYThemSP()
    {
        require_once('./menuadmin.php');
        $this->View('AdminGoiYThemSanPham', 'Admin Gợi ý thêm sản phẩm');
    }

    function getAllProduct()
    {
        $objProduct = $this->getModel('SanPhamDB');
        echo json_encode($objProduct->getAllProduct());
    }

    function getSaleProduct($number)
    {
        $objProduct = $this->getModel('SanPhamDB');
        echo json_encode($objProduct->getSaleProduct($number));
    }

    function uploadImage()
    {
        $filename = date("dmY_his");
        $objProduct = $this->getModel("SanPhamDB");
        if ($objProduct->uploadImage($_FILES['file'], $filename)) {
            echo json_encode(array(0, $filename));
        } else {
            echo -1;
        }
    }


    function updateInformationProduct()
    {
        $data = $_POST['obj'];
        $objProduct = $this->getModel("SanPhamDB");
        $rs = $objProduct->updateInformationProduct($data);
        if ($rs) {
            echo 0;
        } else {
            echo -1;
        }
    }

    function disableProductStatus()
    {
        if (!isset($_SESSION['staff']) ) {
            echo '<script>alert("Bạn không có quyền thực hiên chức năng này !!!");window.location.href="../SanPham";</script>';
            return;
        }
        $productId = $_POST['id'];
        $objProduct = $this->getModel("SanPhamDB");
        if ($objProduct->disableProductStatus($productId)) {
            echo 0;
        } else {
            echo -1;
        }
    }
    function exportProductToExcel()
    {
        $objProduct = $this->getModel('SanPhamDB');
        $data = $objProduct->exportExcel();
        echo json_encode($data);
    }

    function getAllProductByType($typeId)
    {
        $objProduct = $this->getModel('SanPhamDB');
        $data = $objProduct->getAllProduct();
        $result = array();

        foreach ($data as $value) {
            if ($value['MALOAI'] == $typeId && $value['TRANGTHAI'] != 0) {
                $result[] = $value;
            }
        }

        echo json_encode($result);
    }

    function addToCart($idProduct)
    {
        $result = array();
        $cart = array();
        if (isset($_SESSION['cart'])) {
            $cart = $_SESSION['cart'];
        }
        $objProduct = $this->getModel('SanPhamDB');
        $product = $objProduct->getProductById($idProduct);

        if (empty($cart)) {
            $product['amount'] = 1;
            $cart[] = $product;
        } else {
            $isExist = false;
            foreach ($cart as $key => $value) {
                if ($value['MASP'] == $idProduct) {
                    if ($product['SOLUONG'] < $value['amount'] + 1) {
                        $result['SMS'] = 'Không đủ số lượng';
                        echo json_encode($result);
                        return;
                    }
                    $cart[$key]['amount'] += 1;
                    $cart[$key]['ERROR'] = '';
                    $isExist = true;
                    break;
                }
            }

            if (!$isExist) {
                $product['amount'] = 1;
                $cart[] = $product;
            }
        }

        $_SESSION['cart'] = $cart;

        $result['SMS'] = 'Thêm thành công';
        echo json_encode($result);
    }

    function getCart()
    {
        if (!isset($_SESSION['cart'])) {
            echo json_encode(array());
            return;
        }
        $objSale = $this->getModel('KhuyenMaiDB');
        $sale = $objSale->getSaleinCurrent();
        $_SESSION['sale'] = $sale;


        $this->checkCart();

        echo json_encode($_SESSION['cart']);
    }

    function getSale()
    {
        if (isset($_SESSION['sale'])) {
            echo json_encode($_SESSION['sale']);
        } else {
            echo json_encode(array());
        }
    }

    function deleteCartItem($id)
    {
        $cart = $_SESSION['cart'];
        $check = false;
        foreach ($cart as $key => $value) {
            if ($value['MASP'] == $id) {
                unset($cart[$key]);
                $check = true;
                break;
            }
        }

        $_SESSION['cart'] = $cart;
        if ($check) {
            echo 'Xóa thành công';
        } else {
            echo 'Lỗi khi xóa';
        }
    }

    function checkNumberCart($id, $newNumber)
    {
        $result = array();
        $objProduct = $this->getModel('SanPhamDB');
        $product = $objProduct->getProductById($id);
        if ($product['SOLUONG'] < $newNumber) {
            $result['SMS'] = 'Số lượng vượt quá số lượng sản phẩm trong kho';
        } else {
            //Cap nhat so luong moi
            $cart = array();
            if (isset($_SESSION['cart'])) {
                $cart = $_SESSION['cart'];
            }
            foreach ($cart as $key => $value) {
                if ($value['MASP'] == $id) {
                    $cart[$key]['amount'] = $newNumber;
                    $result['SMS'] = "success";
                    break;
                }
            }

            $_SESSION['cart'] = $cart;
        }

        echo json_encode($result);
    }

    function confirmCart()
    {
        $result = array();
        $valid = true;

        if (!isset($_SESSION['account'])) {
            $result['SMS'] = 'NOT_LOGIN';
        } else if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            $result['SMS'] = 'EMPTY';
        } else {
            //Duyet tat ca san pham trong gio hang check so luong
            $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
            $objProduct = $this->getModel('SanPhamDB');
            foreach ($cart as $key => $value) {
                $product = $objProduct->getProductById($value['MASP']);
                $cart[$key]['ERROR'] = '';

                if ($product['SOLUONG'] < $value['amount']) {
                    $cart[$key]['ERROR'] = "Số lượng tối đa " . $product['SOLUONG'];
                    $valid = false;
                }
            }
            $_SESSION['cart'] = $cart;
            if ($valid) {
                $result['URL'] = '/CuaHangNoiThat/GioHang/ThanhToan';
            } else {
                $result['URL'] = '/CuaHangNoiThat/GioHang/';
            }
        }
        echo json_encode($result);
    }

    function orderCart($pay)
    {
        $result = array();
        $valid = true;

        if (!isset($_SESSION['account'])) {
            $result['SMS'] = 'NOT_LOGIN';
        } else if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            $result['SMS'] = 'Giỏ hàng rỗng';
        } else {
            //Duyet tat ca san pham trong gio hang check so luong
            $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
            $objProduct = $this->getModel('SanPhamDB');
            foreach ($cart as $key => $value) {
                $product = $objProduct->getProductById($value['MASP']);
                $cart[$key]['ERROR'] = '';

                if ($product['SOLUONG'] < $value['amount']) {
                    $cart[$key]['ERROR'] = "Số lượng tối đa " . $product['SOLUONG'];
                    $valid = false;
                }
            }
            $_SESSION['cart'] = $cart;
        }

        if (isset($_SESSION['account']) && isset($_SESSION['cart']) && !empty($_SESSION['cart']) && !empty($_SESSION['account']) && $valid) {
            $objBill = $this->getModel('HoaDonDB');
            $billId = $objBill->createNextBillId();
            $cus = $_SESSION['account'];
            $cart = $_SESSION['cart'];
            $cusId = $cus['MAKH'];
            $sum = 0;
            $saleId = $_SESSION['sale']['MAKM'];
            $day = date('Y/m/d');
            $time = date('H:i:s');
            foreach ($cart as $value) {
                $sum += $value['GIA'] * $value['amount'];
            }
            //Tao hoa don
            $billQry = "INSERT INTO `hoadon`(`MAHD`,`MANV`, `MAKH`, `NGAYLAP`, `GIOLAP`, `TONG`, `MATRANGTHAI`, `MAKM`,`PAYPAL`) VALUES ('$billId',NULL,'$cusId','$day','$time',$sum,'TT01','$saleId',$pay);";

            echo $billQry;

            //Tao chi tiet hoa don
            $detailQry = "INSERT INTO `ct_hoadon`(`MAHD`, `MASP`, `SOLUONG`, `GIA`, `PHANTRAMGIAM`) VALUES";
            foreach ($cart as $value) {
                $proId = $value['MASP'];
                $proNumber = $value['amount'];
                $proPrice = $value['GIA'];
                $proSale = $value['PHANTRAMGIAM'];
                $detailQry .= " ('$billId','$proId',$proNumber,$proPrice,$proSale),";
            }

            $detailQry = substr($detailQry, 0, strlen($detailQry) - 1) . ';';

            if ($objBill->addBillAndDetail($billQry, $detailQry)) {
                $result['SMS'] = 'Đặt hàng thành công';
                //tru so luong san pham trong kho
                $objProduct = $this->getModel('SanPhamDB');
                //if ($objProduct->updateNumberListProduct($cart)) {
                    //Xoa gio hang
                    unset($_SESSION['cart']);
                //}
            } else {
                $result['SMS'] = 'Thêm hóa đơn thất bại';
                $result['Error'] = $billQry . '\n' . $detailQry;
            }
        }
        echo json_encode($result);
    }

    function checkCart()
    {
        if (isset($_SESSION['cart'])) {
            $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
            $objProduct = $this->getModel('SanPhamDB');
            foreach ($cart as $key => $value) {
                $product = $objProduct->getProductById($value['MASP']);
                $cart[$key]['ERROR'] = '';

                if ($product['SOLUONG'] < $value['amount']) {
                    $cart[$key]['ERROR'] = "Số lượng tối đa " . $product['SOLUONG'];
                    $valid = false;
                }
            }
            $_SESSION['cart'] = $cart;
        }
    }

    function countCart()
    {
        $result = array();
        if (!isset($_SESSION['cart'])) {
            $result['COUNT'] = 0;
        } else {
            $count = 0;
            foreach ($_SESSION['cart'] as $value) {
                $count += $value['amount'];
            }

            $result['COUNT'] = $count;
        }

        echo json_encode($result);
    }

    function createAutoProductId()
    {
        $objProduct = $this->getModel("SanPhamDB");

        echo json_encode(array(
            'ID' => $objProduct->createNextProductId()
        ));
    }

    /* ============================================================== */
    /* =====================TRANG THAI GIAO HANG ====================*/
    /* ============================================================== */

    function PhanQuyen($id)
    {
        $staff = $this->getModel('NhanVienDB')->getStaffById($id);

        require_once('./menuadmin.php');
        $this->View('PhanQuyenTaiKhoan', 'Phân Quyền Tài Khoản', $staff);
    }



    function ThongKe()
    {
        require_once('./menuadmin.php');
        $this->View('AdminThongKe', 'Admin Thống Kê');
    }

    
    function DangNhap()
    {
        require_once('./menuadmin.php');
        $this->View('AdminDangNhap');
    }

    function DangXuat()
    {
        if (isset($_SESSION['staff'])) {
            unset($_SESSION['staff']);
        }
        echo '<script>window.location.href="./";</script>';
    }

    function checkLoginAdmin($user, $pass)
    {
        $objCustomer = $this->getModel('NhanVienDB');
        $cus = $objCustomer->getStaffByUser($user);
        $pass = hash('md5', $pass);
        $result = array();
        if (empty($cus)) {
            $result['RESULT'] = "NOT_EXISTS";
        } else {
            if ($pass == $cus['MATKHAU']) {
                if (!isset($cus['MAQUYEN']) || $cus['MAQUYEN'] !== '1') {
                    $result['RESULT'] = "NOT_ADMIN";
                    $result['DATA'] = $cus;
                    $_SESSION['staff'] = $cus;
                } else {
                    $result['RESULT'] = "SUCCESS";
                    $result['DATA'] = $cus;
                    $_SESSION['staff'] = $cus;
                    if ($cus['TRANGTHAI'] == 0) {
                        $result['RESULT'] = "BLOCK";
                    }
                }
            } else {
                $result['RESULT'] = "WRONG_PASSWORD";
            }
        }
        $result['RIGHT'] = isset($cus['MAQUYEN']) ? $cus['MAQUYEN'] : null;
        echo json_encode($result);
    }

    function statisticBillAdnReceipt($year)
    {
        $objBill = $this->getModel('HoaDonDB');
        $objReceipt = $this->getModel('PhieuNhapDB');

        $listBill = $objBill->getBillByYear($year);
        $listReceipt = $objReceipt->getReceiptByYear($year);

        $result = array();
        $result['BILL'] = $listBill;
        $result['RECEIPT'] = $listReceipt;

        echo json_encode($result);
    }

    function changePassword($pass, $newPass, $newPassConfirm)
    {
        $idCus = $_SESSION['account']['MAKH'];
        $objCus = $this->getModel("KhachHangDB");
        $cus = $objCus->getCutomerById($idCus);
        $result = array();

        if (md5($pass) != $cus['MATKHAU']) {
            $result['SMS'] = 'Mật khẩu hiện tại không chính xác';
        } else {
            //ma hoa md5
            $newPass = md5($newPass);
            if ($objCus->updateAccountCutomer($idCus, $newPass)) {
                $result['SMS'] = 'SUCCESS';
                if (isset($_SESSION['account'])) {
                    unset($_SESSION['account']);
                }
            } else {
                $result['SMS'] = 'Lỗi khi thay đổi mật khẩu';
            }
        }
        echo json_encode($result);
    }

    function registerNewAccount($data)
    {
        $data = json_decode($data);
        $result = array();
        //Ma hoa password
        $data[2] = md5($data[2]);
        $objCus = $this->getModel('KhachHangDB');
        //Kiem tra ton tai
        $cus = $objCus->getCutomerByUser($data[1]);
        if (!empty($cus)) {
            $result['SMS'] = 'Tên đăng nhập đã được sử dụng';
        } else {
            $id = $objCus->createNextCustomerId();
            $customer = array(
                'MAKH' => $id,
                'TENKH' => $data[0],
                'TENDN' => $data[1],
                'MATKHAU' => $data[2],
                'DIACHI' => $data[4],
                'SDT' => $data[3],
                'TRANGTHAI' => true,
                'DIEMTL' => 0,
                'GIOITINH' => $data[5],
                'NGAYSINH' => $data[6]
            );

            if ($objCus->addNewCustomer($customer)) {
                $result['SMS'] = 'SUCCESS';
            } else {
                $result['SMS'] = 'Đăng ký tài khoản thất bại';
            }
        }
        echo json_encode($result);
    }

    function TrangChuNhanVien()
    {
        require_once('./menuStaff.php');
        $this->View('NhanVienTrangChu', 'Trang Chủ Nhân Viên');
    }

    function statisticBillByTime($from, $to)
    {
        try {
            $arrFrom = explode('-', $from);
            $arrTo = explode('-', $to);

            if (count($arrFrom) != 2 || count($arrTo) != 2 || !is_numeric($arrFrom[0]) || !is_numeric($arrFrom[1]) || !is_numeric($arrTo[0]) || !is_numeric($arrTo[1])) {
                throw new Exception();
            }

            $from .= '-01';
            $to .= '-31';

            $objBill = $this->getModel("HoaDonDB");
            //getBillDetailById
            $listBill = $objBill->getAllBillFT($from, $to);

            foreach ($listBill as $key => $value) {
                $listBill[$key]['DETAIL'] = $objBill->getBillDetailById($value['MAHD']);
            }
        } catch (Exception $ex) {
            $sms = array(
                'sms' => 'Input invalid, input must be have format mm-yyyy'
            );

            echo json_encode($sms);
        }

        return $listBill;
    }


    function statisticReceiptByTime($from, $to)
    {
        try {
            $arrFrom = explode('-', $from);
            $arrTo = explode('-', $to);

            if (count($arrFrom) != 2 || count($arrTo) != 2 || !is_numeric($arrFrom[0]) || !is_numeric($arrFrom[1]) || !is_numeric($arrTo[0]) || !is_numeric($arrTo[1])) {
                throw new Exception();
            }

            $from .= '-01';
            $to .= '-31';

            $objReceipt = $this->getModel("PhieuNhapDB");
            //getBillDetailById
            $listReceipt = $objReceipt->getAllReceiptFT($from, $to);
            foreach ($listReceipt as $key => $value) {
                $listReceipt[$key]['DETAIL'] = $objReceipt->getReceiptDetailById($value['MAPN']);
            }
        } catch (Exception $ex) {
            $sms = array(
                'sms' => 'Input invalid, input must be have format mm-yyyy'
            );

            echo json_encode($sms);
        }

        return $listReceipt;
    }

    function statisticBillInMonth($time)
    {
        try {
            $arrTime = explode('-', $time);
           

            if (count($arrTime) != 2 || !is_numeric($arrTime[0]) || !is_numeric($arrTime[1])) {
                throw new Exception();
            }


            $objBill = $this->getModel("HoaDonDB");
            //getBillDetailById
            $listBill = $objBill->getAllBillInMonth($time);

            foreach ($listBill as $key => $value) {
                $listBill[$key]['DETAIL'] = $objBill->getBillDetailById($value['MAHD']);
            }
        } catch (Exception $ex) {
            $sms = array(
                'sms' => 'Input invalid, input must be have format mm-yyyy'
            );

            echo json_encode($sms);
        }

        return $listBill;
    }

    function statisticReceiptInMonth($time){
        try {
            $arrTime = explode('-', $time);
           

            if (count($arrTime) != 2 || !is_numeric($arrTime[0]) || !is_numeric($arrTime[1])) {
                throw new Exception();
            }


            $objReceipt = $this->getModel("PhieuNhapDB");
            //getBillDetailById
            $listReceipt = $objReceipt->getAllReceiptInMonth($time);

            foreach ($listReceipt as $key => $value) {
                $listReceipt[$key]['DETAIL'] = $objReceipt->getReceiptDetailById($value['MAPN']);
            }
        } catch (Exception $ex) {
            $sms = array(
                'sms' => 'Input invalid, input must be have format mm-yyyy'
            );

            echo json_encode($sms);
        }

        return $listReceipt;
    }

    function ThongKeTheoTG($from, $to)
    {
        $data['bill'] = $this->statisticBillByTime($from, $to);
        $data['receipt'] = $this->statisticReceiptByTime($from, $to);
        $data['time'] = array('from' => $from, 'to' => $to);

        require_once('./menuadmin.php');
        $this->View('AdminThongKe_Time', 'Thống kê theo thời gian', $data);
    }

    function ThongKeBanHang($time)
    {
        $objProduct = $this->getModel("SanPhamDB");
        $objTypeProduct = $this->getModel("LoaiSanPhamDB");

        $data['bill'] = $this->statisticBillInMonth($time);
        $data['product'] = $objProduct->getAllProduct();
        $data['type_product'] = $objTypeProduct->getAllProductType();
        $data['time'] = $time;

        require_once('./menuadmin.php');
        $this->View('AdminThongKe_Sale', 'Thống kê bán hàng trong tháng', $data);
    }

    function ThongKeNhapHang($time)
    {
        $objProduct = $this->getModel("SanPhamDB");
        $objTypeProduct = $this->getModel("LoaiSanPhamDB");

        $data['receipt'] = $this->statisticReceiptInMonth($time);
        $data['product'] = $objProduct->getAllProduct();
        $data['type_product'] = $objTypeProduct->getAllProductType();
        $data['time'] = $time;

        require_once('./menuadmin.php');
        $this->View('AdminThongKe_WareHouse', 'Thống kê nhập hàng trong tháng', $data);
    }
}
