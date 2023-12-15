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
    <div style="width: 80%;margin-left: 10%;">
        <a href="/CuaHangNoiThat/NhanVien/ThemPhieuNhap"><button type="button" class="btn btn-primary">Thêm Phiếu Nhập Kho</button></a>
        <a href="/CuaHangNoiThat/NhanVien/PhieuXuatKho"><button type="button" class="btn btn-primary">Phiếu Xuất Kho</button></a>
        <button onclick="exportExcel();" type="button" class="btn btn-primary">Xuất Excel</button>
        <div class="form-group" style="width: 50%;float: right;margin-left: 2rem;">
            <input type="email" class="form-control" id="searchReceipt" placeholder="Nhập vào thông tin cần tìm..." style="float: right;width: 20rem;">
        </div>
    </div>
    <div style="width: 80%;margin-left: 10%;margin-top: 1rem;">
        <div class="form-row">
            <div class="form-group col-md-4">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="checkReceiptId">
                    <label class="form-check-label" for="autoSizingCheck">Tìm theo mã phiếu nhập</label>
                </div>
                <input type="text" class="form-control" id="inputReceiptId">
            </div>
            <div class="form-group col-md-4">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="checkNameSupplier">
                    <label class="form-check-label" for="autoSizingCheck">Tìm theo tên nhà cung cấp</label>
                </div>
                <input type="text" class="form-control" id="inputNameSupplier">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="checkNameStaff">
                    <label class="form-check-label" for="autoSizingCheck">Tìm theo tên nhân viên</label>
                </div>
                <input type="text" class="form-control" id="inputNameStaff">
            </div>
            <div class="form-group col-md-1">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="checkDay">
                    <label class="form-check-label" for="autoSizingCheck">Ngày</label>
                </div>
                <select class="form-control" id="inputDay">
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
                    <input class="form-check-input" type="checkbox" id="checkMonth">
                    <label class="form-check-label" for="autoSizingCheck">Tháng</label>
                </div>
                <select class="form-control" id="inputMonth">
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
                    <input class="form-check-input" type="checkbox" id="checkYear">
                    <label class="form-check-label" for="autoSizingCheck">Năm</label>
                </div>
                <input type="text" class="form-control" id="inputYear">
            </div>
            <button onclick="searchReceipt();" type="submit" class="btn btn-primary">Tìm kiếm </button>
        </div>

    </div>
    <table id="tableContent" class="table" style="width: 80%;margin-left: 10%;"></table>

    <!-- Hoa don phieu nhap -->
    <div id="printReceipt" style="width: 40%;margin-left: 30%;background-color: lightgray;color: black;position: absolute;top: 5rem;"></div>

    <!-- Thong bao xuat excel thanh cong -->
    <div id="openExportReceipt" style="width: 60%;background-color: #007bff; position: absolute; top: 25%; height: auto; padding: 2rem; border-radius: 1rem; color: white;left:20%;font-size: 1.3rem;border: 2px solid black;"></div>

    <script>
        loadTable();

        function loadTable() {
            $(document).ready(function() {
                $.ajax({
                    url: '/CuaHangNoiThat/Admin/getAllReceipt',
                    success: function(data) {
                        var data = JSON.parse(data);
                        //console.log(data);

                        $xhtml = '<thead>' +
                            '<tr>' +
                            '<th scope="col">#</th>' +
                            '<th scope="col">Mã Phiếu Nhập</th>' +
                            '<th scope="col">Tên Nhân Viên</th>' +
                            '<th scope="col">Tên Nhà Cung Cấp</th>' +
                            '<th scope="col">Ngày Lập</th>' +
                            '<th scope="col">Giờ Lập</th>' +
                            '<th scope="col" style="width: 10rem;">Tổng</th>' +
                            '<th scope="col" style="width: 15rem;">Chức Năng</th>' +
                            '</tr>' +
                            '</thead>' +
                            '<tbody>';
                        for ($i = 0; $i < data.length; $i++) {
                            $xhtml += '<tr><th scope="row">' + ($i + 1) + '</th>' +
                                '<td>' + data[$i].MAPN + '</td>' +
                                '<td>('+data[$i].MANV+')' + data[$i].TENNV + '</td>' +
                                '<td>' + data[$i].TENNCC + '</td>' +
                                '<td>' + data[$i].NGAYLAP + '</td>' +
                                '<td>' + data[$i].GIOLAP + '</td>' +
                                '<th scope="col">' + formatter.format(data[$i].TONG) + '</th>' +
                                '<td>' +
                                '<button onclick="viewBillDetail(\''+data[$i].MAPN+'\');" class="btn btn-primary btnControl" type="submit" style="background-color: #007bff;margin-top: 0.3rem;">In phiếu nhập</button>' +
                                '<a href="/CuaHangNoiThat/Admin/XemChiTietPhieuNhap/'+data[$i].MAPN+'">' +
                                '<button class="btn btn-primary btnControl" type="submit" style="background-color: green;margin-top: 0.3rem;">Xem chi tiết</button>' +
                                '</a>' +
                                '</td></tr>';
                        }


                        $xhtml += '</tbody></table>';
                        $('#tableContent').html($xhtml);
                    }
                });
            });
        }

        //Bat su kien nhap vao o tim kiem
        $(document).ready(function() {
            $("#searchReceipt").keyup(function() {
                $value = convertStringToEnglish(this.value);

                $.ajax({
                    url: '/CuaHangNoiThat/Admin/getAllReceipt',
                    success: function(data) {
                        var data = JSON.parse(data);
                        //console.log(data);
                        $xhtml = '<thead>' +
                            '<tr>' +
                            '<th scope="col">#</th>' +
                            '<th scope="col">Mã Phiếu Nhập</th>' +
                            '<th scope="col">Tên Nhân Viên</th>' +
                            '<th scope="col">Tên Nhà Cung Cấp</th>' +
                            '<th scope="col">Ngày Lập</th>' +
                            '<th scope="col">Giờ Lập</th>' +
                            '<th scope="col" style="width: 10rem;">Tổng</th>' +
                            '<th scope="col" style="width: 15rem;">Chức Năng</th>' +
                            '</tr>' +
                            '</thead>' +
                            '<tbody>';
                        for ($i = 0; $i < data.length; $i++) {
                            $check = false;
                            if (convertStringToEnglish(data[$i].MAPN).includes($value)) {
                                $check = true;
                            }
                            if (convertStringToEnglish(data[$i].TENNV).includes($value)) {
                                $check = true;
                            }

                            if (convertStringToEnglish(data[$i].TENNCC).includes($value)) {
                                $check = true;
                            }
                            if (convertStringToEnglish(data[$i].NGAYLAP).includes($value)) {
                                $check = true;
                            }

                            if (!$check) {
                                continue;
                            }
                            $xhtml += '<tr><th scope="row">' + ($i + 1) + '</th>' +
                                '<td>' + data[$i].MAPN + '</td>' +
                                '<td>' + data[$i].TENNV + '</td>' +
                                '<td>' + data[$i].TENNCC + '</td>' +
                                '<td>' + (data[$i].NGAYLAP) + '</td>' +
                                '<td>' + data[$i].GIOLAP + '</td>' +
                                '<th scope="col">' + formatter.format(data[$i].TONG) + '</th>' +
                                '<td>' +
                                '<button onclick="viewBillDetail(\''+data[$i].MAPN+'\');" class="btn btn-primary btnControl" type="submit" style="background-color: #007bff;margin-top: 0.3rem;">In phiếu nhập</button>' +
                                '<a href="/CuaHangNoiThat/Admin/XemChiTietPhieuNhap/1">' +
                                '<button class="btn btn-primary btnControl" type="submit" style="background-color: green;margin-top: 0.3rem;">Xem chi tiết</button>' +
                                '</a>' +
                                '</td></tr>';
                        }


                        $xhtml += '</tbody></table>';
                        $('#tableContent').html($xhtml);
                    }
                });

            });
        });

        function searchReceipt() {
            $receiptId = "@";
            $nameSupplier = "@";
            $nameStaff = "@";
            $day = "@";
            $month = "@";
            $year = "@";

            if ($("#checkReceiptId").is(":checked")) {
                $receiptId = convertStringToEnglish($("#inputReceiptId").val());
            }
            if ($("#checkNameSupplier").is(":checked")) {
                $nameSupplier = convertStringToEnglish($("#inputNameSupplier").val());
            }
            if ($("#checkNameStaff").is(":checked")) {
                $nameStaff = convertStringToEnglish($("#inputNameStaff").val());
            }
            if ($("#checkDay").is(":checked")) {
                $day = convertStringToEnglish($("#inputDay").val());
            }
            if ($("#checkMonth").is(":checked")) {
                $month = convertStringToEnglish($("#inputMonth").val());
            }
            if ($("#checkYear").is(":checked")) {
                $year = convertStringToEnglish($("#inputYear").val());
            }

            $.ajax({
                url: '/CuaHangNoiThat/Admin/getAllReceipt',
                success: function(data) {
                    var data = JSON.parse(data);
                    //console.log(data);
                    $xhtml = '<thead>' +
                        '<tr>' +
                        '<th scope="col">#</th>' +
                        '<th scope="col">Mã Phiếu Nhập</th>' +
                        '<th scope="col">Tên Nhân Viên</th>' +
                        '<th scope="col">Tên Nhà Cung Cấp</th>' +
                        '<th scope="col">Ngày Lập</th>' +
                        '<th scope="col">Giờ Lập</th>' +
                        '<th scope="col" style="width: 10rem;">Tổng</th>' +
                        '<th scope="col" style="width: 15rem;">Chức Năng</th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>';
                    for ($i = 0; $i < data.length; $i++) {
                        $dayReceipt = parseInt(data[$i].NGAYLAP.substring(8));
                        $monthReceipt = parseInt(data[$i].NGAYLAP.substring(5, 7));
                        $yearReceipt = parseInt(data[$i].NGAYLAP.substring(0, 4));


                        if ($receiptId != '@' && !convertStringToEnglish(data[$i].MAPN).includes($receiptId)) {
                            continue;
                        }
                        if ($nameStaff != '@' && !convertStringToEnglish(data[$i].TENNV).includes($nameStaff)) {
                            continue;
                        }
                        if ($nameSupplier != '@' && !convertStringToEnglish(data[$i].TENNCC).includes($nameSupplier)) {
                            continue;
                        }
                        if ($day != '@' && $day != $dayReceipt) {
                            continue;
                        }
                        if ($month != '@' && $month != $monthReceipt) {
                            continue;
                        }
                        if ($year != '@' && $year != $yearReceipt) {
                            continue;
                        }



                        $xhtml += '<tr><th scope="row">' + ($i + 1) + '</th>' +
                            '<td>' + data[$i].MAPN + '</td>' +
                            '<td>' + data[$i].TENNV + '</td>' +
                            '<td>' + data[$i].TENNCC + '</td>' +
                            '<td>' + (data[$i].NGAYLAP) + '</td>' +
                            '<td>' + data[$i].GIOLAP + '</td>' +
                            '<th scope="col">' + formatter.format(data[$i].TONG) + '</th>' +
                            '<td>' +
                            '<button class="btn btn-primary btnControl" type="submit" style="background-color: #007bff;margin-top: 0.3rem;">In phiếu nhập</button>' +
                            '<a href="/CuaHangNoiThat/Admin/XemChiTietPhieuNhap/1">' +
                            '<button class="btn btn-primary btnControl" type="submit" style="background-color: green;margin-top: 0.3rem;">Xem chi tiết</button>' +
                            '</a>' +
                            '</td></tr>';
                    }


                    $xhtml += '</tbody></table>';
                    $('#tableContent').html($xhtml);
                }
            });
        }


        //Xem chi tiet Phieu Nhap
        function viewBillDetail($id) {
            $.ajax({
                url: '/CuaHangNoiThat/Admin/getReceiptAndDetail',
                data: {
                    'id': $id
                },
                method: "post",
                success: function(data) {
                    var data = JSON.parse(data);
                    var bill = data.receipt;
                    var detail = data.detail;

                    console.log(data);

                    $xhtml = '<div>' +
                        '<button class="printBtn btn btn-primary btnControl" style="background-color: red;" onclick="$(\'#printReceipt\').hide();">Đóng</button>' +
                        '<button class="printBtn btn btn-primary btnControl" onclick="printBillTOImage();">In</button>' +
                        '</div>' +
                        '<div id="exportBillToImage">' +
                        '<div style="width: 100%;background-color: lightgray;">' +
                        '<h1 style="text-align: center;">MILD STORE</h1>' +
                        '<div style="width: 100%;text-align: center;">' +
                        '<p style="font-weight: 800;color: gray;">Decorate your Life with Arts</p>' +
                        '<h5>Địa chỉ: 273 An D. Vương, Phường 3, Quận 5, Thành phố Hồ Chí Minh</h5>' +
                        '<h5>SĐT: 0843739379</h5>' +
                        '<h5>www.mildstore.com</h5>' +
                        '</div>' +
                        '<div>' +
                        '<p style="text-align: center;">------------------------------------------------------------------------------------------</p>' +
                        '<h3 style="width: 90%;margin-left: 5%;">THÔNG TIN PHIẾU NHẬP</h3>' +
                        '<div style="background-color: white;width: 90%;margin-left: 5%;padding: 1rem;">' +
                        '<table style="font-size:1.2rem;">' +
                        '<tr>' +
                        '<td style="font-weight:800;padding-right:3rem;">Mã Phiếu Nhập: </td>' +
                        '<td>' + bill.MAPN + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="font-weight:800;padding-right:3rem;">Tên Nhân Viên: </td>' +
                        '<td>' + bill.TENNV + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="font-weight:800;padding-right:3rem;">Tên Nhà Cung Cấp: </td>' +
                        '<td>' + bill.TENNCC + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="font-weight:800;padding-right:3rem;">Thời gian lập : </td>' +
                        '<td>' + bill.GIOLAP + ' ' + bill.NGAYLAP + '</td>' +
                        '</tr>' +
                        '</table>' +
                        '</div>' +
                        '<h3 style="width: 90%;margin-left: 5%;">CHI TIẾT PHIẾU NHẬP</h3>' +
                        '<table class="table" style="width: 90%;margin-left: 5%;background-color: white;">' +
                        '<thead>';
                    $xhtml += '<tr>' +
                        '<th scope="col">#</th>' +
                        '<th scope="col">Tên Sản Phẩm</th>' +
                        '<th scope="col">Số Lượng</th>' +
                        '<th scope="col">Đơn Giá</th>' +
                        '<th scope="col">Thành Tiền</th>' +
                        '</tr>';
                    $sumPrice = 0;
                    $sumNumber = 0;
                    for ($i = 0; $i < detail.length; $i++) {
                        $sumNumber += parseInt(detail[$i].SOLUONG);
                        $sumPrice += parseInt(detail[$i].GIA) * parseInt(detail[$i].SOLUONG);
                        $xhtml += '<tr>' +
                            '<th scope="col">' + ($i + 1) + '</th>' +
                            '<td>' + detail[$i].TENSP + '</td>' +
                            '<td>' + detail[$i].SOLUONG + '</td>' +
                            '<th scope="col">' + formatter.format(detail[$i].GIA) + '</th>' +
                            '<th scope="col">' + formatter.format(detail[$i].GIA * detail[$i].SOLUONG) + '</th>' +
                            '</tr>';
                    }
                    $xhtml += '<tr>' +
                        '<th scope="col" colspan="6"></th>' +
                        '</tr>' +
                        '<tr>' +
                        '<th scope="col" colspan="2">Thành Tiền:</th>' +
                        '<td colspan="1">' + $sumNumber + '<td>' +
                        '<th scope="col">' + formatter.format($sumPrice) + '</th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>' +
                        '</tbody>' +
                        '</table>' +
                        '</div>' +
                        '</div>' +
                        '</div>';

                    $("#printReceipt").html($xhtml);
                    $("#printReceipt").show();
                }
            });
        }

        function printBillTOImage() {
            html2canvas(document.querySelector("#exportBillToImage")).then(canvas => {
                canvas.toBlob(function(blob) {
                    saveAs(blob, "Receipt.png");
                });
            });
        }

        $('#openExportReceipt').hide();
        function exportExcel() {
            //<a href="">
            $.ajax({
                url: '/CuaHangNoiThat/Admin/exportReceiptToExcel',
                success: function(data) {
                    var data = JSON.parse(data);
                    if (data.ERROR == 0) {
                        $xhtml = 'Xuất phiếu nhập thành công file được lưu tại (' + data.NAME + '). Bạn có muốn mở file không ?' +
                            '<div>' +
                            '<button class="btn btn-primary btnControl" style="background-color: white;color: #007bff;float: right;" onclick="window.location = \'' + data.NAME + '\';$(\'#openExportReceipt\').hide();">Mở File</button>' +
                            '<button class="btn btn-primary btnControl" style="background-color: blue;color: white;float: right;" onclick="$(\'#openExportReceipt\').hide();">Đóng</button>' +
                            '</div>';
                        $('#openExportReceipt').html($xhtml);
                        $('#openExportReceipt').show();
                    } else {
                        alert('Lỗi khi ghi file : ' + data.ERROR);
                    }
                }
            });
        }
    </script>
</body>

</html>