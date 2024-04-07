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
  <title>Add Permission</title>
  <link href="../css/addpermis.css" rel="stylesheet" />
</head>

<body>
  <a href="permis.php"><img class="img-fluid" src="../assets/img/portfolio/back.png" width="50" /></a>
  <h1>Add Permission</h1>
  <form method="post" action="permisadd.php">


    <label for="permission-name">Name Permission:</label>
    <input type="text" id="permission-name" name="pername" required><br>

    <button type="submit" name="submit">Add Permission</button>
  </form>
</body>

</html>
<?php
if (isset($_POST['submit'])) {
  
  $id = nextId(" concat('PER-',nvl(lpad(substr(max(per_id),5,3)+1,3,'0'),'001'))  ",'permis');
  $name = $_POST['pername'];
  $data = "'$id','$name'";
   
  if(insert('permis','(per_id,per_name)',$data)){
    echo "<script> alert('บันทึกข้อมูลเรียบร้อย'); </script>";
    echo "<script> window.location = 'permis.php'</script>";
  }




}
?>