<?php
// tree-next.php  (✅ 클릭한 계정의 "상위 추천인" 내려주는 버전)
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
$minDept = null;
foreach ($list as $row) {
  $d = (int)($row['dept'] ?? 0);
  if ($d <= 0) continue;
  if ($minDept === null || $d < $minDept) $minDept = $d;
}

if ($minDept === null) {
  // 추천인 없음
  json_out(['ok' => true, 'nodes' => []]);
}

$nodes = [];
foreach ($list as $row) {
  if ((int)($row['dept'] ?? 0) !== $minDept) continue;

  $nodes[] = [
    'userId'    => $row['userId'] ?? null,
    'accountNo' => (string)($row['accountNo'] ?? ''),
    'name'      => (string)($row['name'] ?? ''),
    'deptNo'    => $row['deptNo'] ?? null,
    'createdAt' => (string)($row['createdAt'] ?? ''),
  ];
}

// deptNo 정렬(있으면)
usort($nodes, fn($a,$b) => (int)($a['deptNo'] ?? 0) <=> (int)($b['deptNo'] ?? 0));

json_out(['ok' => true, 'nodes' => $nodes]);
