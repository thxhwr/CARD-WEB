<?php
    session_start();
    $isLogin = $_SESSION['user_No'];

    echo $isLogin;
?>