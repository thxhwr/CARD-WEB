<?php 
    $mysqli = new mysqli("72.60.237.149","thxdeal","dealThx11223@#","THXDEAL_DB", "37722");

    if($mysqli->connect_errno){
        die("fail".$mysqli->connect_error);
        exit();
    };

    echo "success";
?>