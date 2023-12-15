<?php
// echo '<pre>';
// print_r($data);
// echo '</pre>';
?>

<!doctype html>
<html lang="en">

<head>
    <title>Thống kê theo thời gian</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div>
        <button class="btn btn-warning" onclick="window.location.href='/CuaHangNoiThat/Admin/ThongKe'">Trở về</button>
        <button class="btn btn-primary" onclick="printToImage('#statisticExport','ThongKeNhapHang_<?php echo $data['time'];?>');">Xuất Hình Ảnh</button>
    </div>
    <div style="width: 900px;" id="statisticExport">
        <div style="width: 100%;background-color: lightgray;">
            <h1 style="text-align: center;">MILD STORE</h1>
            <div style="width: 100%;text-align: center;">
                <p style="font-weight: 800;color: gray;">Decorate your Life with Arts</p>
                <h5>Địa chỉ: 273 An D. Vương, Phường 3, Quận 5, Thành phố Hồ Chí Minh</h5>
                <h5>SĐT: 0843739379</h5>
                <h5>www.mildstore.com</h5>
            </div>
            <div>
                <p style="text-align: center;">------------------------------------------------------------------------------------------</p>
                <h3 style="width: 90%;margin-left: 5%;">THỐNG KÊ NHẬP HÀNG <?php echo $data['time']; ?> </h3>
                <div style="background-color: white;width: 90%;margin-left: 5%;padding: 1rem;">
                    <table style="font-size:1.2rem;">
                        <tbody>
                            <tr>
                                <td style="font-weight:800;padding-right:3rem;">Thời gian lập : </td>
                                <td><?php echo date('H:i:s d-m-Y'); ?></td>

                            </tr>
                            <tr>
                                <td style="font-weight:800;padding-right:3rem;">Người lập : </td>
                                <td>Quản trị viên</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <h3 style="width: 90%;margin-left: 5%;">CHI TIẾT</h3>
                <table class="table" style="width: 90%;margin-left: 5%;background-color: white;">
                    <tbody>
                        <tr>
                            <th scope="col">Tổng số lượng phiếu nhập: </th>
                            <td><?php echo count($data['receipt']); ?></td>
                            <th scope="col">Tổng tiền phiếu nhập: </th>
                            <td>
                                <?php
                                $sumB = 0;
                                foreach ($data['receipt'] as $value) {
                                    $sumB += $value['TONG'];
                                }

                                echo number_format($sumB, 0, '', ',');
                                ?>
                                VNĐ
                            </td>
                        </tr>
                    </tbody>

                </table>
                <?php

                function isExistId($list, $id)
                {
                    foreach ($list as $key => $value) {
                        if ($key == $id) {
                            return true;
                        }
                    }
                    return false;
                }

                function getNameTypeProduct($list,$id){
                    foreach ($list as $value) {
                        if ($value['MALOAI'] == $id) {
                            return $value;
                        }
                    }
                    return NULL;
                }
                $count_product_list = array();
                foreach ($data['receipt'] as $value) {
                    foreach ($value['DETAIL'] as $subvalue) {
                        if (!isExistId($count_product_list, $subvalue['MASP'])) {
                            $count_product_list[$subvalue['MASP']] = $subvalue['SOLUONG'];
                        } else {
                            $count_product_list[$subvalue['MASP']] += $subvalue['SOLUONG'];
                        }
                    }
                }
                ?>
                <h3 style="width: 90%;margin-left: 5%;">Sản Phẩm Đã Nhập</h3>
                <table class="table" style="width: 90%;margin-left: 5%;background-color: white;">
                    <thead>
                        <tr>
                            <th scope="col">Mã Sản Phẩm </th>
                            <th scope="col">Tên Sản Phẩm </th>
                            <th scope="col">Loại Sản Phẩm </th>
                            <th scope="col">Giá Bán </th>
                            <th scope="col">Hình Ảnh </th>
                            <th scope="col">Số Lượng Nhập Vào </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        function getProductFromList($list, $id)
                        {
                            foreach ($list as $value) {
                                if ($value['MASP'] == $id) {
                                    return $value;
                                }
                            }
                            return NULL;
                        }

                        foreach ($count_product_list as $key => $value) {
                           
                                $product = getProductFromList($data['product'], $key);
                                if ($product == NULL) continue;
                               
                                echo '<tr>' .
                                    '<td>'.$product['MASP'].'</td>'.
                                    '<td>'.$product['TENSP'].'</td>'.
                                    '<td>'.getNameTypeProduct($data['type_product'],$product['MALOAI'])['TENLOAI'].'</td>'.
                                    '<td>'.$product['GIA'].'</td>'.
                                    '<td>'.
                                    '<img src="/CuaHangNoiThat/public/image/HINHANH/'.$product['HINHANH'].'" alt="No Image" style="width: 5rem;">'.
                                    '</td>'.
                                    '<td>'.$count_product_list[$product['MASP']].'</td>'.
                                    '</tr>';
                            
                        }
                        ?>
                    </tbody>
                </table>
                <hr>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>