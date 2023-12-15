

<!doctype html>
<html lang="en">

<head>
    <title>Thống kê doanh thu</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

        var billData = JSON.parse('<?php echo json_encode($data['bill']);?>');
        var timeData = JSON.parse('<?php echo json_encode($data['time']);?>');
        var statisticArrayData = createTimeline(timeData);


        for(var i = 1;i < statisticArrayData.length;i++){
            var item = statisticArrayData[i];
            var labelTime = item[0]
            
            var sumB = 0;
            

            //Loop bill list
            for(var item of billData){
                if(parseInt(item['NGAYLAP'].split('-')[2]) == parseInt(labelTime)){
                    sumB+= parseInt(item['TONG']);
                }
                
            }

            
            statisticArrayData[i][0] = (labelTime);
            statisticArrayData[i][1] = sumB;
            

        }


        google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable(statisticArrayData);

        var options = {
          title: 'Thống kê Doanh thu theo tháng '+timeData,
          hAxis: {title: 'Ngày',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }


        function createTimeline(time){
            var timeArr = time.split('-')
            

            var month = parseInt(timeArr[1]);
            var year = parseInt(timeArr[0]);

            var result = new Array();
            result.push(['Ngày', 'Hóa Đơn',]);
            var lastDay = 0;
            switch(month){
                case 1: case 3: case 5: case 7: case 8: case 10: case 12:{
                    lastDay = 31;
                    break;
                }
                case 4: case 6: case 9: case 11:{
                    lastDay = 30;
                    break;
                }
                case 2:{
                    lastDay = (checkLeepYear(year)== true ? 29:28);
                    break;
                }
            }
            for(var i = 1;i <= lastDay;i++){
                result.push([i,0]);
            }
            return result;
        }

        function checkLeepYear(year){
            return (((year % 4 == 0) && (year % 100 != 0)) ||
             (year % 400 == 0));
        }

        function compactYearMonth(str){
            //2121-03
            var arr = str.split('-')
            return arr[1] + '/' + arr[0].slice(2)
        }

        
    </script>
</head>

<body>
    <div>
    <button class="btn btn-warning" onclick="window.location.href='/CuaHangNoiThat/NhanVien/ThongKeBanHang'">Trở về</button>
        <button class="btn btn-primary" onclick="printToImage('#statisticExport','ThongKeDoanhThu_<?php echo $data['time'];?>')">Xuất Hình Ảnh</button>
    </div>
    <div style="width: 1200px;" id="statisticExport">
        <div style="width: 100%;background-color: lightgray;">
            <h1 style="text-align: center;">MILD STORE</h1>
            <div style="width: 100%;text-align: center;">
                <p style="font-weight: 800;color: gray;">Decorate your Life with Arts</p>
                <h5>Địa chỉ: 273 An D. Vương, Phường 3, Quận 5, Thành phố Hồ Chí Minh</h5>
                <h5>SĐT: 0843739379</h5>
                <h5>www.mildstore.com</h5>
            </div>
            <div>
                <p style="text-align: center;">------------------------------------------------------------------------------------------</p>
                <h3 style="width: 90%;margin-left: 5%;">THỐNG KÊ DOANH THU CỦA NHÂN VIÊN [<?php echo $_SESSION['staff']['TENNV'];?>] TẠI <?php echo $data['time'];?></h3>
                <div style="background-color: white;width: 90%;margin-left: 5%;padding: 1rem;">
                    <table style="font-size:1.2rem;">
                        <tbody>
                            <tr>
                                <td style="font-weight:800;padding-right:3rem;">Thời gian lập : </td>
                                <td><?php echo date('H:i:s d-m-Y');?></td>

                            </tr>
                        </tbody>
                    </table>
                </div>
                <h3 style="width: 90%;margin-left: 5%;">HÓA ĐƠN & PHIẾU NHẬP</h3>
                <table class="table" style="width: 90%;margin-left: 5%;background-color: white;">
                    <thead>
                        <tr>
                            <th scope="col">Tổng số lượng hóa đơn: </th>
                            <td><?php echo count($data['bill']); ?></td>
                        </tr>
                        <tr>
                            <th scope="col">Tổng tiền hóa đơn: </th>
                            <td>
                                <?php
                                    $sumB = 0;
                                    foreach($data['bill'] as $value){
                                        $sumB += $value['TONG'];
                                    }
                                    
                                    echo number_format($sumB,0,'',',');
                                ?>
                                VNĐ
                            </td>
                        </tr>
                    </thead>

                </table>
                <h3 style="width: 90%;margin-left: 5%;">BIỂU ĐỒ</h3>
                <div id="chart_div" style="width: 1200px; height: 500px;"></div>

                <hr>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>