<?php
include("../func.php");
conn();
session_start();
if (!isset($_SESSION["NAME"])) {
    header("location:../login.php");
}
$pos = $_SESSION['POS'];
$row = mysqli_fetch_array(selectWhere('count(*) as permis', 'pos_per', "pp_posid='$pos' and pp_perid='PER-001'"));
$permis = $row['permis'];
$readOnlyAttribute = $permis == 0 ? 'disabled' : '';

?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Posiotion</title>
    <link href="../css/addpermis.css" rel="stylesheet" />
</head>

<body>
    <a href="position.php"><img class="img-fluid" src="../assets/img/portfolio/back.png" width="50" /></a>
    <h1>Edit Posiotion</h1>
    <?php
    $id = $_GET['id'];
    $result = selectWhere('*', 'position', "pos_id='$id'");
    $row = $result->fetch_array();
    ?>
    <form method="post" action="positionedit.php?=<?= $id ?>">

        <label for="Posiotion-id">ID Posiotion:</label>
        <input type="text" id="Posiotion-id" name="posid" value="<?= $row['pos_id'] ?>" readonly>
        <label for="Posiotion-name">Name Posiotion:</label>
        <input type="text" id="Posiotion-name" name="posname" value="<?= $row['pos_name'] ?>" required <?=$readOnlyAttribute?>><br>

        <label for="position">Posiotion:</label>
        <?php

        $pp_pos = [];
        $pm = select('*', 'permis');
        while ($row = mysqli_fetch_array($pm)) {

            $pp = selectWhere('pp_perid', 'pos_per', "pp_posid='$id'");
            while ($pp_row = mysqli_fetch_array($pp)) {
                $pp_pos[] = $pp_row["pp_perid"];
            }
            $isChecked = in_array($row["per_id"], $pp_pos);
            
        ?>
            <input type="checkbox" name="per[]" id="per" value="<?php echo $row['per_id']; ?>"<?=$readOnlyAttribute?> <?php if ($isChecked) echo "checked"; ?>>
            <?php echo $row['per_name'] . "<br>" ?>

        <?php }
        mysqli_close(conn());
        ?><br><br>

        <?php if ($permis) { ?>
            <button type="submit" name="submit">Edit Posiotion</button>
        <?php } ?>

    </form>
</body>

</html>
<?php
if (isset($_POST['submit'])) {
    $id = $_POST['posid'];
    $name = $_POST['posname'];
    $data = "'$name'";
    $perid = $_POST['per'];
    if (update('position', "pos_name=$data", "pos_id='$id'")) {
        if (delete('pos_per', "pp_posid='$id'")) {
            for ($i = 0; $i < sizeof($perid); $i++) {
                $data_per = "'$id','$perid[$i]'";
                insert('pos_per', '', $data_per);
            }
            echo "<script> alert('แก้ไขข้อมูลสำร็จ'); </script>";

            echo "<script> window.location = 'position.php'; </script>";
        }
    }
}
?>