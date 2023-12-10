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
    <title>Edit Date</title>
    <link href="../css/addpermis.css" rel="stylesheet" />
</head>

<body>
    <a href="finance.php"><img class="img-fluid" src="../assets/img/portfolio/back.png" width="50" /></a>
    <h1>Set Date</h1>
    <form method="post" action="financeeditdate.php">
        <?php
        $r = $_POST['round'];
        $s = $_POST['share'];
        $n = $_POST['roundid'];
        $ar = array();
        $j = 0;
        $result = selectWhere('*', 'date', "date_roundid='$n'");
        while ($rou = $result->fetch_array()) {
            $ar[$j] = $rou['date_date'];
            $j++;
        }
        for ($i = 0; $i < $r; $i++) {
            $k = $i + 1;
            echo " <div>Round $k <label for='date' style='color: red;'>(ระบุวันที่ 2 หลัก เช่น 07,15,29 เป็นต้น)</label>
            <input type='text'  name='round$k' value='$ar[$i]' maxlength='2' minlength='2'required></div>";
        }
        ?>
        <input type='number' value="<?= $r ?>" name='num' hidden></div>
        <input type='number' value="<?= $s ?>" name='share' hidden></div>
        <input type='text' value="<?= $n ?>" name='id' hidden></div>
        <button type="submit" name="submit2">Edit date</button>


    </form>
</body>

</html>
<?php
if (isset($_POST['submit2'])) {
    $id = $_POST['id'];
    $rnum = $_POST['num'];
    $share = $_POST['share'];
    
    if (update('round', "round_num='$rnum',round_rev='$share'", "round_id='$id'")) {
        if (delete('date', "date_roundid='$id'")) {
            for ($i = 1; $i <= $rnum; $i++) {
                $date = $_POST["round$i"];
                $data2 = "'$id','$date'";
                insert('date', '(date_roundid,date_date)', $data2);
            }
            echo "<script> alert('แก้ไขข้อมูลสำเร็จ'); </script>";
            echo "<script> window.location = 'finance.php'</script>";
        }

    }


}
?>