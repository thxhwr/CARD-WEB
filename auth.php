<?php
// 항상 제일 위에
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['user_No'])) {
    header('Location: /index.php');
    exit;
}
