<?php
include("../func.php");
conn();
session_start();
$pos = $_SESSION['POS'];
if (!isset($_SESSION["ID"])) {
    header("location:../login.php");
}
$row = mysqli_fetch_array(selectWhere('count(*) as permis', 'pos_per', "pp_posid='$pos' and pp_perid='PER-005'"));
$permis = $row['permis'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="../css/styles.css" rel="stylesheet" />
    <!-- นำเข้า library Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body id="page-top">

    <!-- Portfolio Section-->
    <section class="page-section portfolio" id="portfolio">
        <div class="container">
            <!-- Portfolio Section Heading-->
            <div text-align="left">
                <a href="../index.php"><img class="img-fluid" src="../assets/img/portfolio/home.png" width="100" /></a>
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">DashBoard</h2>
            </div>

            <!-- Icon Divider-->
            <div class="divider-custom">

                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <form action="rpt_dashboard.php" method="post">
                <div class="mb-3">
                    <div>
                        <label for="start_date" class="form-label">วันที่เริ่มต้น</label>
                        <input type="date" class="form-control" id="start_date" name="start_date">
                    </div>
                    <div>
                        <label for="end_date" class="form-label">วันที่สิ้นสุด</label>
                        <input type="date" class="form-control" id="end_date" name="end_date">
                    </div>
                    <div>
                        <label for="top" class="form-label">จำนวนอันดับ</label>
                        <input type="number" class="form-control" id="top" name="top">

                    </div>

                </div>

                <button type="submit" class="btn btn-primary">ค้นหา</button>
            </form>
            <?php

            if ((isset($_POST['start_date']) && $_POST['start_date'] != null) && isset($_POST['end_date']) && $_POST['end_date'] != null) {
                // รับค่าช่วงเวลาจากฟอร์ม
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                if (isset($_POST['top']) && $_POST['top'] != null) {
                    $top = $_POST['top'];
                } else {
                    $top = '10';
                }
                $sql = selectWhere(
                    "book_pubid,pub_name,COUNT(recd_bookid) as amount",
                    "receipt,receipt_detail,book,publisher",
                    "(rec_id = recd_recid and recd_bookid=book_id and pub_id = book_pubid) 
                                 AND (rec_date BETWEEN '$start_date' AND '$end_date')
                                 group by book_pubid order by amount desc limit $top"
                );
                $pub = array();
                $amount = array();
                if ($sql->num_rows > 0) {

                    while ($row = $sql->fetch_assoc()) {
                        array_push($pub, $row["pub_name"]);
                        array_push($amount, $row['amount']);
                    }
                } else {
                    echo "ไม่พบข้อมูล";
                }
            } else{
                echo "<script>window.alert('กรุณาระบุวันที่')</script>";
            }


            ?>
            <!-- สร้างกราฟแท่งด้วย canvas -->
            <canvas id="myChart"></canvas>

            <script>
                // สร้างกราฟแท่ง
                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($pub); ?>,
                        datasets: [{
                            label: 'จำนวนขาย',
                            data: <?php echo json_encode($amount); ?>,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>

        </div>
    </section>



    </div>

    <!-- Copyright Section-->
    <div class="copyright py-4 text-center text-white">
        <div class="container"><small>Copyright &copy; Your Website 2023</small></div>
    </div>


    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>