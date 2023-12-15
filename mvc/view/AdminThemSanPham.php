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
    <button type="button" class="btn btn-primary btn-lg optionButton" style="float: right;">Đọc File</button>
    <h2 style="width: 100%;color: #0066cc;font-weight: 600;">Thêm Sản Phẩm</h2>

    <div class="form-group">
      <label for="exampleInputEmail1">Tên sản phẩm</label>
      <input type="text" class="form-control" id="exampleInputEmail1">
    </div>
    <label for="exampleInputEmail1">Loại sản phẩm</label>
    <select class="form-control">
      <option></option>
    </select>
    <div class="form-group">
      <label for="exampleInputEmail1">Giá</label>
      <input type="text" class="form-control" id="exampleInputEmail1">
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Số lượng</label>
      <input type="text" class="form-control" id="exampleInputEmail1">
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Hình Ảnh</label>

      <input type="file" class="form-control-file" id="exampleFormControlFile1">
    </div>
    <a href="/CuaHangNoiThat/Admin/SanPham">
      <button type="submit" class="btn btn-primary" style="background-color: white;color: #0066cc;font-size: 1.5rem;margin-top: 2rem;">Trở về </button>
    </a>
    <button type="submit" class="btn btn-primary" style="background-color: #0066cc;color: white;font-size: 1.5rem;margin-top: 2rem;float: right;">Thêm Sản Phẩm</button>
  </div>
</body>

</html>