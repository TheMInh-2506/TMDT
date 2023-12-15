

<!doctype html>
<html lang="en">

<head>
    <title>Thống kê theo thời gian</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

        var billData = JSON.parse('<?php echo json_encode($data['bill']);?>');
        var receiptData = JSON.parse('<?php echo json_encode($data['receipt']);?>');
        var timeData = JSON.parse('<?php echo json_encode($data['time']);?>');
        var statisticArrayData = createTimeline(timeData['from'],timeData['to']);

        for(var i = 1;i < statisticArrayData.length;i++){
            var item = statisticArrayData[i];
            var labelTime = item[0]
            
            var sumB = 0;
            var sumR = 0;

            //Loop bill list
            for(var item of billData){
                if(item['NGAYLAP'].includes(labelTime)){
                    sumB+= parseInt(item['TONG']);
                }
                
            }

            //Loop receipt list
            for(var item of receiptData){
                if(item['NGAYLAP'].includes(labelTime)){
                    sumR+= parseInt(item['TONG']);
                }
                
            }
            statisticArrayData[i][0] = compactYearMonth(labelTime);
            statisticArrayData[i][1] = sumB;
            statisticArrayData[i][2] = sumR;
            

        }


        google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable(statisticArrayData);

        var options = {
          title: 'Thống kê Hóa Đơn và Phiếu Nhập theo thời gian',
          hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }


        function createTimeline(from,to){
            var fromArr = from.split('-')
            var toArr = to.split('-')

            var monthF = parseInt(fromArr[1]);
            var yearF = parseInt(fromArr[0]);

            var monthT = parseInt(toArr[1]);
            var yearT = parseInt(toArr[0]);

            var result = new Array();
            result.push(['Tháng', 'Hóa Đơn', 'Phiếu Nhập']);
            while(monthF != monthT || yearF != yearT){
                var label = yearF + '-' + (monthF < 10 ? '0'+monthF : monthF);
                var tmp =[label,0,0];
                result.push(tmp)

                if(monthF == 12 && yearF != yearT){
                    monthF = 1;
                    yearF++;
                }
                else{
                    monthF ++;
                }
            }
            var label = yearF + '-' + (monthF < 10 ? '0'+monthF : monthF)
            result.push([label,0,0])
            return result;
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
    <button class="btn btn-warning" onclick="window.location.href='/CuaHangNoiThat/Admin/ThongKe'">Trở về</button>
        <button class="btn btn-primary" onclick="printToImage('#statisticExport','ThongKeTheoThoiGianTu_<?php echo $data['time']['from'];?>_den_<?php echo $data['time']['to'];?>')">Xuất Hình Ảnh</button>
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
                <h3 style="width: 90%;margin-left: 5%;">THỐNG KÊ THEO THỜI GIAN TỪ <?php echo $data['time']['from'];?> ĐẾN <?php echo $data['time']['to'];?></h3>
                <div style="background-color: white;width: 90%;margin-left: 5%;padding: 1rem;">
                    <table style="font-size:1.2rem;">
                        <tbody>
                            <tr>
                                <td style="font-weight:800;padding-right:3rem;">Thời gian lập : </td>
                                <td><?php echo date('H:i:s d-m-Y');?></td>

                            </tr>
                            <tr>
                                <td style="font-weight:800;padding-right:3rem;">Người lập : </td>
                                <td>Quản trị viên</td>
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
                            <th scope="col">Tổng số lượng phiếu nhập: </th>
                            <td><?php echo count($data['receipt']); ?></td>
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
                            <th scope="col">Tổng tiền phiếu nhập: </th>
                            <td>
                                <?php
                                    $sumR = 0;
                                    foreach($data['receipt'] as $value){
                                        $sumR += $value['TONG'];
                                    }
                                    
                                    echo number_format($sumR,0,'',',');
                                ?>
                                VNĐ</td>
                        </tr>
                        <tr>
                            <th scope="col" colspan="3">Lợi nhuận: </th>
                            <th scope="col"><?php echo number_format($sumB-$sumR,0,'',','); ?> VNĐ</th>
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