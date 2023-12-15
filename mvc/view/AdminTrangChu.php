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
    .admin-item {
      width: 20rem;
      height: 20rem;
      background-color: #3884ff;
      float: left;
      margin: 1rem;
      border-radius: 1rem;
      padding: 2rem;
      color: white;
    }
  </style>
</head>

<body>
  <div style="width: 80%;margin-left: 10%;">
    <div class="admin-item">
      <div style="text-align: center;width: 100%;font-size: 128px;"><?php echo $data['countStaff']; ?></div>
      <div style="text-align: center;width: 100%;font-size: 32px;">Nhân Viên</div>
    </div>
    <div class="admin-item">
      <div style="text-align: center;width: 100%;font-size: 128px;"><?php echo $data['countCustomer']; ?></div>
      <div style="text-align: center;width: 100%;font-size: 32px;">Khách Hàng</div>
    </div>
    <div class="admin-item">
      <div style="text-align: center;width: 100%;font-size: 128px;"><?php echo $data['countProduct']; ?></div>
      <div style="text-align: center;width: 100%;font-size: 32px;">Sản Phẩm</div>
    </div>
    <div class="admin-item">
      <div style="text-align: center;width: 100%;font-size: 128px;"><?php echo $data['countBill']; ?></div>
      <div style="text-align: center;width: 100%;font-size: 32px;">Hóa Đơn</div>
    </div>
  </div>
  <?php
    if(isset($_SESSION['staff'])){
      $staff = $_SESSION['staff'];
      echo '<table class="table" style="width: 30%;margin-left: 10%;font-size: 1.4rem;">
      <tr>
        <th colspan="2" style="text-align: center;">THÔNG TIN NHÂN VIÊN</th>
      </tr>
      <tr>
        <th>Mã Nhân Viên</th>
        <td>'.$staff['MANV'].'</td>
      </tr>
      <tr>
        <th>Họ Tên</th>
        <td>'.$staff['TENNV'].'</td>
      </tr>
      <tr>
        <th>Ngày Sinh</th>
        <td>'.$staff['NGAYSINH'].'</td>
      </tr>
      <tr>
        <th>Giới Tính</th>
        <td>'.$staff['GIOITINH'].'</td>
      </tr>
      <tr>
        <th>Địa Chỉ</th>
        <td>'.$staff['DIACHI'].'</td>
      </tr>
      <tr>
        <th>SĐT</th>
        <td>'.$staff['SDT'].'</td>
      </tr>
    </table>';
    }
  ?>
</body>

</html>