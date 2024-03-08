<?php
include("../func.php");
conn();
session_start();

$pos = $_SESSION['POS'];
if (!isset($_SESSION["ID"])) {
    header("location:../login.php");
}
$per = mysqli_fetch_array(selectWhere('count(*) as permis', 'pos_per', "pp_posid='$pos' and pp_perid='PER-004'"));
$permis = $per['permis'];

$id = $_GET['id'];
?>
<!DOCTYPE html>
<html>

<head>
  <title>Edit Round</title>
  <link href="../css/addpermis.css" rel="stylesheet" />
</head>

<body>
  <a href="finance.php"><img class="img-fluid" src="../assets/img/portfolio/back.png" width="50" /></a>
  <h1>Edit Round</h1>
  <?php 
  $rou = selectWhere('*', 'round', "round_id='$id'")->fetch_array();
  ?>
  <form method="post" action="financeeditdate.php">
    <label for="Round-name">Number of Round :</label>
    <input type="number" id="Round-num" value="<?= $rou['round_num'] ?>" name="round" required>
    <label for="Round-name">Share (%) :</label>
    <input type="number" id="Round-share" value="<?= $rou['round_rev'] ?>" name="share" required>
    <input type="text" id="Round-name" value="<?= $rou['round_id'] ?>" name="roundid" hidden>
    
    <button type="submit" name="submit">Next</button>

  </form>
</body>

</html>
