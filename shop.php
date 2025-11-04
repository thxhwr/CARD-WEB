<?php $pageTitle = "쇼핑"; ?>
<!doctype html>
<html lang="ko">
<head><?php include __DIR__ . "/head.php"; ?></head>
<body>
<div class="app">

<?php include __DIR__ . "/header.php"; ?> <!-- 기존 헤더 재사용 -->

        <header class="appbar-apply">
            <nav class="appbar__inner container--narrow" aria-label="상단 내비게이션">
                <img src="/assets/icons/logo.svg">
                <a href="/index.php" class="nav-btn home-btn" aria-label="홈"><img src="/assets/icons/icon-cart.svg"></a>
            </nav>
        </header>

        <main class="page">
            <section class="container--narrow">

                <!-- 1) 배너 -->
                <div class="shop-banner">
                    <img src="/assets/img/img-main-event-sample01.png" alt="혜택 배너">
                </div>

                <div class="shop-best">
                    <div class="shop-categories">
                        <button class="cat is-active">
                            <img src="/assets/icons/icon-all.svg" class="ico">
                            <span>전체</span>
                        </button>

                        <button class="cat">
                            <img src="/assets/icons/icon-health.svg" class="ico">
                            <span>건강</span>
                        </button>

                        <button class="cat">
                            <img src="/assets/icons/icon-life.svg" class="ico">
                            <span>생활</span>
                        </button>

                        <button class="cat">
                            <img src="/assets/icons/icon-beauty.svg" class="ico">
                            <span>뷰티</span>
                        </button>

                        <button class="cat">
                            <img src="/assets/icons/icon-food.svg" class="ico">
                            <span>식품</span>
                        </button>

                        <button class="cat">
                            <img src="/assets/icons/icon-car.svg" class="ico">
                            <span>자동차</span>
                        </button>
                    </div>

                    <div class="shop-grid">
                        <div class="product">
                            <span class="badge">1</span>
                            <img src="/assets/img/img-shop-sample05.png" alt="">
                            <p class="name">파벡스 분리형포트 여행용전 기포트 프리볼EFX-256H</p>
                            <div class="price">
                            <span class="discount">45%</span>
                            <span class="sale">12,400원</span>
                            <span class="origin">36,000원</span>
                            </div>
                            <p class="sold">2,600개 주문했어요</p>
                        </div>

                        <div class="product">
                            <span class="badge">2</span>
                            <img src="/assets/img/img-shop-sample05.png" alt="">
                            <p class="name">아모레퍼시픽 역대 최대 혜택 15% 적립 + 20% 추가 할인</p>
                            <div class="price">
                            <span class="discount">20%</span>
                            <span class="sale">9,200원</span>
                            <span class="origin">12,000원</span>
                            </div>
                            <p class="sold">2,410개 주문했어요</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>

<?php include __DIR__ . "/footer.php"; ?>
</div>
<script>
    document.querySelectorAll('.shop-categories .cat').forEach(btn=>{
        btn.addEventListener('click', ()=>{
            document.querySelectorAll('.cat').forEach(b=>b.classList.remove('is-active'));
            btn.classList.add('is-active');
        });
    });
</script>
</body>
</html>
