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
$pos = $_GET['pos'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Information Admin</title>
    <link rel="stylesheet" href="../css/addadmin.css">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="../css/styles.css" rel="stylesheet" />


</head>

<body>
    <a href="admin.php"><img class="img-fluid" src="../assets/img/portfolio/back.png" width="50" /></a>
    <form action="adminEdit.php?id=<?= $id ?>&pos=<?= $pos ?>">

        <h1>Information Admin</h1>
        <?php

        $row = selectWhere('*', 'emp', "emp_id='$id'")->fetch_array();
        $p = selectWhere('*', 'position', "pos_id='$pos'")->fetch_array();

        ?>

        <label for="id">ID:</label>
        <input type="text" name="pos" id="id" value="<?= $pos ?>" hidden>
        <input type="text" name="id" id="id" value="<?= $row['emp_id'] ?>" readonly>

        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?= $row['emp_uname'] ?>" readonly>

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?= $row['emp_name'] ?>" readonly>

        <label for="lname">Last Name:</label>
        <input type="text" name="lname" id="lname" value="<?= $row['emp_lname'] ?>" readonly>

        <label for="birthdate">Birthdate:</label>
        <input type="date" name="birthdate" id="birthdate" value="<?= $row['emp_bdate'] ?>" readonly>

        <label for="tel">Telephone:</label>
        <input type="tel" name="tel" id="tel" value="<?= $row['emp_tel'] ?>" readonly>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= $row['emp_email'] ?>" readonly>

        <label for="gender">Gender:</label>
        <input type="radio" name="gender" id="male" value="M" onclick="return false;" <?php if ($row['emp_sex'] == 'M')
                                                                                            echo "checked" ?> readonly>Male
        <input type="radio" name="gender" id="female" value="F" onclick="return false;" <?php if ($row['emp_sex'] == 'F')
                                                                                            echo "checked" ?> readonly>Female
        <br>
        <label for="salary">Salary:</label>
        <input type="number" name="salary" id="salary" value="<?= $row['emp_sal'] ?>" readonly>

        <label for="position">Position:</label>
        <?php

        ?>
        <select name="position" disabled>
            <option><?= $p['pos_name'] ?></option>
        </select><br><br>

        <?php if ($permis) { ?>
            <input type="submit" value="Edit" name="edit">
        <?php } ?>
    </form>

</body>

</html>