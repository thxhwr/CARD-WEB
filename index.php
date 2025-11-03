<?php $pageTitle = "홈"; ?>
<!doctype html>
<html lang="ko">
<head>
  <?php include __DIR__ . "/head.php"; ?>
</head>
<body>
  <>
  <header class="appbar">THX Deal</header>

  <!-- 본문: 모바일 디자인 폭을 유지하고 싶으면 container--narrow 사용 -->
  <main class="page">
    <section class="container--narrow mt-4">
      <h1>오프라인 카드 받고<br><span style="color:var(--primary)">특별한 혜택</span>을 누리세요</h1>

      <article class="card mb-4">
        <div class="card__media">
          <!-- 카드 이미지 (반응형) -->
          <img src="assets/img/img-card-blank@2x.png" alt="카드" style="width:100%;height:auto;display:block;border-radius:var(--r-md)">
        </div>
        <div class="card__body">
          <h2>땡스페이 비자 카드</h2>
          <p class="text">THX 가맹점 10% 할인 · 멤버스 포인트 2~5% 적립 · THX MALL 보너스 포인트</p>
          <button class="btn btn--primary" type="button">
            오프라인 카드 발급 신청
            <img src="assets/icons/btn-next-arrow-right-w@2x.png" alt="" width="16" height="16">
          </button>
        </div>
      </article>
    </section>
  </main>

  <nav class="tabbar" role="tablist" aria-label="하단 탭">
    <a class="tab" href="#"><span class="ico"><img src="assets/icons/ico-gnb01.svg" alt=""></span>검색</a>
    <a class="tab" href="#"><span class="ico"><img src="assets/icons/ico-gnb02.svg" alt=""></span>주문내역</a>
    <a class="tab is-active" href="#"><span class="ico"><img src="assets/icons/ico-gnb-card-home-sel.svg" alt=""></span>카드</a>
    <a class="tab" href="#"><span class="ico"><img src="assets/icons/ico-gnb03.svg" alt=""></span>쇼핑</a>
    <a class="tab" href="#"><span class="ico"><img src="assets/icons/ico-gnb04.svg" alt=""></span>My</a>
  </nav>
</body>
</html>
