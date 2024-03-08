<?php
session_start();
echo "<script> src ='https://code.jquery.com/jquery-3.6.1.min.js' 
</script>
<script src = 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js'></script>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css'/>";

echo "<script src='function.js'></script>";

if (!isset($_SESSION['cusid'])) {
    echo '
        <script>
            sweetalerts("กรุณาลงชื่อเข้าใช้งานก่อน!!","warning","","login.php");
        </script>
        ';
} else {
    $cusid = $_SESSION['cusid'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard2</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- นำเข้า library Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <?php
    include "nav.php";
    ?>
    <div class="container px-4 px-lg-5 mt-3">

        <div class="d-flex justify-content-between">
            <h2>
                <div>แดชบอร์ดของฉัน</div>
            </h2>
            <div class="d-flex justify-content-end">
                <?php
                $sqlcheckpro = "select book_id from book
                inner join publisher on pub_id = book_pubid
                inner join customer on cus_id = pub_cusid
                where pub_cusid = '$cusid' and book_status = '2'";
                $ex_sqlcheckpro = connectdb()->query($sqlcheckpro);
                if ($ex_sqlcheckpro->num_rows > 0) {
                    echo '<a class="btn btn-success mb-4 me-2" href="promotion.php" role="button">
                        <h4>โปรโมชั่น</h4>
                    </a>';
                } else {
                ?>
                    <script>
                        function adds(mypage) {
                            let agree = confirm("ยังไม่มีหนังสือที่เผยแพร่");
                            if (agree) {
                                window.location = mypage;
                            }
                        }
                    </script>
                    <a class="btn btn-success mb-4 me-2" onclick="adds(this.href); return false;" href="my_work.php">
                        <h4>โปรโมชั่น</h4>
                    </a>
                <?php
                }
                ?>

                <a class="btn btn-primary mb-4 me-2" href="add_book.php" role="button">
                    <h4>+เพิ่มผลงาน</h4>
                </a>

                <a class="btn btn-warning mb-4 me-2" href="report_bestselling_book.php" role="button">
                    <h4>ดูรายงาน</h4>
                </a>

                <a class="btn btn-info mb-4 me-2" href="dash_board.php" role="button">
                    <h4>แดชบอร์ด</h4>
                </a>

            </div>
        </div>

        <div class="mb-3">
            <a href="dash_board.php"><button type="button" class="btn btn-outline-success">หนังสือขายดีเลือกตามช่วงเวลา</button></a>
            <a href="dash_board2.php"><button type="button" class="btn btn-success">หนังสือแต่ละเล่มขายดีในช่วงไหน</button></a>
        </div>

        <?php

        if (isset($_SESSION['cusid'])) {
            $cusid = $_SESSION['cusid'];

            $sqlpub = "select pub_id from publisher inner join customer on cus_id = pub_cusid
            where pub_cusid = '$cusid'";

            $ex_pub = connectdb()->query($sqlpub);
            if ($ex_pub->num_rows > 0) {
                $row = $ex_pub->fetch_assoc();
                $pubid = $row['pub_id'];


                $col = "recd_bookid,DATE_FORMAT(rec_date, '%Y-%m-%d') as new_date, book_name,
                count(recd_bookid) as total_quantity";
                $table = "book
                INNER JOIN receipt_detail ON book.book_id = receipt_detail.recd_bookid
                INNER JOIN receipt ON receipt.rec_id = receipt_detail.recd_recid
                INNER JOIN publisher ON publisher.pub_id = book.book_pubid
                INNER JOIN customer ON customer.cus_id = publisher.pub_cusid";
                $where = "pub_id = '$pubid' AND YEAR(rec_date) = YEAR(CURRENT_DATE) AND rec_date <= CURRENT_DATE
                GROUP BY recd_bookid
                ORDER BY rec_date ASC";
                $sqlbook = select_where($col, $table, $where);

                // สร้าง arrays สำหรับเก็บข้อมูลที่ดึงมาจากฐานข้อมูล
                $book_names = array();
                $sales = array();
                $date = array();

                if ($sqlbook->num_rows > 0) {

                    while ($row = $sqlbook->fetch_assoc()) {


                        array_push($book_names, $row["book_name"]);
                        array_push($sales, $row['total_quantity']);
                        array_push($date, $row['new_date']);
                    }
                } else {
                    echo "ไม่พบข้อมูล";
                }
            }
            connectdb()->close();
        }
        ?>

        <!-- สร้างกราฟแท่งด้วย canvas -->
        <canvas id="myChart"></canvas>

        <script>
            // Sample data for demonstration purposes
            var bookNames = <?php echo json_encode($book_names); ?>;
            var salesData = <?php echo json_encode($sales); ?>;
            var date = <?php echo json_encode($date); ?>;
            var datasets = []; // Array to store datasets

            // Define an array of dynamic colors
            var dynamicColors = function() {
                var r = Math.floor(Math.random() * 255);
                var g = Math.floor(Math.random() * 255);
                var b = Math.floor(Math.random() * 255);
                return "rgba(" + r + "," + g + "," + b + ", 0.2)";
            };

            // Loop through book names to create datasets
            for (var i = 0; i < bookNames.length; i++) {
                var dataset = {
                    label: bookNames[i],
                    data: [], // Array to store sales data for the current book
                    backgroundColor: dynamicColors(), // Use dynamicColors function for dynamic color
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                };

                // Loop through sales data to extract sales values for the current book
                for (var j = 0; j < salesData.length; j++) {
                    dataset.data.push(salesData[j][i]); // Assuming the sales amount is stored in the 'amount' property
                }

                // Add the dataset to the array
                datasets.push(dataset);
            }

            // Create the chart
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($date); ?>,
                    datasets: datasets // Assign dynamically generated datasets
                },
                options: {
                    plugins: {
                        datalabels: {
                            anchor: 'end',
                            align: 'top',
                            formatter: Math.round // You can customize the formatter function as per your requirement
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'วันที่ขาย'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'จำนวนขาย'
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    </div>
</body>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</html>