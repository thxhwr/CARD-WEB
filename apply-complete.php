<?php $pageTitle = "카드 신청"; ?>
<!doctype html>
<html lang="ko">
<head>
    <?php include __DIR__ . "/head.php"; ?>
</head>
<body>
    <div class="app">

    <!-- 상단 앱바 -->
    <header class="appbar">
        <nav class="appbar__inner">
        <a href="javascript:history.back()" class="nav-btn">←</a>
        <h1 class="appbar__title">카드 신청</h1>
        <a href="/index.php" class="home-btn">🏠</a>
        </nav>
    </header>

    <main class="page">
        <section class="container--narrow">

        <div class="complete-msg">
            <h2><b>오프라인 카드가</b><br>정상 발급되었습니다</h2>
            <p>입력하신 주소로 영업일 기준 <b>3~7일</b> 이내에<br>카드를 발송해 드리겠습니다.</p>
        </div>

        <div class="complete-card-box">
            <div class="card-img-wrap">
            <img src="/assets/img/img-card-blank.png" alt="THANKS CARD" class="card-img">
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

    <?php include __DIR__ . "/footer.php"; ?>
    </div>
</body>
</html>
