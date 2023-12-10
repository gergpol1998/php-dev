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
  <title>Add Type Book</title>
  <link href="../css/addpermis.css" rel="stylesheet" />
</head>

<body>
  <a href="typebook.php"><img class="img-fluid" src="../assets/img/portfolio/back.png" width="50" /></a>
  <h1>Add Type Book</h1>
  <form method="post" action="typebookadd.php">


    <label for="permission-name">Name Type Book:</label>
    <input type="text"  name="typebookname" required><br>

    <button type="submit" name="submit">Add Type Book</button>
  </form>
</body>

</html>
<?php
if (isset($_POST['submit'])) {
  
  $id = nextId(" concat('TYPE-',nvl(lpad(substr(max(type_id),6,3)+1,3,'0'),'001'))  ",'typebook');
  $name = $_POST['typebookname'];
  $data = "'$id','$name'";
   
  if(insert('typebook','(type_id,type_name)',$data)){
    echo "<script> alert('บันทึกข้อมูลเรียบร้อย'); </script>";
    echo "<script> window.location = 'typebook.php'</script>";
  }




}
?>