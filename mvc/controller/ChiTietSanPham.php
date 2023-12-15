<?php
    class ChiTietSanPham extends Controller{
function display(){
    
}

        function SanPham($id){
            $objProduct = $this->getModel('SanPhamDB');
            $product = $objProduct->getProductById($id);
            $data = array();
            $data['product'] = $product;

            $this->View('ChiTietSanPham','CHi Tiết Sản Phẩm',$data);
        }

        

        function getProductById($productId){
            $productId = 0;
            if(isset($_POST['productId'])){
                $productId = $_GET['productId'];
            }
            $objProduct = $this->getModel('SanPham');
            return $objProduct->getProductById($productId);
        }
    }

?>