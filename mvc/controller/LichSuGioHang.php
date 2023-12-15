<?php
    class LichSuGioHang extends Controller{
        function display(){
            if(!isset($_SESSION['account'])){
                $this->View('TrangChu');
                return;    
            }
            $obj = $this->getModel('HoaDonDB');
            $objSale = $this->getModel("KhuyenMaiDB");
            
            $data = $obj->getBillByCusId("KH01");
            foreach($data as $key=>$value){
                $sumBill = 0;
                foreach($obj->getBillDetailById($value['MAHD']) as $subvalue){
                    $sumBill += $subvalue['GIA']*$subvalue['SOLUONG']*(1-$subvalue['PHANTRAMGIAM']/100);
                }

                $saleId = $value['MAKM'];
                
                $sale = $objSale->getSaleById($saleId);
                $data[$key]['LAST_PRICE'] = (1-$sale['PHANTRAMGIAM']/100)*$sumBill;
                
            }
            $this->View('LichSuGioHang',"",$data);
        }

        function XemChiTiet($id){
            $obj = $this->getModel('HoaDonDB');
            $objSale = $this->getModel('KhuyenMaiDB');
            $objProduct = $this->getModel("SanPhamDB");

            $bill = $obj->getBillById($id)[0];
            $data['detail'] = $obj->getBillDetailById($id);
            $data['sale'] = $objSale->getSaleById($bill['MAKM']);
            $data['sale']['MAHD'] = $id;

            foreach($data['detail'] as $key=>$value){
                $pro = $objProduct->getProductById($value['MASP']);
                $data['detail'][$key]['TENSP'] = $pro['TENSP'];
                $data['detail'][$key]['HINHANH'] = $pro['HINHANH'];

            }
            $this->View('XemChiTiet',"Xem Chi Tiết Đơn Hàng",$data);
        }
    }

?>