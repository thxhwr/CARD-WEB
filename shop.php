<?php $pageTitle = "쇼핑"; ?>
<!doctype html>
<html lang="ko">
<head><?php include __DIR__ . "/head.php"; ?></head>
<body>
<div class="app">

<?php include __DIR__ . "/header.php"; ?> <!-- 기존 헤더 재사용 -->

        <main class="page">
            <section class="container--narrow">

            <!-- 1) 배너 -->
            <div class="shop-banner">
                <img src="/assets/img/img-main-event-sample01.png" alt="혜택 배너">
            </div>

            <!-- 2) 카테고리 아이콘 -->
            <div class="shop-categories">
                <button class="cat is-active">전체</button>
                <button class="cat">건강</button>
                <button class="cat">뷰티</button>
                <button class="cat">리빙</button>
                <button class="cat">식품</button>
                <button class="cat">여행</button>
            </div>

            <!-- 3) 상품 리스트 -->
            <div class="shop-grid">
                <div class="product">
                <img src="/assets/img/prod1.png" alt="">
                <p class="name">피넛츠 프렌즈컵 여행용 기프트 텀블러</p>
                <div class="price"><span class="discount">45%</span> 12,400원</div>
                </div>

                <div class="product">
                <img src="/assets/img/prod2.png" alt="">
                <p class="name">아모레퍼시픽 럭키 에디션 세트</p>
                <div class="price"><span class="discount">20%</span> 9,200원</div>
                </div>

                <!-- ...복제해서 나열... -->
            </div>

            </section>
        </main>

<?php include __DIR__ . "/footer.php"; ?>
</div>
</body>
</html>
