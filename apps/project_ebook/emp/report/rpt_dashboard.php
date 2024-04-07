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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
</head>
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
      <div style="text-align:center">
        <form action="./rpt_dashboard.php" method="post">
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
      <?php
      $i = 0;
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
      $pubname = select(
        "pub_name,COUNT(recd_bookid) as n",
        "receipt_detail INNER JOIN book ON recd_bookid = book_id 
     INNER JOIN publisher ON book_pubid = pub_id 
     INNER JOIN receipt ON rec_id = recd_recid
     WHERE year(rec_date) = $yy
     GROUP BY pub_name ORDER BY COUNT(recd_bookid) DESC limit 10"
      );
      function generateRandomColor()
      {
        $red = rand(0, 255);
        $green = rand(0, 255);
        $blue = rand(0, 255);
        return "rgb($red, $green, $blue)";
      }

      $colors = [];



      foreach ($pubname as $pub) {
        $pn = $pub["pub_name"];
        $n = $pub["n"];
        $lb = array();
        $dt = array();
        $book = select(
          "book_name, count(recd_bookid) as nb",
          "receipt_detail INNER JOIN book ON recd_bookid = book_id 
         INNER JOIN publisher ON book_pubid = pub_id 
         INNER JOIN receipt ON rec_id = recd_recid
         WHERE pub_name = '$pn' and year(rec_date) = $yy
         GROUP BY book_name
         ORDER BY count(recd_bookid) desc"
        );


      ?>
        <h1>อันดับ <?php echo ($i + 1) . " : " . $pn ?> จำนวนหนังสือที่ขายได้ <?php echo $n . " เล่ม"; ?></h1>
        <canvas id='myChart<?= $i ?>' width='200' height='100'></canvas>

        <script>
          var ctx<?= $i ?> = document.getElementById('myChart<?= $i ?>').getContext('2d');
          var myChart<?= $i ?> = new Chart(ctx<?= $i ?>, {
            type: 'bar',
            data: {
              labels: [
                <?php
                foreach ($book as $dt) {
                  echo "'" . $dt['book_name'] . "',";
                  $colors[] = generateRandomColor();
                }
                ?>
              ],
              datasets: [{
                label: 'จำนวนหนังสือ',
                data: [
                  <?php
                  foreach ($book as $dt) {
                    echo "'" . $dt['nb'] . "',";
                  }
                  ?>
                ],
                backgroundColor: <?= json_encode($colors) ?>,
              }]
            },
            options: {
              // Add any additional Chart.js options here
            }
          });
        </script>
      <?php

        $i++;
      }

      ?>









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