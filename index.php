<?php $pageTitle = "홈"; ?>
<!doctype html>
<html lang="ko">
<head>
  <?php include __DIR__ . "/partials/head.php"; ?>
</head>
<body>
  <header class="header">
    <div class="header__bar">
      <button class="icon-btn" aria-label="메뉴 열기" data-burger>☰</button>
      <div class="brand">SHOP</div>
      <a class="icon-btn" href="/products.php" aria-label="상품">🛍</a>
    </div>
  </header>

  <main>
    <section class="hero container">
      <div style="margin-top:16px">
        <a class="btn btn--primary" href="/products.php">상품 보러가기</a>
      </div>
    </section>
  </main>

  <?php include __DIR__ . "/partials/footer.php"; ?>
</body>
</html>
