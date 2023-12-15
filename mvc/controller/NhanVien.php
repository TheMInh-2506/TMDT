<?php
class NhanVien extends Controller
{
    function display()
    {
        require_once('./menuStaff.php');
        $this->View('NhanVienTrangChu', 'Trang Chủ Nhân Viên');
    }

    function DangNhap(){
        require_once('./menuStaff.php');
        $this->View('NhanVienDangNhap');
    }

    function DangXuat(){
        if (isset($_SESSION['staff'])) {
            unset($_SESSION['staff']);
        }
        echo '<script>window.location.href="/CuaHangNoiThat/NhanVien";</script>';
    }

    function SanPham(){
        if(!isset($_SESSION['staff']) || strpos($_SESSION['staff']['QUYEN'],'v_product') === false){
            $this->returnHome();
        }
        $objTypeProduct = $this->getModel("LoaiSanPhamDB");
        $data = array();
        $data['type'] = $objTypeProduct->getAllProductType();
        require_once('./menuStaff.php');
        $this->View('NhanVienSanPham', 'Trang Sản Phẩm Nhân Viên', $data);
    }

    function returnHome($url = ''){
        echo '<script>alert("Bạn không có quyền sử dụng chức năng này !!!!");window.location.href = "/CuaHangNoiThat/NhanVien'.($url == '' ? '':'/'.$url).'";</script>';
    }

    function SuaSanPham($id)
    {
        if (!isset($_SESSION['staff']) || strpos($_SESSION['staff']['QUYEN'],'e_product') === false) {
            echo '<script>alert("Bạn không có quyền thực hiên chức năng này !!!");window.location.href="/CuaHangNoiThat/NhanVien/SanPham";</script>';
        }
        $data = array();
        $objProduct = $this->getModel("SanPhamDB");
        $objTypeProduct = $this->getModel("LoaiSanPhamDB");

        $data['id'] = $id;
        $data['product'] = $objProduct->getProductById($id);
        $data['type'] = $objTypeProduct->getAllProductType();
        require_once('./menuStaff.php');
        $this->View('NhanVienSuaSanPham', 'Sửa Sản Phẩm Nhân Viên', $data);
    }

    function GoiYThemSP(){
        if(!isset($_SESSION['staff']) || strpos($_SESSION['staff']['QUYEN'],'ve_product') === false){
            $this->returnHome('SanPham');
        }
        require_once('./menuStaff.php');
        $this->View('NhanVienGoiYThemSanPham', 'Gợi ý thêm sản phẩm nhân viên');
    }

    function KhachHang()
    {
        if(!isset($_SESSION['staff']) || strpos($_SESSION['staff']['QUYEN'],'v_customer') === false){
            $this->returnHome();
        }
        require_once('./menuStaff.php');
        $this->View('NhanVienKhachHang', 'Khách Hàng Nhân Viên');
    }

    function HoaDon()
    {
        if(!isset($_SESSION['staff']) || strpos($_SESSION['staff']['QUYEN'],'v_bill') === false){
            $this->returnHome();
        }
        require_once('./menuStaff.php');
        $this->View('NhanVienHoaDon', 'Hóa Đơn Nhân Viên');
    }
    
    function XemChiTietHD($id)
    {
        if(!isset($_SESSION['staff']) || strpos($_SESSION['staff']['QUYEN'],'v_bill') === false){
            $this->returnHome('HoaDon');
        }
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
        require_once('./menuStaff.php');
        $this->View('NhanVienChiTietHoaDon', 'Chi Tiết HĐ - Nhân Viên', $data);
    }

    function XemChiTietHD_STA($id)
    {
        if(!isset($_SESSION['staff']) || strpos($_SESSION['staff']['QUYEN'],'v_bill') === false){
            $this->returnHome('HoaDon');
        }
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
        require_once('./menuStaff.php');
        $this->View('NhanVienChiTietHoaDon_STA', 'Chi Tiết HĐ - Thống Kê', $data);
    }

    function KhuyenMai()
    {
        if(!isset($_SESSION['staff']) || strpos($_SESSION['staff']['QUYEN'],'v_sale') === false){
            $this->returnHome();
        }
        require_once('./menuStaff.php');
        $this->View('NhanVienKhuyenMai', 'Khuyến Mãi - Nhân Viên');
    }

    function ThemKhuyenMai()
    {
        if(!isset($_SESSION['staff']) || strpos($_SESSION['staff']['QUYEN'],'a_sale') === false){
            $this->returnHome('KhuyenMai');
        }
        require_once('./menuStaff.php');
        $this->View('NhanVienThemKhuyenMai', 'Admin Thêm Khuyến mãi');
    }

    function NhaCungCap()
    {
        if(!isset($_SESSION['staff']) || strpos($_SESSION['staff']['QUYEN'],'v_supplier') === false){
            $this->returnHome();
        }
        require_once('./menuStaff.php');
        $this->View('NhanVienNhaCungCap', 'Nhà Cung Cấp - Nhân Viên');
    }

    function ThemNhaCungCap()
    {
        if(!isset($_SESSION['staff']) || strpos($_SESSION['staff']['QUYEN'],'a_supplier') === false){
            $this->returnHome('NhaCungCap');
        }
        require_once('./menuStaff.php');
        $this->View('NhanVienThemNhaCungCap', 'Thêm Nhà Cung Cấp - Nhân Viên');
    }

