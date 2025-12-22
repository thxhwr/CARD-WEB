<?php
    session_start();
    $isLogin = !empty($_SESSION['user_Id']);

    echo $isLogin;
?>