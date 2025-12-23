<?php $pageTitle = "마이페이지"; ?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include __DIR__ . "/auth.php"; ?>
    <?php include __DIR__ . "/head.php"; ?>
</head>
<body>

<div class="app">
    <header class="appbar-apply">
        <nav class="appbar__inner container--narrow" aria-label="상단 내비게이션">
            <a href="javascript:history.back()" class="nav-btn" aria-label="뒤로가기">
                <img src="/assets/icons/btn-next-arrow-left-dg.svg" width="24px" height="24px">
            </a>
            <h1 class="appbar__title">마이페이지</h1>
            <a href="/index.php" class="nav-btn home-btn" aria-label="홈"></a>
        </nav>
    </header>

     <main class="page">
            <section class="apply-form">
                <div class="f-group">
                    <div class="mypage-section-title">계 정</div>
                    <div class="mypage-user-id">
                        <?= htmlspecialchars($_SESSION['user_No'] ?? '', ENT_QUOTES) ?>
                    </div>
                </div>
                <div class="f-group">
                    <div class="mypage-section-title">보유 페이</div>
                    <div class="mypage-pay-wrap">
                        <div>
                            <div class="mypage-pay-amount">
                                <?= number_format($user_pay ?? 0) ?>
                                <span class="mypage-pay-unit">P</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="f-group">
                    <a href="/member-tree.php" class="mypage-link">
                        <div class="mypage-section-title" style="margin:0;">추천인</div>
                        <!-- <span>추천인</span> -->
                        <img src="/assets/icons/btn-next-arrow-right-g@2x.png" alt=">" class="arrow-icon">
                    </a>
                </div>
                <div class="mypage-actions">
                    <form action="/logout.php" method="post">
                        <button type="submit" class="btn-logout">로그아웃</button>
                    </form>
                </div>
            </section>
    </main>
     <?php include __DIR__ . "/footer.php"; ?>
</div>
</body>
</html>