    function SuaNhaCungCap($id)
    {
        if(!isset($_SESSION['staff']) || strpos($_SESSION['staff']['QUYEN'],'e_supplier') === false){
            $this->returnHome('NhaCungCap');
        }
        $objSupplier = $this->getModel("NhaCungCapDB");
        $supplier = $objSupplier->getSupplierById($id);
        require_once('./menuStaff.php');
        $this->View('NhanVienSuaNhaCungCap', 'Sửa Nhà Cung Cấp - Nhân Viên', $supplier);
    }

    function PhieuNhap()
    {
        if(!isset($_SESSION['staff']) || strpos($_SESSION['staff']['QUYEN'],'v_receipt') === false){
            $this->returnHome();
        }
        require_once('./menuStaff.php');
        $this->View('NhanVienPhieuNhap', 'Quản Kho Nhân Viên');
    }

    function ThemPhieuNhap()
    {
        if(!isset($_SESSION['staff']) || strpos($_SESSION['staff']['QUYEN'],'a_receipt') === false){
            $this->returnHome();
        }
        $data = array();
        $objTypeProduct = $this->getModel('LoaiSanPhamDB');
        $objSupplier = $this->getModel('NhaCungCapDB');
        $objProduct = $this->getModel('SanPhamDB');

        $data['NCC'] = $objSupplier->getAllSupplier();
        $data['TypeProduct'] = $objTypeProduct->getAllProductType();
        $data['Product'] = $objProduct->getAllProduct();
        $data['NEXT_ID'] = $objProduct->createNextproductId();
        require_once('./menuStaff.php');
        $this->View('NhanVienThemPhieuNhap', 'Thêm Phiếu Nhập - Nhân Viên', $data);
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

        require_once('./menuStaff.php');
        $this->View('NhanVienChiTietPhieuNhap', 'Chi Tiết Phiếu Nhập - Nhân Viên', $data);
    }

    function BaoCaoYeuCauThemSanPham(){
        $objProduct = $this->getModel('SanPhamDB');
        $objTypeProduct = $this->getModel('LoaiSanPhamDB');

        $data['product'] = $objProduct->getAllProduct();
        $data['type_product'] = $objTypeProduct->getAllProductType();

        require_once('./menuStaff.php');
        $this->View('NhanVienBaoCaoYeuCauThemSanPham', 'Báo Cáo Yêu Cầu Thêm Sản Phẩm', $data);
    }

    function ThongKeBanHang(){
        if(!isset($_SESSION['staff']) || strpos($_SESSION['staff']['QUYEN'],'sta_bill') === false){
            $this->returnHome();
        }

        require_once('./menuStaff.php');
        $this->View('ThongKeBanHang', 'Thống Kê Bán Hàng');
    }

    function statisticByTime($from,$to){
        try {
            
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

    function statisticProficByTime($time,$id){
        try {
            
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

        $result = array();
        foreach($listBill as $value){
            if($value['MANV'] == $id){
                $result[] = $value;
            }
        }

        return $result;
    }

    function ThongKeTheoTG($from,$to){
        $data['bill'] = $this->statisticByTime($from,$to);
        $data['time']['from'] = $from;
        $data['time']['to'] = $to;

        require_once('./menuStaff.php');
        $this->View('LichSuGiaoDich', 'Lịch Sử Giao Dịch',$data);
    }

    function ThongKeDoanhThu($time){
        $id = $_SESSION['staff']['MANV'];
        $data['bill'] = $this->statisticProficByTime($time,$id);
        $data['time'] = $time;

        require_once('./menuStaff.php');
        $this->View('ThongKeDoanhThu', 'Thống Kê Doanh Thu',$data);
    }

    function PhieuXuatKho(){
        require_once('./menuStaff.php');
        $this->View('NhanVienPhieuXuatKho', 'Phiếu Xuất Kho');
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
        require_once('./menuStaff.php');
        $this->View('NhanVienChiTietPhieuXuat', 'Chi Tiết Phiếu Xuất Kho', $data);
    }

    function getAllBillAndReceiptWithDetail(){
        $objBill = $this->getModel('HoaDonDB');
        $objReceipt = $this->getModel('PhieuNhapDB');
        $objStaff = $this->getModel('NhanVienDB');

        $data = array();
        $data['BILL'] = $objBill->getAllBill();
        $data['RECEIPT'] = $objReceipt->getAllReceipt();
        
        foreach($data['BILL'] as $key=>$value){
            $data['BILL'][$key]['staff'] = $objStaff->getStaffById($value['MANV']);
            $data['BILL'][$key]['ex_staff'] = $objStaff->getStaffById($value['MANV_XUAT']);

        }
        
        foreach($data['RECEIPT'] as $key=>$value){
            $data['RECEIPT'][$key]['staff'] = $objStaff->getStaffById($value['MANV']);
            
        }
        
        echo json_encode($data);
    }

    function ThongKeKho(){
        if(!isset($_SESSION['staff']) || strpos($_SESSION['staff']['QUYEN'],'sta_receipt') === false){
            $this->returnHome();
        }
        require_once('./menuStaff.php');
        $this->View('ThongKeKho', 'Thống Kê Kho');
    }
}
?>