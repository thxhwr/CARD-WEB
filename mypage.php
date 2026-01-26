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
            <a href="./mypage.php" class="nav-btn" aria-label="뒤로가기">
                <img src="/assets/icons/btn-next-arrow-left-dg.svg" width="24px" height="24px">
            </a>
            <h1 class="appbar__title">마이페이지</h1>
            <a href="/index.php" class="nav-btn home-btn" aria-label="홈"></a>
        </nav>
    </header>

     <main class="page">
            <section class="apply-form">
                <div class="f-group">
                    <div class="mypage-section-title">이메일</div>
                    <div class="mypage-user-id" style="text-align:right">
                        <?= htmlspecialchars($_SESSION['user_No'] ?? '', ENT_QUOTES) ?>
                    </div>
                </div>
                <div class="f-group">
                    <div class="mypage-section-title">아이디</div>
                    <div class="mypage-user-id" style="text-align:right">
                        <?= htmlspecialchars($_SESSION['user_Id'] ?? '', ENT_QUOTES) ?>
                    </div>
                </div>
                <div class="f-group" onclick="location.href='point-history.php?type=TP'">
                    <div class="mypage-section-title">땡스 포인트</div>
                    <div class="mypage-pay-wrap">
                        <div>
                            <div class="mypage-pay-amount" style="text-align:right">
                                <?= number_format($had['data']['data']['TP'] ?? 0) ?>
                                <span class="mypage-pay-unit">TP</span>
                                <img src="/assets/icons/btn-next-arrow-right-g@2x.png" alt=">" class="arrow-icon" style="width: 17px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="f-group" onclick="location.href='point-history.php?type=SP'">
                    <div class="mypage-section-title">쇼핑 포인트</div>
                    <div class="mypage-pay-wrap">
                        <div>
                            <div class="mypage-pay-amount" style="text-align:right">
                                <?= number_format($had['data']['data']['SP'] ?? 0) ?>
                                <span class="mypage-pay-unit">SP</span>
                                <img src="/assets/icons/btn-next-arrow-right-g@2x.png" alt=">" class="arrow-icon" style="width: 17px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="f-group" onclick="location.href='point-history.php?type=LP'">
                    <div class="mypage-section-title">행운 포인트</div>
                    <div class="mypage-pay-wrap">
                        <div>
                            <div class="mypage-pay-amount" style="text-align:right">
                                <?= number_format($had['data']['data']['LP'] ?? 0) ?>
                                <span class="mypage-pay-unit">LP </span>
                                <img src="/assets/icons/btn-next-arrow-right-g@2x.png" alt=">" class="arrow-icon" style="width: 17px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="f-group" style="padding:20px 0">
                    <a href="/member-tree.php" class="mypage-link">
                        <div class="mypage-section-title" style="margin:0;">추천인</div>
                        <!-- <span>추천인</span> -->
                        <img src="/assets/icons/btn-next-arrow-right-g@2x.png" alt=">" class="arrow-icon">
                    </a>
                </div>
                 <?php if($_SESSION['user_No'] == "youbr919@naver.com"){?>
                <div class="f-group" style="padding:20px 0">
                    <a href="/withdraw-other.php" class="mypage-link">
                        <div class="mypage-section-title" style="margin:0;">출금하기</div>
                        <!-- <span>추천인</span> -->
                        <img src="/assets/icons/btn-next-arrow-right-g@2x.png" alt=">" class="arrow-icon">
                    </a>
                </div>
                <?php }?>
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
