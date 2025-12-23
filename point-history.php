<?php $pageTitle = "마이페이지"; ?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include __DIR__ . "/auth.php"; ?>
    <?php include __DIR__ . "/head.php"; ?>
</head>
<?php
    session_start();

    $userId = $_SESSION['user_Id'];

    // 허용할 포인트 타입 목록 (나중에 여기만 추가하면 됨)
    $allowedTypes = ['TP', 'SP', 'LP'];

    // GET으로 받은 타입
    $type = $_GET['type'] ?? 'TP';

    // 잘못된 타입 방어
    if (!in_array($type, $allowedTypes, true)) {
        $type = 'TP';
    }

    $response = curlPost(
    'https://api.thxdeal.com/api/point/history.php',
        [ 
            'accountNo' => $_SESSION['user_No'],
            'typeCode' => $type,
            'page' => "",
            'limit' => "",
        ]
    );

    if (!$response) {
        $errorMsg = '서버 통신 오류';
    } elseif (($response['resCode'] ?? -1) !== 0) {
        $errorMsg = $response['message'] ?? '요청 실패';
    }

    print_r($response);
?>
<body>
<div class="app">
    <header class="appbar-apply">
        <nav class="appbar__inner container--narrow" aria-label="상단 내비게이션">
            <a href="javascript:history.back()" class="nav-btn" aria-label="뒤로가기">
                <img src="/assets/icons/btn-next-arrow-left-dg.svg" width="24px" height="24px">
            </a>
            <h1 class="appbar__title">포인트내역</h1>
            <a href="/index.php" class="nav-btn home-btn" aria-label="홈"></a>
        </nav>
    </header>

    <main class="page">
        <div class="point-wrap">

            <!-- 보유 포인트 -->
            <div class="point-summary">
                <p class="label">보유 포인트</p>
                <p class="amount">12,500 P</p>
            </div>

            <!-- 필터 -->
            <div class="point-filter">
                <button class="active">전체</button>
                <button>적립</button>
                <button>사용</button>
            </div>

            <!-- 포인트 내역 -->
            <ul class="point-list">
                <!-- 적립 -->
                <li class="point-item plus">
                    <div class="left">
                        <p class="title">추천인 가입 적립</p>
                        <p class="date">2025-12-22</p>
                    </div>
                    <div class="right">
                        <p class="value">+3,000P</p>
                        <p class="balance">잔액 12,500P</p>
                    </div>
                </li>

                <!-- 사용 -->
                <li class="point-item minus">
                    <div class="left">
                        <p class="title">카드 신청 사용</p>
                        <p class="date">2025-12-20</p>
                    </div>
                    <div class="right">
                        <p class="value">-5,000P</p>
                        <p class="balance">잔액 9,500P</p>
                    </div>
                </li>
            </ul>

        </div>
        
    </main>
     <?php include __DIR__ . "/footer.php"; ?>
</div>
</body>
</html>
