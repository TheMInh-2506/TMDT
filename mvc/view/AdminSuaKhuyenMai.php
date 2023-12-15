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
    <h2 style="width: 100%;color: #0066cc;font-weight: 600;">Sửa Khuyến Mãi</h2>

    <div class="form-group">
      <label for="exampleInputEmail1">Mã Khuyến Mãi</label>
      <input type="text" class="form-control" value="<?php echo $data['MAKM'];?>" id="idSale" readonly>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Ngày Bắt Đầu</label>
      <input type="date" class="form-control" value="<?php echo $data['NGAYBD'];?>" id="startSale">
    </div>
    <label for="exampleInputEmail1">Ngày Kết Thúc</label>
    <input type="date" class="form-control" value="<?php echo $data['NGAYKT'];?>" id="endSale">
    <a href="/CuaHangNoiThat/Admin/KhuyenMai">
      <button type="submit" class="btn btn-primary" style="background-color: white;color: #0066cc;font-size: 1.5rem;margin-top: 2rem;">Trở về </button>
    </a>
    <button onclick="editSale();" class="btn btn-primary" style="background-color: #0066cc;color: white;font-size: 1.5rem;margin-top: 2rem;float: right;">Sửa Khuyến Mãi</button>
  </div>
  <script>
    function editSale(){
      $idSale = $("#idSale").val();
      $startSale = $("#startSale").val();
      $endSale = $("#endSale").val();

      if($startSale == ''){
        alert('Ngày bắt đầu không được trống !!!');
        return;
      }
      if($endSale == ''){
        alert('Ngày kết thúc không được trống !!!');
        return;
      }
      if($startSale > $endSale){
        alert('Ngày bắt đầu không được  vượt quá ngày kết thúc!!!');
        return;
      }

      $obj = {'MAKM':$idSale,'NGAYBD':$startSale,'NGAYKT':$endSale};

      $.ajax({
        url : '/CuaHangNoiThat/Admin/updateInforSale',
        method:'post',
        data:{data:$obj},
        success: function(data){
          alert(data);
        }
      });
    }
  </script>
</body>

</html>