<?php
include("../func.php");

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
    <title>New Admin</title>
    <link rel="stylesheet" href="../css/addadmin.css">

</head>

<body>
    <a href="admin.php"><img class="img-fluid" src="../assets/img/portfolio/back.png" width="50" /></a>
    <form method="POST" action="adminAdd.php">
        <h1>New Admin</h1>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>

        <label for="lname">Last Name:</label>
        <input type="text" name="lname" id="lname" required>

        <label for="birthdate">Birthdate:</label>
        <input type="date" name="birthdate" id="birthdate" required>

        <label for="tel">Telephone:</label>
        <input type="tel" name="tel" id="tel" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="gender">Gender:</label>
        <input type="radio" name="gender" id="male" value="M" required>Male
        <input type="radio" name="gender" id="female" value="F" required>Female

        <label for="salary">Salary:</label>
        <input type="number" name="salary" id="salary" required>
        <label for="position">Position:</label>
        <select name="position">
            <?php
            $result = select('*', 'position');
            while ($row = $result->fetch_array()) {
            ?>
                <option value="<?= $row['pos_id'] ?>"><?= $row['pos_name'] ?></option>
            <?php } ?>
        </select><br><br>

        <input type="submit" value="Register" name="submit">
    </form>

</body>

</html>
<?php
if (isset($_POST['submit'])) {

    $date = findDate();
    $id = nextId(" concat('EMP-$date',nvl(lpad(substr(max(emp_id),9,3)+1,3,'0'),'001'))  ", 'emp');
    $username = $_POST['username'];
    $password = hash('sha512', $_POST['password']);
    $name = $_POST['name'];
    $lname = $_POST['lname'];
    $birthdate = $_POST['birthdate'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $salary = $_POST['salary'];
    $posid = $_POST['position'];
    $data = "'$id','$username','$password','$name','$lname','$birthdate','$tel','$email','$gender','$salary','$posid'";
    //echo $data;
    $chk_uname = selectWhere("emp_uname", "emp", "emp_uname = '$username'")->num_rows > 0;
    if ($chk_uname > 0) {
        echo "<script> alert('USERNAME ซ้ำ'); </script>";
    }else{
        if (insert('emp', '(emp_id,emp_uname,emp_pass,emp_name,emp_lname,emp_bdate,emp_tel,emp_email,emp_sex,emp_sal,emp_pos)', $data)) {
            echo "<script> alert('บันทึกข้อมูลเรียบร้อย'); </script>";
            echo "<script> window.location = 'admin.php'</script>";
        } else {
            echo "<script> alert('บันทึกข้อมูลไม่สำเร็จ'); </script>";
            //echo "<script> window.location = 'admin.php'</script>";
        }
    }
}
?>