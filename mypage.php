<?php $pageTitle = "마이페이지"; ?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include __DIR__ . "/head.php"; ?>
    <style>
        .mypage-title {
            font-size: 20px;
            font-weight: 700;
        }

        .mypage-sub {
            font-size: 13px;
            color: var(--primary);
        }

        .mypage-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 18px 16px;
            box-shadow:
                0 10px 15px -10px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(15, 23, 42, 0.02);
            margin-bottom: 16px;
        }

        .mypage-section-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 6px;
        }

        .mypage-user-id {
            font-size: 17px;
            font-weight: 600;
        }

        .mypage-pay-wrap {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 8px;
        }

        .mypage-pay-amount {
            font-size: 22px;
            font-weight: 700;
        }

        .mypage-pay-unit {
            font-size: 20px;
            margin-left: 4px;
        }

        .mypage-pay-label {
            font-size: 13px;
            color: var(--primary);
        }

        .mypage-actions {
            margin-top: 24px;
        }

        .btn-logout {
            width: 100%;
            border: none;
            border-radius: 999px;
            padding: 13px 16px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            background: var(--primary);
            color: #ffffff;
            transition: background 0.15s ease, transform 0.08s ease;
        }

        .btn-logout:active {
            transform: translateY(1px);
            background: var(--primary-hover);
        }

        /* 살짝 위에 여백 */
        .mypage-footer-space {
            height: 24px;
        }
    </style>
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
                    <div class="mypage-section-title">아이디</div>
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
