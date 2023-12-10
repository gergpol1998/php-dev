<?php
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 'Off');
function conn(){
    $servername = "103.114.200.105:9906";
    $username = "root";
    $password = "root";
    $db = "ebook";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $db);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    return $conn;
}
function today(){
    $td = mysqli_query(conn(),"select DATE_FORMAT(CURDATE(),'%Y-%m-%d') as today")->fetch_assoc();
    return $td['today'];
}
function findDate()
{
    $sql1 = "SELECT DATE_FORMAT(CURDATE(),'%m') as month";
    $result1 = mysqli_query(conn(), $sql1);
    $row1 = mysqli_fetch_array($result1);

    $sql2 = "SELECT DATE_FORMAT(CURDATE(),'%y')+43 as year";
    $result2 = mysqli_query(conn(), $sql2);
    $row2 = mysqli_fetch_array($result2);
    return $date = $row2['year'] . $row1['month'];
}
function nextId($concat,$table)
{
    $sql = "select $concat as next_id from $table";
    $result = mysqli_query(conn(), $sql);
    $row = mysqli_fetch_array($result);
    return $row['next_id'];
}
function select($col,$table){
    $sql = "select $col from $table";
    $result = mysqli_query(conn(), $sql);
    return $result;
}
function selectWhere($col,$table,$where){
    $sql = "select $col from $table where $where";
    $result = mysqli_query(conn(), $sql);
   return $result;
    //return $sql;
}
function insert($table,$col,$vales){
    $sql = "insert into $table $col values($vales)";
    $result = mysqli_query(conn(), $sql);
    return $result;
    //return $sql;
}
function delete($table,$where){
    $sql = "DELETE FROM $table WHERE $where";
    $result = mysqli_query(conn(), $sql);
    return $result;
}
function update($table, $set, $where){
    $sql = "update $table set $set where $where";
    $result = mysqli_query(conn(), $sql);
    return $result;
    //return $sql;
}
function bookautoid(){
    $code = "BOOK-"; //กำหนดอักษรนำหน้า
    $yearMonth = substr(date("Y") + 543, -2) . date("m"); //ดึงค่าปี เดือน ปัจจุบัน
    //query MAX ID
    $sql = "SELECT MAX(book_id) AS LAST_ID FROM book";
    $result = conn()->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    $maxId = substr($row['LAST_ID'],-6); //ดึงค่าไอดีล่าสุดจากตารางข้อมูลที่จะบันทึก
    
    if ($maxId == '') {
        $maxId = "000001";
    } else {
        $maxId = ($maxId + 1);  //บวกค่าเพิ่มอีก 1
    }
    $maxId = str_pad($maxId,6,'0',STR_PAD_LEFT);
    $nextId = $code . $yearMonth . $maxId; //นำข้อมูลทั้งหมดมารวมกัน
    return $nextId;
    }
}
function autoID($title,$col,$table){
    $code = $title; //กำหนดอักษรนำหน้า
    $yearMonth = substr(date("Y") + 543, -2) . date("m"); //ดึงค่าปี เดือน ปัจจุบัน
    //query MAX ID
    $sql = "SELECT MAX($col) AS LAST_ID FROM $table";
    $result = conn()->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    $maxId = substr($row['LAST_ID'],-6); //ดึงค่าไอดีล่าสุดจากตารางข้อมูลที่จะบันทึก
    
    if ($maxId == '') {
        $maxId = "000001";
    } else {
        $maxId = ($maxId + 1);  //บวกค่าเพิ่มอีก 1
    }
    $maxId = str_pad($maxId,5,'0',STR_PAD_LEFT);
    $nextId = $code . $yearMonth . $maxId; //นำข้อมูลทั้งหมดมารวมกัน
    return $nextId;
    }
}
function tagautoid(){
    $code = "TAG-"; //กำหนดอักษรนำหน้า
    //query MAX ID
    $sql = "SELECT MAX(tag_id) AS LAST_ID FROM tag";
    $result = conn()->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    $maxId = substr($row['LAST_ID'],-11); //ดึงค่าไอดีล่าสุดจากตารางข้อมูลที่จะบันทึก
    
    if ($maxId == '') {
        $maxId = '00000000001';
    } else {
        $maxId = ($maxId + 1);  //บวกค่าเพิ่มอีก 1
    }
    $maxId = str_pad($maxId,11,'0',STR_PAD_LEFT);
    $nextId = $code . $maxId; //นำข้อมูลทั้งหมดมารวมกัน
    return $nextId;
    }
}

function insertdata($table,$values,$inputdata){
    $sql = "insert into $table ($values)
    values ($inputdata)";
    $result = conn()->query($sql);
    return $result;
}
function getsql($table,$values,$inputdata){
    $sql = "insert into $table ($values)
    values ($inputdata)";
    
    return $sql;
}

?>