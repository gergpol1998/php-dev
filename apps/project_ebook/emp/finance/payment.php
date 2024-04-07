<?php
include("../func.php");
conn();
session_start();
error_reporting(0);
$pos = $_SESSION['POS'];
if (!isset($_SESSION["ID"])) {
    header("location:../login.php");
}
$row = mysqli_fetch_array(selectWhere('count(*) as permis', 'pos_per', "pp_posid='$pos' and pp_perid='PER-004'"));
$permis = $row['permis'];
$ro = $_GET['rou'];
$currentPath = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            display: inline-block;
            margin: 0 5px;
            padding: 10px 15px;
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            color: #333;
            text-decoration: none;
            border-radius: 3px;
            transition: background-color 0.3s, color 0.3s;
        }

        .pagination a:hover {
            background-color: #ddd;
            color: #007bff;
        }

        .pagination a.active {
            background-color: #007bff;
            border: 1px solid #007bff;
            color: #fff;
        }

        .pagination span {
            display: inline-block;
            margin: 0 5px;
            padding: 10px 15px;
            color: #333;
        }
    </style>

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
</head>

<body id="page-top">

    <!-- Portfolio Section-->
    <section class="page-section portfolio" id="portfolio">
        <div class="container">
            <!-- Portfolio Section Heading-->
            <div text-align="left">
                <a href="../index.php"><img class="img-fluid" src="../assets/img/portfolio/home.png" width="100" /></a>
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Payment Manage</h2>
            </div>

            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <?php
            $r = select('*', 'round');
            
            ?>
            <div style="text-align:center">
                <?php while ($rou = $r->fetch_assoc()) { ?>
                    <a href="payment.php?rou=<?= $rou['round_id'] ?>" name='rou' class="btn btn-success"><?= $rou['round_id'] ?></a>
                <?php } ?>
            </div>
        </div>
    </section>
    <div style="text-align: center;">
        <h2><?= $ro?></h2>
        <h5>DATE : <?= today()?></h5>
        <?php if ($permis){ ?>
            <a href="insertIncome.php?rou=<?= $ro ?>&p=<?= $currentPath ?>" class="btn btn-danger" style="float: right;">PayAll</a>
        <?php } ?>
        <table class="table table-hover">
            <tr>
                <th>ID</th>
                <th>PUBLISHER</th>
                <th>ROU</th>
                <th>INCOME</th>
                <th>MANAGE</th>
            </tr>
            <?php
            $itemsPerPage = 20; // จำนวนรายการต่อหน้า
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1; // หน้าที่กำลังแสดงอยู่
            $whereClause = "(rec_id=recd_recid and recd_bookid=book_id and book_pubid=pub_id)  AND (pub_round='$ro') AND
                            (rec_date BETWEEN pub_dinc and NOW())"; // แก้ไขเงื่อนไขให้เหมาะสม
            $totalItems = mysqli_num_rows(selectWhere('DISTINCT(pub_id)', 'receipt,receipt_detail,book,publisher', $whereClause)); // ดึงจำนวนทั้งหมดของรายการที่ตรงกับเงื่อนไข
            $totalPages = ceil($totalItems / $itemsPerPage); // คำนวณหน้าทั้งหมด
            $startItem = ($page - 1) * $itemsPerPage; // กำหนดเริ่มต้นของการแสดงรายการ

            $td = mysqli_query(conn(),"SELECT DATE_FORMAT(CURDATE(),'%d') as d")->fetch_assoc();
            $t = $td['d'];
            $dd = selectWhere("*",'date',"date_roundid='$ro' and date_date=$t")->fetch_assoc();
            $dd['date_date'];
            $rou = selectWhere('*','round',"round_id='$ro'")->fetch_assoc();

            $query = "SELECT pub_id,pub_name,pub_round,sum(recd_price) as pub_income
            FROM receipt,receipt_detail,book,publisher
            WHERE (rec_id=recd_recid and recd_bookid=book_id and book_pubid=pub_id)  AND
                    (rec_date BETWEEN pub_dinc and NOW()) AND (pub_round='$ro') AND (pub_instatus=0)
            GROUP BY pub_id  LIMIT $startItem, $itemsPerPage"; // ดึงข้อมูลตามหน้าที่กำลังแสดง
            $result = mysqli_query(conn(), $query);
            if($t==$dd['date_date']){
            while ($row = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <td><?= $row['pub_id'] ?></td>
                    <td><?= $row['pub_name'] ?></td>
                    <td><?= $row['pub_round']?></td>
                    <td><?= $row['pub_income'] ?>*<?= $rou['round_rev'] ?>% = <?= $row['pub_income']*($rou['round_rev']/100) ?></td>
                    <?php 
                        $id = $row['pub_id'];
                        $inc = $row['pub_income']*($rou['round_rev']/100);
                    ?>
                    <td>
                    <?php if ($permis){ ?>
                        <a href="insertIncome.php?id=<?=$id?>&inc=<?=$inc?>&p=<?=$currentPath?>" class="btn btn-primary">Pay</a>
                    <?php } ?>    
                    </td>
                </tr>
            <?php
            }}
            mysqli_close(conn());
            ?>
        </table>
        <div class="pagination">
            <?php
            $numAdjacentLinks = 2; // จำนวนหน้าที่แสดงที่อยู่รอบหน้าปัจจุบัน
            // แสดงลิงก์หน้าแรก
            if ($page > 1) {
                echo "<a href='?page=1&rou=$ro'>1</a>";
                if ($page > $numAdjacentLinks + 2) {
                    echo '<span>...</span>';
                }
            }
            // แสดงลิงก์หน้าก่อนหน้าปัจจุบัน
            for ($i = max(1, $page - $numAdjacentLinks); $i < $page; $i++) {
                echo "<a href='?page=" . $i . "&rou=$ro'>" . $i . '</a>';
            }
            // แสดงหน้าปัจจุบัน
            echo '<a class="active">' . $page . '</a>';
            // แสดงลิงก์หน้าหลังจากปัจจุบัน
            for ($i = $page + 1; $i <= min($page + $numAdjacentLinks, $totalPages); $i++) {
                echo "<a href='?page=" . $i . "&rou=$ro'>" . $i . '</a>';
            }
            // แสดงเครื่องหมาย ...
            if ($page < $totalPages) {
                if ($page < $totalPages - $numAdjacentLinks - 1) {
                    echo '<span>...</span>';
                }
                echo "<a href='?page=" . $totalPages . "&rou=$ro'>" . $totalPages . '</a>';
            }
            ?>
        </div>
    </div>

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
<?php 

?>