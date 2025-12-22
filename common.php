<?php
    session_start();
    $isLogin = !empty($_SESSION['user_No']);

    echo $isLogin;
?>