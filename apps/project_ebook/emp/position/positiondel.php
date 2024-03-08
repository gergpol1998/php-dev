<?php
include("../func.php");
conn();
session_start();
if (!isset($_SESSION["NAME"])) {
    header("location:../login.php");
}
   
$id = $_GET['id'];
//echo $id;
if(delete('position',"pos_id='$id'")){
    echo "<script> alert('ลบข้อมูลสำเร็จ'); </script>";

    echo "<script> window.location = 'position.php'; </script>";
}


?>