<?php
include("../func.php");
conn();
session_start();
if (!isset($_SESSION["NAME"])) {
    header("location:../login.php");
}
$id = $_GET['id'];
$pos = $_GET['pos'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Customer</title>
    <link rel="stylesheet" href="../css/addadmin.css">



</head>

<body>
    <a href="cus.php"><img class="img-fluid" src="../assets/img/portfolio/back.png" width="50" /></a>
    <form method="POST" action="cusEdit.php?id=<?= $id ?>">

        <h1>Edit Customer</h1>
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


            <input type="submit" value="Edit" name="edit">
        </form>

    </body>

    </html>
    <?php
        if (isset($_POST['edit'])) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $lname = $_POST['lname'];
            $birthdate = $_POST['birthdate'];
            $tel = $_POST['tel'];
            $email = $_POST['email'];
            $gender = $_POST['gender'];
            

            //echo updateA("emp", "emp_name='$name',emp_lname='$lname',emp_bdate='$birthdate',emp_tel='$tel',emp_email='$email',emp_sex='$gender',emp_sal=$salary", "emp_id='$id'");
        
            if (update("customer", "cus_name='$name',cus_lname='$lname',cus_bdate='$birthdate',cus_tel='$tel',cus_email='$email',cus_sex='$gender'","cus_id='$id'")) {
                echo "<script> alert('บันทึกข้อมูลเรียบร้อย'); </script>";
                echo "<script> window.location = 'cus.php'</script>";

            }

        }
        ?>