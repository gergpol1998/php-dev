<?php
include("../func.php");
conn();
session_start();
$pos = $_SESSION['POS'];
if (!isset($_SESSION["ID"])) {
    header("location:../login.php");
}
$date = $_GET['date'];
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
echo '
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
    
</head>';
$sql = selectWhere("*", 'income', "date_format(inc_month,'%Y-%m') = DATE_FORMAT(CURDATE(),'$date')");
//show ในหน้า pdf
$tableh1 = "
<h3>วันที่พิมพ์รายงาน " . date("d/m/Y") . "</h3>
<h2 style='text-align:center'>Report Expense</h2>
<h2 style='text-align:center'>DATE : $date</h2>
<table id='bg-table' width='100%' style='border-collapse: collapse;font-size:12pt;margin-top:8px;'>
    <thead>
        <tr style='border:1px solid #000;padding:4px;'>
            <td  style='border-right:1px solid #000;padding:4px;text-align:center;'   width='10%'>ID</td>
            <td  style='border-right:1px solid #000;padding:4px;text-align:center;'  width='15%'>CUSTOMER</td>
            <td  style='border-right:1px solid #000;padding:4px;text-align:center;'  width='15%'>AMOUNT</td>
            <td  style='border-right:1px solid #000;padding:4px;text-align:center;' width='15%'>DATE</td> 
        </tr>

    </thead>
<tbody>";
/*
//show ในหน้าเว็บ
echo "<h2 style='text-align:center'>Report Expense</h2>
<h2 style='text-align:center'>DATE : $date</h2>
<table id='bg-table' width='100%' style='border-collapse: collapse;font-size:12pt;margin-top:8px;'>
    <thead>
        <tr style='border:1px solid #000;padding:4px;'>
            <td  style='border-right:1px solid #000;padding:4px;text-align:center;'   width='10%'>ID</td>
            <td  style='border-right:1px solid #000;padding:4px;text-align:center;'  width='15%'>PUBLISHER</td>
            <td  style='border-right:1px solid #000;padding:4px;text-align:center;'  width='15%'>AMOUNT</td>
            <td  style='border-right:1px solid #000;padding:4px;text-align:center;' width='15%'>DATE</td>
            
        </tr>

    </thead>
<tbody>";
*/
$total = 0;
$tablebody = '<tr></tr>';
$tablebody2 = '<tr></tr>';
while ($row = $sql->fetch_assoc()) {
    $formattedAmount = number_format($row['inc_amount'], 0, '.', ',');
    //show ในหน้า pdf
    $tablebody .= '
    <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:3px;text-align:center;"  >' . $row['inc_id'] . '</td>
        <td style="border-right:1px solid #000;padding:3px;text-align:center;">' . $row['inc_pubid'] . '</td>
        <td style="border-right:1px solid #000;padding:3px;text-align:center;">' . $formattedAmount . '</td>
        <td style="border-right:1px solid #000;padding:3px;text-align:center;">' . $row['inc_month'] . '</td>     
    </tr>';
    $total += $row['top_amount'];

/*
    //show ในหน้าเว็บ
    echo '
    <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:3px;text-align:center;"  >' . $row['inc_id'] . '</td>
        <td style="border-right:1px solid #000;padding:3px;text-align:center;">' . $row['inc_pubid'] . '</td>
        <td style="border-right:1px solid #000;padding:3px;text-align:center;">' . $row['inc_amount'] . '</td>
        <td style="border-right:1px solid #000;padding:3px;text-align:center;">' . $row['inc_month'] . '</td> 
    </tr>';
*/
}

//ปิด tag
$tableend1 = "</tbody></table>";
$totalDisplay = "<div style='margin-top: 10px; font-size: 12pt; text-align: right;'>
    <strong>Total Amount: " . $total . "</strong>
</div>";
$mpdf->WriteHTML($tableh1);
$mpdf->WriteHTML($tablebody);
$mpdf->WriteHTML($tablebody2);
$mpdf->WriteHTML($tableend1);
$mpdf->WriteHTML($totalDisplay);
$mpdf->Output("rpt_expense.pdf");
echo "<script>window.location = 'rpt_expense.pdf'</script>";
//echo '<a class="btn btn-success mb-4" href="MyReport.pdf" role="button">โหลดรายงาน</a>';
