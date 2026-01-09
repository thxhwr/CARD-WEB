<?php
session_start();

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

header('Content-Type: text/html; charset=UTF-8');

require_once __DIR__ . "/auth.php"; // curlPost가 여기/공용 include에 포함돼 있어야 함

$accountNo = $_SESSION['user_No'] ?? '';
if ($accountNo === '') exit;

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

// ✅ "null" 문자열 방지
$lastBalanceRaw = $_GET['lastBalance'] ?? null;
$lastBalance = ($lastBalanceRaw === null || $lastBalanceRaw === '' || $lastBalanceRaw === 'null')
  ? null
  : (int)$lastBalanceRaw;

// -----------------------
// 2) 내역 가져오기 (io 필터로 비면 다음 페이지 스킵)
// -----------------------
$items   = [];
$tryPage = $page;
$maxTry  = 10;

while ($maxTry-- > 0) {
  $historyRes = curlPost(
    'https://api.thxdeal.com/api/point/history.php',
    [
      'accountNo' => $accountNo,
      'typeCode'  => $type,
      'page'      => $tryPage,
      'limit'     => $limit,
    ]
  );

  if (!$historyRes || (($historyRes['data']['resCode'] ?? -1) !== 0)) break;

  $data = $historyRes['data']['data'] ?? [];
  if (!(isset($data[0]) && is_array($data[0]))) break; // 더 없음

  // io 필터
  if ($io !== 'all') {
    $want = $io; // IN / OUT
    $data = array_values(array_filter($data, function($row) use ($want){
      return strtoupper(trim($row['ACTION_TYPE'] ?? '')) === $want;
    }));
  }

  if (!empty($data)) {
    $items = $data;
    break;
  }

  $tryPage++;
}

if (empty($items)) exit;

// -----------------------
// 3) 잔액 이어서 계산 (items 확보 후에 해야 함)
//    lastBalance가 null이면(첫 값이 없음) 잔액은 표시 안 함
// -----------------------
$newLastBalance = null;

if ($lastBalance !== null) {
  // 최신순 정렬(내림차순)
  usort($items, function($a, $b){
    $ta = strtotime($a['CREATED_AT'] ?? '') ?: 0;
    $tb = strtotime($b['CREATED_AT'] ?? '') ?: 0;
    return $tb <=> $ta;
  });

  $running = $lastBalance;

  foreach ($items as &$row) {
    $action = strtoupper(trim($row['ACTION_TYPE'] ?? ''));
    $amount = (int)($row['AMOUNT'] ?? 0);

    // 이 거래가 적용된 "후" 잔액
    $row['_BALANCE_AFTER'] = $running;

    // 더 과거로 되감기
    if ($action === 'IN')      $running -= $amount;
    else if ($action === 'OUT') $running += $amount;
  }
  unset($row);

  // 다음 더보기를 위한 기준 잔액(이번 페이지의 가장 과거쪽 기준)
  $newLastBalance = $running;
}

// -----------------------
// 4) 출력 (반드시 li)
// -----------------------
foreach ($items as $row) {
  $action = strtoupper(trim($row['ACTION_TYPE'] ?? ''));
  $isOut  = ($action === 'OUT');
  $cls    = $isOut ? 'OUT' : 'IN';
  $sign   = $isOut ? '-' : '+';

  $title  = $row['DESCRIPTION'] ?? '포인트';
  $amount = (int)($row['AMOUNT'] ?? 0);

  $createdAt = $row['CREATED_AT'] ?? '';
  $dateStr   = $createdAt ? date('y-m-d', strtotime($createdAt)) : '';

  $balAfter = $row['_BALANCE_AFTER'] ?? null;
  ?>
  <li class="p-item <?= $cls ?>">
    <div class="left">
      <p class="left-title"><?= htmlspecialchars($title, ENT_QUOTES) ?></p>
      <p class="date"><?= htmlspecialchars($dateStr, ENT_QUOTES) ?></p>
    </div>
    <div class="right">
      <p class="value"><?= $sign ?><?= number_format($amount) ?> <?= htmlspecialchars($type, ENT_QUOTES) ?></p>
      <?php if ($balAfter !== null): ?>
        <p class="balance">잔액 <?= number_format((int)$balAfter) ?> <?= htmlspecialchars($type, ENT_QUOTES) ?></p>
      <?php endif; ?>
    </div>
  </li>
  <?php
}

// ✅ 서버가 실제로 사용한 페이지
echo "<!-- usedPage:$tryPage -->";

// ✅ 다음 더보기용 잔액(있을 때만)
if ($newLastBalance !== null) {
  echo "<!-- nextBalance:$newLastBalance -->";
}