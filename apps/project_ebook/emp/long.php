<?php
include("func.php");
session_start();

if(mkdir('/test1/test2', 0777, true)){
    echo "yesss";
}else{
    echo "Noo";
    
}





?>