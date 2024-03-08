<?php
include("../func.php");
conn();
session_start();
if (!isset($_SESSION["POS"])) {
    header("location:../login.php");
}
$id = $_GET['id'];
//echo $id;



?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Coin</title>
    <link href="../css/addpermis.css" rel="stylesheet" />
</head>

<body>
    <a href="coin.php"><img class="img-fluid" src="../assets/img/portfolio/back.png" width="50" /></a>
    <h1>Edit Coin</h1>
    <form method="post" action="coinedit.php?=<?= $id ?>">
        <?php
        $sql = "select * from coin where coin_id = '$id'";
        $result = mysqli_query(conn(), $sql);
        $row = mysqli_fetch_array($result);
        ?>
        <label for="coin-id">ID Coin:</label>
        <input type="text" id="coin-id" name="coinid" value="<?= $row['coin_id'] ?>" readonly>
        <label for="coin-name">Amount Coin:</label>
        <input type="text" id="coin-name" name="amount" value="<?= $row['coin_amount'] ?>" required><br>

        <button type="submit" name="submit">Edit coin</button>
    </form>
</body>

</html>
<?php
if (isset($_POST['submit'])) {
    $id = $_POST['coinid'];
    $amount = $_POST['amount'];
    $data = "$amount";
    if (update('coin', "coin_amount=$data",  "coin_id='$id'")) {
        echo "<script> alert('แก้ไขข้อมูลสำเร็จ'); </script>";
        //echo $sql; 
        echo "<script> window.location = 'coin.php'; </script>";
    }
}
?>