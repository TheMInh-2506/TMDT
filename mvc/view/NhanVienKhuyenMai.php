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

    <div style="width: 80%;margin-left: 10%;margin-top: 1rem;">
        <div class="form-row">
            <div class="form-group col-md-2">
                <div class="form-check mb-2">
                    <label class="form-check-label" for="autoSizingCheck">Tìm theo mã KM</label>
                </div>
                <input type="text" class="form-control" id="searchValue">
            </div>


            <button onclick="searchValue();" type="submit" class="btn btn-primary">Tìm kiếm </button>
        </div>
    </div>


    <div style="width: 80%;margin-left: 10%;">
        <a href="/CuaHangNoiThat/NhanVien/ThemKhuyenMai"><button type="button" class="btn btn-primary btn-lg optionButton">Thêm khuyến mãi</button></a>
    </div>




    <table id="tableContent" class="table" style="width: 80%;margin-left: 10%;"></table>

    <script>
        loadTable();

        function loadTable() {
            $.ajax({
                url: '/CuaHangNoiThat/Admin/getAllSale',
                success: function(data) {
                    var data = JSON.parse(data);
                    $xhtml = '<thead>' +
                        '<tr>' +
                        '<th scope="col">#</th>' +
                        '<th scope="col">Mã Khuyến Mãi</th>' +
                        '<th scope="col">Ngày Bắt Đầu</th>' +
                        '<th scope="col">Ngày Kết Thúc</th>' +
                        '<th scope="col">Phần Trăm Giảm</th>' +
                        '<th scope="col">Trạng Thái</th>' +
                        '<th scope="col" style="width: 15rem;">Chức Năng</th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>';
                    for ($i = 0; $i < data.length; $i++) {
                        $xhtml += '<tr>' +
                            '<th scope="row">' + ($i + 1) + '</th>' +
                            '<td>' + data[$i].MAKM + '</td>' +
                            '<td>' + formatDateToddmmyyyy(data[$i].NGAYBD) + '</td>' +
                            '<td>' + formatDateToddmmyyyy(data[$i].NGAYKT) + '</td>' +
                            '<td>' + data[$i].PHANTRAMGIAM + '%</td>';
                        if (data[$i].TRANGTHAI == 1) {
                            var begin = Date.parse(data[$i].NGAYBD);
                            var end = Date.parse(data[$i].NGAYKT);
                            var today = new Date();
                            var dd = String(today.getDate()).padStart(2, '0');
                            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                            var yyyy = today.getFullYear();
                            today = Date.parse(yyyy + '-' + mm + '-' + dd);

                            if (today >= begin && today <= end) {
                                $xhtml += '<td>Mã còn hiệu lực</td>';
                                $xhtml += '<td>' +
                                    '<button class="btn btn-primary btnControl" type="submit" style="background-color: red;" onclick="deleteSale(\'' + data[$i].MAKM + '\');">Xóa khuyến mãi</button>' +
                                    '</td>' +
                                    '</tr>';
                            } else {
                                $xhtml += '<td>Mã không có hiệu lực</td><td></td>';
                            }


                        } else {
                            $xhtml += '<td>Mã đã bị xóa</td><td></td>';
                        }


                    }
                    $xhtml += '</tbody>';
                    $("#tableContent").html($xhtml);
                }
            });
        }

        function searchValue() {
            $searchValue = convertStringToEnglish($("#searchValue").val());
            if($searchValue.localeCompare('') == 0){
                loadTable();
                return;
            }

            $.ajax({
                url: '/CuaHangNoiThat/Admin/getAllSale',
                success: function(data) {
                    var data = JSON.parse(data);
                    $xhtml = '<thead>' +
                        '<tr>' +
                        '<th scope="col">#</th>' +
                        '<th scope="col">Mã Khuyến Mãi</th>' +
                        '<th scope="col">Ngày Bắt Đầu</th>' +
                        '<th scope="col">Ngày Kết Thúc</th>' +
                        '<th scope="col">Phần Trăm Giảm</th>' +
                        '<th scope="col">Trạng Thái</th>' +
                        '<th scope="col" style="width: 15rem;">Chức Năng</th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>';
                    for ($i = 0; $i < data.length; $i++) {
                        $check = false;
                        if (convertStringToEnglish(data[$i].MAKM).localeCompare($searchValue) == 0) {
                            $check = true;
                        }

                        if (!$check) {
                            continue;
                        }
                        $xhtml += '<tr>' +
                            '<th scope="row">' + ($i + 1) + '</th>' +
                            '<td>' + data[$i].MAKM + '</td>' +
                            '<td>' + formatDateToddmmyyyy(data[$i].NGAYBD) + '</td>' +
                            '<td>' + formatDateToddmmyyyy(data[$i].NGAYKT) + '</td>' +
                            '<td>' + data[$i].PHANTRAMGIAM + '%</td>';
                        if (data[$i].TRANGTHAI == 1) {
                            var begin = Date.parse(data[$i].NGAYBD);
                            var end = Date.parse(data[$i].NGAYKT);
                            var today = new Date();
                            var dd = String(today.getDate()).padStart(2, '0');
                            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                            var yyyy = today.getFullYear();
                            today = Date.parse(yyyy + '-' + mm + '-' + dd);

                            if (today >= begin && today <= end) {
                                $xhtml += '<td>Mã còn hiệu lực</td>';
                                $xhtml += '<td>' +
                                    '<button class="btn btn-primary btnControl" type="submit" style="background-color: red;" onclick="deleteSale(\'' + data[$i].MAKM + '\');">Xóa khuyến mãi</button>' +
                                    '</td>' +
                                    '</tr>';
                            } else {
                                $xhtml += '<td>Mã không có hiệu lực</td><td></td>';
                            }


                        } else {
                            $xhtml += '<td>Mã đã bị xóa</td><td></td>';
                        }
                    }
                    $xhtml += '</tbody>';
                    $("#tableContent").html($xhtml);
                }
            });
        }


        function deleteSale($id) {
            if (!checkRight('d_sale')) {
                return;
            }
            if (!confirm("Bạn có muốn xóa khuyến mãi này ?")) {
                return;
            }
            $.ajax({
                url: '/CuaHangNoiThat/Admin/disabledSale/' + $id,
                success: function(data) {
                    var data = JSON.parse(data);
                    alert(data.SMS);
                    loadTable();
                }
            })
        }
    </script>

</body>

</html>