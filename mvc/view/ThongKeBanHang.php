<!doctype html>
<html lang="en">

<head>
    <title><?php echo $title; ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
        .selecter {
            width: 40%;
            margin-left: 30%;
        }

        .selecter td {
            padding: 0 1rem 0 1rem;
        }

        .selecter td>h4 {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div>
        <h1>Xem lịch sử giao dịch</h1>
        <table class="selecter">
            <tr>
                <td>
                    <h4>Chọn ngày bắt đầu</h4>
                </td>
                <td>
                    <h4>Chọn ngày kết thúc</h4>
                </td>
            </tr>
            <tr>
                <td><input type="date" id="monthFrom"></td>
                <td><input type="date" id="monthTo"></td>
                <td><button class="btn btn-primary" onclick="statistic();">Thống Kê</button></td>
            </tr>
        </table>
    </div>

    <div>
        <h1>Thống kê doanh thu bán hàng của User (Theo tháng)</h1>
        <table class="selecter">
            <tr>
                <td>
                    <h4>Chọn tháng thống kê</h4>
                </td>
               
            </tr>
            <tr>
                <td><input type="month" id="monthFromU"></td>
                
                <td><button class="btn btn-primary" onclick="statisticProficUser();">Thống Kê</button></td>
            </tr>
        </table>
    </div>







    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script>
        function statistic() {
            $monthFrom = $("#monthFrom").val()
            $monthTo = $("#monthTo").val()

            if (!$monthFrom.localeCompare('') || !$monthTo.localeCompare('')) {
                alert('Vui lòng chọn đầy đủ thông tin để thống kê')
                return;
            }

            //month start must be smaller than month end
            console.log(-Date.parse($monthFrom) + Date.parse($monthTo))
            if (-Date.parse($monthFrom) + Date.parse($monthTo) < 0) {
                alert('Ngày bắt đầu phải nhỏ hơn ngày kết thúc');
                return;
            }


            window.location.href = "/CuaHangNoiThat/NhanVien/ThongKeTheoTG/" + $monthFrom + '/' + $monthTo;

        }


        function statisticProficUser() {
            $monthFrom = $("#monthFromU").val()
            

            if (!$monthFrom.localeCompare('')) {
                alert('Vui lòng chọn đầy đủ thông tin để thống kê')
                return;
            }

            

            window.location.href = "/CuaHangNoiThat/NhanVien/ThongKeDoanhThu/" + $monthFrom;
        }
    </script>
</body>

</html>