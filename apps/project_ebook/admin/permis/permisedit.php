<?php
include("../func.php");
conn();
session_start();
if (!isset($_SESSION["POS"])) {
    header("location:../login.php");
}
$id = $_GET['id'];
//echo $id;
$sql = "select * from permis where per_id = '$id'";
$result = mysqli_query(conn(), $sql);
$row = mysqli_fetch_array($result);


?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Permission</title>
    <link href="../css/addpermis.css" rel="stylesheet" />
</head>

<body>
    <a href="permis.php"><img class="img-fluid" src="../assets/img/portfolio/back.png" width="50" /></a>
    <h1>Edit Permission</h1>
    <form method="post" action="permisedit.php?=<?=$id?>">
    
        <label for="permission-id">ID Permission:</label>
        <input type="text" id="permission-id" name="perid" value="<?= $row['per_id'] ?>" readonly>
        <label for="permission-name">Name Permission:</label>
        <input type="text" id="permission-name" name="pername" value="<?= $row['per_name'] ?>" required><br>

        <button type="submit" name="submit">Edit Permission</button>
    </form>
</body>

</html>
<?php
if (isset($_POST['submit'])) {
    $id = $_POST['perid'];
    $name =$_POST['pername'];
    $data = "'$name'";
    if(update('permis', "per_name=$data",  "per_id='$id'" )){
        echo "<script> alert('แก้ไขข้อมูลสำเร็จ'); </script>";
        //echo $sql; 
       echo "<script> window.location = 'permis.php'; </script>";
    }





}
?>