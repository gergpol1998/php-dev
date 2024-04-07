<?php
include("../func.php");
conn();
session_start();

if (!isset($_SESSION["ID"])) {
header("location:../login.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Set Date</title>
    <link href="../css/addpermis.css" rel="stylesheet" />
</head>

<body>
    <a href="finance.php"><img class="img-fluid" src="../assets/img/portfolio/back.png" width="50" /></a>
    <h1>Set Date</h1>
    <form method="post" action="financesetdate.php">
        <?php
        $r = $_POST['round'];
        $s = $_POST['share'];
        $ar = array();
        for ($i = 1; $i <= $r; $i++) {
            echo " <div>Round $i <label for='date' style='color: red;'>(ระบุวันที่ 2 หลัก เช่น 07,15,29 เป็นต้น)</label>
            <input type='text'  name='round$i'maxlength='2' minlength='2'required></div>";
        }
        ?>
        <input type='number' value="<?= $r ?>" name='num' hidden></div>
        <input type='number' value="<?= $s ?>" name='share' hidden></div>
        <button type="submit" name="submit2">Add date</button>


    </form>
</body>

</html>
<?php
if (isset($_POST['submit2'])) {
    $id = nextId(" concat('ROU-',nvl(lpad(substr(max(round_id),5,3)+1,3,'0'),'001'))  ", 'round');
    $rnum = $_POST['num'];
    $share = $_POST['share'];
    $data = "'$id','$rnum','$share'";

    if (insert('round', '(round_id,round_num,round_rev)', $data)) {
        for ($i = 1; $i <= $rnum; $i++) {
            $date = $_POST["round$i"];
            $data2 = "'$id','$date'";
            insert('date', '(date_roundid,date_date)', $data2);
        }
        echo "<script> window.location = 'finance.php'</script>";
    }
}
?>