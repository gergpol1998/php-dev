<?php
include("func.php");
conn();
session_start();

?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Page</title>
    <link href="css/login.css" rel="stylesheet" />
</head>

<body>
    <div class="container">
        <h1>Login</h1>
        <form method="POST" action="login.php">
            <div class="form-group">
                <label class="label" for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label class="label" for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="submit">Login</button>

        </form>
    </div>
</body>

</html>
<?php
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = hash('sha512', $_POST['password']);

    $sql = "select * from emp where emp_uname='$username' and emp_pass='$password'";
    $result = mysqli_query(conn(), $sql);
    $row = mysqli_fetch_array($result);
    echo "<script> src ='https://code.jquery.com/jquery-3.6.1.min.js' 
    </script>
    <script src = 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js'></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css'/>";
    if ($row > 0) {
        $_SESSION["ID"] = $row['emp_id'];
        $_SESSION["POS"] = $row['emp_pos'];
        $_SESSION["NAME"] = $row['emp_name'];
        $_SESSION["LNAME"] = $row['emp_lname'];
        $_SESSION["EID"] = $row['emp_id'];

        echo '
        <script>
        setTimeout(function() {
        swal({
                title: "เข้าสู่ระบบสำเร็จ", //ข้อความ เปลี่ยนได้ เช่น บันทึกข้อมูลสำเร็จ!!
                type: "success", //success, warning, danger
                timer: 2000, //ระยะเวลา redirect 3000 = 3 วิ เพิ่มลดได้
                showConfirmButton: false //ปิดการแสดงปุ่มคอนเฟิร์ม ถ้าแก้เป็น true จะแสดงปุ่ม ok ให้คลิกเหมือนเดิม
            }, function(){
                window.location.href = "index.php"; //หน้าเพจที่เราต้องการให้ redirect ไป อาจใส่เป็นชื่อไฟล์ภายในโปรเจคเราก็ได้ครับ เช่น admin.php
                });
        },1000);
    </script>';

    } else {

        echo "
    <script>
    setTimeout(function() {
    swal({
            title: 'เข้าสู่ระบบไม่สำเร็จ', //ข้อความ เปลี่ยนได้ เช่น บันทึกข้อมูลสำเร็จ!!
            text: 'Username or Password ผิด', //ข้อความเปลี่ยนได้ตามการใช้งาน
            type: 'warning', //success, warning, danger
            timer: 2000, //ระยะเวลา redirect 3000 = 3 วิ เพิ่มลดได้
            showConfirmButton: false //ปิดการแสดงปุ่มคอนเฟิร์ม ถ้าแก้เป็น true จะแสดงปุ่ม ok ให้คลิกเหมือนเดิม
        }, function(){
            window.location.href = 'login.php'; //หน้าเพจที่เราต้องการให้ redirect ไป อาจใส่เป็นชื่อไฟล์ภายในโปรเจคเราก็ได้ครับ เช่น admin.php
            });
    },1000);
</script>
    ";
    }
    mysqli_close(conn());
}
?>