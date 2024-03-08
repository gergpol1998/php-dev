<?php
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 'Off');

session_destroy();
echo "<script> src ='https://code.jquery.com/jquery-3.6.1.min.js' 
</script>
<script src = 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js'></script>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css'/>";

echo '
    <script>
    setTimeout(function() {
    swal({
            title: "ออกจากระบบ", //ข้อความ เปลี่ยนได้ เช่น บันทึกข้อมูลสำเร็จ!!
            type: "success", //success, warning, danger
            timer: 2000, //ระยะเวลา redirect 3000 = 3 วิ เพิ่มลดได้
            showConfirmButton: false //ปิดการแสดงปุ่มคอนเฟิร์ม ถ้าแก้เป็น true จะแสดงปุ่ม ok ให้คลิกเหมือนเดิม
        }, function(){
            window.location.href = "login.php"; //หน้าเพจที่เราต้องการให้ redirect ไป อาจใส่เป็นชื่อไฟล์ภายในโปรเจคเราก็ได้ครับ เช่น admin.php
            });
    },1000);
</script>
    ';

?>