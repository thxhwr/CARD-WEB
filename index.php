<?php $pageTitle = "홈"; ?>
<!doctype html>
<html lang="ko">
<head>
  <?php include __DIR__ . "/head.php"; ?>
</head>
<body>
  <div class="app">    
    <header class="appbar">
      <div class="brand"><img src="assets/icons/logo.svg"></div>
    </header>
    <div class="title">
      <strong>오프라인 카드 받고</strong>
      <strong class="accent">특별한 혜택을 누리세요</strong>
    </div>
    <main class="phone" role="main" aria-label="THX Deal 앱 화면">
      <section class="screen">
        <article class="promo" aria-label="땡스페이 비자 카드">
          <div class="cc-preview">
            <img src="assets/img/img-card-blank.png" alt="땡스페이 카드 이미지" class="cc-img">
          </div>
          <div style="text-align:center;margin:30px">
            <span style="font-size:22px;font-weight:bold">땡스페이 비자 카드</span>
          </div>
          <div style="width:100%;margin:0 auto;text-align:center">
            <ul class="list" aria-label="혜택 목록">
              <li><img src="/assets/icons/icon-main-card-benefit01@2x.png" width="24px" height="24px" ><span>THX 가맹점 <b>10% 할인</b></span></li>
              <li><img src="/assets/icons/icon-main-card-benefit02@2x.png" width="24px" height="24px"><span>멤버스 포인트 <b>2~5% 적립</b></span></li>
              <li><img src="/assets/icons/icon-main-card-benefit03@2x.png" width="24px" height="24px"><span>THX MALL <b>보너스 포인트</b></span></li>
            </ul>
          </div>
          <p class="desc">지금 발급하면 <b>3~5일</b> 이내에 <br>안전하게 배송해드려요</p>
        </article>
        <button class="cta" type="button">
          오프라인 카드 발급 신청
          <img src="/assets/icons/btn-next-arrow-right-w@2x.png" alt="" class="cta-icon">
        </button>
      </section>
    </main>
    <?php include __DIR__ . "/footer.php"; ?>
  </div>
</body>
</html>
