<?php
include("../func.php");
conn();
session_start();
$pos = $_SESSION['POS'];
if (!isset($_SESSION["ID"])) {
    header("location:../login.php");
}
$row = mysqli_fetch_array(selectWhere('count(*) as permis', 'pos_per', "pp_posid='$pos' and pp_perid='PER-003'"));
$permis = $row['permis'];
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
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">BOOK Manage</h2>
            </div>

            <!-- Icon Divider-->
            <div class="divider-custom">

                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <div style="text-align:center">
                <a href="book.php" class="btn btn-warning">APPROVED</a>
                <a href="bookpending.php" class="btn btn-success">PENDING</a>

            </div>
        </div>
    </section>

    <div style="text-align: center;">
        <h2>APPROVED</h2>
        <table class="table table-hover">
            <tr>
                <th>ID</th>
                <th>TYPE BOOK NAME</th>
                <th>PUBLISHER</th>
                <th>MANAGE</th>
            </tr>
            <?php
            $itemsPerPage = 20; // จำนวนรายการต่อหน้า
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1; // หน้าที่กำลังแสดงอยู่
            $whereClause = 'book_status = 2'; // แก้ไขเงื่อนไขให้เหมาะสม

            // ดึงจำนวนทั้งหมดของรายการที่ตรงกับเงื่อนไข
            $totalItems = mysqli_num_rows(selectWhere('*', 'book', $whereClause));

            // คำนวณหน้าทั้งหมด
            $totalPages = ceil($totalItems / $itemsPerPage);

            // กำหนดเริ่มต้นของการแสดงรายการ
            $startItem = ($page - 1) * $itemsPerPage;

            // ดึงข้อมูลตามหน้าที่กำลังแสดง
            $query = "SELECT * FROM book, publisher WHERE book_pubid=pub_id and $whereClause LIMIT $startItem, $itemsPerPage";
            $result = mysqli_query(conn(), $query);

            while ($row = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <td><?= $row['book_id'] ?></td>
                    <td><?= $row['book_name'] ?></td>
                    <td><?= $row['pub_name'] ?></td>
                    <td>
                        <a href="bookView.php?id=<?= $row["book_id"] ?>" class="btn btn-primary">View</a>
                    </td>
                </tr>
            <?php
            }
            mysqli_close(conn());
            ?>
        </table>
        <div class="pagination">
            <?php
            $numAdjacentLinks = 2; // จำนวนหน้าที่แสดงที่อยู่รอบหน้าปัจจุบัน
            // แสดงลิงก์หน้าแรก
            if ($page > 1) {
                echo '<a href="?page=1">1</a>';
                if ($page > $numAdjacentLinks + 2) {
                    echo '<span>...</span>';
                }
            }
            // แสดงลิงก์หน้าก่อนหน้าปัจจุบัน
            for ($i = max(1, $page - $numAdjacentLinks); $i < $page; $i++) {
                echo '<a href="?page=' . $i . '">' . $i . '</a>';
            }
            // แสดงหน้าปัจจุบัน
            echo '<a class="active">' . $page . '</a>';
            // แสดงลิงก์หน้าหลังจากปัจจุบัน
            for ($i = $page + 1; $i <= min($page + $numAdjacentLinks, $totalPages); $i++) {
                echo '<a href="?page=' . $i . '">' . $i . '</a>';
            }
            // แสดงเครื่องหมาย ...
            if ($page < $totalPages) {
                if ($page < $totalPages - $numAdjacentLinks - 1) {
                    echo '<span>...</span>';
                }
                echo '<a href="?page=' . $totalPages . '">' . $totalPages . '</a>';
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