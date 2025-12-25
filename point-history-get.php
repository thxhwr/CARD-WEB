<?php
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