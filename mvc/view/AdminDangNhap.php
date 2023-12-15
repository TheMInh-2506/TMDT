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
    <style>
        /* Styles for desktop */
        fieldset {
            width: 500px;
            margin: 0 auto;
        }

        legend {
            font-size: 80px;
            margin: 0 10px 10px 10px;
            padding-top: 80px;
            text-align: center;
        }

        .input-group {
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="password"] {
            width: 90%;
            padding: 5px;
            box-sizing: border-box;
        }

        .error-message {
            font-size: 18px;
            text-align: left;
            color: red;
            margin-left: 20%;
            display: none;
        }

        .btn-log {
            margin-top: 10px;
            width: 90%;
            padding: 5px;
        }

        .reg {
            margin-top: 10px;
            text-align: center;
        }

        /* Styles for mobile */
        @media (max-width: 500px) {
            fieldset {
                width: 90%;
            }

            .error-message {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
<fieldset>
        <legend><i class="fa fa-user-circle-o" aria-hidden="true"></i></legend>
        <p>ĐĂNG NHẬP ADMIN</p>
        <div class="input-group">
            <input type="text" id="uname" name="uname" placeholder="abc">
            <p class="error-message" id="errorUname">Tên đăng nhập không hợp lệ</p>
        </div>
        <div class="input-group">
            <input type="password" id="pass" name="pass" placeholder="*********">
            <p class="error-message" id="errorPass">Mật khẩu không hợp lệ</p>
        </div>
        <p id="errorMessage"></p>
        <input type="submit" id="submitbtn" value="ĐĂNG NHẬP" class="btn-log">
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
                console.log(data);

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
                    $("#errorMessage").html("Tài khoản của bạn không phải là admin");
                    $("#errorMessage").show();
                    $.ajax({
                        url: '/CuaHangNoiThat/Admin/DangXuat'
                    })
                }
                 else {
                    window.location.href = "./";
                }
            }
        });

    });
</script>

</html>