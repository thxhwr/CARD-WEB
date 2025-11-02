<!doctype html>
<html lang="ko">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <title>모바일 퍼스트 쇼핑몰 스타터</title>
  <meta name="theme-color" content="#ffffff">
  <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
  <div class="nav-backdrop" data-backdrop></div>
  <header class="header">
    <div class="header__bar">
      <button class="icon-btn" aria-label="메뉴 열기" data-burger>☰</button>
      <div class="brand">SHOP</div>
      <a class="icon-btn" href="products.html" aria-label="상품">🛍</a>
    </div>
  </header>

  <aside class="nav-drawer" aria-label="사이드 내비">
    <nav class="nav-list">
      <a href="index.html" aria-current="page">홈</a>
      <a href="products.html">상품</a>
      <a href="#">카테고리</a>
      <a href="#">마이</a>
    </nav>
  </aside>

  <main>
    <section class="hero container">
      <h1>모바일 퍼스트 베이스</h1>
      <p>이 스타터는 모바일 화면을 기준으로 만들었고, 상단 고정 헤더/사이드 드로어/하단 탭바를 포함해요.</p>
      <div style="margin-top:16px">
        <a class="btn btn--primary" href="products.html">상품 보러가기</a>
      </div>
    </section>
  </main>

  <nav class="tabbar" aria-label="하단 탭">
    <a href="index.html" aria-current="page">홈</a>
    <a href="products.html">상품</a>
    <a href="#">장바구니</a>
    <a href="#">마이</a>
  </nav>

  <footer class="footer">
    <div class="container">© 2025 Shop · <a href="#">이용약관</a> · <a href="#">개인정보</a></div>
  </footer>

  <script src="assets/js/main.js" defer></script>
</body>
</html>
