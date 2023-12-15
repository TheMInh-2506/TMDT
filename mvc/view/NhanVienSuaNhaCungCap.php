<!doctype html>
<html lang="en">

<head>
    <title><?php echo $title; ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body style="background-image: radial-gradient(#b3b3b3, #ffffff);">

    <div style="width: 30%;margin-left: 35%;font-size: 1.5rem;background-color: white;padding: 2rem;border-radius: 1rem;color:#0066cc;margin-top: 2rem;">
        <h2 style="width: 100%;color: #0066cc;font-weight: 600;">Sửa Nhà Cung Cấp</h2>
        <div class="form-group">
            <label for="exampleInputEmail1">Mã Nhà Cung Cấp</label>
            <input type="text" class="form-control" value="<?php echo $data['MANCC'];?>" id="idSupplier" readonly>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Tên Nhà Cung Cấp</label>
            <input type="text" class="form-control" value="<?php echo $data['TENNCC'];?>" id="nameSupplier">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Địa Chỉ</label>
            <input type="text" class="form-control" value="<?php echo $data['DIACHI'];?>" id="addressSupplier">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">SĐT</label>
            <input type="text" class="form-control" value="<?php echo $data['SDT'];?>" id="phoneSupplier">
        </div>


        <a href="/CuaHangNoiThat/NhanVien/NhaCungCap">
            <button type="submit" class="btn btn-primary" style="background-color: white;color: #0066cc;font-size: 1.5rem;margin-top: 2rem;">Trở về </button>
        </a>
        <button onclick="updateInforSupplier();" type="submit" class="btn btn-primary" style="background-color: #0066cc;color: white;font-size: 1.5rem;margin-top: 2rem;float: right;">Sửa Nhà Cung Cấp</button>
    </div>
    <script>
        function updateInforSupplier(){
            $idSupplier = $("#idSupplier").val();
            $nameSupplier = $("#nameSupplier").val();
            $addressSupplier = $("#addressSupplier").val();
            $phoneSupplier = $("#phoneSupplier").val();

            //Check valid input
            if($nameSupplier == ''){
                alert("Vui lòng nhập tên nhà cung cấp");
                $("#nameSupplier").focus();
                return;
            }
            else if($addressSupplier == ''){
                alert("Vui lòng nhập địa chỉ nhà cung cấp");
                $("#addressSupplier").focus();
                return;
            }
            else if($phoneSupplier == ''){
                alert("Vui lòng nhập SĐT nhà cung cấp");
                $("#phoneSupplier").focus();
                return;
            }
            else if(!checkPhoneNumber($phoneSupplier)){
                alert("SĐT nhà cung cấp không hợp lệ. SĐt phải có độ dài từ 10-11 số, bắt đầu bằng số 0 và chỉ chứa chữ số");
                $("#phoneSupplier").focus();
                return;
            }
            $objSupplier = {
                'MANCC':$idSupplier,
                'TENNCC':$nameSupplier,
                'DIACHI':$addressSupplier,
                'SDT':$phoneSupplier
            };
            $.ajax({
                url:'/CuaHangNoiThat/Admin/updateInformationSupplier',
                data: {data:$objSupplier},
                method: 'post',
                success:function(data){
                    if(data == 0){
                        alert("Cập nhật thông tin NCC thành công");
                    }
                    else{
                        alert("Không thể cập nhật");
                    }
                }
            });
        }
    </script>
</body>

</html>