<?php $pageTitle = "카드 신청"; ?>
<!doctype html>
<html lang="ko">
<head>
    <?php include __DIR__ . "/head.php"; ?>
</head>
<body>
    <div class="app">

        <header class="appbar-apply">
            <nav class="appbar__inner container--narrow" aria-label="상단 내비게이션">
                <a href="javascript:history.back()" class="nav-btn" aria-label="뒤로가기">
                    <img src="/assets/icons/btn-next-arrow-left-dg.svg" width="24px" height="24px">
                </a>
                <h1 class="appbar__title">카드 신청</h1>
                <a href="/index.php" class="nav-btn home-btn" aria-label="홈"><img src="/assets/icons/icon-home.svg"></a>
            </nav>
        </header>

        <main class="page">
            <div class="title">
                <strong>오프라인 카드가</strong>
                <strong><span class="accent">정상 발급</span>되었습니다.</strong>
                <p>입력하신 주소로 영업일 기준 <b>3~7일</b> 이내에<br>카드를 발송해 드리겠습니다.</p>
            </div>

            <section class="apply-ok container--narrow">

                <div class="complete-card-box">
                    <div class="thx-card card-img-wrap">
                        <img src="/assets/img/img-card-blank.png" alt="THANKS CARD" class="card-img">
                        <div class="card-text card-number">5395 9188 8888 8888</div>
                        <!-- <div class="card-text card-holder">CHAN TAI MAN</div> -->
                        <!-- <div class="card-text card-expire">01/23</div> -->
                    </div>

                    <div class="card-info">
                    <strong class="card-name">땡스페이 비자 카드</strong>

                    <div class="info-list">
                        <div><span>카드번호</span><b>5395 9188 8888 8888</b></div>
                        <div><span>유효기간</span><b>01/23</b></div>
                        <div><span>소유자</span><b>김땡스</b></div>
                    </div>
                    </div>
                </div>

                <a href="index.php" class="btn-home">카드 홈</a>

            </section>
        </main>
    </div>
</body>
</html>
