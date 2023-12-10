<?php
include("../func.php");
conn();
session_start();
if (!isset($_SESSION["POS"])) {
    header("location:../login.php");
}
   
$id = $_GET['id'];
//echo $id;
if(delete('permis',"per_id='$id'")){
    echo "<script> alert('ลบข้อมูลสำเร็จ'); </script>";

    echo "<script> window.location = 'permis.php'; </script>";
}


?>