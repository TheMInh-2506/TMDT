<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../my-css.css">
    <title>Đăng nhập</title>
</head>

<body>
    
    <fieldset>
        <legend><i class="fa fa-user-circle-o" aria-hidden="true"></i></legend>
        <p>ĐĂNG NHẬP NHÂN VIÊN</p>
        <input type="text" id="uname" name="uname" placeholder="a@gmail.com">
        <p style="font-size: 18px;text-align: left;color: red;margin-left: 20%;" id="errorUname">Tên đăng nhập không hợp lệ</p>
        <input type="password" id="pass" name="pass" placeholder="*********">
        <p style="font-size: 18px;text-align: left;color: red;margin-left: 20%;" id="errorPass">Mật khẩu không hợp lệ</p>
        <p id="errorMessage" style="margin-top: 0;padding-top: 0;"></p>
        <input type="submit" id="submitbtn" value="ĐĂNG NHẬP" class="btn-log">
        <div class="reg">Bạn chưa có tài khoản? <a href="./DangKy">Đăng ký</a></div>
    </fieldset>

</body>
<script>
    $(document).ready(function() {
        $("#errorUname").hide();
        $("#errorPass").hide();
    });

    $("#submitbtn").click(function() {
        $("#errorUname").hide();
        $("#errorPass").hide();
        $("#errorMessage").hide();

        $uname = $("#uname").val();
        $pass = $("#pass").val();

        if ($uname === "") {
            $("#errorUname").show();
            return;
        }
        if ($pass === "") {
            $("#errorPass").show();
            return;
        }

        $.ajax({
            url: '/CuaHangNoiThat/Admin/checkLoginAdmin/' + $uname + '/' + $pass,
            method: 'POST',
            data: {
                url: window.location.href
            },
            success: function(data) {
                var data = JSON.parse(data);
                $result = data.RESULT;
                if ($result === "NOT_EXISTS") {
                    $("#errorMessage").html("Tài khoản không tồn tại");
                    $("#errorMessage").show();
                } else if ($result === "WRONG_PASSWORD") {
                    $("#errorMessage").html("Mật khẩu không chính xác");
                    $("#errorMessage").show();
                } else if($result === 'BLOCK'){
                    $("#errorMessage").html("Tài khoản bạn đã bị khóa. Vui lòng liên hệ mildstore@gmail.com để biết thêm chi tiết");
                    $("#errorMessage").show();
                }
                else if($result === 'NOT_ADMIN'){
                    window.location.href = "/CuaHangNoiThat/NhanVien";
                }
                 else {
                    $("#errorMessage").html("Tài khoản của bạn không phải là Nhân viên");
                    $("#errorMessage").show();
                    
                    
                }
            }
        });

    });
</script>

</html>