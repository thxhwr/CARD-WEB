<nav class="tabbar" aria-label="하단 탭">
  <a href="/index.php" <?= basename($_SERVER['SCRIPT_NAME'])==='index.php'?'aria-current="page"':'' ?>>홈</a>
  <a href="/products.php" <?= basename($_SERVER['SCRIPT_NAME'])==='products.php'?'aria-current="page"':'' ?>>상품</a>
  <a href="#">장바구니</a>
  <a href="#">마이</a>
</nav>

<footer class="footer">
  <div class="container">© 2025 THXDEAL · <a href="#">이용약관</a> · <a href="#">개인정보</a></div>
</footer>

<script src="/assets/js/main.js" defer></script>
