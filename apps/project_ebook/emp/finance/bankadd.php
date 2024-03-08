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
  <title>Add Bank</title>
  <link href="../css/addpermis.css" rel="stylesheet" />
</head>

<body>
  <a href="bank.php"><img class="img-fluid" src="../assets/img/portfolio/back.png" width="50" /></a>
  <h1>Add Bank</h1>
  <form method="post" action="bankadd.php">


    <label for="bank-name">Bank Name :</label>
    <input type="text" id="bank-name" name="bank" required><br>

    <button type="submit" name="submit">Add Bank</button>
  </form>
</body>

</html>
<?php
if (isset($_POST['submit'])) {
  
  $id = nextId(" concat('BANK-',nvl(lpad(substr(max(bank_id),6,4)+1,3,'0'),'001'))  ",'bank');
  $name = $_POST['bank'];
  $data = "'$id','$name'";
   
  if(insert('bank','(bank_id,bank_name)',$data)){
    echo "<script> alert('บันทึกข้อมูลเรียบร้อย'); </script>";
    echo "<script> window.location = 'bank.php'</script>";
  }




}
?>