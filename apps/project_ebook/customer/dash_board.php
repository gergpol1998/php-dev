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
    <title>dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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
            <a href="dash_board.php"><button type="button" class="btn btn-success">หนังสือขายดีเลือกตามช่วงเวลา</button></a>
            <a href="dash_board2.php"><button type="button" class="btn btn-outline-success">หนังสือแต่ละเล่มขายดีในช่วงไหน</button></a>
        </div>

        <form action="dash_board.php" method="get">
            <div class="mb-3">
                <label for="start_date" class="form-label">วันที่เริ่มต้น</label>
                <input type="date" class="form-control" id="start_date" name="start_date">
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">วันที่สิ้นสุด</label>
                <input type="date" class="form-control" id="end_date" name="end_date">
            </div>
            <button type="submit" class="btn btn-primary">ค้นหา</button>
        </form>
        <?php

        if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
            // รับค่าช่วงเวลาจากฟอร์ม
            $start_date = $_GET['start_date'];
            $end_date = $_GET['end_date'];
            $cusid = $_SESSION['cusid'];

            $sqlpub = "select pub_id from publisher inner join customer on cus_id = pub_cusid
            where pub_cusid = '$cusid'";
            $ex_pub = connectdb()->query($sqlpub);
            if ($ex_pub->num_rows > 0) {
                $row = $ex_pub->fetch_assoc();
                $pubid = $row['pub_id'];

                $col = "recd_bookid,DATE_FORMAT(rec_date, '%Y-%m-%d') as new_date ,book_name,count(recd_bookid) as total_quantity";
                $table = "book
                INNER JOIN receipt_detail ON book.book_id = receipt_detail.recd_bookid
                INNER JOIN receipt ON receipt.rec_id = receipt_detail.recd_recid
                INNER JOIN publisher ON publisher.pub_id = book.book_pubid
                INNER JOIN customer ON customer.cus_id = publisher.pub_cusid";
                $where = "DATE_FORMAT(rec_date, '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date' AND pub_id = '$pubid'
                GROUP BY recd_bookid
                ORDER BY total_quantity DESC";
                $sqlbook = select_where($col, $table, $where);

                // Initialize arrays to store data
                $book_names = array();
                $sales = array();
                $date_sales = array();

                if ($sqlbook->num_rows > 0) {

                    while ($row = $sqlbook->fetch_assoc()) {

                        $book_name = $row["book_name"];
                        $total_quantity = $row['total_quantity'];
                        $new_date = $row['new_date'];

                        // If the date already exists, add the sales to the existing date_sales array
                        if (array_key_exists($new_date, $date_sales)) {
                            $date_sales[$new_date][$book_name] = $total_quantity;
                        } else {
                            // Otherwise, create a new entry in date_sales array
                            $date_sales[$new_date] = array($book_name => $total_quantity);
                        }

                        // Store unique book names
                        if (!in_array($book_name, $book_names)) {
                            $book_names[] = $book_name;
                        }
                    }
                } else {
                    echo "ไม่พบข้อมูล";
                }
            }
            connectdb()->close();
        }
        ?>

        <div>
            <canvas id="myChart" width="800" height="600"></canvas>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            const ctx = document.getElementById('myChart');

            // Convert PHP arrays to JavaScript arrays
            var bookNames = <?php echo json_encode($book_names); ?>;
            var dateSales = <?php echo json_encode($date_sales); ?>;

            // Prepare datasets for Chart.js
            var datasets = [];
            for (var i = 0; i < bookNames.length; i++) {
                var salesData = [];

                // Iterate over dateSales to populate salesData for each book
                for (var date in dateSales) {
                    if (dateSales.hasOwnProperty(date)) {
                        var sales = dateSales[date][bookNames[i]] || 0;
                        salesData.push(sales);
                    }
                }

                datasets.push({
                    label: bookNames[i],
                    data: salesData,
                    borderWidth: 1
                });
            }

            // Create the Chart.js chart
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: bookNames, // Change this line to use bookNames array
                    datasets: datasets
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
                                text: 'หนังสือ' // Change the x-axis title to 'ชื่อหนังสือ' (Book Name)
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'จำนวน'
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
