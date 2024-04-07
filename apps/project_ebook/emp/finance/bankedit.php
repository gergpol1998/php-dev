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
    <title>Edit Bank</title>
    <link href="../css/addpermis.css" rel="stylesheet" />
</head>

<body>
    <a href="bank.php"><img class="img-fluid" src="../assets/img/portfolio/back.png" width="50" /></a>
    <h1>Edit Bank</h1>
    <form method="post" action="bankedit.php?=<?= $id ?>">
        <?php
        $sql = "select * from bank where bank_id = '$id'";
        $result = mysqli_query(conn(), $sql);
        $row = mysqli_fetch_array($result);
        ?>
        <label for="bank-id">ID Bank:</label>
        <input type="text" id="bank-id" name="bankid" value="<?= $row['bank_id'] ?>" readonly>
        <label for="bank-name">Bank Name:</label>
        <input type="text" id="bank-name" name="bank" value="<?= $row['bank_name'] ?>" required><br>

        <button type="submit" name="submit">Edit bank</button>
    </form>
</body>

</html>
<?php
if (isset($_POST['submit'])) {
    $id = $_POST['bankid'];
    $bank = $_POST['bank'];
    $data = "'$bank'";
    if (update('bank', "bank_name=$data",  "bank_id='$id'")) {
        echo "<script> alert('แก้ไขข้อมูลสำเร็จ'); </script>";
        //echo $sql; 
        echo "<script> window.location = 'bank.php'; </script>";
    }
}
?>