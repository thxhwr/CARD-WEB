<?php
session_start();

// 로그인 여부
$isLogin = isset($_SESSION['user_Id']);
