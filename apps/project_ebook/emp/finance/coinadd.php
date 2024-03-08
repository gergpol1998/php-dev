<?php
include("../func.php");
conn();
session_start();
/*
if (!isset($_SESSION["NAME"])) {
  header("location:../login.php");
}
*/
?>
<!DOCTYPE html>
<html>

<head>
  <title>Add Coin</title>
  <link href="../css/addpermis.css" rel="stylesheet" />
</head>

<body>
  <a href="coin.php"><img class="img-fluid" src="../assets/img/portfolio/back.png" width="50" /></a>
  <h1>Add Coin</h1>
  <form method="post" action="coinadd.php">


    <label for="coin-name">Amount Coin:</label>
    <input type="text" id="coin-name" name="amount" required><br>

    <button type="submit" name="submit">Add Coin</button>
  </form>
</body>

</html>
<?php
if (isset($_POST['submit'])) {
  
  $id = nextId(" concat('COIN-',nvl(lpad(substr(max(coin_id),6,3)+1,3,'0'),'001'))  ",'coin');
  $amount = $_POST['amount'];
  $data = "'$id',$amount";
   
  if(insert('coin','(coin_id,coin_amount)',$data)){
    echo "<script> alert('บันทึกข้อมูลเรียบร้อย'); </script>";
    echo "<script> window.location = 'coin.php'</script>";
  }




}
?>