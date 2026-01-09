<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

$accountNo = $_SESSION['user_No'] ?? '';
if ($accountNo === '') exit; // 로그인 없으면 종료

// -----------------------
// 1) 파라미터
// -----------------------
$allowedTypes = ['TP', 'SP', 'LP'];
$type = $_GET['type'] ?? 'TP';
if (!in_array($type, $allowedTypes, true)) $type = 'TP';

$allowedIO = ['all', 'IN', 'OUT'];
$io = $_GET['io'] ?? 'all';
if (!in_array($io, $allowedIO, true)) $io = 'all';

$page  = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 20;

// -----------------------
// 2) 내역 API 호출
// -----------------------
$historyRes = curlPost(
  'https://api.thxdeal.com/api/point/history.php',
  [
    'accountNo' => $accountNo,
    'typeCode'  => $type,
    'page'      => $page,
    'limit'     => $limit,
  ]
);

$items = [];

if ($historyRes && (($historyRes['data']['resCode'] ?? -1) === 0)) {
  $data = $historyRes['data']['data'] ?? [];

  // 케이스 A: data가 리스트
  if (isset($data[0]) && is_array($data[0])) {
    $items = $data;
  }
  // 케이스 C(혹시): data.data.data
  elseif (isset($data['data']['data']) && is_array($data['data']['data'])) {
    $items = $data['data']['data'];
  }
}

// -----------------------
// 3) IO 필터
// -----------------------
if ($io !== 'all') {
  $want = ($io === 'IN') ? 'IN' : 'OUT';
  $items = array_values(array_filter($items, function($row) use ($want) {
    return strtoupper(trim($row['ACTION_TYPE'] ?? '')) === $want;
  }));
}

// -----------------------
// 4) 더보기는 "추가 HTML"만 뿌려줌
//    (잔액 계산은 기존 페이지에서만 하거나, API가 BALANCE 주면 여기서도 가능)
// -----------------------
if (empty($items)) exit; // 비어있으면 빈 응답

foreach ($items as $row) {
  $title  = htmlspecialchars($row['TITLE'] ?? ($row['REASON'] ?? '포인트'));
  $created = $row['CREATED_AT'] ?? '';
  $date   = $created ? date('y-m-d', strtotime($created)) : '';
  $amount = (int)($row['AMOUNT'] ?? 0);
  $action = strtoupper(trim($row['ACTION_TYPE'] ?? ''));
  $sign   = ($action === 'OUT') ? '-' : '+';

  // 더보기에서는 _BALANCE_AFTER가 없을 수 있으니 있으면 출력, 없으면 숨김 처리
  $balText = '';
  if (isset($row['_BALANCE_AFTER']) && $row['_BALANCE_AFTER'] !== null) {
    $balText = '잔액 ' . (int)$row['_BALANCE_AFTER'] . ' ' . $type;
  }
  ?>
  <div class="history-card">
    <div class="left">
      <div class="title"><?= $title ?> (<?= $type ?>)</div>
      <div class="date"><?= htmlspecialchars($date) ?></div>
    </div>
    <div class="right">
      <div class="amount"><?= $sign . number_format(abs($amount)) ?> <?= $type ?></div>
      <?php if ($balText !== ''): ?>
        <div class="balance"><?= htmlspecialchars($balText) ?></div>
      <?php endif; ?>
    </div>
  </div>
  <?php
}
