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
        <h2>Tìm kiếm hóa đơn nâng cao</h2>
        <div class="form-row">
            <div class="form-group col-md-4">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="checkIdBill">
                    <label class="form-check-label" for="autoSizingCheck">Tìm theo mã hóa đơn</label>
                </div>
                <input type="text" class="form-control" id="inputIdBil">
            </div>
            <div class="form-group col-md-4">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="checkNameCus">
                    <label class="form-check-label" for="autoSizingCheck">Tìm theo tên khách hàng</label>
                </div>
                <input type="text" class="form-control" id="inputNameCus">
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
        </div>
        <a href="/CuaHangNoiThat/Admin/HoaDon">
            <button type="submit" class="btn btn-primary" style="background-color: white;color: #007bff;">Trở về </button>
        </a>
        <button type="submit" onclick="searchBill();" class="btn btn-primary">Tìm kiếm </button>
    </div>


    <table id="tableContent" class="table" style="width: 80%;margin-left: 10%;">
    <div id="printBill" style="width: 40%;margin-left: 30%;background-color: lightgray;color: black;position: absolute;top: 5rem;"></div>ode
        
    </table>


    <script>
        //TIm kiem hoa don
        function searchBill(){
            $billId = "@";
            $nameCus = "@";
            $nameStaff = "@";
            $day = "@";
            $month = "@";
            $year = "@";

            $isSearch = false;
            if($("#checkIdBill").is(":checked")){
               $billId = convertStringToEnglish($("#inputIdBil").val());
               $isSearch = true;
            }
            if($("#checkNameCus").is(":checked")){
               $nameCus = convertStringToEnglish($("#inputNameCus").val());
               $isSearch = true;
            }
            if($("#checkNameStaff").is(":checked")){
               $nameStaff = convertStringToEnglish($("#inputNameStaff").val());
               $isSearch = true;
            }
            if($("#checkDay").is(":checked")){
               $day = convertStringToEnglish($("#inputDay").val());
               $isSearch = true;
            }
            if($("#checkMonth").is(":checked")){
               $month = convertStringToEnglish($("#inputMonth").val());
               $isSearch = true;
            }
            if($("#checkYear").is(":checked")){
               $year = convertStringToEnglish($("#inputYear").val());
               $isSearch = true;
            }

           


            $.ajax({
                url: "/CuaHangNoiThat/Admin/getAllBill",
                success : function(data){
                    var data = JSON.parse(data);
                    var xhtml = '<thead>' +
                            '<tr>' +
                            '<th scope="col">#</th>' +
                            '<th scope="col">Mã Hóa Đơn</th>' +
                            '<th scope="col">Tên Nhân Viên</th>' +
                            '<th scope="col">Tên Khách Hàng</th>' +
                            '<th scope="col">Ngày Lập</th>' +
                            '<th scope="col">Giờ Lập</th>' +
                            '<th scope="col" style="width: 10rem;">Tổng</th>' +
                            '<th scope="col">Trạng Thái</th>' +
                            '<th scope="col" style="width: 15rem;">Chức Năng</th>' +
                            '</tr>' +
                            '</thead><tbody>';
                        $checkingSearch = true;
                        for (var i = 0; i < data.length; i++) {
                            $dayBill = data[i].NGAYLAP.substring(8);
                            $monthBill = data[i].NGAYLAP.substring(5,7);
                            $yearBill = data[i].NGAYLAP.substring(0,4);


                            if($billId != '@' && !convertStringToEnglish(data[i].MAHD).includes($billId)){
                                continue;
                            }
                            if($nameStaff != '@' && !convertStringToEnglish(data[i].TENNV).includes($nameStaff)){
                                continue;
                            }
                            if($nameCus != '@' && !convertStringToEnglish(data[i].TENKH).includes($nameCus)){
                                continue;
                            }
                            if($day != '@' && $day != $dayBill){
                                continue;
                            }
                            if($month != '@' && $month != $monthBill){
                                continue;
                            }
                            if($year != '@' && $year != $yearBill){
                                continue;
                            }


                            if(!$isSearch){
                                continue;
                            }



                            xhtml += '<tr>' +
                                '<th scope="row">' + (i + 1) + '</th>' +
                                '<td>' + data[i]['MAHD'] + '</td>' +
                                '<td>' + data[i]['TENNV'] + '</td>' +
                                '<td>' + data[i]['TENKH'] + '</td>' +
                                '<td>' + data[i]['NGAYLAP'] + '</td>' +
                                '<td>' + data[i]['GIOLAP'] + '</td>' +
                                '<th scope="row">' + formatter.format(data[i]['TONG']) + '</th>' +
                                '<td>' + data[i]['MAKM'] + ' (' + data[i]['PHANTRAMGIAM'] + '%)</td>' +
                                '<th scope="row">' + data[i]['TONG'] * (1 - (data[i]['PHANTRAMGIAM'] / 100)) + '</th>' +
                                '<td>' + data[i]['MOTATRANGTHAI'] + '</td>' +
                                '<td>';
                            if (data[i].MATRANGTHAI == 'TT01') {
                                xhtml += '<button onclick="confirmBill(\''+data[i]['MAHD']+'\');" class="btn btn-primary btnControl" type="submit" style="background-color: red;" onclick="">Xác nhận hóa đơn</button>';
                            }
                            xhtml += '<button  onclick="viewBillDetail(\'' + data[i]['MAHD'] + '\');" class="btn btn-primary btnControl" type="submit" style="background-color: #007bff;margin-top: 0.3rem;">In hóa đơn</button>' +
                                '<a href="/CuaHangNoiThat/Admin/XemChiTietHD/' + data[i].MAHD + '">' +
                                '<button class="btn btn-primary btnControl" type="submit" style="background-color: green;margin-top: 0.3rem;">Xem chi tiết</button>' +
                                '</a>' +
                                '</td>' +
                                '</tr>';

                        }
                        xhtml += '</tbody>';

                        document.getElementById('tableContent').innerHTML = xhtml;
                }
            });
        }
        function viewBillDetail($id) {
            $.ajax({
                url: '/CuaHangNoiThat/Admin/getBillAndDetail',
                data: {
                    'id': $id
                },
                method: "post",
                success: function(data) {
                    var data = JSON.parse(data);
                    var bill = data.bill;
                    var detail = data.detail;

                    console.log(data);

                    $xhtml = '<div>' +
                        '<button class="printBtn btn btn-primary btnControl" style="background-color: red;" onclick="$(\'#printBill\').hide();">Đóng</button>' +
                        '<button class="printBtn btn btn-primary btnControl" onclick="printBillTOImage();">In</button>' +
                        '</div>' +
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
                        '<h3 style="width: 90%;margin-left: 5%;">THÔNG TIN HÓA ĐƠN</h3>' +
                        '<div style="background-color: white;width: 90%;margin-left: 5%;padding: 1rem;">' +
                        '<table style="font-size:1.2rem;">' +
                        '<tr>' +
                        '<td style="font-weight:800;padding-right:3rem;">Mã Hóa Đơn: </td>' +
                        '<td>' + bill.MAHD + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="font-weight:800;padding-right:3rem;">Tên Nhân Viên: </td>' +
                        '<td>' + bill.TENNV + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="font-weight:800;padding-right:3rem;">Tên Khách Hàng: </td>' +
                        '<td>' + bill.TENKH + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="font-weight:800;padding-right:3rem;">Thời gian lập : </td>' +
                        '<td>' + bill.GIOLAP + ' ' + bill.NGAYLAP + '</td>' +
                        '</tr>' +
                        '</table>' +
                        '</div>' +
                        '<h3 style="width: 90%;margin-left: 5%;">CHI TIẾT HÓA ĐƠN</h3>' +
                        '<table class="table" style="width: 90%;margin-left: 5%;background-color: white;">' +
                        '<thead>';
                    $xhtml += '<tr>' +
                        '<th scope="col">#</th>' +
                        '<th scope="col">Tên Sản Phẩm</th>' +
                        '<th scope="col">Số Lượng</th>' +
                        '<th scope="col">% Giảm</th>' +
                        '<th scope="col">Đơn Giá</th>' +
                        '<th scope="col">Thành Tiền</th>' +
                        '</tr>';
                    $sumPrice = 0;
                    $sumNumber = 0;
                    for ($i = 0; $i < detail.length; $i++) {
                        $sumNumber += parseInt(detail[$i].SOLUONG);
                        $sumPrice += parseInt(detail[$i].GIA)*parseInt(detail[$i].SOLUONG)*(1-(detail[$i].PHANTRAMGIAM/100));
                        $xhtml += '<tr>' +
                            '<th scope="col">' + ($i + 1) + '</th>' +
                            '<td>' + detail[$i].TENSP + '</td>' +
                            '<td>' + detail[$i].SOLUONG + '</td>' +
                            '<td>'+detail[$i].PHANTRAMGIAM+'%</td>' +
                            '<th scope="col">' + formatter.format(detail[$i].GIA) + '</th>' +
                            '<th scope="col">' + formatter.format(detail[$i].GIA * detail[$i].SOLUONG*(1-(detail[$i].PHANTRAMGIAM/100))) + '</th>' +
                            '</tr>';
                    }
                    $xhtml += '<tr>' +
                        '<th scope="col" colspan="6"></th>' +
                        '</tr>' +
                        '<tr>' +
                        '<th scope="col" colspan="2">Tổng</th>' +
                        '<td colspan="2">'+$sumNumber+'<td>'+
                        '<th scope="col">'+formatter.format($sumPrice)+'</th>' +
                        '</tr>' +
                        '<tr>' +
                        '<th scope="col" colspan="5">Giảm giá</th>' +
                        '<td colspan="2">'+bill.SALE.PHANTRAMGIAM+'%<td>'+
                        '</tr>' +
                        '<tr>' +
                        '<th scope="col" colspan="5">Thành Tiền</th>' +
                        '<th scope="col" colspan="2">'+formatter.format((1-(bill.SALE.PHANTRAMGIAM/100))*$sumPrice)+'<th>'+
                        '</tr>' +
                        '</thead>' +
                        '<tbody>' +
                        '</tbody>' +
                        '</table>' +
                        '</div>' +
                        '</div>';

                    $("#printBill").html($xhtml);
                    $("#printBill").show();
                }
            });
        }

        function printBillTOImage() {
            html2canvas(document.querySelector("#printBill")).then(canvas => {
                canvas.toBlob(function(blob) {
                    saveAs(blob, "Bill.png");
                });
            });
        }
    </script>
</body>

</html>