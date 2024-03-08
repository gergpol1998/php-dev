<?php

use LDAP\Result;

include("../func.php");
conn();
session_start();
$pos = $_SESSION['POS'];
if (!isset($_SESSION["ID"])) {
    header("location:../login.php");
}
$id =  $_GET['id'];
$inc = $_GET['inc'];
$path = $_GET['p'];
$rou = $_GET['rou'];
if (isset($_GET['rou'])) {

    $sh = selectWhere("*", 'round', "round_id='$rou'")->fetch_assoc();
    $share = $sh['round_rev'] / 100;
    $query = "SELECT pub_id,pub_name,pub_round,sum(recd_price)*$share as pub_income
            FROM receipt,receipt_detail,book,publisher
            WHERE (rec_id=recd_recid and recd_bookid=book_id and book_pubid=pub_id)  AND
                    (rec_date BETWEEN pub_dinc and NOW()) AND (pub_round='$rou')
            GROUP BY pub_id";
    $result = mysqli_query(conn(), $query);
    while ($row = $result->fetch_assoc()) {
        $inc_id = autoID("INC-", 'inc_id', "income");
        $inc_pub = $row['pub_id'];
        $inc_income = $row['pub_income'];
        $col = 'inc_id,inc_pubid,inc_month,inc_amount';
        $data = "'$inc_id','$inc_pub',NOW(),$inc_income";
        insertdata('income', $col, $data);
    }
    update('publisher', "pub_dinc=NOW(),pub_instatus=1", "pub_round='$rou'");
    echo "<script>window.location = '$path';</script>";
} else {

    $inc_id = autoID("INC-", 'inc_id', "income");
    $inc_pub = $id;
    $inc_income = $inc;
    $col = 'inc_id,inc_pubid,inc_month,inc_amount';
    $data = "'$inc_id','$inc_pub',NOW(),$inc_income";
    insertdata('income', $col, $data);
    update('publisher', "pub_dinc=NOW(),pub_instatus=1", "pub_id='$id'");
    echo "<script>window.location = '$path';</script>";
}
