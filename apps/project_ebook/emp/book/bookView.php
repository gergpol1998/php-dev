<?php
include("../func.php");
conn();
session_start();
if (!isset($_SESSION["ID"])) {
    header("location:../login.php");
}
$pos = $_SESSION['POS'];
$row = mysqli_fetch_array(selectWhere('count(*) as permis', 'pos_per', "pp_posid='$pos' and pp_perid='PER-003'"));
$permis = $row['permis'];
$id = $_GET['id'];

?>
<!DOCTYPE html>
<html>

<head>
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="../css/addpermis.css" rel="stylesheet" />
</head>
<?php
$book = selectWhere('*', 'book,publisher', "book_id='$id' and (book_pubid=pub_id)")->fetch_array();
$tbook = selectWhere('type_name', 'book_type,typebook', "btype_bookid='$id' and btype_typeid=type_id");


?>

<body>
    <a href="book.php"><img class="img-fluid" src="../assets/img/portfolio/back.png" width="50" /></a>
    <form method="post" action="bookView.php?=<?= $id ?>">
        <?php
        if (strpos($book['book_cover'], 'http') === 0) {
            // ถ้าขึ้นต้นด้วย http
            echo '<h1><img src="' . $book['book_cover'] . '" width="200" height="250"></h1>';
        } else {
            // ถ้าไม่ขึ้นต้นด้วย http
            echo '<h1><img src="../../customer/' . $book['book_cover'] . '" width="200" height="250"></h1>';
        }
        ?>

        <h1 style="word-wrap: break-word"><?= $book['book_name'] ?></h1>
        <div style="display: none;"><input type="text" name="bookid" value="<?= $book['book_id'] ?>"> </div>
        <div>Summary : </div>
        <div><textarea name="summary" cols="40" rows="10" readonly><?= $book['book_summary'] ?></textarea></div>
        <?php $tname = '';
        while ($r = $tbook->fetch_array()) {
            $tname .= $r['type_name'] . ",";
        } ?>
        <div>Type : <?php echo rtrim($tname, ","); ?></div>
        <div>Publisher : <?= $book['pub_name'] ?></div>
        <div>Price : <?= $book['book_price'] ?></div>
        <div>Date send : <?= $book['book_dateup'] ?></div>
        <div>Date Approve : <?= $book['book_app'] ?></div>
        <div>Demo content : <a href="../../customer/testread.php?bookid=<?= $book['book_id'] ?>" class="btn btn-warning">READ</a></div>
        <div>Full content : <a href="../../customer/readbook.php?bookid=<?= $book['book_id'] ?>" class="btn btn-secondary">READ</a></div>
        <br>
        <div style="text-align: center;">

            <?php
            if ($permis) {
                if ($book['book_status'] == 1) { ?>
                    <input type="submit" class="btn btn-primary" name="submit1" value="Approval">
                    <input type="submit" class="btn btn-danger" name="submit2" value="Disapproval">

            <?php }
            } ?>
        </div>
    </form>
</body>

</html>
<?php
if (isset($_POST['submit1'])) {
    $emp = $_SESSION['ID'];
    $bid = $_POST['bookid'];
    $d = mysqli_query(conn(), "SELECT DATE_FORMAT(NOW(), '%Y-%m-%d') as today")->fetch_assoc();
    $date = $d['today'];
    if (update("book", "book_app='$date',book_empid='$emp',book_status=2", "book_id = '$bid'")) {
        echo "<script>alert('อนุมัติสำเร็จ')</script>";
        echo "<script>window.location = 'book.php'</script>";
    }
} else if (isset($_POST['submit2'])) {
    $bid = $_POST['bookid'];
    if (update("book", "book_status=0", "book_id = '$bid'")) {
        echo "<script>alert('ไม่อนุมัติ ตีกลับเป็นฉบับร่าง')</script>";
        echo "<script>window.location = 'bookpending.php'</script>";
    }
}
?>