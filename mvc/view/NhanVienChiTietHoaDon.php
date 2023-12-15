<!doctype html>
<html lang="en">

<head>
    <title><?php echo $title; ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .optionButton {
            width: 13rem;
            font-size: 1.1rem;
        }

        .btnControl {
            width: 10rem;
        }
    </style>
</head>

<body>
    <h1 style="margin-top: 5rem;margin-left: 10%;"><?php echo $title; ?></h1>
    <div>
        <a href="/CuaHangNoiThat/NhanVien/HoaDon">
            <button type="submit" class="btn btn-primary" style="background-color: white;color: #0066cc;margin-left: 10%;">Trở về </button>
        </a>
    </div>
    <table id="tableContent" class="table" style="width: 80%;margin-left: 10%;">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Mã Sản Phẩm</th>
                <th scope="col">Tên Sản Phẩm</th>
                <th scope="col">Hình Ảnh</th>
                <th scope="col">Số Lượng</th>
                <th scope="col">Phần Trăm Giảm</th>
                <th scope="col">Đơn Giá</th>
                <th scope="col">Thành Tiền</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $sale = $data['sale'];
            $data = $data['data'];
            $count = 1;
            $sumNumber = 0;
            $sumPrice = 0;
            $sumPriceSale = 0;
            foreach ($data as $value) {
                $sumNumber+= $value['SOLUONG'];
                $sumPrice += $value['GIA'] * $value['SOLUONG'];
                $sumPriceSale += $value['GIA'] * $value['SOLUONG'] * (1 - ($value['PHANTRAMGIAM'] / 100));
                echo '<tr>
                <th scope="row">' . $count++ . '</th>
                <td>' . $value['MASP'] . '</td>
                <td>' . $value['TENSP'] . '</td>
                <td><img style="width: 10rem;height: 5rem;" src="/CuaHangNoiThat/public/image/HINHANH/' . $value['HINHANH'] . '" alt=""></td>
                <td>' . $value['SOLUONG'] . '</td>
                <td>' . $value['PHANTRAMGIAM'] . '%</td>
                <td>' . number_format($value['GIA']) . ' VNĐ</td>
                <td style="font-weight:800;">' . number_format($value['GIA'] * $value['SOLUONG'] * (1 - ($value['PHANTRAMGIAM'] / 100))) . ' VNĐ</td>
            </tr>';
            }
            echo '<tr>
            <td colspan="8"></td>
            </tr><tr>
            <th scope="row" colspan="4">Tổng</th>
            <th scope="row" colspan="2">'.$sumNumber.'</th>
            <th scope="row">'.number_format($sumPrice).'  VNĐ</th>
            <th scope="row">'.number_format($sumPriceSale).' VNĐ</th>
            </tr>';
            echo '<tr>
            <th scope="row" colspan="4">Khuyến Mãi</th>
            <th scope="row">'.$sale['MAKM'].'</th>
            <th scope="row">'.$sale['NGAYBD'].' - '.$sale['NGAYKT'].'</th>
            <th scope="row" >'.$sale['PHANTRAMGIAM'].' %</th>
            <th scope="row"> - '.number_format($sumPriceSale*$sale['PHANTRAMGIAM']/100).' VNĐ</th>
            </tr>';
            echo '<tr>
            <th scope="row" colspan="4">Thành Tiền</th>
            <th scope="row"></th>
            <th scope="row" colspan="2"></th>
            <th scope="row">'.number_format($sumPriceSale*(1-$sale['PHANTRAMGIAM']/100)).' VNĐ</th>
            </tr>';
            ?>

        </tbody>
    </table>

</body>

</html>