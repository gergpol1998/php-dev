<?php
include("../func.php");
conn();
session_start();

if (!isset($_SESSION["ID"])) {
header("location:../login.php");
}

?>
<!DOCTYPE html>
<html>

<head>
  <title>Add Round</title>
  <link href="../css/addpermis.css" rel="stylesheet" />
</head>

<body>
  <a href="finance.php"><img class="img-fluid" src="../assets/img/portfolio/back.png" width="50" /></a>
  <h1>Add Round</h1>
  <form method="post" action="financesetdate.php">
    <label for="Round-name">Number of Round :</label>
    <input type="number" id="Round-name" name="round" required>
    <label for="Round-share">Share (%) </label>
    <input type="number" id="Round-share" name="share" required>
    <button type="submit" name="submit">Next</button>

  </form>
</body>

</html>
