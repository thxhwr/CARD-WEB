<?php $pageTitle = "홈"; ?>
<!doctype html>
<html lang="ko">
<head>
  <?php include __DIR__ . "/head.php"; ?>
</head>
<body>
  <main class="phone" role="main" aria-label="THX Deal 앱 화면">
    <!-- 상단 -->
    <header class="appbar" aria-label="앱바">
      <div class="brand"><span class="brand-badge">THX</span> Deal</div>
    </header>

    <!-- 본문 -->
    <section class="screen">
      <div class="title">
        <strong>오프라인 카드 받고</strong>
        <strong class="accent">특별한 혜택을 누리세요</strong>
      </div>

      <article class="promo" aria-label="땡스페이 비자 카드">
        <div class="cc-preview">
          <img src="assets/img/img-card-black.png" alt="땡스페이 카드 이미지" class="cc-img">
        </div>

        <h2>땡스페이 비자 카드</h2>

        <ul class="list" aria-label="혜택 목록">
          <li><span class="ico">%</span><span>THX 가맹점 <b>10% 할인</b></span></li>
          <li><span class="ico">★</span><span>멤버스 포인트 <b>2~5% 적립</b></span></li>
          <li><span class="ico">＋</span><span>THX MALL <b>보너스 포인트</b></span></li>
        </ul>

        <p class="desc">지금 발급하면 <b>3~5일</b> 이내에 안전하게 배송해드려요</p>

        <button class="cta" type="button">오프라인 카드 발급 신청</button>
      </article>
    </section>

    <!-- 하단 탭 -->
    <nav class="tabbar" aria-label="하단 탭">
      <a class="tab" href="#"><span class="t-ico">🔎</span>검색</a>
      <a class="tab" href="#"><span class="t-ico">🧾</span>주문내역</a>
      <a class="tab is-active" href="#"><span class="t-ico">💳</span>카드</a>
      <a class="tab" href="#"><span class="t-ico">🛍</span>쇼핑</a>
      <a class="tab" href="#"><span class="t-ico">🙂</span>My</a>
    </nav>
  </main>


  <?php include __DIR__ . "/footer.php"; ?>
</body>
</html>
