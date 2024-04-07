<?php

// ข้อมูลอุปกรณ์
$data = array(
    "pub a" => array(
        "book 1" => 3,
        "book 2" => 2,
        "book 3" => 3,
    ),
    "pub b" => array(
        "book 4" => 1,
        "book 5" => 4,
        "book 6" => 2,
    ),
    "pub c" => array(
        "book 7" => 2,
        "book 8" => 1,
        "book 9" => 4,
    )
);

// กำหนดชื่อแกน X และ Y
$xAxisLabel = "ชื่อ";
$yAxisLabel = "จำนวน";

// เริ่มสร้างกราฟ
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>ตัวอย่างกราฟแท่งจากข้อมูล</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>
</head>

<body>
    <canvas id="myChart" width="400" height="200"></canvas>

    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    "pub 1","p2"
                ],
                datasets: [{
                    label: 'xx',
                    data: [
                        1, 
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1
                }, {
                    label: 'xy',
                    data: [
                        1, 2, 1.5
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1
                }]
            },

        });
    </script>
    <canvas id="myChart2" width="400" height="200"></canvas>

    <script>
        var ctx2 = document.getElementById('myChart2').getContext('2d');
        var myChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: [
                    "pub 1", "pub 2", "pub 3"
                ],
                datasets: [{
                    label: 'xx',
                    data: [
                        1, 2, 1.5
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1
                }, {
                    label: 'xx',
                    data: [
                        1, 2, 1.5
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1
                }]
            },

        });
    </script>
</body>

</html>