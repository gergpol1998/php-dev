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

    ),
    "pub c" => array(
        "book 6" => 2,
        "book 7" => 1,
        "book 8" => 4,
    )
);
foreach ($data as $key => $books) {
    echo "\"" . $key . "\",";
}
foreach ($data["pub a"] as $key => $dt) {
    echo "\"" . $key . "\" = \"" . $dt . "\",";
}



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
                    <?php
                    foreach ($data as $key => $books) {
                        echo "\"" . $key . "\",";
                    }
                    ?>
                ],
                datasets: [{
                    label: 'กราฟ 1',
                    data: [
                        <?php
                        foreach ($data as $key => $books) {
                            echo $books['value1'] . ",";
                        }
                        ?>
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1
                }, {
                    label: 'กราฟ 2',
                    data: [
                        <?php
                        foreach ($data as $key => $books) {
                            echo $books['value2'] . ",";
                        }
                        ?>
                    ],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1
                }]
            },

        });
    </script>

    <canvas id="myChart2" width="400" height="200"></canvas>

    <script>
        var ctx2 = document.getElementById('myChart2').getContext('2d');
        var myChart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: [
                    <?php
                    foreach ($data as $key => $books) {
                        echo "\"" . $key . "\",";
                    }
                    ?>
                ],
                datasets: [{
                    label: 'กราฟ 1',
                    data: [
                        <?php
                        foreach ($data as $key => $books) {
                            echo $books['value1'] . ",";
                        }
                        ?>
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1
                }, {
                    label: 'กราฟ 2',
                    data: [
                        <?php
                        foreach ($data as $key => $books) {
                            echo $books['value2'] . ",";
                        }
                        ?>
                    ],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1
                }]
            },

        });
    </script>
</body>

</html>