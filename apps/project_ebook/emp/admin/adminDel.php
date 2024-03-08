<?php
include("../func.php");
conn();
session_start();
if (!isset($_SESSION["NAME"])) {
    header("location:../login.php");
}
   
$id = $_GET['id'];
//echo $id;
if(delete('emp',"emp_id='$id'")){
    echo "<script> alert('ลบข้อมูลสำเร็จ'); </script>";
        //echo $sql; 
       echo "<script> window.location = 'admin.php'; </script>";
}


?>