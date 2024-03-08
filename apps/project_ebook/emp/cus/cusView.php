<?php
include("../func.php");
conn();
session_start();
if (!isset($_SESSION["ID"])) {
    header("location:../login.php");
}
$id = $_GET['id'];
$pos = $_SESSION['POS'];
$per = mysqli_fetch_array(selectWhere('count(*) as permis', 'pos_per', "pp_posid='$pos' and pp_perid='PER-002'"));
$permis = $per['permis'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Information Admin</title>
    <link rel="stylesheet" href="../css/addadmin.css">



</head>

<body>
    <a href="cus.php"><img class="img-fluid" src="../assets/img/portfolio/back.png" width="50" /></a>
    <form method="POST" action="cusEdit.php?id=<?= $id ?>">

        <h1>View Customer</h1>
        <?php
        selectWhere('*', 'customer', "cus_id='$id'");
        $row = selectWhere('*', 'customer', "cus_id='$id'")->fetch_array();

        ?>

        <label for="id">ID:</label>
        <input type="text" name="id" id="id" value="<?= $row['cus_id'] ?>" readonly>

        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?= $row['cus_uname'] ?>" readonly>

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?= $row['cus_name'] ?>" required>

        <label for="lname">Last Name:</label>
        <input type="text" name="lname" id="lname" value="<?= $row['cus_lname'] ?>" required>

        <label for="birthdate">Birthdate:</label>
        <input type="date" name="birthdate" id="birthdate" value="<?= $row['cus_bdate'] ?>" required>

        <label for="tel">Telephone:</label>
        <input type="tel" name="tel" id="tel" value="<?= $row['cus_tel'] ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= $row['cus_email'] ?>" required>

        <label for="gender">Gender:</label>
        <input type="radio" name="gender" id="male" value="M" <?php if ($row['cus_sex'] == 'M')
            echo "checked" ?>
                required>Male
            <input type="radio" name="gender" id="female" value="F" <?php if ($row['cus_sex'] == 'F')
            echo "checked" ?>
                required>Female
            <br>

        <?php if($permis){?>
        <!--<input type="submit" value="Edit" name="edit">>-->
        <?php }?>
        </form>

</body>

</html>