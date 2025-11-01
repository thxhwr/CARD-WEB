<?php 
    $mysqli = new mysqli("localhost","jiheon1992","!!aA165165","THXDEAL_DB");

    if($mysqli -> connect_error){
        echo "fail".$mysqli->connect_error;
        exit();
    };

    echo "success";
?>