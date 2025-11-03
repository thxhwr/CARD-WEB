<?php $pageTitle = "홈"; ?>
<!doctype html>
<html lang="ko">
<head>
  <?php include __DIR__ . "/head.php"; ?>
</head>
<body>
  <div class="backdrop"></div>
  <header class="header">
    <div class="header__bar">
      <button class="icon-btn" aria-label="메뉴" data-burger>☰</button>
      <div class="brand">SHOP</div>
      <a class="icon-btn" href="products.html" aria-label="상품">🛍</a>
    </div>
  </header>

  <main class="container">
    <section class="mt-4">
      <h1 style="margin:0 0 8px 0;font-size:var(--fs-24)">홈</h1>
      <p class="text-muted"></p>
      <a class="btn btn--primary mt-4" href="products.html">상품 보러가기</a>
    </section>
  </main>
  </main>

  <?php include __DIR__ . "/footer.php"; ?>
</body>
</html>
