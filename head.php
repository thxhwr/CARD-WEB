<?php
  $title = isset($pageTitle) ? $pageTitle . " · THXDEAL" : "THXDEAL";
  if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }

  $current = basename($_SERVER['PHP_SELF']);  // 현재 파일 이름

  if (empty($_SESSION['user_No'])) {
      // index.php, login.php 등은 예외
      $allow = ['index.php', 'login.php'];

      if (!in_array($current, $allow, true)) {
          header('Location: /index.php');
          exit;
      }
  }
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title><?= htmlspecialchars($title) ?></title>

<meta name="theme-color" content="#ffffff">
<meta name="description" content="">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/modern-css-reset/1.4.0/reset.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500&display=swap">
<link rel="preload" href="/assets/css/main.css" as="style">
<link rel="stylesheet" href="/assets/css/main.css">
<link rel="icon" href="/assets/img/favicon.svg" type="image/svg+xml">
