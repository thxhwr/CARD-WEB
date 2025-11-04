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
                            $products = [
                            ["name"=>"(남여공용) 티클릿 오버핏 후드 맨투맨", "price"=>12400, "origin"=>36900, "discount"=>45, "img"=>"/assets/img/prod1.jpg"],
                            ["name"=>"파벡스 분리형포트 EFX-256H", "price"=>12400, "origin"=>36900, "discount"=>45, "img"=>"/assets/img/prod2.jpg"],
                            ["name"=>"아모레 최대혜택 세트", "price"=>9200, "origin"=>12000, "discount"=>20, "img"=>"/assets/img/prod3.jpg"],
                            ["name"=>"프리미엄 텀블러 기프트 세트", "price"=>15800, "origin"=>22800, "discount"=>31, "img"=>"/assets/img/prod4.jpg"],
                            ["name"=>"글라스 에어프라이어 4L+1.5L", "price"=>219000, "origin"=>289000, "discount"=>24, "img"=>"/assets/img/prod5.jpg"],
                            ["name"=>"바디케어 스페셜 패키지", "price"=>17900, "origin"=>25800, "discount"=>31, "img"=>"/assets/img/prod6.jpg"],
                            ["name"=>"홈카페 라떼머신 세트", "price"=>89000, "origin"=>129000, "discount"=>31, "img"=>"/assets/img/prod7.jpg"],
                            ["name"=>"유니버설 키친툴 5종", "price"=>27900, "origin"=>39900, "discount"=>30, "img"=>"/assets/img/prod8.jpg"],
                            ["name"=>"코지 담요 2P", "price"=>13900, "origin"=>19900, "discount"=>30, "img"=>"/assets/img/prod9.jpg"],
                            ["name"=>"여행용 파우치 세트 6P", "price"=>11900, "origin"=>17900, "discount"=>34, "img"=>"/assets/img/prod10.jpg"],
                            ["name"=>"무선 미니 선풍기", "price"=>15900, "origin"=>22900, "discount"=>31, "img"=>"/assets/img/prod11.jpg"],
                            ["name"=>"컴팩트 가습기", "price"=>12900, "origin"=>18900, "discount"=>31, "img"=>"/assets/img/prod12.jpg"],
                            ];

                            $perPage = 9;                                     // ✅ 9개씩
                            $total = count($products);
                            $totalPages = max(1, (int)ceil($total / $perPage));
                            $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
                            $page = min($page, $totalPages);
                            $start = ($page - 1) * $perPage;
                            $view = array_slice($products, $start, $perPage);

                            /* 유틸: 숫자 포맷 & XSS 방지 */
                            function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
                            function w($n){ return number_format((int)$n); }

                            /* 현재 URL에 page만 바꿔 붙이기 */
                            function page_url($n){
                            $params = $_GET; $params['page'] = $n;
                            return basename($_SERVER['PHP_SELF']).'?'.http_build_query($params);
                            }
                        ?>

                        <style>
                            /* 섹션 레이아웃 */
                            .weekly-section{max-width:1280px;margin:0 auto;padding:32px 16px;background:#fff;}
                            .weekly-label{color:#FF7634;font-weight:700;font-size:14px;margin-bottom:6px;}
                            .weekly-title{font-size:24px;font-weight:800;margin-bottom:18px;}

                            /* ✅ 3열 그리드 (모바일 2열) */
                            .weekly-grid{
                            display:grid;
                            grid-template-columns:repeat(3,1fr);
                            gap:20px;
                            }
                            @media (max-width:680px){
                            .weekly-grid{ grid-template-columns:repeat(2,1fr); }
                            }

                            /* 카드 */
                            .item{background:#fff;border-radius:12px;}
                            .item img{width:100%;border-radius:12px;margin-bottom:8px;display:block;object-fit:cover;aspect-ratio:1/1;}
                            .item .name{
                            font-size:14px;color:#111;line-height:1.35;margin-bottom:4px;
                            display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;
                            }
                            .item .origin{font-size:13px;color:#999;text-decoration:line-through;margin-bottom:2px;}
                            .item .price{font-size:15px;font-weight:700;color:#111;}
                            .item .price .discount{color:#FF7634;margin-right:4px}

                            /* ✅ 페이지네이션 (9개 초과시에만 표시) */
                            .week-pagination{display:flex;justify-content:center;gap:8px;margin-top:20px;flex-wrap:wrap}
                            .week-pagination .btn{
                            min-width:36px;height:36px;padding:0 10px;border:1px solid #ddd;background:#fff;
                            border-radius:18px;cursor:pointer;font-size:14px;line-height:34px;
                            }
                            .week-pagination .btn[disabled]{opacity:.45;cursor:default}
                            .week-pagination .num{border:1px solid #eee}
                            .week-pagination .num.is-active{background:#111;color:#fff;border-color:#111}
                        </style>

                        <section class="weekly-section">
                            <p class="weekly-label">고객님들이 Pick한</p>
                            <h2 class="weekly-title">이번주 특가 상품</h2>

                            <div class="weekly-grid">
                            <?php foreach($view as $p): ?>
                            <div class="item">
                            <img src="<?= h($p['img']) ?>" alt="<?= h($p['name']) ?>">
                            <p class="name"><?= h($p['name']) ?></p>
                            <p class="origin"><?= w($p['origin']) ?>원</p>
                            <p class="price"><span class="discount"><?= h($p['discount']) ?>%</span> <?= w($p['price']) ?>원</p>
                            </div>
                            <?php endforeach; ?>
                            </div>

                            <?php if ($total > $perPage): ?>
                            <nav class="week-pagination" aria-label="상품 페이지 이동">
                            <a class="btn prev" href="<?= page_url(max(1,$page-1)) ?>" <?= $page<=1?'disabled':'' ?>>‹</a>
                            <?php for($i=1;$i<=$totalPages;$i++): ?>
                            <a class="btn num <?= $i===$page?'is-active':'' ?>" href="<?= page_url($i) ?>"><?= $i ?></a>
                            <?php endfor; ?>
                            <a class="btn next" href="<?= page_url(min($totalPages,$page+1)) ?>" <?= $page>=$totalPages?'disabled':'' ?>>›</a>
                            </nav>
                            <?php endif; ?>
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
</body>
</html>
