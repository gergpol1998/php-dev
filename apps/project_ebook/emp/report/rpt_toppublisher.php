<?php
ini_set('pcre.backtrack_limit', 2000000);
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("../func.php");
conn();
session_start();
$pos = $_SESSION['POS'];
if (!isset($_SESSION["ID"])) {
    header("location:../login.php");
}

require_once __DIR__ . '../../../customer/vendor/autoload.php';

$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'margin_left' => 15,
    'margin_right' => 15,
    'margin_top' => 16,
    'margin_bottom' => 16,
    'margin_header' => 9,
    'margin_footer' => 9,
    'mirrorMargins' => true,

    'fontDir' => array_merge($fontDirs, [
        __DIR__ . 'vendor/mpdf/mpdf/custom/font/directory',
    ]),
    'fontdata' => $fontData + [
        'thsarabun' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabunNew Bold.ttf',
            'U' => 'THSarabunNew BoldItalic.ttf'
        ]
    ],
    'default_font' => 'thsarabun',
    'defaultPageNumStyle' => 1
]);
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
</head>

<body id="page-top">
    <!-- Portfolio Section-->
    <section class="page-section portfolio" id="portfolio">
        <div class="container">
            <!-- Portfolio Section Heading-->
            <div text-align="left">
                <a href="../index.php"><img class="img-fluid" src="../assets/img/portfolio/home.png" width="100" /></a>
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">TOP PUBLISHER</h2>
            </div>

            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <div style="text-align:center">
                <form action="./rpt_toppublisher.php" method="post">
                    <?php
                    $years = [];
                    for ($i = 2030; $i >= 2015; $i--) {
                        $years[] = $i;
                    }
                    ?>
                    <select name="year">
                        <option value="">เลือกปี</option>
                        <?php foreach ($years as $year) : ?>
                            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="submit" name="submit1" value="ค้นหา" class="btn btn-primary">
                </form>

            </div>
            <div style="text-align:right">
                <form action="./rpt_toppublisher.php" method="post">
                    <input type="submit" name="submit2" value="โหลดรายงาน" class="btn btn-primary">
                </form>

            </div>

        </div>
    </section>
    <?php
    // จำกัดจำนวน pub_name ที่แสดงต่อหน้า
    $limit = 10;
    if (isset($_POST['submit1'])) {
        if ($_POST['year'] != null) {
            $_SESSION['yy'] = $_POST['year'];
        } else {
            $_SESSION['yy'] = 'year(now())';
        }
    } else {
        $_SESSION['yy'] = 'year(now())';
    }
    $yy = $_SESSION['yy'];
    $npub = select(
        "COUNT(DISTINCT pub_name) AS total_pub",
        "receipt_detail INNER JOIN book ON recd_bookid = book_id 
	INNER JOIN receipt ON rec_id = recd_recid
    INNER JOIN publisher ON book_pubid = pub_id
    WHERE year(rec_date) = $yy "
    );

    // ดึงข้อมูล total pub_name

    $total_row = mysqli_fetch_assoc($npub);
    $total_pub_name = $total_row['total_pub']; // Get total publishers

    // คำนวณจำนวนหน้าทั้งหมด
    $total_pages = ceil($total_pub_name / $limit);

    // ตรวจสอบ GET parameter
    if (isset($_GET["page"])) {
        $page = $_GET["page"]; // ดึงหมายเลขหน้า
    } else {
        $page = 1; // ตั้งค่าเริ่มต้น
    }


    $pub_nbook = select(
        "pub_name, COUNT(recd_bookid) AS nbook",
        "receipt_detail INNER JOIN book ON recd_bookid = book_id 
            INNER JOIN receipt ON rec_id = recd_recid
            INNER JOIN publisher ON book_pubid = pub_id
            WHERE year(rec_date) = $yy
      GROUP BY pub_name ORDER BY COUNT(recd_bookid) DESC 
      LIMIT " . ($page - 1) * $limit . ", " . $limit
    );



    ?>


    <div class="container">
        <?php
        // วนลูปแสดงข้อมูล pub_name 
        while ($row = mysqli_fetch_array($pub_nbook)) {

        ?>
            <h2><?php echo $row['pub_name'] . ' ขายได้ ' . $row['nbook'] . ' เล่ม' ?></h2>
            <?php

            $pub_name = $row['pub_name'];

            // ดึงข้อมูล book ของ pub_name นั้น

            $book = select(
                "book_name,sum(m1)+sum(m2)+sum(m3)+sum(m4)+sum(m5)+sum(m6)+sum(m7)+sum(m8)+sum(m9)+sum(m10)+sum(m11)+sum(m12) as sum_m
                    ,sum(m1)as m1,sum(m2)as m2,sum(m3)as m3,sum(m4)as m4,sum(m5)as m5,sum(m6)as m6
                    ,sum(m7)as m7,sum(m8)as m8,sum(m9)as m9,sum(m10)as m10,sum(m11)as m11,sum(m12)as m12",
                "(
                        SELECT book_name
                            ,case when month(rec_date) = 1 then count(recd_bookid) else 0 end as m1
                            ,case when month(rec_date) = 2 then count(recd_bookid) else 0 end as m2
                            ,case when month(rec_date) = 3 then count(recd_bookid) else 0 end as m3
                            ,case when month(rec_date) = 4 then count(recd_bookid) else 0 end as m4
                            ,case when month(rec_date) = 5 then count(recd_bookid) else 0 end as m5
                            ,case when month(rec_date) = 6 then count(recd_bookid) else 0 end as m6
                            ,case when month(rec_date) = 7 then count(recd_bookid) else 0 end as m7
                            ,case when month(rec_date) = 8 then count(recd_bookid) else 0 end as m8
                            ,case when month(rec_date) = 9 then count(recd_bookid) else 0 end as m9
                            ,case when month(rec_date) = 10 then count(recd_bookid) else 0 end as m10
                            ,case when month(rec_date) = 11 then count(recd_bookid) else 0 end as m11
                            ,case when month(rec_date) = 12 then count(recd_bookid) else 0 end as m12
                        FROM receipt 
                        INNER JOIN receipt_detail on rec_id = recd_recid
                        INNER JOIN book on recd_bookid = book_id
                        INNER JOIN publisher on book_pubid = pub_id 
                        where pub_name ='$pub_name' and year(rec_date) = $yy
                        group by book_name,month(rec_date)
                        )as t1
                        group by book_name"
            );



            ?>
            <table class="table table-hover">
                <tr>
                    <th>Book Name</th>
                    <th>All Sale</th>
                    <th>Jan.</th>
                    <th>Feb.</th>
                    <th>Mar.</th>
                    <th>Apr.</th>
                    <th>May</th>
                    <th>Jun.</th>
                    <th>Jul..</th>
                    <th>Aug.</th>
                    <th>Sep.</th>
                    <th>Oct.</th>
                    <th>Nov.</th>
                    <th>Dec.</th>

                </tr>
                <?php

                // วนลูปแสดงข้อมูล book
                while ($nbook = mysqli_fetch_array($book)) {

                ?>
                    <tr>
                        <td>
                            <?= $nbook['book_name'] ?>
                        </td>
                        <td>
                            <?= $nbook['sum_m'] ?>
                        </td>
                        <td>
                            <?= $nbook['m1'] ?>
                        </td>
                        <td>
                            <?= $nbook['m2'] ?>
                        </td>
                        <td>
                            <?= $nbook['m3'] ?>
                        </td>
                        <td>
                            <?= $nbook['m4'] ?>
                        </td>
                        <td>
                            <?= $nbook['m5'] ?>
                        </td>
                        <td>
                            <?= $nbook['m6'] ?>
                        </td>
                        <td>
                            <?= $nbook['m7'] ?>
                        </td>
                        <td>
                            <?= $nbook['m8'] ?>
                        </td>
                        <td>
                            <?= $nbook['m9'] ?>
                        </td>
                        <td>
                            <?= $nbook['m10'] ?>
                        </td>
                        <td>
                            <?= $nbook['m11'] ?>
                        </td>
                        <td>
                            <?= $nbook['m12'] ?>
                        </td>
                    </tr>

                <?php
                }
                ?>
            </table>

        <?php
        }

        // แสดง pagination 
        for ($i = 1; $i <= $total_pages; $i++) {

        ?>
            <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php
        }
        ?>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".pagination a").click(function(e) {
                e.preventDefault(); // หยุดการโหลดหน้าใหม่
                var page = $(this).attr("href").split("=")[1]; // ดึงหมายเลขหน้า
                // โหลดข้อมูลใหม่
                $.ajax({
                    url: "report_toppublisher.php",
                    data: {
                        page: page
                    },
                    success: function(data) {
                        // แทนที่เนื้อหาใน div ด้วยข้อมูลใหม่
                        $("#content").html(data);
                    }
                });
            });
        });
    </script>

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
if (isset($_POST['submit2'])) {
    ini_set('max_execution_time', 600);
    $date = today();

    $pub_nbook = select(
        "pub_name, COUNT(recd_bookid) AS nbook",
        "receipt_detail INNER JOIN book ON recd_bookid = book_id 
            INNER JOIN receipt ON rec_id = recd_recid
            INNER JOIN publisher ON book_pubid = pub_id
            WHERE year(rec_date) = $yy
      GROUP BY pub_name ORDER BY COUNT(recd_bookid) DESC 
      LIMIT " . ($page - 1) * $limit . ", " . $limit
    );


    // เตรียมข้อมูลสำหรับสร้าง PDF
    //$mpdf = new mPDF('utf-8', 'A4', '', '', 10, 10, 10, 10);
    $mpdf->SetHTMLHeader("<div><h1 style='text-align:center'>รายงานผู้เผยแพร่ขายดี</h1><br>");
    $mpdf->SetHTMLFooter('หน้า {PAGENO}/{nb}');

    $tableh1 = '<style>
  table {
    border-collapse: collapse;
    width: 100%;
  }

  th, td {
    border: 1px solid black;
    padding: 5px;
  }

  th {
    text-align: center;
  }
  </style>';

    $tablebody = '<br><table class="table table-hover">';
    $tablebody .= '<tr><th>ลำดับ</th><th>ผู้เผยแพร่</th><th>จำนวนหนังสือที่ขายได้</th></tr>';

    $i = 1;
    while ($row = mysqli_fetch_array($pub_nbook)) {
        $pub_name = $row['pub_name'];

        $tablebody .= '<tr>';
        $tablebody .= '<td>' . $i . '</td>';
        $tablebody .= '<td>' . $row['pub_name'] . '</td>';
        $tablebody .= '<td>' . $row['nbook'] . '</td>';
        $tablebody .= '</tr>';

        // รายการหนังสือ
        if (isset($_SESSION['yy'])) {
            $yy = $_SESSION['yy'];
            $book = select(
                "book_name,sum(m1)+sum(m2)+sum(m3)+sum(m4)+sum(m5)+sum(m6)+sum(m7)+sum(m8)+sum(m9)+sum(m10)+sum(m11)+sum(m12) as sum_m
                ,sum(m1)as m1,sum(m2)as m2,sum(m3)as m3,sum(m4)as m4,sum(m5)as m5,sum(m6)as m6
                ,sum(m7)as m7,sum(m8)as m8,sum(m9)as m9,sum(m10)as m10,sum(m11)as m11,sum(m12)as m12",
                "(
                    SELECT book_name
                        ,case when month(rec_date) = 1 then count(recd_bookid) else 0 end as m1
                        ,case when month(rec_date) = 2 then count(recd_bookid) else 0 end as m2
                        ,case when month(rec_date) = 3 then count(recd_bookid) else 0 end as m3
                        ,case when month(rec_date) = 4 then count(recd_bookid) else 0 end as m4
                        ,case when month(rec_date) = 5 then count(recd_bookid) else 0 end as m5
                        ,case when month(rec_date) = 6 then count(recd_bookid) else 0 end as m6
                        ,case when month(rec_date) = 7 then count(recd_bookid) else 0 end as m7
                        ,case when month(rec_date) = 8 then count(recd_bookid) else 0 end as m8
                        ,case when month(rec_date) = 9 then count(recd_bookid) else 0 end as m9
                        ,case when month(rec_date) = 10 then count(recd_bookid) else 0 end as m10
                        ,case when month(rec_date) = 11 then count(recd_bookid) else 0 end as m11
                        ,case when month(rec_date) = 12 then count(recd_bookid) else 0 end as m12
                    FROM receipt 
                    INNER JOIN receipt_detail on rec_id = recd_recid
                    INNER JOIN book on recd_bookid = book_id
                    INNER JOIN publisher on book_pubid = pub_id 
                    where pub_name ='$pub_name' and year(rec_date) = $yy
                    group by book_name,month(rec_date)
                    )as t1
                    group by book_name"
            );
        } else {
            $book = select(
                "book_name,sum(m1)+sum(m2)+sum(m3)+sum(m4)+sum(m5)+sum(m6)+sum(m7)+sum(m8)+sum(m9)+sum(m10)+sum(m11)+sum(m12) as sum_m
                ,sum(m1)as m1,sum(m2)as m2,sum(m3)as m3,sum(m4)as m4,sum(m5)as m5,sum(m6)as m6
                ,sum(m7)as m7,sum(m8)as m8,sum(m9)as m9,sum(m10)as m10,sum(m11)as m11,sum(m12)as m12",
                "(
                    SELECT book_name
                        ,case when month(rec_date) = 1 then count(recd_bookid) else 0 end as m1
                        ,case when month(rec_date) = 2 then count(recd_bookid) else 0 end as m2
                        ,case when month(rec_date) = 3 then count(recd_bookid) else 0 end as m3
                        ,case when month(rec_date) = 4 then count(recd_bookid) else 0 end as m4
                        ,case when month(rec_date) = 5 then count(recd_bookid) else 0 end as m5
                        ,case when month(rec_date) = 6 then count(recd_bookid) else 0 end as m6
                        ,case when month(rec_date) = 7 then count(recd_bookid) else 0 end as m7
                        ,case when month(rec_date) = 8 then count(recd_bookid) else 0 end as m8
                        ,case when month(rec_date) = 9 then count(recd_bookid) else 0 end as m9
                        ,case when month(rec_date) = 10 then count(recd_bookid) else 0 end as m10
                        ,case when month(rec_date) = 11 then count(recd_bookid) else 0 end as m11
                        ,case when month(rec_date) = 12 then count(recd_bookid) else 0 end as m12
                    FROM receipt 
                    INNER JOIN receipt_detail on rec_id = recd_recid
                    INNER JOIN book on recd_bookid = book_id
                    INNER JOIN publisher on book_pubid = pub_id 
                    where pub_name ='$pub_name' and year(rec_date) = year(now())
                    group by book_name,month(rec_date)
                    )as t1
                    group by book_name"
            );
        }

        $tablebody .= '<tr><td colspan="3">';
        $tablebody .= '<table class="table table-bordered">';
        $tablebody .= '<tr>
                            <th>Book Name</th>
                            <th>All Sale</th>
                            <th>Jan.</th>
                            <th>Feb.</th>
                            <th>Mar.</th>
                            <th>Apr.</th>
                            <th>May</th>
                            <th>Jun.</th>
                            <th>Jul..</th>
                            <th>Aug.</th>
                            <th>Sep.</th>
                            <th>Oct.</th>
                            <th>Nov.</th>
                            <th>Dec.</th>
                        </tr>';

        while ($nbook = mysqli_fetch_array($book)) {
            $tablebody .= '<tr>';
            $tablebody .= '<td>' . $nbook['book_name'] . '</td>';
            $tablebody .= '<td>' . $nbook['sum_m'] . '</td>';
            $tablebody .= '<td>' . $nbook['m1'] . '</td>';
            $tablebody .= '<td>' . $nbook['m2'] . '</td>';
            $tablebody .= '<td>' . $nbook['m3'] . '</td>';
            $tablebody .= '<td>' . $nbook['m4'] . '</td>';
            $tablebody .= '<td>' . $nbook['m5'] . '</td>';
            $tablebody .= '<td>' . $nbook['m6'] . '</td>';
            $tablebody .= '<td>' . $nbook['m7'] . '</td>';
            $tablebody .= '<td>' . $nbook['m8'] . '</td>';
            $tablebody .= '<td>' . $nbook['m9'] . '</td>';
            $tablebody .= '<td>' . $nbook['m10'] . '</td>';
            $tablebody .= '<td>' . $nbook['m11'] . '</td>';
            $tablebody .= '<td>' . $nbook['m12'] . '</td>';
            $tablebody .= '</tr>';
        }

        $tablebody .= '</table>';
        $tablebody .= '</td></tr>';

        $i++;
    }

    $tableend1 = '</table>';

    // เขียนเนื้อหา HTML ลงใน PDF
    $mpdf->WriteHTML($tableh1);
    $mpdf->WriteHTML($tablebody);
    $mpdf->WriteHTML($tableend1);

    // บันทึกไฟล์ PDF
    $mpdf->Output("rpt_toppublisher.pdf");

    // แสดง PDF บนหน้าเว็บ
    echo "<script>window.open('rpt_toppublisher.pdf', '_blank');</script>";
}

?>