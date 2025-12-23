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


$allowedIO = ['all', 'IN', 'OUT'];
$io = $_GET['io'] ?? 'all';
if (!in_array($io, $allowedIO, true)) $io = 'all';


$page  = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 20;


$errorMsg = '';
$totalPoint = 0;
$balanceRes = curlPost(
    'https://api.thxdeal.com/api/point/balance.php',
    ['accountNo' => $_SESSION['user_No']]
);

$balances = [];
if ($balanceRes && ($balanceRes['data']['resCode'] ?? -1) === 0) {
    // 예: [ 'TP'=>65, 'SP'=>65, 'LP'=>0 ]
    $balances = $balanceRes['data']['data'] ?? [];
}

$currentBalance = (int)($balances[$type] ?? 0);

    
$response = curlPost(
    'https://api.thxdeal.com/api/point/history.php',
    [
        'accountNo' => $accountNo,
        'typeCode'  => $type,
        'page'      => $page,
        'limit'     => $limit,
    ]
);
if (!$response) {
    $errorMsg = '서버 통신 오류';
} elseif (($response['data']['resCode'] ?? -1) !== 0) {
    $errorMsg = $response['message'] ?? '요청 실패';
} else {

    $items = $response['data']['data'] ?? [];

    // (plus/minus 키가 item에 있다면)
    if ($io !== 'all') {
        $items = array_values(array_filter($items, fn($it) => ($it['ACTION_TYPE'] ?? '') === $io));
    }
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
                <p class="amount"><?= number_format($currentBalance) ?> <?= htmlspecialchars($type) ?></p>
            </div>

            <!-- 필터: 전체/적립/사용 (GET으로) -->
            <div class="point-filter">
                <a class="<?= $io==='all'?'active':'' ?>"   href="?type=<?= htmlspecialchars($type, ENT_QUOTES) ?>&io=all">전체</a>
                <a class="<?= $io==='IN'?'active':'' ?>"  href="?type=<?= htmlspecialchars($type, ENT_QUOTES) ?>&io=IN">적립</a>
                <a class="<?= $io==='OUT'?'active':'' ?>" href="?type=<?= htmlspecialchars($type, ENT_QUOTES) ?>&io=OUT">사용</a>
            </div>

            <?php if ($errorMsg): ?>
                <p class="error-text"><?= htmlspecialchars($errorMsg, ENT_QUOTES) ?></p>

            <?php elseif (empty($items)): ?>
                <p class="empty-text">내역이 없습니다.</p>

            <?php else: ?>
                <?php
                    if (!is_array($items)) $items = [];
                ?>
                <ul class="point-list">
                    <?php foreach ($items as $row): ?>
                        <?php
                            $running = $currentBalance;
                            $action = strtoupper(trim($row['ACTION_TYPE'] ?? ''));
                            $isOut  = ($action === 'OUT');

                            $cls  = $isOut ? 'minus' : 'plus';
                            $sign = $isOut ? '-' : '+';

                            $title     = $row['DESCRIPTION'] ?? '포인트';
                            $amount    = (int)($row['AMOUNT'] ?? 0);
                            $items[$i]['_BALANCE_AFTER'] = $running;
                            if ($action === 'IN') {
                                $running -= $amount;
                            } elseif ($action === 'OUT') {
                                $running += $amount;
                            }
                            
                            $createdAt = $row['CREATED_AT'] ?? '';
                            $dateStr   = $createdAt ? date('Y-m-d', strtotime($createdAt)) : '';

                            print_r($items[$i]['_BALANCE_AFTER']);
                        ?>

                        <li class="point-item <?= $cls ?>">
                            <div class="left">
                                <p class="title"><?= htmlspecialchars($title, ENT_QUOTES) ?></p>
                                <p class="date"><?= htmlspecialchars($dateStr, ENT_QUOTES) ?></p>
                            </div>
                            <div class="right">
                                <p class="value"><?= $sign ?><?= number_format($amount) ?>P</p>
                            </div>
                            <?php
                                echo 
                                echo $row['_BALANCE_AFTER'];
                                $bal = $row['_BALANCE_AFTER'] ?? null;
                                if ($bal !== null) {
                                echo '<p class="balance">잔액 ' . number_format($bal) . 'P</p>';
                                }
                            ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

        </div>
    </main>

    <?php require_once __DIR__ . "/footer.php"; ?>
</div>