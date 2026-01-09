<?php
session_start();

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

header('Content-Type: text/html; charset=UTF-8');
require_once __DIR__ . "/auth.php";

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
$tryPage = $page;
$maxTry  = 5; // 무한루프 방지

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

  if (!$historyRes || ($historyRes['data']['resCode'] ?? -1) !== 0) {
    break;
  }

  $data = $historyRes['data']['data'] ?? [];
  if (!is_array($data) || empty($data)) break;

  // io 필터
  if ($io !== 'all') {
    $want = $io;
    $data = array_values(array_filter($data, function($row) use ($want){
      return strtoupper(trim($row['ACTION_TYPE'] ?? '')) === $want;
    }));
  }

  if (!empty($data)) {
    $items = $data;
    break; // ✅ 쓸 수 있는 데이터 확보
  }

  $tryPage++; // 다음 페이지 시도
}
echo "<!-- rawCount=" . count($rawItems) . " filteredCount=" . count($items) . " io={$io} page={$page} -->";

if (empty($items)) exit;
foreach ($items as $row) {
  $action = strtoupper(trim($row['ACTION_TYPE'] ?? ''));
  $isOut  = ($action === 'OUT');
  $cls  = $isOut ? 'OUT' : 'IN';
  $sign = $isOut ? '-' : '+';

  $title  = $row['DESCRIPTION'] ?? '포인트';
  $amount = (int)($row['AMOUNT'] ?? 0);

  $createdAt = $row['CREATED_AT'] ?? '';
  $dateStr = $createdAt ? date('y-m-d', strtotime($createdAt)) : '';
?>
<li class="p-item <?= $cls ?>">
  <div class="left">
    <p class="left-title"><?= htmlspecialchars($title, ENT_QUOTES) ?></p>
    <p class="date"><?= htmlspecialchars($dateStr, ENT_QUOTES) ?></p>
  </div>
  <div class="right">
    <p class="value"><?= $sign ?><?= number_format($amount) ?> <?= htmlspecialchars($type, ENT_QUOTES) ?></p>
  </div>
</li>
<?php } ?>