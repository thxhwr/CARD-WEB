<?php


declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');

session_start();

function json_out(array $arr, int $code = 200): void {
  http_response_code($code);
  echo json_encode($arr, JSON_UNESCAPED_UNICODE);
  exit;
}

$raw = file_get_contents('php://input');
$req = json_decode($raw, true);

$accountNo = trim((string)($req['accountNo'] ?? ''));
if ($accountNo === '') {
  json_out(['ok' => false, 'message' => 'accountNo가 없습니다.'], 400);
}

// 1) API 호출
$postFields = ['accountNo' => $accountNo];

$ch = curl_init('https://api.thxdeal.com/api/member/testMemberReco.php');
curl_setopt_array($ch, [
  CURLOPT_POST           => true,
  CURLOPT_POSTFIELDS     => http_build_query($postFields),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_TIMEOUT        => 10,
]);

$response = curl_exec($ch);
if ($response === false) {
  $err = curl_error($ch);
  curl_close($ch);
  json_out(['ok' => false, 'message' => "API 호출 실패: {$err}"], 500);
}
curl_close($ch);

$data = json_decode($response, true);
if (!is_array($data)) {
  json_out(['ok' => false, 'message' => '응답 JSON 파싱 실패'], 500);
}

if (($data['resCode'] ?? 1) !== 0) {
  json_out(['ok' => false, 'message' => (string)($data['message'] ?? 'API 오류')], 500);
}

$list = $data['data']['list'] ?? [];
if (!is_array($list)) $list = [];

// 2) ✅ "가장 가까운 상위 추천인"만 뽑기 = 최소 dept 그룹
// 2) ✅ deptNo(라인)별로 "가장 가까운 상위 추천인" 1명씩 뽑기
$best = []; // key: deptNo

foreach ($list as $row) {
  if (!is_array($row)) continue;

  $dept = (int)($row['dept'] ?? 0);
  if ($dept <= 0) continue;

  $deptNo = (int)($row['deptNo'] ?? 0); // 라인 구분용
  // deptNo가 없으면 0으로 묶임(어쩔 수 없음)

  if (!isset($best[$deptNo]) || $dept < (int)($best[$deptNo]['dept'] ?? PHP_INT_MAX)) {
    $best[$deptNo] = $row; // 해당 라인의 가장 가까운(최소 dept) 추천인 저장
  }
}

if (empty($best)) {
  json_out(['ok' => true, 'nodes' => []]);
}

$nodes = [];
foreach ($best as $row) {
  $nodes[] = [
    'userId'    => $row['userId'] ?? null,
    'accountNo' => (string)($row['accountNo'] ?? ''),
    'name'      => (string)($row['name'] ?? ''),
    'deptNo'    => $row['deptNo'] ?? null,
    'createdAt' => (string)($row['createdAt'] ?? ''),
  ];
}

// deptNo 오름차순 정렬
usort($nodes, fn($a,$b) => (int)($a['deptNo'] ?? 0) <=> (int)($b['deptNo'] ?? 0));

json_out(['ok' => true, 'nodes' => $nodes]);

