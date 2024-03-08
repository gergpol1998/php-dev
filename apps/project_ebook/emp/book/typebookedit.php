<?php
include("../func.php");
conn();
session_start();
if (!isset($_SESSION["POS"])) {
    header("location:../login.php");
}
$id = $_GET['id'];
//echo $id;
$sql = "select * from typebook where type_id = '$id'";
$result = mysqli_query(conn(), $sql);
$row = mysqli_fetch_array($result);


?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit TYPE BOOK</title>
    <link href="../css/addpermis.css" rel="stylesheet" />
</head>

<body>
    <a href="typebook.php"><img class="img-fluid" src="../assets/img/portfolio/back.png" width="50" /></a>
    <h1>Edit Type Book</h1>
    <form method="post" action="typebookedit.php?=<?=$id?>">
    
        <label for="permission-id">ID Type Book:</label>
        <input type="text" id="permission-id" name="typeid" value="<?= $row['type_id'] ?>" readonly>
        <label for="permission-name">Name Type Book:</label>
        <input type="text" id="permission-name" name="typename" value="<?= $row['type_name'] ?>" required><br>

        <button type="submit" name="submit">Edit Name Type Book</button>
    </form>
</body>

</html>
<?php
if (isset($_POST['submit'])) {
    $id = $_POST['typeid'];
    $name =$_POST['typename'];
    $data = "'$name'";
    if(update('typebook', "type_name=$data",  "type_id='$id'" )){
        echo "<script> alert('แก้ไขข้อมูลสำเร็จ'); </script>";
        //echo $sql; 
       echo "<script> window.location = 'typebook.php'; </script>";
    }





}
?>