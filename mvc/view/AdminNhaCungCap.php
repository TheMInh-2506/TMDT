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
            width: 14rem;
        }
    </style>
</head>

<body>
    <h1 style="margin-top: 5rem;margin-left: 10%;"><?php echo $title; ?></h1>
    <div style="width: 80%;margin-left: 10%;">
        <a href="/CuaHangNoiThat/Admin/ThemNhaCungCap"><button type="button" class="btn btn-primary btn-lg optionButton">Thêm Nhà Cung Cấp</button></a>
        <button onclick="exportExcel();" type="button" class="btn btn-primary btn-lg optionButton">Xuất Excel</button>
        <div class="form-group" style="width: 50%;float: right;margin-left: 2rem;">
            <input type="text" class="form-control" id="searchSupplier" placeholder="Nhập vào thông tin nhà cung cấp..." style="float: right;width: 20rem;">
        </div>
    </div>
    <!-- Table -->
    <table id="tableContent" class="table" style="width: 80%;margin-left: 10%;"></table>

     <!-- Thong bao xuat excel thanh cong -->
     <div id="openExportSupplier" style="width: 60%;background-color: #007bff; position: absolute; top: 25%; height: auto; padding: 2rem; border-radius: 1rem; color: white;left:20%;font-size: 1.3rem;border: 2px solid black;"></div>
    <script>
        $("#openExportSupplier").hide();
        loadTable();

        function loadTable() {
            $.ajax({
                url: '/CuaHangNoiThat/Admin/getAllSupplier',
                success: function(data) {
                    var data = JSON.parse(data);
                    $xhtml = '<thead>' +
                        '<tr>' +
                        '<th scope="col">#</th>' +
                        '<th scope="col">Mã Nhà Cung Cấp</th>' +
                        '<th scope="col">Tên Nhà Cung Cấp</th>' +
                        '<th scope="col">Địa Chỉ</th>' +
                        '<th scope="col">SĐT</th>' +
                        '<th scope="col">Trạng thái</th>' +
                        '<th scope="col" style="width: 15rem;">Chức Năng</th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>';
                    for ($i = 0; $i < data.length; $i++) {
                        $xhtml += '<tr>' +
                            '<th scope="row">' + ($i + 1) + '</th>' +
                            '<td>' + data[$i].MANCC + '</td>' +
                            '<td>' + data[$i].TENNCC + '</td>' +
                            '<td>' + data[$i].DIACHI + '</td>' +
                            '<td>' + data[$i].SDT + '</td>' +
                            '<td>' + (data[$i].TRANGTHAI == 1 ? 'Còn hoạt động' : 'Không hoạt động') + '</td>' +
                            '<td>' +
                            '<button onclick="block_unblock(\''+data[$i].MANCC+'\');" class="btn btn-primary btnControl" type="submit" style="background-color: red;">Mở/Khóa Nhà Cung Cấp</button>' +
                            '<a href="/CuaHangNoiThat/Admin/SuaNhaCungCap/'+data[$i].MANCC+'">' +
                            '<button class="btn btn-primary btnControl" type="submit" style="background-color: green;margin-top: 0.3rem;">Sửa Nhà Cung Cấp</button>' +
                            '</a>' +
                            '</td>' +
                            '</tr>';
                    }
                    $xhtml += '</tbody>';
                    $("#tableContent").html($xhtml);
                }
            })
        }

        //Bắt sự kiện tìm kiếm NCC
        $(document).ready(function() {
            $("#searchSupplier").keyup(function() {
                var keySearch = convertStringToEnglish($("#searchSupplier").val());
                $.ajax({
                    url: '/CuaHangNoiThat/Admin/getAllSupplier',
                    success: function(data) {
                        var data = JSON.parse(data);
                        $xhtml = '<thead>' +
                            '<tr>' +
                            '<th scope="col">#</th>' +
                            '<th scope="col">Mã Nhà Cung Cấp</th>' +
                            '<th scope="col">Tên Nhà Cung Cấp</th>' +
                            '<th scope="col">Địa Chỉ</th>' +
                            '<th scope="col">SĐT</th>' +
                            '<th scope="col">Trạng thái</th>' +
                            '<th scope="col" style="width: 15rem;">Chức Năng</th>' +
                            '</tr>' +
                            '</thead>' +
                            '<tbody>';
                        for ($i = 0; $i < data.length; $i++) {
                            $check = false;

                            if (convertStringToEnglish(data[$i].MANCC).includes(keySearch)) {
                                $check = true;
                            }
                            if (convertStringToEnglish(data[$i].TENNCC).includes(keySearch)) {
                                $check = true;
                            }
                            if (convertStringToEnglish(data[$i].DIACHI).includes(keySearch)) {
                                $check = true;
                            }
                            if (convertStringToEnglish(data[$i].SDT).includes(keySearch)) {
                                $check = true;
                            }
                            if (convertStringToEnglish((data[$i].TRANGTHAI == 1 ? "Còn hoạt động":"Không hoạt động")).includes(keySearch)) {
                                $check = true;
                            }

                            if(!$check){
                                continue;
                            }

                            $xhtml += '<tr>' +
                                '<th scope="row">' + ($i + 1) + '</th>' +
                                '<td>' + data[$i].MANCC + '</td>' +
                                '<td>' + data[$i].TENNCC + '</td>' +
                                '<td>' + data[$i].DIACHI + '</td>' +
                                '<td>' + data[$i].SDT + '</td>' +
                                '<td>' + (data[$i].TRANGTHAI == 1 ? 'Còn hoạt động' : 'Không hoạt động') + '</td>' +
                                '<td>' +
                                '<button onclick="block_unblock(\''+data[$i].MANCC+'\');" class="btn btn-primary btnControl" type="submit" style="background-color: red;">Mở/Khóa Nhà Cung Cấp</button>' +
                                '<a href="/CuaHangNoiThat/Admin/SuaNhaCungCap/'+data[$i].MANCC+'">' +
                                '<button class="btn btn-primary btnControl" type="submit" style="background-color: green;margin-top: 0.3rem;">Sửa Nhà Cung Cấp</button>' +
                                '</a>' +
                                '</td>' +
                                '</tr>';
                        }
                        $xhtml += '</tbody>';
                        $("#tableContent").html($xhtml);
                    }
                })
            });
        });

        function block_unblock(idSupplier){
            $.ajax({
                url: '/CuaHangNoiThat/Admin/block_unblockSupplier/' + idSupplier,
                success: function(data){
                    
                    if(data == 0){
                        alert("Cập nhật trạng thái thành công");
                        loadTable();
                    }
                    else{
                        alert("Không thể cập nhật");
                    }
                }
            })
        }

        function exportExcel(){
            $.ajax({
                url: '/CuaHangNoiThat/Admin/exportSupplierToExcel',
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