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
  <title>Add Position</title>
  <link href="../css/addpermis.css" rel="stylesheet" />
</head>

<body>
  <a href="position.php"><img class="img-fluid" src="../assets/img/portfolio/back.png" width="50" /></a>
  <h1>Add Position</h1>
  <form method="post" action="positionadd.php">

    <label for="permission-name">Name Position:</label>
    <input type="text" name="posname" required><br>

    <label for="permis">Permission:</label>
        <?php
            
            $result = select('*','permis');
            while ($row = mysqli_fetch_array($result)) {
            ?>
            <input type="checkbox" name="per[]" id="per" value=<?php echo $row['per_id'] ?>>
            <?php echo $row['per_name'] . "<br>" ?>

            <?php }
            mysqli_close(conn());
            ?><br><br>

    <button type="submit" name="submit">Add Position</button>
  </form>
</body>

</html>
<?php
if (isset($_POST['submit'])) {
  
  $id = nextId(" concat('POS-',nvl(lpad(substr(max(pos_id),5,3)+1,3,'0'),'001'))  ",'position');
  $name = $_POST['posname'];
  $data = "'$id','$name'";

  $perid = $_POST['per'];
   
  if(insert('position','',$data)){
    for($i=0;$i<sizeof($perid);$i++){
      $data_per ="'$id','$perid[$i]'";
      insert('pos_per','',$data_per);
  }
    echo "<script> alert('บันทึกข้อมูลเรียบร้อย'); </script>";
    echo "<script> window.location = 'position.php'</script>";
  }




}
?>