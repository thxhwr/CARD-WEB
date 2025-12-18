<?php
session_start();

// 자동 로그인 처리
require_once __DIR__ . "/remember_login.php";

// 로그인 여부
$isLogin = isset($_SESSION['user_Id']);
