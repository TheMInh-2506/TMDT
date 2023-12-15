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
        <a href="/CuaHangNoiThat/Admin/ThemNhanVien"><button type="button" class="btn btn-primary btn-lg optionButton">Thêm Nhân Viên</button></a>
        <button onclick="exportExcel();" type="button" class="btn btn-primary btn-lg optionButton">Xuất Excel</button>
        <div class="form-group" style="width: 50%;float: right;margin-left: 2rem;">
            <input type="text" class="form-control" id="searchValue" placeholder="Nhập vào tên nhân viên..." style="float: right;width: 20rem;">
        </div>
    </div>


    <div style="width: 80%;margin-left: 10%;margin-top: 1rem;">
        <div class="form-row">
            <div class="form-group col-md-2">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="checkIdStaff">
                    <label class="form-check-label" for="autoSizingCheck">Tìm theo mã nhân viên</label>
                </div>
                <input type="text" class="form-control" id="inputIdStaff">
            </div>
            <div class="form-group col-md-3">
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
            <div class="form-group col-md-1">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="checkSexStaff">
                    <label class="form-check-label" for="autoSizingCheck">Giới Tính</label>
                </div>
                <select class="form-control" id="inputSexStaff">
                    <option value="Nam">Nam</option>
                    <option value="Nữ">Nữ</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-2">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="checkAddressStaff">
                    <label class="form-check-label" for="autoSizingCheck">Tìm theo địa chỉ</label>
                </div>
                <input type="text" class="form-control" id="inputAddressStaff" placeholder="Nhập vào địa chỉ">
            </div>
            <div class="form-group col-md-2">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="checkPhoneStaff">
                    <label class="form-check-label" for="autoSizingCheck">Tìm theo SĐT</label>
                </div>
                <input type="text" class="form-control" id="inputPhoneStaff" placeholder="Nhập vào SĐT">
            </div>
            <div class="form-group col-md-2">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="checkUserStaff">
                    <label class="form-check-label" for="autoSizingCheck">Tìm theo Username</label>
                </div>
                <input type="text" class="form-control" id="inputUserStaff" placeholder="Nhập vào Username">
            </div>
            <div class="form-group col-md-2">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="checkStatusStaff">
                    <label class="form-check-label" for="autoSizingCheck">Trạng Thái</label>
                </div>
                <select class="form-control" id="inputStatusStaff">
                    <option value="1">Đang hoạt động</option>
                    <option value="0">Đã khóa</option>
                </select>
            </div>
            <button onclick="searchValue();" type="submit" class="btn btn-primary">Tìm kiếm </button>
        </div>
    </div>
    <table id="tableContent" class="table" style="width: 80%;margin-left: 10%;"></table>
    <!-- Thong bao xuat excel thanh cong -->
    <div id="openExportSupplier" style="width: 60%;background-color: #007bff; position: absolute; top: 25%; height: auto; padding: 2rem; border-radius: 1rem; color: white;left:20%;font-size: 1.3rem;border: 2px solid black;"></div>

    <script>
        $("#openExportSupplier").hide();
        loadTable();

        function isExistValueInString(string, value) {
            return string.includes(value);
        }

        function loadTable() {
            $.ajax({
                url: '/CuaHangNoiThat/Admin/getAllStaff',
                success: function(data) {
                    var data = JSON.parse(data);

                    $xhtml = '<thead>' +
                        '<tr>' +
                        '<th scope="col">#</th>' +
                        '<th scope="col">Mã Nhân Viên</th>' +
                        '<th scope="col">Tên Nhân Viên</th>' +
                        '<th scope="col">Ngày Sinh</th>' +
                        '<th scope="col">Giới Tính</th>' +
                        '<th scope="col">Địa Chỉ</th>' +
                        '<th scope="col">SĐT</th>' +
                        '<th scope="col">Tên Đăng Nhập</th>' +
                        '<th scope="col">Trạng Thái</th>' +
                        '<th scope="col" style="width: 15rem;">Chức Năng</th>' +
                        '</tr>' +
                        '</thead><tbody>';
                    for ($i = 0; $i < data.length; $i++) {
                        console.log(data);
                        $xhtml += '<tr>' +
                            '<th scope="row">' + ($i + 1) + '</th>' +
                            '<td>' + data[$i].MANV + '</td>' +
                            '<td>' + data[$i].TENNV + '</td>' +
                            '<td>' + (data[$i].NGAYSINH) + '</td>' +
                            '<td>' + data[$i].GIOITINH + '</td>' +
                            '<td>' + data[$i].DIACHI + '</td>' +
                            '<td>' + data[$i].SDT + '</td>' +
                            '<td>' + data[$i].TENDN + '</td>' +
                            '<td>' + (data[$i].TRANGTHAI == 1 ? 'Đang hoạt động' : 'Đã khóa') + '</td>' +
                            '<td>';
                        $rightStaff = data[$i].QUYEN;
                        if (data[$i].TRANGTHAI == 1 && data[$i].STAFF_LOGIN != data[$i].MANV && !isExistValueInString($rightStaff,'e_right')) {
                            $xhtml += '<button onclick="blockStaff(\'' + data[$i].MANV + '\');" class="btn btn-primary btnControl" type="submit" style="background-color: red;">Khóa Nhân Viên</button>' +
                                '<a href="/CuaHangNoiThat/Admin/SuaNhanVien/' + data[$i].MANV + '">' +
                                '<button class="btn btn-primary btnControl" type="submit" style="background-color: green;margin-top: 0.3rem;">Sửa Thông Tin</button></a>';


                            $xhtml += '<a href="/CuaHangNoiThat/Admin/PhanQuyen/' + data[$i].MANV + '"><button class="btn btn-primary btnControl" type="submit" style="background-color: #f09605;margin-top: 0.3rem;">Sửa Phân Quyền</button></a>';


                        }

                        $xhtml += '</td></tr>';
                    }
                    $xhtml += '</tbody>';
                    $("#tableContent").html($xhtml);
                }
            });
        }

        function blockStaff($id) {
            if (!confirm('Bạn có muốn xóa nhân viên này ra khỏi hệ thống hay không ? Việc xóa sẽ không thể hoàn tác khi thực hiện')) {
                return;
            }
            $.ajax({
                url: '/CuaHangNoiThat/Admin/updateStatusStaff',
                method: 'post',
                data: {
                    data: $id
                },
                success: function(data) {
                    alert(data);
                    loadTable();
                }
            });
        }

        $(document).ready(function() {
            $("#searchValue").keyup(function() {
                $searchValue = convertStringToEnglish($("#searchValue").val());

                $.ajax({
                    url: '/CuaHangNoiThat/Admin/getAllStaff',
                    success: function(data) {
                        var data = JSON.parse(data);
                        $xhtml = '<thead>' +
                            '<tr>' +
                            '<th scope="col">#</th>' +
                            '<th scope="col">Mã Nhân Viên</th>' +
                            '<th scope="col">Tên Nhân Viên</th>' +
                            '<th scope="col">Ngày Sinh</th>' +
                            '<th scope="col">Giới Tính</th>' +
                            '<th scope="col">Địa Chỉ</th>' +
                            '<th scope="col">SĐT</th>' +
                            '<th scope="col">Tên Đăng Nhập</th>' +
                            '<th scope="col">Trạng Thái</th>' +
                            '<th scope="col" style="width: 15rem;">Chức Năng</th>' +
                            '</tr>' +
                            '</thead><tbody>';

                        for ($i = 0; $i < data.length; $i++) {
                            $check = false;
                            if (convertStringToEnglish(data[$i].MANV).includes($searchValue)) {
                                $check = true;
                            }
                            if (convertStringToEnglish(data[$i].TENNV).includes($searchValue)) {
                                $check = true;
                            }
                            if (convertStringToEnglish(formatDateToddmmyyyy(data[$i].NGAYSINH)).includes($searchValue)) {
                                $check = true;
                            }
                            if (convertStringToEnglish(data[$i].GIOITINH).includes($searchValue)) {
                                $check = true;
                            }
                            if (convertStringToEnglish(data[$i].SDT).includes($searchValue)) {
                                $check = true;
                            }
                            if (convertStringToEnglish(data[$i].DIACHI).includes($searchValue)) {
                                $check = true;
                            }
                            if (convertStringToEnglish(data[$i].TENDN).includes($searchValue)) {
                                $check = true;
                            }
                            if (convertStringToEnglish((data[$i].TRANGTHAI == 1 ? 'Đang hoạt động' : 'Đã khóa')).includes($searchValue)) {
                                $check = true;
                            }

                            if (!$check) {
                                continue;
                            }
                            $xhtml += '<tr>' +
                                '<th scope="row">' + ($i + 1) + '</th>' +
                                '<td>' + data[$i].MANV + '</td>' +
                                '<td>' + data[$i].TENNV + '</td>' +
                                '<td>' + (data[$i].NGAYSINH) + '</td>' +
                                '<td>' + data[$i].GIOITINH + '</td>' +
                                '<td>' + data[$i].DIACHI + '</td>' +
                                '<td>' + data[$i].SDT + '</td>' +
                                '<td>' + data[$i].TENDN + '</td>' +
                                '<td>' + (data[$i].TRANGTHAI == 1 ? 'Đang hoạt động' : 'Đã khóa') + '</td>' +
                                '<td>';

                            $rightStaff = data[$i].QUYEN;
                            if (data[$i].TRANGTHAI == 1 && data[$i].STAFF_LOGIN != data[$i].MANV && !isExistValueInString($rightStaff,'e_right')) {
                                $xhtml += '<button onclick="blockStaff(\'' + data[$i].MANV + '\');" class="btn btn-primary btnControl" type="submit" style="background-color: red;">Khóa Nhân Viên</button>' +
                                    '<a href="/CuaHangNoiThat/Admin/SuaNhanVien/' + data[$i].MANV + '">' +
                                    '<button class="btn btn-primary btnControl" type="submit" style="background-color: green;margin-top: 0.3rem;">Sửa Thông Tin</button></a>';


                                $xhtml += '<a href="/CuaHangNoiThat/Admin/PhanQuyen/' + data[$i].MANV + '"><button class="btn btn-primary btnControl" type="submit" style="background-color: #f09605;margin-top: 0.3rem;">Sửa Phân Quyền</button></a>';
                            }

                            $xhtml += '</td></tr>';
                        }
                        $xhtml += '</tbody>';
                        $("#tableContent").html($xhtml);
                    }
                });
            });
        });

        function searchValue() {

            $idStaff = "#";
            $nameStaff = "#";
            $day = "#";
            $month = "#";
            $year = "#";
            $sexStaff = "#";
            $rightStaff = "#";
            $addressStaff = "#";
            $phoneStaff = "#";
            $usernameStaff = "#";
            $statusStaff = "#";


            if ($("#checkIdStaff").is(":checked")) {
                $idStaff = convertStringToEnglish($("#inputIdStaff").val());
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
            if ($("#checkSexStaff").is(":checked")) {
                $sexStaff = convertStringToEnglish($("#inputSexStaff").val());
            }
            if ($("#checkAddressStaff").is(":checked")) {
                $addressStaff = convertStringToEnglish($("#inputAddressStaff").val());
            }
            if ($("#checkPhoneStaff").is(":checked")) {
                $phoneStaff = convertStringToEnglish($("#inputPhoneStaff").val());
            }
            if ($("#checkUserStaff").is(":checked")) {
                $usernameStaff = convertStringToEnglish($("#inputUserStaff").val());
            }
            if ($("#checkStatusStaff").is(":checked")) {
                $statusStaff = convertStringToEnglish($("#inputStatusStaff").val());
            }

            // console.log($idStaff);
            // console.log($nameStaff);
            // console.log($day);
            // console.log($month);
            // console.log($year);
            // console.log($sexStaff);
            // console.log($rightStaff);
            // console.log($addressStaff);
            // console.log($phoneStaff);
            // console.log($usernameStaff);
            // console.log($statusStaff);
            // console.log("");

            $.ajax({
                url: '/CuaHangNoiThat/Admin/getAllStaff',
                success: function(data) {
                    var data = JSON.parse(data);
                    //console.log(data);
                    $xhtml = '<thead>' +
                        '<tr>' +
                        '<th scope="col">#</th>' +
                        '<th scope="col">Mã Nhân Viên</th>' +
                        '<th scope="col">Tên Nhân Viên</th>' +
                        '<th scope="col">Ngày Sinh</th>' +
                        '<th scope="col">Giới Tính</th>' +
                        '<th scope="col">Địa Chỉ</th>' +
                        '<th scope="col">SĐT</th>' +
                        '<th scope="col">Tên Đăng Nhập</th>' +
                        '<th scope="col">Trạng Thái</th>' +
                        '<th scope="col" style="width: 15rem;">Chức Năng</th>' +
                        '</tr>' +
                        '</thead><tbody>';
                    for ($i = 0; $i < data.length; $i++) {
                        $dayReceipt = parseInt(data[$i].NGAYSINH.substring(8));
                        $monthReceipt = parseInt(data[$i].NGAYSINH.substring(5, 7));
                        $yearReceipt = parseInt(data[$i].NGAYSINH.substring(0, 4));


                        if ($idStaff != '#' && !convertStringToEnglish(data[$i].MANV).includes($idStaff)) {
                            continue;
                        }
                        if ($nameStaff != '#' && !convertStringToEnglish(data[$i].TENNV).includes($nameStaff)) {
                            continue;
                        }
                        if ($day != '#' && parseInt($day) != parseInt($dayReceipt)) {
                            continue;
                        }
                        if ($month != '#' && parseInt($month) != parseInt($monthReceipt)) {
                            continue;
                        }
                        if ($year != '#' && parseInt($year) != parseInt($yearReceipt)) {
                            continue;
                        }
                        if ($sexStaff != '#' && !convertStringToEnglish(data[$i].GIOITINH).includes($sexStaff)) {
                            continue;
                        }
                        if ($addressStaff != '#' && !convertStringToEnglish(data[$i].DIACHI).includes($addressStaff)) {
                            continue;
                        }
                        if ($phoneStaff != '#' && !convertStringToEnglish(data[$i].SDT).includes($phoneStaff)) {
                            continue;
                        }
                        if ($statusStaff != '#' && parseInt($statusStaff) != parseInt(data[$i].TRANGTHAI)) {
                            continue;
                        }
                        if ($usernameStaff != '#' && !convertStringToEnglish(data[$i].TENDN).includes($usernameStaff)) {
                            continue;
                        }

                        $xhtml += '<tr>' +
                            '<th scope="row">' + ($i + 1) + '</th>' +
                            '<td>' + data[$i].MANV + '</td>' +
                            '<td>' + data[$i].TENNV + '</td>' +
                            '<td>' + (data[$i].NGAYSINH) + '</td>' +
                            '<td>' + data[$i].GIOITINH + '</td>' +
                            '<td>' + data[$i].DIACHI + '</td>' +
                            '<td>' + data[$i].SDT + '</td>' +
                            '<td>' + data[$i].TENDN + '</td>' +
                            '<td>' + (data[$i].TRANGTHAI == 1 ? 'Đang hoạt động' : 'Đã khóa') + '</td>' +
                            '<td>';
                        $rightStaff = data[$i].QUYEN;
                        if (data[$i].TRANGTHAI == 1 && data[$i].STAFF_LOGIN != data[$i].MANV && !isExistValueInString($rightStaff,'e_right')) {
                            $xhtml += '<button onclick="blockStaff(\'' + data[$i].MANV + '\');" class="btn btn-primary btnControl" type="submit" style="background-color: red;">Khóa Nhân Viên</button>' +
                                '<a href="/CuaHangNoiThat/Admin/SuaNhanVien/' + data[$i].MANV + '">' +
                                '<button class="btn btn-primary btnControl" type="submit" style="background-color: green;margin-top: 0.3rem;">Sửa Thông Tin</button></a>';


                            $xhtml += '<a href="/CuaHangNoiThat/Admin/PhanQuyen/' + data[$i].MANV + '"><button class="btn btn-primary btnControl" type="submit" style="background-color: #f09605;margin-top: 0.3rem;">Sửa Phân Quyền</button></a>';


                        }

                        $xhtml += '</td></tr>';
                    }


                    $xhtml += '</tbody></table>';
                    $('#tableContent').html($xhtml);
                }
            });
        }

        function exportExcel() {
            $.ajax({
                url: '/CuaHangNoiThat/Admin/exportStaffToExcel',
                success: function(data) {
                    var data = JSON.parse(data);
                    if (data.ERROR == 0) {
                        $xhtml = 'Xuất thông tin NCC thành công file được lưu tại (' + data.NAME + '). Bạn có muốn mở file không ?' +
                            '<div>' +
                            '<button class="btn btn-primary btnControl" style="background-color: white;color: #007bff;float: right;" onclick="window.location = \'' + data.NAME + '\';$(\'#openExportReceipt\').hide();">Mở File</button>' +
                            '<button class="btn btn-primary btnControl" style="background-color: blue;color: white;float: right;" onclick="$(\'#openExportSupplier\').hide();">Đóng</button>' +
                            '</div>';
                        $('#openExportSupplier').html($xhtml);
                        $('#openExportSupplier').show();
                    } else {
                        alert('Lỗi khi ghi file : ' + data.ERROR);
                    }
                }
            });
        }
    </script>
</body>

</html>