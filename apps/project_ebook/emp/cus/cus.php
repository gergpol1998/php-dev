<?php
include("../func.php");
conn();
session_start();

if (!isset($_SESSION["ID"])) {
    header("location:../login.php");
}
$pos = $_SESSION['POS'];
$per = mysqli_fetch_array(selectWhere('count(*) as permis', 'pos_per', "pp_posid='$pos' and pp_perid='PER-002'"));
$permis = $per['permis'];
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
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Customer Manage</h2>
            </div>

            <!-- Icon Divider-->
            <div class="divider-custom">

                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>

            <div style="text-align:right">
                <form action="cus.php" method="post">
                    <input type="text" name="search" placeholder="id or username">
                    <input type="submit" name="submit" value="Search">
                </form>

            </div>
        </div>
    </section>
    <?php
    $itemsPerPage = 20; // จำนวนรายการต่อหน้า
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1; // หน้าที่กำลังแสดงอยู่

    if (isset($_POST['submit'])) {
        $search = $_POST['search'];
        $whereClause = "(upper(cus_id) like upper('$search%') or upper(cus_uname) like upper('$search%'))";
    } else {
        $whereClause = '1'; // แสดงทุกข้อมูล
    }
    // ดึงจำนวนทั้งหมดของรายการ
    $totalItems = mysqli_num_rows(selectWhere('*', 'customer', $whereClause));

    // คำนวณหน้าทั้งหมด
    $totalPages = ceil($totalItems / $itemsPerPage);

    // กำหนดเริ่มต้นของการแสดงรายการ
    $startItem = ($page - 1) * $itemsPerPage;

    // ดึงข้อมูลลูกค้าตามหน้าที่กำลังแสดง
    $query = "SELECT * FROM customer WHERE $whereClause LIMIT $startItem, $itemsPerPage";
    $result = mysqli_query(conn(), $query);
    ?>
    <div style="text-align: center;">
        <table class="table table-hover">
            <tr>
                <th>ID</th>
                <th>USERNAME</th>
                <th>FULLNAME</th>
                <th>E-MAIL</th>
                <th>COIN</th>
                <th>MANAGE</th>
            </tr>
            <?php
            while ($row = $result->fetch_array()) {
            ?>
                <tr>
                    <td>
                        <?= $row['cus_id'] ?>
                    </td>
                    <td>
                        <?= $row['cus_uname'] ?>
                    </td>
                    <td>
                        <?= $row['cus_name'] ?> <?= $row['cus_lname'] ?>
                    </td>
                   
                    <td>
                        <?= $row['cus_email'] ?>
                    </td>
                    <td>
                        <?= $row['cus_coin'] ?>
                    </td>
                    <td>
                        <?php if ($permis) { ?>
                            <a href="cusView.php?id=<?= $row["cus_id"] ?>" class="btn btn-success">View</a>
                            
                        <?php } ?>

                    </td>
                </tr>
            <?php
            }
            mysqli_close(conn());
            ?>
        </table>
        <!-- แสดงปุ่มหน้า -->
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