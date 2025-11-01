<?php 
    $mysqli = new mysqli("localhost","jiheon","!!aA165165","THXDEAL_DB");

    if($mysqli -> connect_errno){
        echo "fail".$mysqli->connect_error;
        exit();
    };

    echo "success";
?>