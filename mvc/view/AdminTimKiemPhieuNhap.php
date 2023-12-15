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
    <div style="width: 60%;margin-left: 20%;margin-top: 1rem;">
        <h2><?php echo $title;?></h2>
        <div class="form-row">
            <div class="form-group col-md-4">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="autoSizingCheck">
                    <label class="form-check-label" for="autoSizingCheck">Tìm theo mã phiếu nhập</label>
                </div>
                <input type="text" class="form-control" id="inputAddress">
            </div>
            <div class="form-group col-md-4">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="autoSizingCheck">
                    <label class="form-check-label" for="autoSizingCheck">Tìm theo tên nhà cung cấp</label>
                </div>
                <input type="text" class="form-control" id="inputAddress">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="autoSizingCheck">
                    <label class="form-check-label" for="autoSizingCheck">Tìm theo tên nhân viên</label>
                </div>
                <input type="text" class="form-control" id="inputAddress">
            </div>
            <div class="form-group col-md-1">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="autoSizingCheck">
                    <label class="form-check-label" for="autoSizingCheck">Ngày</label>
                </div>
                <select class="form-control">
                    <?php
                    for ($i = 1; $i <= 31; $i++) {
                        $value = strlen((string)$i) > 1 ? $i : '0' . $i;
                        echo '<option value="' . $i . '">' . $value . '</option>';
                    }
                    ?>

                </select>
            </div>
            <div class="form-group col-md-1">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="autoSizingCheck">
                    <label class="form-check-label" for="autoSizingCheck">Tháng</label>
                </div>
                <select class="form-control">
                    <?php
                    for ($i = 1; $i <= 12; $i++) {
                        $value = strlen((string)$i) > 1 ? $i : '0' . $i;
                        echo '<option value="' . $i . '">' . $value . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-1">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="autoSizingCheck">
                    <label class="form-check-label" for="autoSizingCheck">Năm</label>
                </div>
                <input type="text" class="form-control" id="inputAddress">
            </div>
        </div>
        <a href="/CuaHangNoiThat/Admin/PhieuNhap">
            <button type="submit" class="btn btn-primary" style="background-color: white;color: #007bff;">Trở về </button>
        </a>
        <button type="submit" class="btn btn-primary">Tìm kiếm </button>
    </div>


    <table id="tableContent" class="table" style="width: 80%;margin-left: 10%;">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Mã Hóa Đơn</th>
                <th scope="col">Tên Nhân Viên</th>
                <th scope="col">Tên Nhà Cung Cấp</th>
                <th scope="col">Ngày Lập</th>
                <th scope="col">Giờ Lập</th>
                <th scope="col" style="width: 10rem;">Tổng</th>
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
                <td></td>
                <td>
                    <button class="btn btn-primary btnControl" type="submit" style="background-color: #007bff;margin-top: 0.3rem;">In phiếu nhập</button>
                    <a href="/CuaHangNoiThat/Admin/XemChiTietPhieuNhap/1">
                        <button class="btn btn-primary btnControl" type="submit" style="background-color: green;margin-top: 0.3rem;">Xem chi tiết</button>
                    </a>
                </td>

            </tr>
        </tbody>
    </table>
</body>

</html>