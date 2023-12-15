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

<body style="background-image: radial-gradient(#b3b3b3, #ffffff);">

    <div style="width: 25%;margin-left: 5%;font-size: 1.5rem;background-color: white;padding: 2rem;border-radius: 1rem;color:#0066cc;margin-top: 2rem;float: left;height: 32rem;">
        <h2 style="width: 100%;color: #0066cc;font-weight: 600;">Thêm Phiếu Nhập</h2>
        <div class="form-group">
            <label for="exampleInputEmail1">Tên Nhân Viên</label>
            <select class="form-control" disabled id="staffId">
                <?php
                $staff = $_SESSION['staff'];
                if (isset($staff['MANV'])) {
                    echo "<option value='$staff[MANV]'>$staff[TENNV]</option>";
                } else {
                    echo "<option value='NV00'>Nhân Viên Test</option>";
                }

                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Tên Nhà Cung Cấp</label>
            <select class="form-control" id="supplierId">
                <?php
                foreach ($data['NCC'] as $value) {
                    if ($value['TRANGTHAI']) {
                        echo "<option value='$value[MANCC]'>$value[TENNCC]</option>";
                    }
                }
                ?>
            </select>

        </div>

        <a href="/CuaHangNoiThat/NhanVien/PhieuNhap">
            <button type="submit" class="btn btn-primary" style="background-color: white;color: #0066cc;font-size: 1.5rem;margin-top: 2rem;">Trở về </button>
        </a>
        <button onclick="addReceiptToDB();" type="submit" class="btn btn-primary" style="background-color: #0066cc;color: white;font-size: 1.5rem;margin-top: 2rem;float: right;">Thêm Phiếu Nhập</button>

    </div>

    <div style="width: 64%;margin-left: 1rem;font-size: 1.5rem;background-color: white;padding: 2rem;border-radius: 1rem;color:#0066cc;margin-top: 2rem;float: left;height: 32rem;">
        <h2 style="width: 100%;color: #0066cc;font-weight: 600;text-align: center;">Thêm Chi Tiết Phiếu Nhập</h2>
        <div style="width: 40%;border: 1px solid black;padding-left: 1rem;">
            <label for="">Đọc Excel</label>
            <input type="file" name="readfile" class="form-control-file" id="readDetailFromFile" style="width: auto;margin-bottom: 1rem;" multiple>
        </div>
        <div class="form-row">
            <div class="form-group col-md-2">
                <div class="form-check mb-2">
                    <label class="form-check-label" for="autoSizingCheck">Mã Sản Phẩm</label>
                </div>
                <input type="text" class="form-control" id="inputProductId">
                <button style="font-size: 1rem;width: 100%;background-color: white;font-weight: bolder;" onclick="createAutoId();">Tạo mã tự động</button>
            </div>
            <div class="form-group col-md-4">
                <div class="form-check mb-2">
                    <label class="form-check-label" for="autoSizingCheck">Tên Sản Phẩm</label>
                </div>
                <input type="text" class="form-control" id="inputProductName">
            </div>
            <div class="form-group col-md-4">
                <div class="form-check mb-2">
                    <label class="form-check-label" for="autoSizingCheck">Loại Sản Phẩm</label>
                </div>
                <select class="form-control" id="inputProductType">
                    <?php
                    foreach ($data['TypeProduct'] as $value) {
                        echo "<option value='$value[MALOAI]'>$value[TENLOAI]</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-2">
                <div class="form-check mb-2">
                    <label class="form-check-label" for="autoSizingCheck">Giá</label>
                </div>
                <input type="text" class="form-control" id="inputProductPrice">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-2">
                <div class="form-check mb-2">
                    <label class="form-check-label" for="autoSizingCheck">Số lượng</label>
                </div>
                <input type="number" class="form-control" id="inputProductNumber">
            </div>
            <div class="form-group col-md-4" id="containerImage">
                <div class="form-check mb-2">
                    <label class="form-check-label" for="autoSizingCheck">Hình Ảnh</label>
                </div>
                <input type="file" name="image" class="form-control" id="inputProductImage" multiple>
            </div>
            <div class="form-group col-md-4" id="containerCurentImage">
                <div class="form-check mb-2">
                    <label class="form-check-label" for="autoSizingCheck">Hình Ảnh hiện tại</label>
                </div>
                <input type="text" value="" style="font-size: 1rem;width: 15rem;" readonly id="currentImage">
                <button onclick="changeCurrentImage();" class="btn btn-primary" style="width: 15rem;">Thay đổi hình ảnh</button>
            </div>
            <div style="width: 100%;" id="addControl">
                <button onclick="addItemToDetail();" type="submit" class="btn btn-primary" style="background-color: #0066cc;color: white;font-size: 1em;margin-top: 2rem;float: right;margin-left:1rem;">Thêm Chi Tiết</button>
                <button onclick="refreshInput();" type="submit" class="btn btn-primary" style="background-color: white;color: #0066cc;font-size: 1em;margin-top: 2rem;float: right;margin-left: 2rem;">Làm Lại</button>
            </div>
            <div style="width: 100%;" id="editControl">
                <button onclick="addItemToDetail();" type="submit" class="btn btn-primary" style="background-color: #0066cc;color: white;font-size: 1em;margin-top: 2rem;float: right;margin-left:1rem;">Thêm Chi Tiết</button>
                <button onclick="cancelEditItem();" type="submit" class="btn btn-primary" style="background-color: white;color: #0066cc;font-size: 1em;margin-top: 2rem;float: right;margin-left: 2rem;">Hủy Bỏ</button>
            </div>
        </div>
    </div>


    <table id="tableContent" class="table" style="width: 90%;margin-left: 5%;background-color: white;margin-top: 2odeoderem;float: left;"></table>

    <script>
        let detailReceipt = new Array();
        let tmpItem = new Array();
        loadTable();
        $('#editControl').hide();
        $("#containerCurentImage").hide();
        //Onchange mã SP
        $(document).ready(function() {
            $("#inputProductId").change(function() {
                $idProduct = $("#inputProductId").val();
                if ($idProduct.substring(0, 2) != 'SP') {
                    alert('Mã sản phẩm phải có dạng SPxxx. Với xxx là số nguyên');
                    $("#inputProductId").val("");
                    return;
                }

                //Kiem tra trong Chi tiet PN
                for ($i = 0; $i < detailReceipt.length; $i++) {
                    if (detailReceipt[$i].MASP == $idProduct) {
                        alert("Mã sản phẩm đã tồn tại trong chi tiết Phiếu Nhập");
                        refreshInput();
                        return;
                    }
                }
                //Kiem tra trong CSDL

                var productArray = <?php echo json_encode($data['Product']) ?>;
                var nextId = <?php echo json_encode($data['NEXT_ID']) ?>;
                for ($i = 0; $i < productArray.length; $i++) {
                    if (productArray[$i].MASP == $idProduct) {
                        if (confirm("Mã sản phẩm " + $idProduct + " đã tồn tại trong CSDL. Bạn có muốn tự động điền thông tin của sản phẩm này không ?")) {
                            //Lay thong tin tu CSDL
                            $("#inputProductName").val(productArray[$i]['TENSP']);
                            $("#inputProductType").val(productArray[$i]['MALOAI']);
                            $("#inputProductPrice").val(productArray[$i]['GIA']);
                            $("#currentImage").val(productArray[$i]['HINHANH']);
                            $("#containerImage").css("display", "none");
                            $("#containerCurentImage").show();
                            $("#containerImage").hide();
                            $("#containerCurentImage").hide();

                            //Vo hieu hoa cac muc da lay thong tin
                            $("#inputProductId").prop("readonly", true);
                            $("#inputProductName").prop("readonly", true);
                            $("#inputProductType").prop("disabled", true);
                            $("#inputProductPrice").prop("readonly", true);
                            $("#inputProductImage").prop("readonly", true);



                            //Lay du lieu tu csdl
                            $idProduct = productArray[$i]['MASP'];
                            $nameProduct = productArray[$i]['TENSP'];
                            $typeProduct = productArray[$i]['MALOAI'];
                            $priceProduct = productArray[$i]['GIA'];
                            $imageProduct = productArray[$i]['HINHANH'];
                            $("#inputProductNumber").focus();

                        } else {
                            alert("Hệ thống tự điền mã sản phẩm mới");
                            $("#inputProductId").val(nextId);
                            $("#inputProductId").focus();
                        }
                        return;
                    }
                }

            });
        });

        //Onchange ten SP
        $(document).ready(function() {
            $("#inputProductName").change(function() {
                $nameProduct = convertStringToEnglish($("#inputProductName").val());

                var productArray = <?php echo json_encode($data['Product']) ?>;
                for ($i = 0; $i < productArray.length; $i++) {
                    if (convertStringToEnglish(productArray[$i].TENSP).localeCompare($nameProduct) == 0) {
                        console.log(convertStringToEnglish(productArray[$i].TENSP));
                        console.log($nameProduct);
                        alert("Tên Sản Phẩm đã tồn tại. Vui lòng chọn Tên Sản phẩm khác");
                        $("#inputProductName").val("");
                        $("#inputProductName").focus();
                    }
                }

            });
        });

        function addItemToDetail() {
            $idProduct = $("#inputProductId").val();
            $nameProduct = $("#inputProductName").val();
            $typeProduct = $("#inputProductType").val();
            $priceProduct = $("#inputProductPrice").val();
            $numberProduct = $("#inputProductNumber").val();
            $imageProduct = $("#currentImage").val();

            //Kiem tra dau vao
            //MASP
            if ($idProduct == '') {
                alert('Vui lòng nhập mã sản phẩm');
                $("#inputProductId").focus();
                return;
            } else if ($idProduct.length < 4 || $idProduct.length > 10) {
                alert('Mã sản phẩm có dộ dài từ 4-10 ký tự');
                $("#inputProductId").focus();
                return;
            } else if ($idProduct.substring(0, 2) != "SP") {
                alert("Mã sản phẩm phải có dạng 'SP__'");
                $("#inputProductId").focus();
                return;
            }
            $idProduct = $("#inputProductId").val();
            //Kiem tra trong Chi tiet PN
            for ($i = 0; $i < detailReceipt.length; $i++) {
                if (detailReceipt[$i].MASP == $idProduct) {
                    alert("Mã sản phẩm đã tồn tại trong chi tiết Phiếu Nhập");
                    refreshInput();
                    return;
                }
            }
            //Ten SP
            if ($nameProduct == '') {
                alert('Vui lòng nhập tên sản phẩm');
                $("#inputProductName").focus();
                return;
            } else if ($nameProduct.length < 4) {
                alert('Tên sản phẩm có dộ dài từ 4-10 ký tự');
                $("#inputProductName").focus();
                return;
            }

            //Gia
            if ($priceProduct == '') {
                alert('Vui lòng nhập giá sản phẩm');
                $("#inputProductPrice").focus();
                return;
            } else if (isNaN($priceProduct) || $priceProduct <= 0 || parseInt($priceProduct) != $priceProduct) {
                alert('Giá Sản Phẩm phải là số nguyên dương');
                $("#inputProductPrice").focus();
                return;
            }

            //SoLuong
            if ($numberProduct == '') {
                alert('Vui lòng nhập SL sản phẩm');
                $("#inputProductNumber").focus();
                return;
            } else if (isNaN($numberProduct) || $numberProduct <= 0 || parseInt($numberProduct) != $numberProduct) {
                alert('Số Lượng Sản Phẩm phải là số nguyên dương');
                $("#inputProductNumber").focus();
                return;
            }
            //Hinh anh
            if ($imageProduct == '') {
                alert('Vui lòng chọn hình ảnh sản phẩm');
                return;
            } else {
                $extension = $imageProduct.substring($imageProduct.length - 3);
                if ($extension != 'png' && $extension != 'jpg') {
                    alert('Hình ảnh phải có định dạng [png], [jpg]');
                    $('#inputProductImage').val("");
                    return;
                }
            }

            //Them vao chi tiet
            var newItem = {
                MASP: $idProduct,
                TENSP: $nameProduct,
                MALOAI: $typeProduct,
                GIA: $priceProduct,
                SOLUONG: $numberProduct,
                HINHANH: $imageProduct
            };
            detailReceipt.push(newItem);

            alert("Thêm thành công");
            refreshInput();
            loadTable();
            tmpItem = new Array();
            $("#containerCurentImage").hide();
            $("#containerImage").show();
            $("#currentImage").val("");
            $("#inputProductImage").val("");
        }

        //Bat onchange khi chon hinh anh 
        $(document).ready(function() {
            $("#inputProductImage").change(function() {
                $imageProduct = $("#inputProductImage").val();
                $extension = $imageProduct.substring($imageProduct.length - 3);
                if ($extension != 'png' && $extension != 'jpg' && $extension != 'jpeg') {
                    alert('Hình ảnh phải có định dạng [png], [jpg], [jpeg]');
                    $('#inputProductImage').val("");
                    return;
                }
                var file_data = $('#inputProductImage').prop('files')[0];
                var form_data = new FormData();
                form_data.append('file', file_data);

                $.ajax({
                    url: '/CuaHangNoiThat/Admin/uploadImage',
                    dataType: 'text', // what to expect back from the server
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    success: function(data) {
                        var data = JSON.parse(data);
                        console.log(data)
                        var currentImage = $("#inputProductImage").val();

                        //get name image
                        $index = currentImage.length - 1;
                        while ($index > 0 && currentImage[$index] != '/' && currentImage[$index] != '\\') {
                            $index--;
                        }

                        currentImage = data[1] + (currentImage.substring($index + 1));
                        if (data[0] == 0) {
                            alert("Thêm ảnh thành công");
                            $("#currentImage").val(currentImage);
                            $("#containerCurentImage").show();
                            $("#containerImage").hide();
                            return;
                        }
                        alert('Không thể upload ảnh');
                        $('#inputProductImage').val("");
                    }
                });
            });
        });

        function refreshInput() {
            $("#inputProductId").val("");
            $("#inputProductName").val("");
            $("#inputProductType").prop('selectedIndex', 0);
            $("#inputProductPrice").val("");
            $("#inputProductNumber").val("");
            $("#inputProductId").focus();
            $("#currentImage").val("");
            $("#inputProductImage").val("");

            //Hien cac muc 
            $("#inputProductId").prop("readonly", false);
            $("#inputProductName").prop("readonly", false);
            $("#inputProductType").prop("disabled", false);
            $("#inputProductPrice").prop("readonly", false);
            $("#inputProductImage").prop("readonly", false);
            $("#containerImage").show();
            $("#containerCurentImage").hide();



        }

        function loadTable() {
            $xhtml = '<thead>' +
                '<tr>' +
                '<th scope="col">#</th>' +
                '<th scope="col">Mã Sản Phẩm</th>' +
                '<th scope="col" style="width: 20rem;">Tên Sản Phẩm</th>' +
                '<th scope="col">Loại</th>' +
                '<th scope="col">Giá</th>' +
                '<th scope="col">Số Lượng</th>' +
                '<th scope="col" style="width: 10rem;">Hình Ảnh</th>' +
                '<th scope="col" style="width: 10rem;">Chức Năng</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>';
            for ($i = 0; $i < detailReceipt.length; $i++) {
                $xhtml += '<tr>' +
                    '<th scope="row">' + ($i + 1) + '</th>' +
                    '<td>' + detailReceipt[$i].MASP + '</td>' +
                    '<td>' + detailReceipt[$i].TENSP + '</td>' +
                    '<td>' + detailReceipt[$i].MALOAI + '</td>' +
                    '<td>' + detailReceipt[$i].GIA + '</td>' +
                    '<td>' + detailReceipt[$i].SOLUONG + '</td>' +
                    '<td>' + detailReceipt[$i].HINHANH + '</td>' +
                    '<td>' +
                    '<button onclick="editItem(\'' + detailReceipt[$i].MASP + '\');" class="btn btn-primary btnControl" type="submit" style="background-color: #007bff;margin-top: 0.3rem;">Sửa Chi Tiết</button>' +
                    '<button onclick="deleteItem(\'' + detailReceipt[$i].MASP + '\');" class="btn btn-primary btnControl" type="submit" style="background-color: red;margin-top: 0.3rem;">Xóa Chi Tiết</button>' +
                    '</td>' +
                    '</tr>';
            }

            $xhtml += '</tbody>';

            $("#tableContent").html($xhtml);
        }

        function deleteItem($idProduct, $confirm = false) {
            if (!$confirm) {
                if (!confirm("Bạn có muốn xóa chi tiết " + $idProduct)) {
                    return;
                }
            }
            $index = 0;
            while ($index < detailReceipt.length && detailReceipt[$index].MASP != $idProduct) {
                $index++;
            }
            if ($index == 0 && detailReceipt[$index].MASP != $idProduct) {
                return;
            }
            for ($i = $index; $i < detailReceipt.length - 1; $i++) {
                detailReceipt[$i] = detailReceipt[$i + 1];
            }
            detailReceipt.pop();
            loadTable();

        }

        function getItemById($id) {
            for ($i = 0; $i < detailReceipt.length; $i++) {
                if (detailReceipt[$i].MASP == $id) {
                    return detailReceipt[$i];
                }
            }
            return new Array();
        }

        function editItem($idProduct) {
            if (tmpItem.length != 0) {
                detailReceipt.push(tmpItem);
                tmpItem = new Array();
            }

            tmpItem = getItemById($idProduct);
            console.log(tmpItem);
            deleteItem($idProduct, true);

            $('#addControl').hide();
            $('#editControl').show();

            //Kiem tra san pham da co trong DB hay chưa ?
            var productArray = <?php echo json_encode($data['Product']) ?>;
            $check = false;
            for ($i = 0; $i < productArray.length; $i++) {
                if (productArray[$i].MASP == $idProduct) {
                    $check = true;
                    break;
                }
            }
            //them du lieu vao tung input
            $("#inputProductId").val(tmpItem.MASP);
            $("#inputProductName").val(tmpItem.TENSP);
            $("#inputProductType").val(tmpItem.MALOAI);
            $("#inputProductPrice").val(tmpItem.GIA);
            $("#inputProductNumber").val(tmpItem.SOLUONG);
            $("#currentImage").val(tmpItem.HINHANH);
            //An di cac muc da lay thong tin
            $("#containerImage").css("display", "none");
            if ($check) {
                //An di cac muc da lay thong tin
                $("#inputProductId").prop("readonly", true);
                $("#inputProductName").prop("readonly", true);
                $("#inputProductType").prop("disabled", true);
                $("#inputProductPrice").prop("readonly", true);
                $("#containerImage").hide();
                $("#containerCurentImage").hide();
            } else {
                //hien thi cac muc da lay thong tin
                $("#inputProductId").prop("readonly", false);
                $("#inputProductName").prop("readonly", false);
                $("#inputProductType").prop("disabled", false);
                $("#inputProductPrice").prop("readonly", false);
                $("#containerCurentImage").show();
            }
        }

        function cancelEditItem() {
            if (!confirm("Bạn có muốn hủy bỏ việc chỉnh sửa ?")) {
                return;
            }
            $('#addControl').show();
            $('#editControl').hide();
            detailReceipt.push(tmpItem);
            tmpItem = new Array();
            loadTable();
            refreshInput();
        }

        function addReceiptToDB() {
            if (detailReceipt.length == 0) {
                alert("Không thể thêm Phiếu Nhập với chi tiết rỗng !!!");
                return;
            }
            $idStaff = $("#staffId").val();
            $supId = $("#supplierId").val();

            $.ajax({
                url: '/CuaHangNoiThat/Admin/AddReceiptToDb',
                data: {
                    staffid: $idStaff,
                    supplierId: $supId,
                    data: detailReceipt
                },
                method: 'post',
                success: function(result) {
                    console.log(result);
                    if (parseInt(result) == 0) {
                        alert('Thêm Phiếu Nhập thành công ');
                        detailReceipt = new Array();
                        refreshInput();
                        loadTable();
                        return;
                    }
                    alert('Thêm phiếu nhập thất bại !!!');
                }
            });
        }

        $(document).ready(function() {
            $("#readDetailFromFile").change(function() {
                $file = $("#readDetailFromFile").val();
                $extension = $file.substring($file.length - 4);
                if ($extension != 'xlsx') {
                    alert('Chỉ chấp nhận file excel (.xlsx)');
                    $("#readDetailFromFile").val('');
                    return;
                }
                var file_data = $('#readDetailFromFile').prop('files')[0];
                var form_data = new FormData();
                form_data.append('file', file_data);
                $.ajax({
                    url: '/CuaHangNoiThat/Admin/readDetailReceiptFromFile',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    success: function(data) {
                        var data = JSON.parse(data);
                        console.log(data)
                        var dataItem = data[0];
                        var dataCount = data[1];

                        if (countObj(dataItem) != 0) {
                            for (var key in dataItem) {
                                for (var subKey in detailReceipt) {
                                    if (detailReceipt[subKey].MASP == dataItem[key].MASP) {
                                        detailReceipt[subKey].SOLUONG = parseInt(detailReceipt[subKey].SOLUONG) + parseInt(dataItem[key].SOLUONG);
                                        dataItem[key].SOLUONG = 0;
                                    }
                                }
                                if (dataItem[key].SOLUONG != 0) {
                                    detailReceipt.push(dataItem[key]);
                                }
                            }

                            loadTable();

                        }                        

                        $message = 'Tổng số dòng đã đọc : ' + dataCount.sumRow + "\n";
                        $message += 'Tổng số dòng sau khi lọc : ' + dataCount.sumFilterRow + "\n";
                        $message += 'Tổng số dòng hợp lệ : ' + dataCount.sumValidRow + "\n";
                        $message += 'Tổng số dòng không hợp lệ : ' + dataCount.sumInvalidRow + "\n";
                        $message += 'Tổng số sản phẩm mới : ' + dataCount.sumNewRow + "\n";
                        $message += 'Tổng số sản phẩm thêm số lượng : ' + dataCount.sumExistRow + "\n";
                        alert($message);
                        $("#readDetailFromFile").val("");
                    }
                });
            });
        });

        function countObj(obj) {
            var count = 0;
            for (var p in obj) {
                obj.hasOwnProperty(p) && count++;
            }
            return count;
        }

        function changeCurrentImage() {
            $("#containerImage").show();
            $("#containerCurentImage").hide();
            $("#inputProductImage").val("");
            $("#currentImage").val("");
        }

        function createAutoId() {
            if ($("#inputProductId").val() != '') {
                alert("Vui lòng xóa mã SP hiện tại");
                return;
            }
            $.ajax({
                url: '/CuaHangNoiThat/Admin/createAutoProductId',
                success: function(data) {

                    var data = JSON.parse(data);
                    $("#inputProductId").val(data.ID);
                }
            })
        }
    </script>
</body>

</html>