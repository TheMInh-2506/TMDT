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
        <!-- <a href="/CuaHangNoiThat/Admin/ThemLoaiSanPham"><button type="button" class="btn btn-primary btn-lg optionButton">Thêm loại sản phẩm</button></a> -->
        <button onclick="exportExcel();" type="button" class="btn btn-primary btn-lg optionButton">Xuất Excel</button>
        <div class="form-group" style="width: 50%;float: right;margin-left: 2rem;">
            <input type="text" class="form-control" id="searchValue" placeholder="Nhập thông tin loại sản phẩm..." style="float: right;width: 20rem;">
        </div>
    </div>

    <table id="tableContent" class="table" style="width: 80%;margin-left: 10%;"></table>

    <div id="openExportTypeProduct" style="width: 60%;background-color: #007bff; position: absolute; top: 25%; height: auto; padding: 2rem; border-radius: 1rem; color: white;left:20%;font-size: 1.3rem;border: 2px solid black;"></div>
    <script>
        $("#openExportTypeProduct").hide();
        loadTable();

        function loadTable() {
            $.ajax({
                url: '/CuaHangNoiThat/Admin/getAllProductType',
                success: function(data) {
                    var data = JSON.parse(data);

                    $xhtml = '<thead>' +
                        '<tr>' +
                        '<th scope="col" style="width: 3rem;">#</th>' +
                        '<th scope="col" style="width: 10rem;">Mã Loại Sản Phẩm</th>' +
                        '<th scope="col" style="width: 25rem;">Tên Loại Sản Phẩm</th>' +
                        '<th scope="col">Mô Tả</th>' +
                        '<th scope="col" style="width: 15rem;">Chức Năng</th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>';
                    for ($i = 0; $i < data.length; $i++) {
                        $xhtml += '<tr>' +
                            '<th scope="row">' + ($i + 1) + '</th>' +
                            '<td>' + data[$i].MALOAI + '</td>' +
                            '<td>' + data[$i].TENLOAI + '</td>' +
                            '<td>' + data[$i].MOTA + '</td>' +
                            '<td>' +
                            '<a href="/CuaHangNoiThat/Admin/SuaLoaiSanPham/'+data[$i].MALOAI+'">' +
                            '<button class="btn btn-primary btnControl" type="submit" style="background-color: green;">Sửa loại sản phẩm</button>' +
                            '</a>' +
                            '</td>' +

                            '</tr>';
                    }
                    $xhtml += '</tbody>';
                    $("#tableContent").html($xhtml);
                }
            });
        }

        $(document).ready(function() {
            $("#searchValue").keyup(function() {
                $searchValue = convertStringToEnglish($("#searchValue").val());

                $.ajax({
                    url: '/CuaHangNoiThat/Admin/getAllProductType',
                    success: function(data) {
                        var data = JSON.parse(data);

                        $xhtml = '<thead>' +
                            '<tr>' +
                            '<th scope="col" style="width: 3rem;">#</th>' +
                            '<th scope="col" style="width: 10rem;">Mã Loại Sản Phẩm</th>' +
                            '<th scope="col" style="width: 25rem;">Tên Loại Sản Phẩm</th>' +
                            '<th scope="col">Mô Tả</th>' +
                            '<th scope="col" style="width: 15rem;">Chức Năng</th>' +
                            '</tr>' +
                            '</thead>' +
                            '<tbody>';

                        
                        for ($i = 0; $i < data.length; $i++) {
                            $check = false;
                            if (convertStringToEnglish(data[$i].MALOAI).includes($searchValue)) {
                                $check = true;
                            }
                            if (convertStringToEnglish(data[$i].TENLOAI).includes($searchValue)) {
                                $check = true;
                            }
                            if (convertStringToEnglish(data[$i].MOTA).includes($searchValue)) {
                                $check = true;
                            }

                            if(!$check){continue;}
                            $xhtml += '<tr>' +
                                '<th scope="row">' + ($i + 1) + '</th>' +
                                '<td>' + data[$i].MALOAI + '</td>' +
                                '<td>' + data[$i].TENLOAI + '</td>' +
                                '<td>' + data[$i].MOTA + '</td>' +
                                '<td>' +
                                '<a href="/CuaHangNoiThat/Admin/SuaLoaiSanPham/'+data[$i].MALOAI+'">' +
                                '<button class="btn btn-primary btnControl" type="submit" style="background-color: green;">Sửa loại sản phẩm</button>' +
                                '</a>' +
                                '</td>' +

                                '</tr>';
                        }
                        $xhtml += '</tbody>';
                        $("#tableContent").html($xhtml);
                    }
                });
            });
        });

        function exportExcel(){
            $.ajax({
                url: '/CuaHangNoiThat/Admin/exportTypeProductToExcel',
                success: function(data) {
                    var data = JSON.parse(data);
                    if (data.ERROR == 0) {
                        $xhtml = 'Xuất thông tin Loại sản phẩm thành công file được lưu tại (' + data.NAME + '). Bạn có muốn mở file không ?' +
                            '<div>' +
                            '<button class="btn btn-primary btnControl" style="background-color: white;color: #007bff;float: right;" onclick="window.location = \'' + data.NAME + '\';$(\'#openExportReceipt\').hide();">Mở File</button>' +
                            '<button class="btn btn-primary btnControl" style="background-color: blue;color: white;float: right;" onclick="$(\'#openExportTypeProduct\').hide();">Đóng</button>' +
                            '</div>';
                        $('#openExportTypeProduct').html($xhtml);
                        $('#openExportTypeProduct').show();
                    } else {
                        alert('Lỗi khi ghi file : ' + data.ERROR);
                    }
                }
            });
        }
    </script>
</body>

</html>