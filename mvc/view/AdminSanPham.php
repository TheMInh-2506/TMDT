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
    <?php 
        if (isset($_SESSION['staff'])) {
            echo '<div style="width: 80%;margin-left: 10%;">
            <a href="/CuaHangNoiThat/Admin/GoiYThemSP"><button type="button" class="btn btn-primary btn-lg optionButton">Gợi ý thêm sản phẩm</button></a>
            <button onclick="exportExcel();" type="button" class="btn btn-primary btn-lg optionButton">Xuất Excel</button>
            <div class="form-group" style="width: 50%;float: right;margin-left: 2rem;">
                <input type="text" class="form-control" id="searchValue" placeholder="Nhập thông tin sản phẩm..." style="float: right;width: 20rem;">
            </div>
        </div>  ';
        }
    ?>
    

    <div style="width: 80%;margin-left: 10%;margin-top: 1rem;">
        <div class="form-row">
            <div class="form-group col-md-2">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="checkProductId">
                    <label class="form-check-label" for="autoSizingCheck">Mã sản phẩm</label>
                </div>
                <input type="text" class="form-control" id="inputProductId">
            </div>
            <div class="form-group col-md-3">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="checkProductName">
                    <label class="form-check-label" for="autoSizingCheck">Tên sản phẩm</label>
                </div>
                <input type="text" class="form-control" id="inputProductName">
            </div>
            <div class="form-group col-md-3">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="checkProductTypeId">
                    <label class="form-check-label" for="autoSizingCheck">Tìm theo loại sản phẩm</label>
                </div>
                <select class="form-control" id="inputProductTypeId">
                    <?php
                    foreach ($data['type'] as $value) {
                        echo '<option value="' . $value['MALOAI'] . '">' . $value['TENLOAI'] . ' - ' . $value['MALOAI'] . '</option>';
                    }
                    ?>

                </select>
            </div>
            <div class="form-group col-md-3">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="checkStatusProduct">
                    <label class="form-check-label" for="autoSizingCheck">Tìm theo trạng thái sản phẩm</label>
                </div>
                <select class="form-control" id="inputStatusProduct">
                    <option value="1">Còn Trong Cửa Hàng</option>
                    <option value="0">Đã Xóa</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-2">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="checkProductPrice">
                    <label class="form-check-label" for="autoSizingCheck">Tìm theo giá sản phẩm</label>
                </div>
                <input type="number" class="form-control" id="inputMinProductPrice" placeholder="Giá thất nhất">
            </div>
            <div class="form-group col-md-2">
                <div class="form-check mb-2">
                    <label class="form-check-label" for="autoSizingCheck" style="color: white;">Giá cao nhất</label>
                </div>
                <input type="number" class="form-control" id="inputMaxProductPrice" placeholder="Giá cao nhất">
            </div>
            <div class="form-group col-md-2">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="checkStatusDecreaseProduct">
                    <label class="form-check-label" for="autoSizingCheck">Trạng thái giảm</label>
                </div>
                <select class="form-control" id="inputStatusDecreaseProduct">
                    <option value="0">Không Giảm Giá</option>
                    <option value="1">Được Giảm Giá</option>
                </select>
            </div>
            <button onclick="searchMultiValue();" type="submit" class="btn btn-primary">Tìm kiếm </button>
        </div>
        <div>
            <button type="button" class="btn btn-primary" onclick="sortData('GIA','UP');">Giá tăng dần</button>
            <button type="button" class="btn btn-primary" onclick="sortData('GIA','DOWN');">Giá giảm dần</button>
            <button type="button" class="btn btn-primary" onclick="sortData('SOLUONG','UP');">Số lượng tăng dần</button>
            <button type="button" class="btn btn-primary" onclick="sortData('SOLUONG','DOWN');">Số lượng giảm dần</button>
        </div>
    </div>

    <table id="tableContent" class="table" style="width: 80%;margin-left: 10%;"></table>

     <!-- Thong bao xuat excel thanh cong -->
     <div id="openExportBill" style="width: 60%;background-color: #007bff; position: absolute; top: 25%; height: auto; padding: 2rem; border-radius: 1rem; color: white;left:20%;font-size: 1.3rem;border: 2px solid black;"></div>


    <script>
        loadTable();

        function sortData($param,$type){
            $.ajax({
                url: '/CuaHangNoiThat/Admin/getAllProduct',
                success: function(data) {
                    var data = JSON.parse(data);
                    $xhtml = '<thead>' +
                        '<tr>' +
                        '<th scope="col">#</th>' +
                        '<th scope="col">Mã Sản Phẩm</th>' +
                        '<th scope="col" style="width: 20rem;">Tên Sản Phẩm</th>' +
                        '<th scope="col">Loại</th>' +
                        '<th scope="col">Giá</th>' +
                        '<th scope="col">Số Lượng</th>' +
                        '<th scope="col" style="width: 10rem;">Hình Ảnh</th>' +
                        '<th scope="col">Trạng Thái</th>' +
                        '<th scope="col">% Giảm</th>' +
                        '<th scope="col" style="width: 15rem;">Chức Năng</th>' +
                        '</tr>' +
                        '</thead><tbody>';


                    // sort data
                    for(var i = 0;i < data.length-1;i++){
                        for(var j = i+1;j < data.length;j++){
                            if($type == 'UP'){
                                if(parseInt(data[i][$param]) > parseInt(data[j][$param])){
                                    var tmp = data[i];
                                    data[i] = data[j];
                                    data[j] = tmp;
                                }
                            }
                            else{
                                if(parseInt(data[i][$param]) < parseInt(data[j][$param])){
                                    var tmp = data[i];
                                    data[i] = data[j];
                                    data[j] = tmp;
                                }
                            }
                        }
                    }

                    $count = 1;
                    for (var key in data) {
                        $obj = data[key];
                        $xhtml += '<tr>' +
                            '<th scope="row">' + ($count++) + '</th>' +
                            '<td>' + $obj.MASP + '</td>' +
                            '<td>' + $obj.TENSP + '</td>' +
                            '<td>' + $obj.MALOAI + '</td>' +
                            '<td>' + formatter.format($obj.GIA) + '</td>' +
                            '<td>' + $obj.SOLUONG + '</td>' +
                            '<td><img src="../public/image/HINHANH/' + $obj.HINHANH + '" alt="empty_Image" style="width: 10rem;height:8rem;"></td>' +
                            '<td>' + ($obj.TRANGTHAI == 1 ? 'Còn  CửaTrong Hàng' : 'Đã Xóa') + '</td>' +
                            '<td>' + $obj.PHANTRAMGIAM + '%</td>';
                        if ($obj.TRANGTHAI == 1) {
                            $xhtml += '<td><a href="/CuaHangNoiThat/Admin/SuaSanPham/'+$obj.MASP+'"><button class="btn btn-primary btnControl" type="submit" style="background-color: green;">Sửa sản phẩm</button></a><button onclick="deleteElement(\''+$obj.MASP+'\');" class="btn btn-primary btnControl" type="submit" style="background-color: red;margin-top: 1rem;">Xóa Sản phẩm</button></td>';
                        }
                        $xhtml += '</tr>';
                    }

                    $xhtml += '</tbody>';
                    $("#tableContent").html($xhtml);
                }
            });
        }

        function loadTable() {
            $.ajax({
                url: '/CuaHangNoiThat/Admin/getAllProduct',
                success: function(data) {
                    var data = JSON.parse(data);
                    $xhtml = '<thead>' +
                        '<tr>' +
                        '<th scope="col">#</th>' +
                        '<th scope="col">Mã Sản Phẩm</th>' +
                        '<th scope="col" style="width: 20rem;">Tên Sản Phẩm</th>' +
                        '<th scope="col">Loại</th>' +
                        '<th scope="col">Giá</th>' +
                        '<th scope="col">Số Lượng</th>' +
                        '<th scope="col" style="width: 10rem;">Hình Ảnh</th>' +
                        '<th scope="col">Trạng Thái</th>' +
                        '<th scope="col">% Giảm</th>' +
                        '<th scope="col" style="width: 15rem;">Chức Năng</th>' +
                        '</tr>' +
                        '</thead><tbody>';

                    $count = 1;
                    for (var key in data) {
                        $obj = data[key];
                        $xhtml += '<tr>' +
                            '<th scope="row">' + ($count++) + '</th>' +
                            '<td>' + $obj.MASP + '</td>' +
                            '<td>' + $obj.TENSP + '</td>' +
                            '<td>' + $obj.MALOAI + '</td>' +
                            '<td>' + formatter.format($obj.GIA) + '</td>' +
                            '<td>' + $obj.SOLUONG + '</td>' +
                            '<td><img src="../public/image/HINHANH/' + $obj.HINHANH + '" alt="empty_Image" style="width: 10rem;height:8rem;"></td>' +
                            '<td>' + ($obj.TRANGTHAI == 1 ? 'Còn  CửaTrong Hàng' : 'Đã Xóa') + '</td>' +
                            '<td>' + $obj.PHANTRAMGIAM + '%</td>';
                        if ($obj.TRANGTHAI == 1) {
                            $xhtml += '<td><a href="/CuaHangNoiThat/Admin/SuaSanPham/'+$obj.MASP+'"><button class="btn btn-primary btnControl" type="submit" style="background-color: green;">Sửa sản phẩm</button></a><button onclick="deleteElement(\''+$obj.MASP+'\');" class="btn btn-primary btnControl" type="submit" style="background-color: red;margin-top: 1rem;">Xóa Sản phẩm</button></td>';
                        }
                        $xhtml += '</tr>';
                    }

                    $xhtml += '</tbody>';
                    $("#tableContent").html($xhtml);
                }
            });
        }

        //bat su kien nhap vao tim kiem san pham
        $(document).ready(function() {
            $("#searchValue").keyup(function() {
                $valueSearch = convertStringToEnglish($("#searchValue").val());
                $.ajax({
                    url: '/CuaHangNoiThat/Admin/getAllProduct',
                    success: function(data) {
                        var data = JSON.parse(data);
                        $xhtml = '<thead>' +
                            '<tr>' +
                            '<th scope="col">#</th>' +
                            '<th scope="col">Mã Sản Phẩm</th>' +
                            '<th scope="col" style="width: 20rem;">Tên Sản Phẩm</th>' +
                            '<th scope="col">Loại</th>' +
                            '<th scope="col">Giá</th>' +
                            '<th scope="col">Số Lượng</th>' +
                            '<th scope="col" style="width: 10rem;">Hình Ảnh</th>' +
                            '<th scope="col">Trạng Thái</th>' +
                            '<th scope="col">% Giảm</th>' +
                            '<th scope="col" style="width: 15rem;">Chức Năng</th>' +
                            '</tr>' +
                            '</thead><tbody>';

                        $count = 1;
                        for (var key in data) {
                            $obj = data[key];
                            $isSearchElement = false;

                            if (convertStringToEnglish($obj.MASP).includes($valueSearch)) {
                                $isSearchElement = true;
                            }
                            if (convertStringToEnglish($obj.TENSP).includes($valueSearch)) {
                                $isSearchElement = true;
                            }
                            if (convertStringToEnglish($obj.MALOAI).includes($valueSearch)) {
                                $isSearchElement = true;
                            }
                            if (convertStringToEnglish($obj.GIA).includes($valueSearch)) {
                                $isSearchElement = true;
                            }
                            if (convertStringToEnglish($obj.SOLUONG).includes($valueSearch)) {
                                $isSearchElement = true;
                            }
                            if (convertStringToEnglish(($obj.TRANGTHAI == 1 ? "Còn Hoạt Động" : "Đã Xóa")).includes($valueSearch)) {
                                $isSearchElement = true;
                            }
                            if (convertStringToEnglish($obj.PHANTRAMGIAM).includes($valueSearch)) {
                                $isSearchElement = true;
                            }

                            if (!$isSearchElement) {
                                continue;
                            }

                            $xhtml += '<tr>' +
                                '<th scope="row">' + ($count++) + '</th>' +
                                '<td>' + $obj.MASP + '</td>' +
                                '<td>' + $obj.TENSP + '</td>' +
                                '<td>' + $obj.MALOAI + '</td>' +
                                '<td>' + formatter.format($obj.GIA) + '</td>' +
                                '<td>' + $obj.SOLUONG + '</td>' +
                                '<td><img src="../public/image/HINHANH/' + $obj.HINHANH + '" alt="empty_Image" style="width: 10rem;height:8rem;"></td>' +
                                '<td>' + ($obj.TRANGTHAI == 1 ? 'Còn Trong Cửa Hàng' : 'Đã Xóa') + '</td>' +
                                '<td>' + $obj.PHANTRAMGIAM + '%</td>';
                            if ($obj.TRANGTHAI == 1) {
                                $xhtml += '<td><a href="/CuaHangNoiThat/Admin/SuaSanPham/'+$obj.MASP+'"><button class="btn btn-primary btnControl" type="submit" style="background-color: green;">Sửa sản phẩm</button></a><button onclick="deleteElement(\''+$obj.MASP+'\');" class="btn btn-primary btnControl" type="submit" style="background-color: red;margin-top: 1rem;">Xóa Sản phẩm</button></td>';
                            }
                            $xhtml += '</tr>';
                        }

                        $xhtml += '</tbody>';
                        $("#tableContent").html($xhtml);
                    }
                });
            });
        });

        function searchMultiValue() {
            //Default value
            $idProduct = '!';
            $nameProduct = '!';
            $idTypeProduct = '!';
            $statusProduct = '!';
            $minPrice = '!';
            $maxPrice = '!';
            $statusDecrease = '!';

            //Get value from user choose
            if ($("#checkProductId").is(":checked")) {
                $idProduct = convertStringToEnglish($("#inputProductId").val());
            }
            if ($("#checkProductName").is(":checked")) {
                $nameProduct = convertStringToEnglish($("#inputProductName").val());
            }
            if ($("#checkProductTypeId").is(":checked")) {
                $idTypeProduct = convertStringToEnglish($("#inputProductTypeId").val());
            }
            if ($("#checkStatusProduct").is(":checked")) {
                $statusProduct = convertStringToEnglish($("#inputStatusProduct").val());
            }
            if ($("#checkProductPrice").is(":checked")) {
                $minPrice = ($("#inputMinProductPrice").val());
                $maxPrice = ($("#inputMaxProductPrice").val());
            }
            if ($("#checkStatusDecreaseProduct").is(":checked")) {
                $statusDecrease = convertStringToEnglish($("#inputStatusDecreaseProduct").val());
            }

            $.ajax({
                url: '/CuaHangNoiThat/Admin/getAllProduct',
                success: function(data) {
                    var data = JSON.parse(data);

                    $xhtml = '<thead>' +
                        '<tr>' +
                        '<th scope="col">#</th>' +
                        '<th scope="col">Mã Sản Phẩm</th>' +
                        '<th scope="col" style="width: 20rem;">Tên Sản Phẩm</th>' +
                        '<th scope="col">Loại</th>' +
                        '<th scope="col">Giá</th>' +
                        '<th scope="col">Số Lượng</th>' +
                        '<th scope="col" style="width: 10rem;">Hình Ảnh</th>' +
                        '<th scope="col">Trạng Thái</th>' +
                        '<th scope="col">% Giảm</th>' +
                        '<th scope="col" style="width: 15rem;">Chức Năng</th>' +
                        '</tr>' +
                        '</thead><tbody>';

                    $count = 1;
                    for (var key in data) {
                        $obj = data[key];
                        if ($idProduct != '!' && !convertStringToEnglish($obj.MASP).includes($idProduct)) {
                            continue;
                        }
                        if ($nameProduct != '!' && !convertStringToEnglish($obj.TENSP).includes($nameProduct)) {
                            continue;
                        }
                        if ($idTypeProduct != '!' && !convertStringToEnglish($obj.MALOAI).includes($idTypeProduct)) {
                            continue;
                        }
                        if ($statusProduct != '!' && $obj.TRANGTHAI != $statusProduct) {
                            continue;
                        }
                        if ($minPrice != '!' && $minPrice != '' && parseInt($minPrice) > parseInt($obj.GIA)) {
                            continue;
                        }
                        if ($maxPrice != '!' && $maxPrice != '' && parseInt($maxPrice) < parseInt($obj.GIA)) {
                            continue;
                        }
                        if ($statusDecrease != '!' &&
                            ($statusDecrease == 0 && $obj.PHANTRAMGIAM != 0 ||
                                $statusDecrease != 0 && $obj.PHANTRAMGIAM == 0)) {
                            continue;
                        }
                        $xhtml += '<tr>' +
                            '<th scope="row">' + ($count++) + '</th>' +
                            '<td>' + $obj.MASP + '</td>' +
                            '<td>' + $obj.TENSP + '</td>' +
                            '<td>' + $obj.MALOAI + '</td>' +
                            '<td>' + formatter.format($obj.GIA) + '</td>' +
                            '<td>' + $obj.SOLUONG + '</td>' +
                            '<td><img src="../public/image/HINHANH/' + $obj.HINHANH + '" alt="empty_Image" style="width: 10rem;height:8rem;"></td>' +
                            '<td>' + ($obj.TRANGTHAI == 1 ? 'Còn Trong Cửa Hàng' : 'Đã Xóa') + '</td>' +
                            '<td>' + $obj.PHANTRAMGIAM + '%</td>';
                        if ($obj.TRANGTHAI == 1) {
                            $xhtml += '<td><a href="/CuaHangNoiThat/Admin/SuaSanPham/'+$obj.MASP+'"><button class="btn btn-primary btnControl" type="submit" style="background-color: green;">Sửa sản phẩm</button></a><button onclick="deleteElement(\''+$obj.MASP+'\');" class="btn btn-primary btnControl" type="submit" style="background-color: red;margin-top: 1rem;">Xóa Sản phẩm</button></td>';
                        }
                        $xhtml += '</tr>';
                    }

                    $xhtml += '</tbody>';
                    $("#tableContent").html($xhtml);
                }
            });
        }

        function deleteElement($idProduct){
            

            if(!confirm("Bạn có chắc chắn muốn xóa sản phẩm này không ? Sản phẩm sẽ bị vô hiệu vĩnh viễn khi XÓA")){
                return;
            }

            $.ajax({
                url:'/CuaHangNoiThat/Admin/disableProductStatus',
                data :{id:$idProduct},
                method:'post',
                success : function(result){
                    console.log(result);
                    if(result == 0){
                        alert("Xóa Sản Phẩm thành công");
                        loadTable();
                    }
                    else{
                        alert("Lỗi khi xóa !!!");
                    }
                }
            });
        }

        $('#openExportBill').hide();
        function exportExcel() {
            $.ajax({
                url: '/CuaHangNoiThat/Admin/exportProductToExcel',
                success: function(data) {
                    var data = JSON.parse(data);
                    console.log(data);
                    if (data.ERROR == 0) {
                        $xhtml = 'Xuất hóa đơn thành công file được lưu tại (' + data.NAME + '). Bạn có muốn mở file không ?' +
                            '<div>' +
                            '<button class="btn btn-primary btnControl" style="background-color: white;color: #007bff;float: right;" onclick="openfile(\'' + data.NAME + '\');$(\'#openExportBill\').hide();">Mở File</button>' +
                            '<button class="btn btn-primary btnControl" style="background-color: blue;color: white;float: right;" onclick="$(\'#openExportBill\').hide();">Đóng</button>' +
                            '</div>';
                        $('#openExportBill').html($xhtml);
                        $('#openExportBill').show();
                    } else {
                        alert('Lỗi khi ghi file : ' + data.ERROR);
                    }
                }
            });
        }
        //open file
        function openfile(file) {
            window.location = file;
        }
    </script>

</body>

</html>