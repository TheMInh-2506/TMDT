<?php
// echo '<pre>';
// print_r($data);
// echo '</pre>';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <style>
        .card-body td {
            padding-left: 6rem;
        }
    </style>
</head>

<body>
    <h2>LỊCH SỬ MUA HÀNG TỪ <?php echo $data['time']['from'];?> ĐẾN <?php echo $data['time']['to'];?></h2>
    <div style="margin-left: 5%;width: 90%;margin-bottom: 2rem;">
        <!-- item -->
        <!-- <div class="card" style="width: 25rem;margin: 1rem;float: left;border-radius: 1rem;">
            <div style="text-align: center;">
                <img class="card-img-top" src="/CuaHangNoiThat/public/image/bill_icon.jpg" alt="Card image cap" style="width: 10rem;">
            </div>

            <div class="card-body">
                <table>
                    <tr>
                        <th>Mã Hóa Đơn</th>
                        <td>HD001</td>
                    </tr>
                    <tr>
                        <th>Này Lập</th>
                        <td>20/11/2001</td>
                    </tr>
                    <tr>
                        <th>Tổng Tiền</th>
                        <td>99.999 VNĐ</td>
                    </tr>
                    <tr>
                        <th>Thanh Toán Online</th>
                        <td>Có</td>
                    </tr>
                </table>
                <a href="/CuaHangNoiThat/NhanVien/XemChiTietHD_STA/HD01" class="btn btn-primary" style="float: right;margin-top: 2rem;">Xem Chi Tiết</a>
            </div>
        </div> -->

        <?php
        foreach ($data['bill'] as $value) {
            echo '<div class="card" style="width: 25rem;margin: 1rem;float: left;border-radius: 1rem;">' .
                '<div style="text-align: center;">' .
                '<img class="card-img-top" src="/CuaHangNoiThat/public/image/bill_icon.jpg" alt="Card image cap" style="width: 10rem;">' .
                '</div>' .
                '<div class="card-body">' .
                '<table>' .
                '<tr>' .
                '<th>Mã Hóa Đơn</th>' .
                '<td>'.$value['MAHD'].'</td>' .
                '</tr>' .
                '<tr>' .
                '<th>Ngày Lập</th>' .
                '<td>'.$value['NGAYLAP'].'</td>' .
                '</tr>' .
                '<tr>' .
                '<th>Tổng Tiền</th>' .
                '<td>'.number_format($value['TONG']).' VNĐ</td>' .
                '</tr>' .
                '<tr>' .
                '<th>Thanh Toán Online</th>' .
                '<td>'.($value['PAYPAL'] == 0 ? 'Không':'Có').'</td>' .
                '</tr>' .
                '</table>' .
                '<a href="/CuaHangNoiThat/NhanVien/XemChiTietHD_STA/'.$value['MAHD'].'" class="btn btn-primary" style="float: right;margin-top: 2rem;">Xem Chi Tiết</a>' .
                '</div>' .
                '</div>';
        }

        ?>
    </div>
</body>

</html>