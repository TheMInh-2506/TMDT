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
            width: 12rem;
        }
    </style>
</head>

<body>
    <h1 style="margin-top: 5rem;margin-left: 10%;"><?php echo $title; ?></h1>
    <div style="width: 80%;margin-left: 10%;">
        <button onclick="exportExcel();" type="button" class="btn btn-primary btn-lg optionButton">Xuất Excel</button>
        <div class="form-group" style="width: 50%;float: right;margin-left: 2rem;">
            <input type="text" class="form-control" id="searchValue" placeholder="Nhập vào thông tin khách hàng..." style="float: right;width: 20rem;">
        </div>
    </div>

    <div style="width: 80%;margin-left: 10%;margin-top: 1rem;">
        <div class="form-row">
            <div class="form-group col-md-2">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="checkIdCustomer">
                    <label class="form-check-label" for="autoSizingCheck">Tìm theo mã KH</label>
                </div>
                <input type="text" class="form-control" id="inputIdCustomer">
            </div>
            <div class="form-group col-md-2">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="checkNameCustomer">
                    <label class="form-check-label" for="autoSizingCheck">Tìm theo tên khách hàng</label>
                </div>
                <input type="text" class="form-control" id="inputNameCustomer">
            </div>
            <div class="form-group col-md-1">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="checkSexCustomer">
                    <label class="form-check-label" for="autoSizingCheck">Giới Tính</label>
                </div>
                <select class="form-control" id="inputSexCustomer">
                    <option value="Nam">Nam</option>
                    <option value="Nữ">Nữ</option>
                </select>
            </div>
            <div class="form-group col-md-2">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="checkUsername">
                    <label class="form-check-label" for="autoSizingCheck">Tìm theo Username</label>
                </div>
                <input type="text" class="form-control" id="inputUsername" placeholder="Nhập vào Username">
            </div>
            <div class="form-group col-md-2">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="checkAddressCustomer">
                    <label class="form-check-label" for="autoSizingCheck">Tìm theo địa chỉ</label>
                </div>
                <input type="text" class="form-control" id="inputAddressCustomer" placeholder="Nhập vào địa chỉ">
            </div>
            <div class="form-group col-md-2">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="checkPhoneCustomer">
                    <label class="form-check-label" for="autoSizingCheck">Tìm theo SĐT</label>
                </div>
                <input type="text" class="form-control" id="inputPhoneCustomer" placeholder="Nhập vào SĐT">
            </div>
            <div class="form-group col-md-2">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="checkStatusCustomer">
                    <label class="form-check-label" for="autoSizingCheck">Trạng Thái</label>
                </div>
                <select class="form-control" id="inputStatusCustomer">
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

        function loadTable() {
            $.ajax({
                url: '/CuaHangNoiThat/Admin/getAllCustomer',
                success: function(data) {
                    var data = JSON.parse(data);


                    $xhtml = '<thead>' +
                        '<tr>' +
                        '<th scope="col">#</th>' +
                        '<th scope="col">Mã Khách Hàng</th>' +
                        '<th scope="col">Tên Khách Hàng</th>' +
                        '<th scope="col">Ngày Sinh</th>' +
                        '<th scope="col">Giới Tính</th>' +
                        '<th scope="col">Tên Đăng Nhập</th>' +
                        '<th scope="col">Địa Chỉ</th>' +
                        '<th scope="col">SĐT</th>' +
                        '<th scope="col">Trạng Thái</th>' +
                        '<th scope="col" style="width: 15rem;">Chức Năng</th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>';
                    for ($i = 0; $i < data.length; $i++) {
                        $xhtml += '<tr>' +
                            '<th scope="row">' + ($i + 1) + '</th>' +
                            '<td>' + data[$i].MAKH + '</td>' +
                            '<td>' + data[$i].TENKH + '</td>' +
                            '<td>' + data[$i].NGAYSINH + '</td>' +
                            '<td>' + data[$i].GIOITINH + '</td>' +
                            '<td>' + data[$i].TENDN + '</td>' +
                            '<td>' + data[$i].DIACHI + '</td>' +
                            '<td>' + data[$i].SDT + '</td>' +
                            '<td>' + (data[$i].TRANGTHAI == 1 ? 'Đang hoạt động' : 'Đã Khóa') + '</td>' +
                            '<td>' +
                            '<button onclick="block_unblock_Customer(\'' + data[$i].MAKH + '\');" class="btn btn-primary btnControl" type="submit" style="background-color: ' + (data[$i].TRANGTHAI == 1 ? 'red' : 'green') + ';">' + (data[$i].TRANGTHAI == 1 ? 'Khóa Tài Khoản' : 'Mở khóa tài khoản') + '</button>' +
                            '</td>' +
                            '</tr>';

                    }

                    $xhtml += '</tbody>';
                    $("#tableContent").html($xhtml);
                }
            });
        }

        function block_unblock_Customer(id) {
            $.ajax({
                url: '/CuaHangNoiThat/Admin/block_unblockCutomer/' + id,
                success: function(data) {
                    console.log(data);
                    if (data == 0) {
                        alert("Thay đổi trạng thái thành công");
                        loadTable();
                    } else {
                        alert("Không thể thay đổi trạng thái");
                    }
                }
            });
        }

        $(document).ready(function() {
            $("#searchValue").keyup(function() {
                $searchValue = convertStringToEnglish($("#searchValue").val());

                $.ajax({
                    url: '/CuaHangNoiThat/Admin/getAllCustomer',
                    success: function(data) {
                        var data = JSON.parse(data);
                        $xhtml = '<thead>' +
                        '<tr>' +
                        '<th scope="col">#</th>' +
                        '<th scope="col">Mã Khách Hàng</th>' +
                        '<th scope="col">Tên Khách Hàng</th>' +
                        '<th scope="col">Ngày Sinh</th>' +
                        '<th scope="col">Giới Tính</th>' +
                        '<th scope="col">Tên Đăng Nhập</th>' +
                        '<th scope="col">Địa Chỉ</th>' +
                        '<th scope="col">SĐT</th>' +
                        '<th scope="col">Trạng Thái</th>' +
                        '<th scope="col" style="width: 15rem;">Chức Năng</th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>';
                        for ($i = 0; $i < data.length; $i++) {
                            $check = false;
                            if (convertStringToEnglish(data[$i].MAKH).includes($searchValue)) {
                                $check = true;
                            }
                            if (convertStringToEnglish(data[$i].TENKH).includes($searchValue)) {
                                $check = true;
                            }
                            if (convertStringToEnglish(data[$i].TENDN).includes($searchValue)) {
                                $check = true;
                            }
                            if (convertStringToEnglish(data[$i].SDT).includes($searchValue)) {
                                $check = true;
                            }
                            if (convertStringToEnglish(data[$i].DIACHI).includes($searchValue)) {
                                $check = true;
                            }
                            if (convertStringToEnglish(data[$i].GIOITINH).includes($searchValue)) {
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
                            '<td>' + data[$i].MAKH + '</td>' +
                            '<td>' + data[$i].TENKH + '</td>' +
                            '<td>' + data[$i].NGAYSINH + '</td>' +
                            '<td>' + data[$i].GIOITINH + '</td>' +
                            '<td>' + data[$i].TENDN + '</td>' +
                            '<td>' + data[$i].DIACHI + '</td>' +
                            '<td>' + data[$i].SDT + '</td>' +
                            '<td>' + (data[$i].TRANGTHAI == 1 ? 'Đang hoạt động' : 'Đã Khóa') + '</td>' +
                            '<td>' +
                            '<button onclick="block_unblock_Customer(\'' + data[$i].MAKH + '\');" class="btn btn-primary btnControl" type="submit" style="background-color: ' + (data[$i].TRANGTHAI == 1 ? 'red' : 'green') + ';">' + (data[$i].TRANGTHAI == 1 ? 'Khóa Tài Khoản' : 'Mở khóa tài khoản') + '</button>' +
                            '</td>' +
                            '</tr>';
                        }
                        $xhtml += '</tbody>';
                        $("#tableContent").html($xhtml);
                    }
                });
            });
        });

        function searchValue() {

            $idCustomer = "#";
            $nameCustomer = "#";
            $sexCustomer = "#";
            $addressCustomer = "#";
            $phoneCustomer = "#";
            $usernameCustomer = "#";
            $statusCustomer = "#";


            if ($("#checkIdCustomer").is(":checked")) {
                $idCustomer = convertStringToEnglish($("#inputIdCustomer").val());
            }
            if ($("#checkNameCustomer").is(":checked")) {
                $nameCustomer = convertStringToEnglish($("#inputNameCustomer").val());
            }
            if ($("#checkSexCustomer").is(":checked")) {
                $sexCustomer = convertStringToEnglish($("#inputSexCustomer").val());
            }
            if ($("#checkUsername").is(":checked")) {
                $usernameCustomer = convertStringToEnglish($("#inputUsername").val());
            }
            if ($("#checkAddressCustomer").is(":checked")) {
                $addressCustomer = convertStringToEnglish($("#inputAddressCustomer").val());
            }
            if ($("#checkPhoneCustomer").is(":checked")) {
                $phoneCustomer = convertStringToEnglish($("#inputPhoneCustomer").val());
            }
            if ($("#checkStatusCustomer").is(":checked")) {
                $statusCustomer = convertStringToEnglish($("#inputStatusCustomer").val());
            }
            
            console.log($idCustomer );
            console.log($nameCustomer );
            console.log($sexCustomer );
            console.log($addressCustomer );
            console.log($phoneCustomer );
            console.log($usernameCustomer );
            console.log($statusCustomer );
            
            console.log("");

            $.ajax({
                url: '/CuaHangNoiThat/Admin/getAllCustomer',
                success: function(data) {
                    var data = JSON.parse(data);
                    //console.log(data);
                    
                    $xhtml = '<thead>' +
                        '<tr>' +
                        '<th scope="col">#</th>' +
                        '<th scope="col">Mã Khách Hàng</th>' +
                        '<th scope="col">Tên Khách Hàng</th>' +
                        '<th scope="col">Ngày Sinh</th>' +
                        '<th scope="col">Giới Tính</th>' +
                        '<th scope="col">Tên Đăng Nhập</th>' +
                        '<th scope="col">Địa Chỉ</th>' +
                        '<th scope="col">SĐT</th>' +
                        '<th scope="col">Trạng Thái</th>' +
                        '<th scope="col" style="width: 15rem;">Chức Năng</th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>';
                    for ($i = 0; $i < data.length; $i++) {

                        if ($idCustomer != '#' && !convertStringToEnglish(data[$i].MAKH).includes($idCustomer)) {
                            continue;
                        }
                        if ($nameCustomer != '#' && !convertStringToEnglish(data[$i].TENKH).includes($nameCustomer)) {
                            continue;
                        }
                        if ($sexCustomer != '#' && !convertStringToEnglish(data[$i].GIOITINH).includes($sexCustomer)) {
                            continue;
                        }
                        
                        if ($addressCustomer != '#' && !convertStringToEnglish(data[$i].DIACHI).includes($addressCustomer)) {
                            continue;
                        }
                        if ($phoneCustomer != '#' && !convertStringToEnglish(data[$i].SDT).includes($phoneCustomer)) {
                            continue;
                        }
                        
                        if ($usernameCustomer != '#' && !convertStringToEnglish(data[$i].TENDN).includes($usernameCustomer)) {
                            continue;
                        }
                        
                        if ($statusCustomer != '#' && parseInt($statusCustomer) != parseInt(data[$i].TRANGTHAI)) {
                            continue;
                        }
                        $xhtml += '<tr>' +
                            '<th scope="row">' + ($i + 1) + '</th>' +
                            '<td>' + data[$i].MAKH + '</td>' +
                            '<td>' + data[$i].TENKH + '</td>' +
                            '<td>' + data[$i].NGAYSINH + '</td>' +
                            '<td>' + data[$i].GIOITINH + '</td>' +
                            '<td>' + data[$i].TENDN + '</td>' +
                            '<td>' + data[$i].DIACHI + '</td>' +
                            '<td>' + data[$i].SDT + '</td>' +
                            '<td>' + (data[$i].TRANGTHAI == 1 ? 'Đang hoạt động' : 'Đã Khóa') + '</td>' +
                            '<td>' +
                            '<button onclick="block_unblock_Customer(\'' + data[$i].MAKH + '\');" class="btn btn-primary btnControl" type="submit" style="background-color: ' + (data[$i].TRANGTHAI == 1 ? 'red' : 'green') + ';">' + (data[$i].TRANGTHAI == 1 ? 'Khóa Tài Khoản' : 'Mở khóa tài khoản') + '</button>' +
                            '</td>' +
                            '</tr>';                  
                    }


                    $xhtml += '</tbody></table>';
                    $('#tableContent').html($xhtml);
                }
            });
        }

        function exportExcel(){
            $.ajax({
                url: '/CuaHangNoiThat/Admin/exportCustomerToExcel',
                success: function(data) {
                    var data = JSON.parse(data);
                    if (data.ERROR == 0) {
                        $xhtml = 'Xuất thông tin Khách Hàng thành công file được lưu tại (' + data.NAME + '). Bạn có muốn mở file không ?' +
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