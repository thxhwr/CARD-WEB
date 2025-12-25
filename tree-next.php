<?php
session_start();
require_once __DIR__ . "/auth.php";
header('Content-Type: application/json; charset=utf-8');

$raw = file_get_contents("php://input");
$body = json_decode($raw, true);

$accountNo = trim($body['accountNo'] ?? '');
if ($accountNo === '') {
  echo json_encode(['ok'=>false,'message'=>'accountNo 누락']);
  exit;
}

$postFields = ['accountNo' => $accountNo];

$ch = curl_init('https://api.thxdeal.com/api/member/testMemberReco.php');
curl_setopt_array($ch, [
  CURLOPT_POST           => true,
  CURLOPT_POSTFIELDS     => http_build_query($postFields),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_SSL_VERIFYPEER => false,
]);

$response = curl_exec($ch);
if ($response === false) {
  echo json_encode(['ok'=>false,'message'=>'API 호출 실패: '.curl_error($ch)]);
  curl_close($ch);
  exit;
}
curl_close($ch);

$data = json_decode($response, true);

$list = $data['data']['list'] ?? ($data['data'] ?? []);
if (!is_array($list)) $list = [];

$minDept = null;
foreach ($list as $row) {
  $d = (int)($row['dept'] ?? 0);
  if ($d <= 0) continue;
  if ($minDept === null || $d < $minDept) $minDept = $d;
}

if ($minDept === null) {
  echo json_encode(['ok'=>true,'nodes'=>[]]); // 더 위 추천인 없음
  exit;
}

/**
 * ✅ "다음대"만 가져오기
 * - 클릭한 사람 기준으로 가장 가까운(최소 dept) 한 레벨만
 */
$nodes = [];
foreach ($list as $row) {
  $dept = (int)($row['dept'] ?? 0);
  if ($dept !== $minDept) continue;

  $nodes[] = [
    'name'      => $row['name'] ?? '',
    'accountNo' => $row['accountNo'] ?? '',
    'deptNo'    => $row['deptNo'] ?? null,
  ];
}

// deptNo 정렬(있으면)
usort($nodes, fn($a,$b) => ($a['deptNo'] ?? 0) <=> ($b['deptNo'] ?? 0));

echo json_encode(['ok'=>true,'nodes'=>$nodes]);
