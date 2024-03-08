<?php
include("../func.php");
conn();
session_start();

$pos = $_SESSION['POS'];
if (!isset($_SESSION["ID"])) {
    header("location:../login.php");
}
$per = mysqli_fetch_array(selectWhere('count(*) as permis', 'pos_per', "pp_posid='$pos' and pp_perid='PER-004'"));
$permis = $per['permis'];

$id = $_GET['id'];

?>
<!DOCTYPE html>
<html>

<head>
    <title>Add Round</title>
    <link href="../css/addpermis.css" rel="stylesheet" />
</head>

<body>
    <a href="finance.php"><img class="img-fluid" src="../assets/img/portfolio/back.png" width="50" /></a>
    <h1>Information Round</h1>
    <?php

    $rou = selectWhere('*', 'round', "round_id='$id'")->fetch_array();
    ?>

    <form method="post" action="financeedit.php?id=<?= $id ?>">
        <label for="Round-name">Number of Round:</label>
        <input type="number" id="Round-name" name="round" value="<?= $rou['round_num'] ?>" readonly>
        <label for="Round-name">Share (%) :</label>
        <input type="number" id="Round-name" name="share" value="<?= $rou['round_rev'] ?>" readonly>
        <?php
        $result = selectWhere('*', 'date', "date_roundid='$id'");
        $i = 1;
        while ($row = $result->fetch_array()) { ?>
            <div>
                Round <?= $i ?><input type="text" value="<?= $row['date_date'] ?>" readonly>
            </div>

        <?php $i++;
        } ?>

        <?php if ($permis) { ?>
            <button type="submit" name="submit">Edit</button>
        <?php } ?>
    </form>

</body>

</html>