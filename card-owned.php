<?php $pageTitle = "THX Deal"; ?>
<!doctype html>
<html lang="ko">
<head><?php include __DIR__ . "/head.php"; ?></head>
<body>
<div class="app">
    <header class="appbar">
      <div class="brand"><img src="assets/icons/logo.svg"></div>
    </header>

    <main class="page">
        <section class="container--narrow">
            <div class="owned-hero">
                <h2><b>김땡스</b> 님은<br><span class="accent">땡스카드 보유자</span>입니다.</h2>
            </div>
            <article class="owned-card">
                <div class="badge">보유중</div>

                <h3 class="owned-title">땡스페이 비자 카드</h3>

                <div class="owned-art">
                    <div class="owned-circle"></div>
                    <img src="/assets/img/img-card-blank.png" alt="카드 이미지" class="owned-img">
                </div>

                <div class="owned-info">
                    <div><span>카드번호</span><b>5395 9188 8888 8888</b></div>
                    <div><span>유효기간</span><b>01/23</b></div>
                    <div><span>소유자</span><b>김땡스</b></div>
                </div>
            </article>

        </section>
    </main>

    <?php include __DIR__ . "/footer.php"; ?>
</div>
</body>
</html>
