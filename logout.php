<?php
session_start();

// 모든 세션 삭제
$_SESSION = [];
session_unset();
session_destroy();

// remember_me 쿠키도 삭제
if (isset($_COOKIE['remember_me'])) {
    setcookie('remember_me', '', time() - 3600, '/');
}

// 로그아웃 후 이동할 페이지
header("Location: /login.php");
exit;
