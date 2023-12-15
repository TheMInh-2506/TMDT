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
    <h2 style="width: 100%;color: #0066cc;font-weight: 600;">Thêm Khuyến Mãi</h2>

    <div class="form-group">
      <label for="exampleInputEmail1">Ngày Bắt Đầu</label>
      <input type="date" class="form-control" id="startSale">
    </div>
    <label for="exampleInputEmail1">Ngày Kết Thúc</label>
    <input type="date" class="form-control" id="endSale">
    <div class="form-group">
      <label for="exampleInputEmail1">Phần Trăm Giảm </label>
      <input type="number" class="form-control" id="decreaseSale">
    </div>
    <a href="/CuaHangNoiThat/Admin/KhuyenMai">
      <button type="submit" class="btn btn-primary" style="background-color: white;color: #0066cc;font-size: 1.5rem;margin-top: 2rem;">Trở về </button>
    </a>
    <button onclick="addNewSale();" class="btn btn-primary" style="background-color: #0066cc;color: white;font-size: 1.5rem;margin-top: 2rem;float: right;">Thêm Khuyến Mãi</button>
  </div>
  <script>
    function addNewSale() {
      $startSale = $("#startSale").val();
      $endSale = $("#endSale").val();
      $decreaseSale = $("#decreaseSale").val();
      
      if ($startSale == '') {
        alert('Ngày bắt đầu không được trống !!!');
        return;
      }
      if ($endSale == '') {
        alert('Ngày kết thúc không được trống !!!');
        return;
      }
      if ($startSale > $endSale) {
        alert('Ngày bắt đầu không được vượt quá ngày kết thúc!!!');
        return;
      }
      if ($decreaseSale == '') {
        alert('Phần trăm giảm không được trống !!!');
        return;
      }
      if (isNaN($decreaseSale) || parseInt($decreaseSale) < 0 || parseInt($decreaseSale) > 100 || parseInt($decreaseSale) != $decreaseSale) {
        alert('Phần trăm giảm phải là số nguyên lớn hơn 0 !!!');
        return;
      }

      $obj = {
        'NGAYBD': $startSale,
        'NGAYKT': $endSale,
        'PHANTRAMGIAM': $decreaseSale
      };

      $.ajax({
        url : '/CuaHangNoiThat/Admin/addNewSale',
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