<?php
$id = '';
if (isset($data['id'])) {
  $id = $data['id'];
  $product = $data['product'];
}
if ($id == '' || empty($productList)) {
  //return;
}
?>



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
  <div style="width: 30%;margin-left: 35%;font-size: 1.5rem;background-color: white;padding: 2rem;border-radius: 1rem;color:#0066cc;margin-top: 2rem;margin-bottom: 2rem;">
    <h2 style="width: 100%;text-align: center;color: #0066cc;font-weight: 600;">Sửa Sản Phẩm</h2>
    <div class="form-group">
      <label for="exampleInputEmail1">Mã sản phẩm</label>
      <input type="text" class="form-control" id="idProduct" value="<?php echo $product['MASP']; ?>" readonly>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Tên sản phẩm</label>
      <input type="text" class="form-control" value="<?php echo $product['TENSP']; ?>" id="nameProduct">
    </div>
    <label for="exampleInputEmail1">Loại sản phẩm</label>
    <select class="form-control" id="idTypeProduct">
      <?php
      foreach ($data['type'] as $value) {
        if ($value['MALOAI'] == $product['MALOAI']) {
          echo '<option value="' . $value['MALOAI'] . '" selected>' . $value['TENLOAI'] . '</option>';
        } else {
          echo '<option value="' . $value['MALOAI'] . '">' . $value['TENLOAI'] . '</option>';
        }
      }
      ?>
    </select>
    <div class="form-group">
      <label for="exampleInputEmail1">Giá</label>
      <input type="text" class="form-control" value="<?php echo $product['GIA']; ?>" id="priceProduct">
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="float: left;">Hình Ảnh hiện tại</label>
      <img id="currentImageProduct" src="/CuaHangNoiThat/public/image/HINHANH/<?php echo $product['HINHANH']; ?>" alt="error" style="width: 40%;float: right;">
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="width: 100%;">Thay đổi Hình Ảnh</label>
      <input type="file" class="form-control-file" id="changeImageProduct" multiple>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="width: 100%;">Phần Trăm Giảm (%)</label>
      <input type="text" class="form-control-file" value="<?php echo $product['PHANTRAMGIAM']; ?>" id="decreaseProduct">
    </div>
    <a href="/CuaHangNoiThat/Admin/SanPham">
      <button type="submit" class="btn btn-primary" style="background-color: white;color: #0066cc;font-size: 1.5rem;margin-top: 2rem;">Trở về </button>
    </a>
    <button onclick="editProduct();" type="submit" class="btn btn-primary" style="background-color: #0066cc;color: white;font-size: 1.5rem;margin-top: 2rem;float: right;">Sửa Sản Phẩm</button>
  </div>

  <script>
    $(document).ready(function() {
      $("#changeImageProduct").change(function() {
        $imageProduct = $("#changeImageProduct").val();
        $extension = $imageProduct.substring($imageProduct.length - 3);
        if ($extension != 'png' && $extension != 'jpg' && $extension != 'jpeg') {
          alert('Hình ảnh phải có định dạng [png], [jpg], [jpeg]');
          $('#changeImageProduct').val("");
          return;
        }
        var file_data = $('#changeImageProduct').prop('files')[0];
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
            var currentImage = $("#changeImageProduct").val();
            
            //get name image
            $index = currentImage.length - 1;
            while ($index > 0 && currentImage[$index] != '/' && currentImage[$index] != '\\') {
              $index--;
            }

            currentImage = currentImage.substring($index + 1);
            if (data[0] == 0) {
              alert("Thêm ảnh thành công");
              $("#currentImageProduct").attr('src','/CuaHangNoiThat/public/image/HINHANH/'+data[1]+currentImage);
              return;
            }
            alert('Không thể upload ảnh');
            $('#changeImageProduct').val("");
          }
        });
      });
    });

    function editProduct(){
      $idProduct = $("#idProduct").val();
      $nameProduct = $("#nameProduct").val();
      $idTypeProduct = $("#idTypeProduct").val();
      $priceProduct = $("#priceProduct").val();
      $currentImageProduct = getImageNameFromSrc($("#currentImageProduct").attr('src'));
      $decreaseProduct = $("#decreaseProduct").val();

      if($nameProduct == ''){
        alert('Tên sản phẩm không thể để trống');
        $("#nameProduct").focus();
        return;
      }
      else if(isNaN($priceProduct) || $priceProduct < 0 || !isInt($priceProduct)){
        alert('Giá sản phẩm là số nguyên lớn hơn bằng 0');
        $("#priceProduct").focus();
        return;
      }
      else if(isNaN($decreaseProduct) || $decreaseProduct < 0 || $decreaseProduct > 100 || !isInt($decreaseProduct)){
        alert('Phần trăm giảm giá giao động từ 0-100%');
        $("#decreaseProduct").focus();
        return;
      }
      $obj = {
        MASP:$idProduct,
        TENSP:$nameProduct,
        MALOAI:$idTypeProduct,
        GIA:$priceProduct,
        HINHANH:$currentImageProduct,
        PHANTRAMGIAM:$decreaseProduct
    };

      $.ajax({
        url : '/CuaHangNoiThat/Admin/updateInformationProduct',
        data : {obj:$obj},
        method:'post',
        success : function(result){
          console.log(result);
          if(result == 0){
            alert("Cập nhật thông tin sản phẩm thành công");
          }
          else{
            alert("Lỗi khi cập nhật !!!");
          }
        }
      });
    }
  </script>
</body>

</html>