<!doctype html>
<html lang="en">

<head>
    <title>
        <?php echo $title; ?>
    </title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    


    <table id="tableContent" class="table" style="width: 80%;margin-left: 10%;margin-top: 2rem;">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Mã Sản Phẩm</th>
                <th scope="col" style="width: 20rem;">Tên Sản Phẩm</th>
                <th scope="col">Loại</th>
                <th scope="col">Giá</th>
                <th scope="col">Số Lượng</th>
                <th scope="col" style="width: 10rem;">Hình Ảnh</th>
                <th scope="col">Trạng Thái</th>
                <th scope="col" style="width: 15rem;">Chức Năng</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><img src="/CuaHangNoiThat/public/image/Empty.jpg" alt="empty_Image" style="width: 10rem;"></td>
                <td></td>
                <td>
                    <a href="/CuaHangNoiThat/Admin/SuaSanPham?id=1">
                        <button class="btn btn-primary btnControl" type="submit" style="background-color: green;">Sửa sản phẩm</button>
                    </a>
                    
                    <button class="btn btn-primary btnControl" type="submit" style="background-color: red;margin-top: 1rem;">Xóa Sản phẩm</button>
                </td>

            </tr>
        </tbody>
    </table>
</body>

</html>