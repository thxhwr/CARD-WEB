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

$items = [];

if ($errorMsg === '') {
    $historyRes = curlPost(
        'https://api.thxdeal.com/api/point/history.php',
        [
            'accountNo' => $accountNo,
            'typeCode'  => $type,
            'page'      => $page,
            'limit'     => $limit,
        ]
    );

    if (!$historyRes) {
        $errorMsg = '서버 통신 오류(내역)';
    } elseif (($historyRes['data']['resCode'] ?? -1) !== 0) {
        $errorMsg = $historyRes['data']['message'] ?? '내역 조회 실패';
    } else {
        $data = $historyRes['data']['data'] ?? [];

        // ✅ 케이스 A: data가 리스트 바로 배열일 때
        if (isset($data[0]) && is_array($data[0])) {
            $items = $data;
        }
        // ✅ 케이스 C: data.data.list 같은 형태일 때(혹시)
        elseif (isset($data['data']['data']) && is_array($data['data']['data'])) {
            $items = $data['data']['data'];
        } else {
            $items = [];
        }
    }
}

if (!is_array($items)) $items = [];

// -----------------------
// 4) io 필터(전체/적립/사용) - API에서 지원 안 하면 PHP에서 필터링
//    ACTION_TYPE: IN / OUT
// -----------------------
if ($io !== 'all') {
    $want = ($io === 'IN') ? 'IN' : 'OUT';
    $items = array_values(array_filter($items, function($row) use ($want) {
        $action = strtoupper(trim($row['ACTION_TYPE'] ?? ''));
        return $action === $want;
    }));
}

// -----------------------
// 5) 잔액 계산: API 내역에 BALANCE가 없으니
//    현재 잔액($currentBalance) 기준으로 최신순으로 정렬해서 _BALANCE_AFTER 붙이기
// -----------------------
if (!empty($items)) {

    // 계산용 복사본을 최신순(내림차순)으로 정렬
    $calcItems = $items;

    usort($calcItems, function($a, $b){
        $ta = strtotime($a['CREATED_AT'] ?? '') ?: 0;
        $tb = strtotime($b['CREATED_AT'] ?? '') ?: 0;
        return $tb <=> $ta; // 최신순
    });

    $running = $currentBalance;

    foreach ($calcItems as &$row) {
        $action = strtoupper(trim($row['ACTION_TYPE'] ?? ''));
        $amount = (int)($row['AMOUNT'] ?? 0);

        // 이 로그가 적용된 "후" 잔액
        $row['_BALANCE_AFTER'] = $running;

        // 더 과거로 되감기
        if ($action === 'IN') {
            $running -= $amount;
        } elseif ($action === 'OUT') {
            $running += $amount;
        }
    }
    unset($row);

    // 원래 items 순서에 붙이기(POINT_LOG_ID 기준)
    $map = [];
    foreach ($calcItems as $r) {
        $id = $r['POINT_LOG_ID'] ?? null;
        if ($id !== null) $map[$id] = $r['_BALANCE_AFTER'] ?? null;
    }

    foreach ($items as &$row) {
        $id = $row['POINT_LOG_ID'] ?? null;
        $row['_BALANCE_AFTER'] = ($id !== null && array_key_exists($id, $map)) ? $map[$id] : null;
    }
    unset($row);
}
?>
<!DOCTYPE html>
<html lang="ko">
<body>
<div class="app">

    <header class="appbar-apply">
        <nav class="appbar__inner container--narrow" aria-label="상단 내비게이션">
            <a href="./mypage.php" class="nav-btn" aria-label="뒤로가기">
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
                <p class="amount">
                    <?= number_format($currentBalance) ?><span><?= htmlspecialchars($type, ENT_QUOTES) ?></span>
                </p>
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
                            $action = strtoupper(trim($row['ACTION_TYPE'] ?? ''));
                            $isOut  = ($action === 'OUT');

                            $cls  = $isOut ? 'OUT' : 'IN';
                            $sign = $isOut ? '-' : '+';

                            $title     = $row['DESCRIPTION'] ?? '포인트';
                            $amount    = (int)($row['AMOUNT'] ?? 0);

                            $createdAt = $row['CREATED_AT'] ?? '';
                            $dateStr   = $createdAt ? date('Y-m-d', strtotime($createdAt)) : '';

                            $balAfter  = $row['_BALANCE_AFTER'] ?? null;
                        ?>

                        <li class="point-item <?= $cls ?>">
                            <div class="left">
                                <p class="left-title"><?= htmlspecialchars($title, ENT_QUOTES) ?></p>
                                <p class="date"><?= htmlspecialchars($dateStr, ENT_QUOTES) ?></p>
                            </div>
                            <div class="right">
                                <p class="value"><?= $sign ?><?= number_format($amount) ?>P</p>
                                <?php if ($balAfter !== null): ?>
                                    <p class="balance">잔액 <?= number_format((int)$balAfter) ?>P</p>
                                <?php endif; ?>
                            </div>
                        </li>

                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

        </div>
    </main>

    <?php require_once __DIR__ . "/footer.php"; ?>
</div>
<style>
/* 1) 전체 스크롤 막고 앱 높이 고정 */
html, body{
  height:100%;
  margin:0;
  overflow:hidden;
}

/* 2) app: header / main / footer 세로 배치 */
.app{
  height:100vh;
  display:flex;
  flex-direction:column;
}

/* header, footer는 줄어들지 않게 */
.appbar-apply{ flex: 0 0 auto; }
/* footer.php에 들어가는 영역이 감싸는 클래스가 있으면 그걸 지정해도 됨 */
footer, .footer{ flex: 0 0 auto; }

/* 3) main이 남은 높이를 차지 */
.page{
  flex: 1 1 auto;
  min-height: 0;            /* ⭐ flex 스크롤 필수 */
  overflow: hidden;         /* main 자체는 스크롤 X */
}

/* 4) point-wrap 안에서 위는 고정, 리스트만 스크롤 */
.point-wrap{
  height: 100%;
  display:flex;
  flex-direction:column;
  min-height:0;             /* ⭐ 필수 */
}

/* 탭/요약/필터는 고정 */
.point-type-tabs,
.point-summary,
.point-filter{
  flex: 0 0 auto;
}

.point-list{
  flex: 1 1 auto;
  min-height: 0;                 /* ⭐ 필수 */
  overflow-y: auto;
  -webkit-overflow-scrolling: touch;
  overscroll-behavior: contain;

  margin: 0;
  list-style: none;
}

.point-list::-webkit-scrollbar{ width:0; height:0; }

</style>