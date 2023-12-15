<!doctype html>
<html lang="en">

<head>
    <title><?php echo $title;?></title>
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
        <h1>Tạo báo cáo theo thời gian</h1>
        <table class="selecter">
            <tr>
                <td>
                    <h4>Chọn tháng bắt đầu</h4>
                </td>
                <td>
                    <h4>Chọn tháng kết thúc</h4>
                </td>
            </tr>
            <tr>
                <td><input type="month" id="monthFrom"></td>
                <td><input type="month" id="monthTo"></td>
                <td><button class="btn btn-primary" onclick="statistic();">Thống Kê</button></td>
            </tr>
        </table>
    </div>

    <div>
        <h1>Báo cáo bán hàng</h1>
        <table class="selecter">
            <tr>
                <td colspan="2">
                    <h4>Chọn tháng cần thống kê: </h4>
                </td>
            </tr>
            <tr>
                <td><input type="month" id="statisticSale"></td>
                <td><button class="btn btn-primary" onclick="statisticSale();">Thống Kê Bán Hàng</button></td>
            </tr>
        </table>
    </div>

    <div>
        <h1>Báo cáo nhập hàng</h1>
        <table class="selecter">
            <tr>
                <td colspan="2">
                    <h4>Chọn tháng cần thống kê: </h4>
                </td>
            </tr>
            <tr>
                <td><input type="month" id="statisticWareHouse"></td>
                <td><button class="btn btn-primary" onclick="statisticWareHouse()">Thống Kê Nhập Hàng</button></td>
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
            if (-Date.parse($monthFrom) + Date.parse($monthTo) <= 0) {
                alert('Tháng bắt đầu phải nhỏ hơn tháng kết thúc và cách nhau ít nhất 1 tháng');
                return;
            } 


            window.location.href = "/CuaHangNoiThat/Admin/ThongKeTheoTG/"+$monthFrom + '/' + $monthTo;

        }

        function statisticSale(){
            $monthFrom = $("#statisticSale").val()

            if (!$monthFrom.localeCompare('')) {
                alert('Vui lòng chọn đầy đủ thông tin để thống kê')
                return;
            }

           
            window.location.href = "/CuaHangNoiThat/Admin/ThongKeBanHang/"+$monthFrom
        }

        function statisticWareHouse(){
            $monthFrom = $("#statisticWareHouse").val()

            if (!$monthFrom.localeCompare('')) {
                alert('Vui lòng chọn đầy đủ thông tin để thống kê')
                return;
            }

           
            window.location.href = "/CuaHangNoiThat/Admin/ThongKeNhapHang/"+$monthFrom
        }
    </script>
</body>

</html>