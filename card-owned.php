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
                    <div class="thx-card-wrap">
                        <svg class="thx-card" viewBox="0 0 237 147" role="img" aria-label="THX 카드">
                        <!-- 카드 이미지(원본 비율에 맞춘 viewBox: 237×147) -->
                        <image href="/assets/img/img-card-blank.png" x="0" y="0" width="237" height="147"/>

                        <!-- 필터: 약한 양각/그림자 -->
                        <defs>
                            <filter id="emboss">
                            <feDropShadow dx="0" dy="1" stdDeviation="0.8" flood-opacity="0.65"/>
                            </filter>
                        </defs>

                        <!-- 카드번호 -->
                        <text class="card-num" x="25" y="95" filter="url(#emboss)">
                            5395 9188 8888 8888
                        </text>

                        <!-- 유효기간 -->
                        <!-- <text class="card-exp" x="49" y="95" filter="url(#emboss)">01 / 23</text> -->

                        <!-- 소유자명 -->
                        <!-- <text class="card-owner" x="19" y="114" filter="url(#emboss)">CHAN TAI MAN</text> -->
                        </svg>
                    </div>
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
