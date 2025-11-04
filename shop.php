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

                <div class="shop-now">
                    <DIV class="shop-now-title">
                        <strong style="font-size:18px">실시간 베스트 상품</strong>
                        <DIV class="more-link">
                            <a href="#" class="find-link">전체보기</a>
                            <img src="/assets/img/btn-next-arrow-right-dg.png">
                        </DIV>    
                    </DIV>
                    <p style="margin:10px 0 20px">땡스딜의 베스트 상품을 만나보세요.</p>
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

                        <div class="product">
                            <span class="badge">3</span>
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
                            <span class="badge">4</span>
                            <img src="/assets/img/img-shop-sample05.png" alt="">
                            <p class="name">아모레퍼시픽 역대 최대 혜택 15% 적립 + 20% 추가 할인</p>
                            <div class="price">
                            <span class="discount">20%</span>
                            <span class="sale">9,200원</span>
                            <span class="origin">12,000원</span>
                            </div>
                            <p class="sold">2,410개 주문했어요</p>
                        </div>

                        <div class="product">
                            <span class="badge">5</span>
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
                            <span class="badge">6</span>
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

                    <div>
                        <button class="btn-more" >상품 더보기<img src="/assets/img/btn-next-arrow-right-dg.png"></button>
                    </div>
                </div>

                <div class="shop-pick">
                    <section class="point-section">
                        <h2 class="point-title">
                            <span class="label">지금 PICK!</span><br>
                            포인트 왕창드려요
                        </h2>
                        <p class="point-sub">역대급 포인트 적립 상품을 만나보세요</p>

                        <div class="point-list">
                            <div class="point-item">
                                <img src="/assets/img/img-shop-sample05.png" alt="">
                                <p class="name">마르쿠진 글라스 에어프라이어 에어프랭 4L+1.5L</p>
                                <div class="price">
                                    <span class="sale">219,000원</span>
                                    <span class="discount">20%</span>
                                </div>
                                <span class="origin">289,000원</span>
                                <div class="point-badge">2,100P 적립</div>
                            </div>

                            <div class="point-item">
                                <img src="/assets/img/img-shop-sample05.png" alt="">
                                <p class="name">아모레퍼시픽 역대 최대 혜택 15% 적립 + 20% 추가 할인</p>
                                <div class="price">
                                    <span class="sale">9,200원</span>
                                    <span class="discount">20%</span>
                                </div>
                                <span class="origin">12,000원</span>
                                <div class="point-badge">1,700P 적립</div>
                            </div>

                            <div class="point-item">
                                <img src="/assets/img/img-shop-sample05.png" alt="">
                                <p class="name">아모레퍼시픽 역대 최대 혜택 15% 적립 + 20% 추가 할인</p>
                                <div class="price">
                                    <span class="sale">9,200원</span>
                                    <span class="discount">20%</span>
                                </div>
                                <span class="origin">12,000원</span>
                                <div class="point-badge">1,700P 적립</div>
                            </div>

                        </div>
                    </section>
                </div>

                <div class="shop-best">
                    <section class="best-section">
                        <p class="best-label">땡스딜 MD가 엄선한</p>
                        <h2 class="best-title">베스트 특가 상품만 모았어요</h2>

                        <ul class="best-list">
                            <li class="best-item">
                                <span class="rank">1</span>
                                <img src="/assets/img/img-shop-sample05.png" alt="" class="thumb">
                                <div class="info">
                                    <p class="name">파멕스 분리형포트 여행용전기포트 프리볼 EFX-256HX / 800ml 넉넉한dsdasdsadadasdsdada</p>
                                    <p class="price">
                                    <span class="discount">45%</span>
                                    <span class="sale">12,400원</span>
                                    <span class="origin">36,900원</span>
                                    </p>
                                </div>
                            </li>

                            <li class="best-item">
                                <span class="rank">2</span>
                                <img src="/assets/img/img-shop-sample05.png" alt="" class="thumb">
                                <div class="info">
                                    <p class="name">던킨도너츠 기프티콘 45% 할인</p>
                                    <p class="price">
                                    <span class="discount">20%</span>
                                    <span class="sale">9,200원</span>
                                    <span class="origin">12,000원</span>
                                    </p>
                                </div>
                            </li>

                            <li class="best-item">
                                <span class="rank">3</span>
                                <img src="/assets/img/img-shop-sample05.png" alt="" class="thumb">
                                <div class="info">
                                    <p class="name">던킨도너츠 기프티콘 45% 할인</p>
                                    <p class="price">
                                    <span class="discount">20%</span>
                                    <span class="sale">9,200원</span>
                                    <span class="origin">12,000원</span>
                                    </p>
                                </div>
                            </li>

                            <li class="best-item">
                                <span class="rank">4</span>
                                <img src="/assets/img/img-shop-sample05.png" alt="" class="thumb">
                                <div class="info">
                                    <p class="name">던킨도너츠 기프티콘 45% 할인</p>
                                    <p class="price">
                                    <span class="discount">20%</span>
                                    <span class="sale">9,200원</span>
                                    <span class="origin">12,000원</span>
                                    </p>
                                </div>
                            </li>

                            <li class="best-item">
                                <span class="rank">5</span>
                                <img src="/assets/img/img-shop-sample05.png" alt="" class="thumb">
                                <div class="info">
                                    <p class="name">던킨도너츠 기프티콘 45% 할인</p>
                                    <p class="price">
                                    <span class="discount">20%</span>
                                    <span class="sale">9,200원</span>
                                    <span class="origin">12,000원</span>
                                    </p>
                                </div>
                            </li>
                        </ul>

                        <div>
                            <button class="best-more" >상품 더보기<img src="/assets/img/btn-next-arrow-right-dg.png"></button>
                        </div>
                    </section>
                </div>
                <div class="weekly-grid" id="weeklyGrid">
                    <?php
                            // ★ 에러 보이게 (무조건!)
                            ini_set('display_errors', '1');
                            error_reporting(E_ALL);

                            // ★ HTML 이스케이프 헬퍼 (없으면 Fatal 납니다)
                            if (!function_exists('h')) {
                            function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
                            }

                            // ★ 샘플 데이터 (그대로 사용)
                            $products = [
                            ["img"=>"/assets/img/img-shop-sample05.png","name"=>"(남여공용) 국내제조 티클릿 후드티","origin"=>36900,"discount"=>45,"price"=>12400],
                            ["img"=>"/assets/img/img-shop-sample05.png","name"=>"파벡스 분리형 포터블 여행용 전기포트","origin"=>36900,"discount"=>45,"price"=>12400],
                            ["img"=>"/assets/img/img-shop-sample05.png","name"=>"파벡스 브런치 홈 세트","origin"=>36900,"discount"=>45,"price"=>12400],
                            ["img"=>"/assets/img/img-shop-sample05.png","name"=>"씨밀렉스 드라이 캠핑 식기세트","origin"=>36900,"discount"=>45,"price"=>12400],
                            ["img"=>"/assets/img/img-shop-sample05.png","name"=>"에스로레 올 뉴 오픈 캐리어","origin"=>36900,"discount"=>45,"price"=>12400],
                            ["img"=>"/assets/img/img-shop-sample05.png","name"=>"아모레퍼시픽 역대 최대 혜택","origin"=>36900,"discount"=>45,"price"=>12400],
                            ["img"=>"/assets/img/img-shop-sample05.png","name"=>"(전자제품 초특가) 전기포트","origin"=>36900,"discount"=>45,"price"=>12400],
                            ["img"=>"/assets/img/img-shop-sample05.png","name"=>"에어프라이어 4L 특가","origin"=>36900,"discount"=>45,"price"=>12400],
                            ["img"=>"/assets/img/img-shop-sample05.png","name"=>"홍대 쭈꾸미 1.9kg","origin"=>36900,"discount"=>45,"price"=>12400],
                            ["img"=>"/assets/img/img-shop-sample05.png","name"=>"(남여공용) 국내제조 티클릿 후드티","origin"=>36900,"discount"=>45,"price"=>12400],
                            ["img"=>"/assets/img/img-shop-sample05.png","name"=>"파벡스 분리형 포터블 여행용 전기포트","origin"=>36900,"discount"=>45,"price"=>12400],
                            ["img"=>"/assets/img/img-shop-sample05.png","name"=>"파벡스 브런치 홈 세트","origin"=>36900,"discount"=>45,"price"=>12400],
                            ["img"=>"/assets/img/img-shop-sample05.png","name"=>"씨밀렉스 드라이 캠핑 식기세트","origin"=>36900,"discount"=>45,"price"=>12400],
                            ["img"=>"/assets/img/img-shop-sample05.png","name"=>"에스로레 올 뉴 오픈 캐리어","origin"=>36900,"discount"=>45,"price"=>12400],
                            ["img"=>"/assets/img/img-shop-sample05.png","name"=>"아모레퍼시픽 역대 최대 혜택","origin"=>36900,"discount"=>45,"price"=>12400],
                            ["img"=>"/assets/img/img-shop-sample05.png","name"=>"(전자제품 초특가) 전기포트","origin"=>36900,"discount"=>45,"price"=>12400],
                            ["img"=>"/assets/img/img-shop-sample05.png","name"=>"에어프라이어 4L 특가","origin"=>36900,"discount"=>45,"price"=>12400],
                            ["img"=>"/assets/img/img-shop-sample05.png","name"=>"홍대 쭈꾸미 1.9kg","origin"=>36900,"discount"=>45,"price"=>12400],
                            ["img"=>"/assets/img/img-shop-sample05.png","name"=>"(남여공용) 국내제조 티클릿 후드티","origin"=>36900,"discount"=>45,"price"=>12400],
                            ["img"=>"/assets/img/img-shop-sample05.png","name"=>"파벡스 분리형 포터블 여행용 전기포트","origin"=>36900,"discount"=>45,"price"=>12400],
                            ["img"=>"/assets/img/img-shop-sample05.png","name"=>"파벡스 브런치 홈 세트","origin"=>36900,"discount"=>45,"price"=>12400],
                            ["img"=>"/assets/img/img-shop-sample05.png","name"=>"씨밀렉스 드라이 캠핑 식기세트","origin"=>36900,"discount"=>45,"price"=>12400],
                            ["img"=>"/assets/img/img-shop-sample05.png","name"=>"에스로레 올 뉴 오픈 캐리어","origin"=>36900,"discount"=>45,"price"=>12400],
                            ["img"=>"/assets/img/img-shop-sample05.png","name"=>"아모레퍼시픽 역대 최대 혜택","origin"=>36900,"discount"=>45,"price"=>12400],
                            ["img"=>"/assets/img/img-shop-sample05.png","name"=>"(전자제품 초특가) 전기포트","origin"=>36900,"discount"=>45,"price"=>12400],
                            ["img"=>"/assets/img/img-shop-sample05.png","name"=>"에어프라이어 4L 특가","origin"=>36900,"discount"=>45,"price"=>12400],
                            ["img"=>"/assets/img/img-shop-sample05.png","name"=>"홍대 쭈꾸미 1.9kg","origin"=>36900,"discount"=>45,"price"=>12400],
                            // … 더 있어도 됨
                            ];

                            // ★ 페이징
                            $perPage = 9;
                            $total = count($products);
                            $totalPages = max(1, (int)ceil($total / $perPage));
                            $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
                            $page = min($page, $totalPages);
                            $start = ($page - 1) * $perPage;
                            $view = array_slice($products, $start, $perPage);

                            // ★ 페이지 URL 생성
                            function page_url($n){
                            $q = $_GET; $q['page'] = $n;
                            return basename($_SERVER['PHP_SELF']).'?'.http_build_query($q);
                            }
                            ?>


                    <section class="weekly-section">
                        <p class="weekly-label">고객님들이 Pick한</p>
                        <h2 class="weekly-title"><span>이번주 특가 상품</span></h2>

                        <div class="product-grid">
                            <?php foreach($view as $p): ?>
                            <article class="product-card">
                                <img src="<?= h($p['img']) ?>" alt="<?= h($p['name']) ?>">
                                <h3 class="name"><?= h($p['name']) ?></h3>
                                <p class="origin"><?= number_format($p['origin']) ?>원</p>
                                <p class="discount" style="margin:0;padding:0 4px"><?= (int)$p['discount'] ?>%</p> 
                                <p class="price">
                                    <?= number_format($p['price']) ?>원
                                </p>
                            </article>
                            <?php endforeach; ?>
                        </div>

                        <?php if ($total > $perPage): 
                            $prevDisabled = $page <= 1;
                            $nextDisabled = $page >= $totalPages; ?>
                            <nav class="pager" aria-label="상품 페이지 이동">
                            <a class="pager__arrow prev <?= $prevDisabled?'is-disabled':'is-active' ?>"
                                href="<?= !$prevDisabled ? page_url($page-1) : 'javascript:void(0)' ?>"
                                aria-label="이전" <?= $prevDisabled?'aria-disabled="true" tabindex="-1"':'' ?>></a>

                            <a class="pager__arrow next <?= $nextDisabled?'is-disabled':'is-active' ?>"
                                href="<?= !$nextDisabled ? page_url($page+1) : 'javascript:void(0)' ?>"
                                aria-label="다음" <?= $nextDisabled?'aria-disabled="true" tabindex="-1"':'' ?>></a>
                            </nav>
                        <?php endif; ?>
                    </section>
                </div>
                <div class="review">
                    <section class="reviews" >
                        <div class="reviews__head">
                            <h3 class="reviews__title">상품 이용후기</h3>
                            <DIV class="more-link">
                                <a href="#" class="find-link">전체보기</a>
                                <img src="/assets/img/btn-next-arrow-right-dg.png">
                            </DIV>   
                        </div>
                        <p class="reviews__sub">고객님들의 생생한 후기를 확인하세요 👍</p>

                        <!-- 가로 스크롤 레일 -->
                        <div class="reel" id="reviewReel" aria-label="이용후기 목록">
                        <!-- 카드 1 -->
                            <article class="r-card">
                                <div class="r-thumb">
                                    <img src="assets/img/img-shop-review-sample02.png" alt="리뷰 이미지 1">
                                </div>
                                <h4 class="r-title">아빠 생신 선물로 샀드렸어요.</h4>
                                <p class="r-excerpt">디자인이 세련되어 고급스러운 향이 나요. 만족합니다!</p>
                                <div class="r-meta">
                                    <div class="rating" data-value="5"></div> <!-- 5점 -->
                                    <span class="r-buyer">홍*동</span>
                                </div>
                                <hr class="r-divider" role="presentation">

                                <a href="#" class="r-prod" aria-label="카우프만 데이지코모 IH주… 상품 보기">
                                    <span class="r-prod__thumb">
                                        <img src="/assets/img/img-shop-sample05.png" alt="">
                                    </span>
                                    <span class="r-prod__title">카우프만 데이지코모 IH주…</span>
                                </a>
                            </article>

                            <!-- 카드 2 -->
                            <article class="r-card">
                                <div class="r-thumb">
                                <img src="assets/img/img-shop-review-sample02.png" alt="리뷰 이미지 2">
                                </div>
                                <h4 class="r-title">너무 좋습니다! 대만족</h4>
                                <p class="r-excerpt">보틀 유광이라 손에 잘 잡히고 세척도 편해요.</p>
                                <div class="r-meta">
                                    <div class="rating" data-value="3.5"></div> <!-- 3.5점 -->
                                    <span class="r-buyer">민*진</span>
                                </div>
                                <hr class="r-divider" role="presentation">

                                <a href="#" class="r-prod" aria-label="카우프만 데이지코모 IH주… 상품 보기">
                                    <span class="r-prod__thumb">
                                        <img src="/assets/img/img-shop-sample05.png" alt="">
                                    </span>
                                    <span class="r-prod__title">카우프만 데이지코모 IH주…</span>
                                </a>
                            </article>

                            <article class="r-card">
                                <div class="r-thumb">
                                <img src="assets/img/img-shop-review-sample02.png" alt="리뷰 이미지 2">
                                </div>
                                <h4 class="r-title">너무 좋습니다! 대만족</h4>
                                <p class="r-excerpt">보틀 유광이라 손에 잘 잡히고 세척도 편해요.</p>
                                <div class="r-meta">
                                    <div class="rating" data-value="4"></div> <!-- 3.5점 -->
                                    <span class="r-buyer">민*진</span>
                                </div>
                                <hr class="r-divider" role="presentation">

                                <a href="#" class="r-prod" aria-label="카우프만 데이지코모 IH주… 상품 보기">
                                    <span class="r-prod__thumb">
                                        <img src="/assets/img/img-shop-sample05.png" alt="">
                                    </span>
                                    <span class="r-prod__title">카우프만 데이지코모 IH주…</span>
                                </a>
                            </article>

                            <article class="r-card">
                                <div class="r-thumb">
                                <img src="assets/img/img-shop-review-sample02.png" alt="리뷰 이미지 2">
                                </div>
                                <h4 class="r-title">너무 좋습니다! 대만족</h4>
                                <p class="r-excerpt">보틀 유광이라 손에 잘 잡히고 세척도 편해요.</p>
                                <div class="r-meta">
                                    <div class="rating" data-value="1"></div> <!-- 3.5점 -->
                                    <span class="r-buyer">민*진</span>
                                </div>
                                <hr class="r-divider" role="presentation">

                                <a href="#" class="r-prod" aria-label="카우프만 데이지코모 IH주… 상품 보기">
                                    <span class="r-prod__thumb">
                                        <img src="/assets/img/img-shop-sample05.png" alt="">
                                    </span>
                                    <span class="r-prod__title">카우프만 데이지코모 IH주…</span>
                                </a>
                            </article>
                        </div>
                    </section>
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

    (function(){
    const grid = document.getElementById('weeklyGrid');
    const pager = document.getElementById('weekPager');
    const pageSize = 9;                          // ✅ 페이지당 9개
    const items = Array.from(grid.children);     // 모든 카드
    const pageCount = Math.ceil(items.length / pageSize);
    let current = 1;

    function render(){
        // 보여줄 범위만 표시
        const start = (current - 1) * pageSize;
        const end = start + pageSize;
        items.forEach((el, i)=>{
        el.style.display = (i >= start && i < end) ? '' : 'none';
        });

        // 페이저 갱신
        pager.innerHTML = '';
        if(pageCount <= 1){ pager.style.display = 'none'; return; }
        pager.style.display = 'flex';

        const mkBtn = (txt, cls, disabled, onClick)=>{
        const b = document.createElement('button');
        b.type = 'button'; b.className = `btn ${cls||''}`.trim(); b.textContent = txt;
        if(disabled) b.disabled = true;
        if(onClick) b.addEventListener('click', onClick);
        return b;
        };

        // Prev
        pager.appendChild(mkBtn('‹','prev', current===1, ()=>{ current--; render(); }));

        // 숫자 (필요하면 ellipsis 로 축약 가능)
        for(let n=1;n<=pageCount;n++){
        const num = mkBtn(String(n), 'num'+(n===current?' is-active':''), false, ()=>{
            current = n; render();
        });
        pager.appendChild(num);
        }

        // Next
        pager.appendChild(mkBtn('›','next', current===pageCount, ()=>{ current++; render(); }));
    }

    render();
})();
</script>

<script>
  // 뒤로가기 시 스크롤 유지
    window.history.scrollRestoration = "manual";

    // 페이지 떠날 때 스크롤 위치 저장
    window.addEventListener("beforeunload", () => {
    sessionStorage.setItem("scrollY", window.scrollY);
    });

    // 다시 들어왔을 때 복구
    window.addEventListener("load", () => {
    const y = sessionStorage.getItem("scrollY");
    if (y !== null) window.scrollTo(0, parseInt(y));
    });

    document.querySelectorAll('.rating').forEach(el => {
        const val = Number(el.dataset.value) || 0;
        el.style.setProperty('--rate', val);
    });
</script>


</body>
</html>
