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
    <title>Edit Admin</title>
    <link rel="stylesheet" href="../css/addadmin.css">



</head>

<body>
    <a href="admin.php"><img class="img-fluid" src="../assets/img/portfolio/back.png" width="50" /></a>
    <form method="POST" action="adminEdit.php?id=<?= $id ?>">

        <h1>Edit Admin</h1>
        <?php
        selectWhere('*', 'emp', "emp_id='$id'");
        $row = selectWhere('*', 'emp,position', "emp_id='$id' and emp_pos=pos_id")->fetch_array();
        $p = selectWhere('*', 'position', "pos_id='$pos'")->fetch_array();
        //echo $p['pos_name'].$pos;

        ?>

        <label for="id">ID:</label>
        <input type="text" name="id" id="id" value="<?= $row['emp_id'] ?>" readonly>

        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?= $row['emp_uname'] ?>" readonly>

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?= $row['emp_name'] ?>" required>

        <label for="lname">Last Name:</label>
        <input type="text" name="lname" id="lname" value="<?= $row['emp_lname'] ?>" required>

        <label for="birthdate">Birthdate:</label>
        <input type="date" name="birthdate" id="birthdate" value="<?= $row['emp_bdate'] ?>" required>

        <label for="tel">Telephone:</label>
        <input type="tel" name="tel" id="tel" value="<?= $row['emp_tel'] ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= $row['emp_email'] ?>" required>

        <label for="gender">Gender:</label>
        <input type="radio" name="gender" id="male" value="M" <?php if ($row['emp_sex'] == 'M')
            echo "checked" ?>
                required>Male
            <input type="radio" name="gender" id="female" value="F" <?php if ($row['emp_sex'] == 'F')
            echo "checked" ?>
                required>Female

            <label for="salary">Salary:</label>
            <input type="number" name="salary" id="salary" value="<?= $row['emp_sal'] ?>" required>

        <label for="position">Position:</label>
        <select name="position">
            <option value="<?= $p['pos_id'] ?>"><?= $p['pos_name'] ?></option>
            <?php
            $result = select('*', 'position');
            while ($row2 = $result->fetch_array()) {
                ?>
                <option value="<?= $row2['pos_id'] ?>"><?= $row2['pos_name'] ?></option>
            <?php } ?>
        </select><br><br>

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
    $salary = $_POST['salary'];

    $posid = $_POST['position'];
    //echo updateA("emp", "emp_name='$name',emp_lname='$lname',emp_bdate='$birthdate',emp_tel='$tel',emp_email='$email',emp_sex='$gender',emp_sal=$salary", "emp_id='$id'");

    if (update("emp", "emp_name='$name',emp_lname='$lname',emp_bdate='$birthdate',emp_tel='$tel',emp_email='$email',emp_sex='$gender',emp_sal=$salary,emp_pos='$posid'", "emp_id='$id'")) {

        echo "<script> alert('บันทึกข้อมูลเรียบร้อย'); </script>";
        echo "<script> window.location = 'admin.php'</script>";

    }

}
?>