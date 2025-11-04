<?php $pageTitle = "THX Deal"; ?>
<!doctype html>
<html lang="ko">
<head><?php include __DIR__ . "/head.php"; ?></head>
<body>
<style>
    body {background:#F3F3F6}
</style>
<div class="app">
    <header class="appbar">
        <div class="brand"><img src="assets/icons/logo.svg"></div>
    </header>

    <main class="page">
        <div class="title">
            <strong>김떙스 님은</strong>
            <strong><span class="accent">THX카드 보유자</span>입니다.</strong>
        </div>

        <section class="owned-ok container--narrow">
            <div class="owned-card-box">
                <div class="badge">보유중</div>
                <h3 class="owned-title">땡스페이 비자 카드</h3>
                <div class="owned-art">
                    <div class="owned-circle"></div>
                    <img src="/assets/img/img-card-blank.png" alt="THANKS CARD" class="owned-img">
                </div>

                <div class="card-info">

                    <div class="owend-info-list">
                        <div><span>카드번호</span><b>5395 9188 8888 8888</b></div>
                        <div><span>유효기간</span><b>01/23</b></div>
                        <div><span>소유자</span><b>김땡스</b></div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include __DIR__ . "/footer.php"; ?>
</div>
</body>
</html>
