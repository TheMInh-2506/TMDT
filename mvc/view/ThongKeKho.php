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

        .selecter {
            width: 40%;
            margin-left: 30%;
        }

        .selecter td {
            padding: 0 1rem 0 1rem;
        }

        .selecter td>h4 {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h1 style="margin-top: 5rem;margin-left: 10%;"><?php echo $title; ?></h1>
    <h3 style="margin-top: 5rem;margin-left: 10%;">Thống kê số lượng nhập xuất theo thời gian</h3>
    <div style="width: 80%;margin-left: 10%;margin-top: 1rem;">
        <table class="selecter">
            <tr>
                <td>
                    <h4>Chọn ngày bắt đầu</h4>
                </td>
                <td>
                    <h4>Chọn ngày kết thúc</h4>
                </td>
            </tr>
            <tr>
                <td><input type="date" id="monthFrom"></td>
                <td><input type="date" id="monthTo"></td>
                <td><button class="btn btn-primary" onclick="statistic();">Thống Kê</button></td>
            </tr>
        </table>
        <h1 id="sms"></h1>
    </div>
    <h3 style="margin-top: 5rem;margin-left: 10%;">Danh sách nhập xuất</h3>
    <div style="width: 80%;margin-left: 10%;margin-top: 1rem;">
        <div class="form-row">
            <div class="form-group col-md-2">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="checkIdBill">
                    <label class="form-check-label" for="autoSizingCheck">Tìm theo mã phiếu</label>
                </div>
                <input type="text" class="form-control" id="inputIdBil">
            </div>
            <div class="form-group col-md-2">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="checkNameCus">
                    <label class="form-check-label" for="autoSizingCheck">Tìm theo loại phiếu</label>
                </div>
                <select class="form-control" id="noteInOut">
                    <option value="PN">Phiếu Nhập Kho</option>
                    <option value="HD">Phiếu Xuất Kho</option>
                </select>
            </div>
            <div class="form-group col-md-2">
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
            <button type="submit" onclick="searchBill();" class="btn btn-primary">Tìm kiếm </button>
        </div>
    </div>

    <!-- Bang hoa don -->
    <table id="tableContent" class="table" style="width: 80%;margin-left: 10%;"></table>

    <!-- Chi tiet hoa don -->
    <div id="printBill" style="width: 40%;margin-left: 30%;background-color: lightgray;color: black;position: absolute;top: 5rem;"></div>

    <!-- Thong bao xuat excel thanh cong -->
    <div id="openExportBill" style="width: 60%;background-color: #007bff; position: absolute; top: 25%; height: auto; padding: 2rem; border-radius: 1rem; color: white;left:20%;font-size: 1.3rem;border: 2px solid black;"></div>

    <script>
        $('#openExportBill').hide();

        function loadTable() {
            $(document).ready(function() {
                $.ajax({
                    url: "/CuaHangNoiThat/NhanVien/getAllBillAndReceiptWithDetail",
                    success: function(data) {
                        var data = JSON.parse(data);
                        var dataBill = data.BILL;
                        var dataReceipt = data.RECEIPT;

                        var xhtml = '<thead>' +
                            '<tr>' +
                            '<th scope="col">#</th>' +
                            '<th scope="col">Mã phiếu</th>' +
                            '<th scope="col">Loại phiếu</th>' +
                            '<th scope="col">Ngày Lập</th>' +
                            '<th scope="col">Giờ Lập</th>' +
                            '<th scope="col">Người Lập</th>' +
                            '<th scope="col" style="width: 15rem;">Chức Năng</th>' +
                            '</tr>' +
                            '</thead><tbody>';

                        var stt = 1;

                        for (var i = 0; i < dataBill.length; i++) {
                            if (dataBill[i]['ex_staff'] == null) {
                                continue;
                            }
                            xhtml += '<tr>' +
                                '<th scope="row">' + (stt++) + '</th>' +
                                '<td>' + dataBill[i]['MAHD'] + '</td>' +
                                '<td>Phiếu Xuất Kho</td>' +
                                '<td>' + (dataBill[i]['NGAYLAP']) + '</td>' +
                                '<td>' + dataBill[i]['GIOLAP'] + '</td>' +
                                '<td>' + dataBill[i]['ex_staff']['TENNV'] + '</td>' +
                                '<td>';

                            xhtml += '<a href="/CuaHangNoiThat/NhanVien/XemChiTietPX/' + dataBill[i].MAHD + '">' +
                                '<button class="btn btn-primary btnControl" type="submit" style="background-color: green;margin-top: 0.3rem;">Xem chi tiết</button>' +
                                '</a>' +
                                '</td>' +
                                '</tr>';
                        }

                        for (var i = 0; i < dataReceipt.length; i++) {
                            xhtml += '<tr>' +
                                '<th scope="row">' + (stt++) + '</th>' +
                                '<td>' + dataReceipt[i]['MAPN'] + '</td>' +
                                '<td>Phiếu Nhập Kho</td>' +
                                '<td>' + (dataReceipt[i]['NGAYLAP']) + '</td>' +
                                '<td>' + dataReceipt[i]['GIOLAP'] + '</td>' +
                                '<td>' + dataReceipt[i]['staff']['TENNV'] + '</td>' +
                                '<td>';

                            xhtml += '<a href="/CuaHangNoiThat/NhanVien/XemCHiTietPhieuNhap/' + dataReceipt[i].MAPN + '">' +
                                '<button class="btn btn-primary btnControl" type="submit" style="background-color: green;margin-top: 0.3rem;">Xem chi tiết</button>' +
                                '</a>' +
                                '</td>' +
                                '</tr>';
                        }
                        xhtml += '</tbody>';
                        document.getElementById('tableContent').innerHTML = xhtml;
                    }
                });
            });
        }
        loadTable();



        //TIm kiem hoa don
        function searchBill() {
            $billId = "@";
            $type = "@";
            $nameStaff = "@";
            $day = "@";
            $month = "@";
            $year = "@";


            if ($("#checkIdBill").is(":checked")) {
                $billId = convertStringToEnglish($("#inputIdBil").val());
            }
            if ($("#checkNameCus").is(":checked")) {
                $type = ($("#noteInOut").val());
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
                url: "/CuaHangNoiThat/NhanVien/getAllBillAndReceiptWithDetail",
                success: function(data) {
                    var data = JSON.parse(data);
                    var dataBill = data.BILL;
                    var dataReceipt = data.RECEIPT;

                    var xhtml = '<thead>' +
                        '<tr>' +
                        '<th scope="col">#</th>' +
                        '<th scope="col">Mã phiếu</th>' +
                        '<th scope="col">Loại phiếu</th>' +
                        '<th scope="col">Ngày Lập</th>' +
                        '<th scope="col">Giờ Lập</th>' +
                        '<th scope="col">Người Lập</th>' +
                        '<th scope="col" style="width: 15rem;">Chức Năng</th>' +
                        '</tr>' +
                        '</thead><tbody>';

                    var stt = 1;
                    if ($type == 'HD') {
                        for (var i = 0; i < dataBill.length; i++) {
                            $dayBill = parseInt(dataBill[i].NGAYLAP.substring(8));
                            $monthBill = parseInt(dataBill[i].NGAYLAP.substring(5, 7));
                            $yearBill = parseInt(dataBill[i].NGAYLAP.substring(0, 4));
                            if (dataBill[i]['ex_staff'] == null) {
                                continue;
                            }
                            if ($billId != '@' && !convertStringToEnglish(dataBill[i].MAHD).includes($billId)) {
                                continue;
                            }
                            if ($nameStaff != '@' && !convertStringToEnglish(dataBill[i]['ex_staff']['TENNV']).includes($nameStaff)) {
                                continue;
                            }

                            if ($day != '@' && $day != $dayBill) {
                                continue;
                            }
                            if ($month != '@' && $month != $monthBill) {
                                continue;
                            }
                            if ($year != '@' && $year != $yearBill) {
                                continue;
                            }

                            xhtml += '<tr>' +
                                '<th scope="row">' + (stt++) + '</th>' +
                                '<td>' + dataBill[i]['MAHD'] + '</td>' +
                                '<td>Phiếu Xuất Kho</td>' +
                                '<td>' + (dataBill[i]['NGAYLAP']) + '</td>' +
                                '<td>' + dataBill[i]['GIOLAP'] + '</td>' +
                                '<td>' + dataBill[i]['ex_staff']['TENNV'] + '</td>' +
                                '<td>';

                            xhtml += '<a href="/CuaHangNoiThat/NhanVien/XemChiTietPX/' + dataBill[i].MAHD + '">' +
                                '<button class="btn btn-primary btnControl" type="submit" style="background-color: green;margin-top: 0.3rem;">Xem chi tiết</button>' +
                                '</a>' +
                                '</td>' +
                                '</tr>';
                        }

                    } else if ($type == 'PN') {
                        for (var i = 0; i < dataReceipt.length; i++) {
                            $dayBill = parseInt(dataReceipt[i].NGAYLAP.substring(8));
                            $monthBill = parseInt(dataReceipt[i].NGAYLAP.substring(5, 7));
                            $yearBill = parseInt(dataReceipt[i].NGAYLAP.substring(0, 4));

                            if ($billId != '@' && !convertStringToEnglish(dataReceipt[i].MAPN).includes($billId)) {
                                continue;
                            }
                            if ($nameStaff != '@' && !convertStringToEnglish(dataReceipt[i]['staff']['TENNV']).includes($nameStaff)) {
                                continue;
                            }

                            if ($day != '@' && $day != $dayBill) {
                                continue;
                            }
                            if ($month != '@' && $month != $monthBill) {
                                continue;
                            }
                            if ($year != '@' && $year != $yearBill) {
                                continue;
                            }
                            xhtml += '<tr>' +
                                '<th scope="row">' + (stt++) + '</th>' +
                                '<td>' + dataReceipt[i]['MAPN'] + '</td>' +
                                '<td>Phiếu Nhập Kho</td>' +
                                '<td>' + (dataReceipt[i]['NGAYLAP']) + '</td>' +
                                '<td>' + dataReceipt[i]['GIOLAP'] + '</td>' +
                                '<td>' + dataReceipt[i]['staff']['TENNV'] + '</td>' +
                                '<td>';

                            xhtml += '<a href="/CuaHangNoiThat/NhanVien/XemCHiTietPhieuNhap/' + dataReceipt[i].MAPN + '">' +
                                '<button class="btn btn-primary btnControl" type="submit" style="background-color: green;margin-top: 0.3rem;">Xem chi tiết</button>' +
                                '</a>' +
                                '</td>' +
                                '</tr>';
                        }
                    } else {
                        for (var i = 0; i < dataBill.length; i++) {
                            $dayBill = parseInt(dataBill[i].NGAYLAP.substring(8));
                            $monthBill = parseInt(dataBill[i].NGAYLAP.substring(5, 7));
                            $yearBill = parseInt(dataBill[i].NGAYLAP.substring(0, 4));
                            if (dataBill[i]['ex_staff'] == null) {
                                continue;
                            }
                            if ($billId != '@' && !convertStringToEnglish(dataBill[i].MAHD).includes($billId)) {
                                continue;
                            }
                            if ($nameStaff != '@' && !convertStringToEnglish(dataBill[i]['ex_staff']['TENNV']).includes($nameStaff)) {
                                continue;
                            }

                            if ($day != '@' && $day != $dayBill) {
                                continue;
                            }
                            if ($month != '@' && $month != $monthBill) {
                                continue;
                            }
                            if ($year != '@' && $year != $yearBill) {
                                continue;
                            }

                            xhtml += '<tr>' +
                                '<th scope="row">' + (stt++) + '</th>' +
                                '<td>' + dataBill[i]['MAHD'] + '</td>' +
                                '<td>Phiếu Xuất Kho</td>' +
                                '<td>' + (dataBill[i]['NGAYLAP']) + '</td>' +
                                '<td>' + dataBill[i]['GIOLAP'] + '</td>' +
                                '<td>' + dataBill[i]['ex_staff']['TENNV'] + '</td>' +
                                '<td>';

                            xhtml += '<a href="/CuaHangNoiThat/NhanVien/XemChiTietPX/' + dataBill[i].MAHD + '">' +
                                '<button class="btn btn-primary btnControl" type="submit" style="background-color: green;margin-top: 0.3rem;">Xem chi tiết</button>' +
                                '</a>' +
                                '</td>' +
                                '</tr>';
                        }

                        for (var i = 0; i < dataReceipt.length; i++) {
                            $dayBill = parseInt(dataReceipt[i].NGAYLAP.substring(8));
                            $monthBill = parseInt(dataReceipt[i].NGAYLAP.substring(5, 7));
                            $yearBill = parseInt(dataReceipt[i].NGAYLAP.substring(0, 4));

                            if ($billId != '@' && !convertStringToEnglish(dataReceipt[i].MAPN).includes($billId)) {
                                continue;
                            }
                            if ($nameStaff != '@' && !convertStringToEnglish(dataReceipt[i]['staff']['TENNV']).includes($nameStaff)) {
                                continue;
                            }

                            if ($day != '@' && $day != $dayBill) {
                                continue;
                            }
                            if ($month != '@' && $month != $monthBill) {
                                continue;
                            }
                            if ($year != '@' && $year != $yearBill) {
                                continue;
                            }
                            xhtml += '<tr>' +
                                '<th scope="row">' + (stt++) + '</th>' +
                                '<td>' + dataReceipt[i]['MAPN'] + '</td>' +
                                '<td>Phiếu Nhập Kho</td>' +
                                '<td>' + (dataReceipt[i]['NGAYLAP']) + '</td>' +
                                '<td>' + dataReceipt[i]['GIOLAP'] + '</td>' +
                                '<td>' + dataReceipt[i]['staff']['TENNV'] + '</td>' +
                                '<td>';

                            xhtml += '<a href="/CuaHangNoiThat/NhanVien/XemCHiTietPhieuNhap/' + dataReceipt[i].MAPN + '">' +
                                '<button class="btn btn-primary btnControl" type="submit" style="background-color: green;margin-top: 0.3rem;">Xem chi tiết</button>' +
                                '</a>' +
                                '</td>' +
                                '</tr>';
                        }
                    }

                    xhtml += '</tbody>';

                    document.getElementById('tableContent').innerHTML = xhtml;
                }
            });
        }


        function statistic() {
            $monthFrom = $("#monthFrom").val()
            $monthTo = $("#monthTo").val()

            if (!$monthFrom.localeCompare('') || !$monthTo.localeCompare('')) {
                alert('Vui lòng chọn đầy đủ thông tin để thống kê')
                return;
            }

            //month start must be smaller than month end
            if (-Date.parse($monthFrom) + Date.parse($monthTo) < 0) {
                alert('Ngày bắt đầu phải nhỏ hơn ngày kết thúc');
                return;
            }
            ///CuaHangNoiThat/NhanVien/getAllBillAndReceiptWithDetail
            $.ajax({
                url:'/CuaHangNoiThat/NhanVien/getAllBillAndReceiptWithDetail',
                success : function(data){
                    var data = JSON.parse(data);
                    var dataBill = data.BILL;
                    var dataReceipt = data.RECEIPT;
                    var countIn = 0,countOut = 0;
                    
                    for(var data of dataBill){
                        if(data['ex_staff'] != null && Date.parse(data.NGAYLAP) - Date.parse($monthFrom) >= 0 && Date.parse(data.NGAYLAP) - Date.parse($monthTo) <= 0){
                            countOut++;
                        }
                    }

                    for(var data of dataReceipt){
                        if(Date.parse(data.NGAYLAP) - Date.parse($monthFrom) >= 0 && Date.parse(data.NGAYLAP) - Date.parse($monthTo) <= 0){
                            countIn++;
                        }
                    }

                    var sms = 'Trong khoảng thời gian từ ['+$monthFrom+'] đến ['+$monthTo+'] có '+countIn+' phiếu nhập và '+countOut+' phiếu xuất'
                    $('#sms').html(sms);
                    
                }
            })

        }

    </script>
</body>

</html>