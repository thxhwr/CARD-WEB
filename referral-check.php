<?php
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors','0');

$raw = file_get_contents("php://input");
$body = json_decode($raw, true);

$referral = trim($body['referral'] ?? '');
if ($referral === '') {
  echo json_encode(['ok'=>false,'message'=>'추천인 아이디가 비어있습니다.']);
  exit;
}

$ch = curl_init('https://api.thxdeal.com/api/member/testMemberReco.php');
curl_setopt_array($ch, [
  CURLOPT_POST => true,
  CURLOPT_POSTFIELDS => http_build_query(['accountNo'=>$referral]),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_SSL_VERIFYPEER => false,
]);

$res = curl_exec($ch);
curl_close($ch);

$data = json_decode($res, true);

// ✅ 추천인 존재 여부 판단
$list = $data['data']['list'] ?? [];
if (!empty($list)) {
  echo json_encode([
    'ok' => true,
    'name' => $list[0]['name'] ?? '',
    'accountNo' => $list[0]['accountNo'] ?? $referral
  ], JSON_UNESCAPED_UNICODE);
} else {
  echo json_encode([
    'ok' => false,
    'message' => '입력한 추천인 아이디가 존재하지 않습니다.'
  ], JSON_UNESCAPED_UNICODE);
}
