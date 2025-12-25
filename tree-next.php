<?php
session_start();
require_once __DIR__ . "/auth.php";

header('Content-Type: application/json; charset=utf-8');
// ✅ JSON 깨지는 거 방지: PHP가 에러를 화면에 찍지 않게
ini_set('display_errors', '0');

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
  echo json_encode(['ok'=>false,'message'=>'API 호출 실패']);
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
  echo json_encode(['ok'=>true,'nodes'=>[]]);
  exit;
}

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

usort($nodes, fn($a,$b) => ($a['deptNo'] ?? 0) <=> ($b['deptNo'] ?? 0));

echo json_encode(['ok'=>true,'nodes'=>$nodes], JSON_UNESCAPED_UNICODE);
exit;
