<?php
session_start();

// 로그인 여부
$isLogin = isset($_SESSION['user_Id']);
if(!$isLogin){
    header('Location: /index.php');
    exit;
}
