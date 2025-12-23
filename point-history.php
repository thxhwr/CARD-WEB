<?php
session_start();

$pageTitle = "포인트내역";

require_once __DIR__ . "/auth.php";
require_once __DIR__ . "/head.php";


$accountNo = $_SESSION['user_No'] ?? '';
$userId    = $_SESSION['user_Id'] ?? '';


$allowedTypes = ['TP', 'SP', 'LP'];
$type = $_GET['type'] ?? 'TP';
if (!in_array($type, $allowedTypes, true)) $type = 'TP';


$allowedIO = ['all', 'plus', 'minus'];
$io = $_GET['io'] ?? 'all';
if (!in_array($io, $allowedIO, true)) $io = 'all';


$page  = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 20;


$errorMsg = '';
$items = [];
$totalPoint = 0;

$response = curlPost(
    'https://api.thxdeal.com/api/point/history.php',
    [
        'accountNo' => $accountNo,
        'typeCode'  => $type,
        'page'      => $page,
        'limit'     => $limit,
    ]
);
print_r($response);
if (!$response) {
    $errorMsg = '서버 통신 오류';
} elseif (($response['resCode'] ?? -1) !== 0) {
    $errorMsg = $response['message'] ?? '요청 실패';
} else {

    $data = $response['data'] ?? [];
    $totalPoint = (int)($data['totalPoint'] ?? 0);
    $items = $data['list'] ?? [];

    // (plus/minus 키가 item에 있다면)
    if ($io !== 'all') {
        $items = array_values(array_filter($items, fn($it) => ($it['type'] ?? '') === $io));
    }
        print_r($data);
}
?>
<!DOCTYPE html>
<html lang="ko">
<body>
<div class="app">

    <header class="appbar-apply">
        <nav class="appbar__inner container--narrow" aria-label="상단 내비게이션">
            <a href="javascript:history.back()" class="nav-btn" aria-label="뒤로가기">
                <img src="/assets/icons/btn-next-arrow-left-dg.svg" width="24" height="24" alt="">
            </a>
            <h1 class="appbar__title">포인트내역</h1>
            <a href="/index.php" class="nav-btn home-btn" aria-label="홈"></a>
        </nav>
    </header>

    <main class="page">
        <div class="point-wrap">

            <!-- 타입 탭: TP/SP/LP (GET으로 페이지 유지) -->
            <div class="point-type-tabs">
                <a class="<?= $type==='TP'?'active':'' ?>" href="?type=TP&io=<?= htmlspecialchars($io) ?>">TP</a>
                <a class="<?= $type==='SP'?'active':'' ?>" href="?type=SP&io=<?= htmlspecialchars($io) ?>">SP</a>
                <a class="<?= $type==='LP'?'active':'' ?>" href="?type=LP&io=<?= htmlspecialchars($io) ?>">LP</a>
            </div>

            <!-- 보유 포인트 -->
            <div class="point-summary">
                <p class="label">보유 포인트</p>
                <p class="amount"><?= number_format($totalPoint) ?> <?= htmlspecialchars($type) ?></p>
            </div>

            <!-- 필터: 전체/적립/사용 (GET으로) -->
            <div class="point-filter">
                <a class="<?= $io==='all'?'active':'' ?>"   href="?type=<?= htmlspecialchars($type) ?>&io=all">전체</a>
                <a class="<?= $io==='plus'?'active':'' ?>"  href="?type=<?= htmlspecialchars($type) ?>&io=plus">적립</a>
                <a class="<?= $io==='minus'?'active':'' ?>" href="?type=<?= htmlspecialchars($type) ?>&io=minus">사용</a>
            </div>

            <?php if ($errorMsg): ?>
                <p class="error-text"><?= htmlspecialchars($errorMsg, ENT_QUOTES) ?></p>

            <?php elseif (empty($items)): ?>
                <p class="empty-text">내역이 없습니다.</p>

            <?php else: ?>
                <ul class="point-list">
                    <?php foreach ($items as $row): 
                        // ✅ API 항목 키 이름은 실제 응답에 맞게 변경해줘야 함
                        // 예시 가정:
                        // row['io'] = 'plus'|'minus'
                        // row['point'] = 3000
                        // row['balance'] = 12500
                        // row['title'] or row['description']
                        // row['createdAt'] = "2025-12-22 06:34:20"

                        $rowIO   = $row['io'] ?? ($row['type'] ?? ''); // plus/minus
                        $cls     = ($rowIO === 'minus') ? 'minus' : 'plus';
                        $sign    = ($rowIO === 'minus') ? '-' : '+';

                        $title   = $row['description'] ?? $row['title'] ?? '포인트';
                        $point   = (int)($row['point'] ?? 0);
                        $balance = (int)($row['balance'] ?? 0);

                        $created = $row['createdAt'] ?? $row['created_at'] ?? '';
                        $dateStr = $created ? date('Y-m-d', strtotime($created)) : '';
                    ?>
                    <li class="point-item <?= $cls ?>">
                        <div class="left">
                            <p class="title"><?= htmlspecialchars($title, ENT_QUOTES) ?></p>
                            <p class="date"><?= htmlspecialchars($dateStr, ENT_QUOTES) ?></p>
                        </div>
                        <div class="right">
                            <p class="value"><?= $sign ?><?= number_format($point) ?>P</p>
                            <p class="balance">잔액 <?= number_format($balance) ?>P</p>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

        </div>
    </main>

    <?php require_once __DIR__ . "/footer.php"; ?>
</div>