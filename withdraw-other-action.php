<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

if (empty($_SESSION['user_No']) || empty($_SESSION['user_Id'])) {
  go_error('login');
}

// ✅ CSRF 체크
$csrf = $_POST['csrf'] ?? '';
if (empty($_SESSION['csrf_withdraw_other']) || !hash_equals($_SESSION['csrf_withdraw_other'], $csrf)) {
  http_response_code(400);
  echo "요청이 올바르지 않습니다.(CSRF)";
  exit;
}
unset($_SESSION['csrf_withdraw_other']); // 1회성

function only_digits($v){ return preg_replace('/\D+/', '', (string)$v); }

$amount = only_digits($_POST['amount'] ?? '');

$errors = [];
if ($amount === '' || (int)$amount <= 0) $errors[] = '출금 금액을 확인해주세요.';


$minAmount = 10;
if ((int)$amount < $minAmount) $errors[] = "최소 출금 금액은 {$minAmount}원입니다.";

// ✅ (권장) 서버에서 “출금 가능 잔액” 조회 후 비교
// $available = ...;
// if ((int)$amount > $available) $errors[] = '잔액이 부족합니다.';

if ($errors) {
  http_response_code(400);
  echo "<h3>출금 신청 실패</h3><ul>";
  foreach ($errors as $e) echo "<li>" . htmlspecialchars($e, ENT_QUOTES) . "</li>";
  echo "</ul><p><a href='/withdraw_other.php'>뒤로가기</a></p>";
  exit;
}

// ✅ 여기서 출금 신청 API로 전송(프로젝트 API에 맞춰 수정)
$postFields = [
  'accountId'     => $_SESSION['user_Id'],
  'accountNo'   => $_SESSION['user_No'],
  'amount'     => $amount,
];


// 예시: cURL
$ch = curl_init('https://api.thxdeal.com/api/member/memberWithdraw.php');
curl_setopt_array($ch, [
  CURLOPT_POST => true,
  CURLOPT_POSTFIELDS => $postFields,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_TIMEOUT => 15,
]);

$response = curl_exec($ch);
$err = curl_error($ch);
$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);


if ($response === false) {
  http_response_code(500);
  echo "서버 통신 오류: " . htmlspecialchars($err, ENT_QUOTES);
  exit;
}

// ✅ 응답 파싱(형식은 API에 맞춰 수정)
$data = json_decode($response, true);
$resCode = $data['resCode'] ?? null;
$resMsg  = $data['resMsg'] ?? '처리 결과를 확인할 수 없습니다.';

if ((string)$resCode === '0') {
  $withdrawAmount = (int)($data['data']['withdrawAmount'] ?? (int)$amount);
  $remainBalance  = (int)($data['data']['remainBalance'] ?? 0);

  $q = http_build_query([
    'toId'   => $accountNo,
    'amount' => $withdrawAmount,
    'bal'    => $remainBalance,
    'msg'    => $resMsg,
  ]);

  header("Location: /withdraw-complete.php?$q");
  exit;
}

http_response_code(400);
echo "<h3>출금 신청 실패</h3>";
echo "<p>" . htmlspecialchars($resMsg, ENT_QUOTES) . "</p>";
echo "<pre style='background:#f6f7fb;padding:12px;border-radius:10px;overflow:auto;max-width:900px;'>"
  . htmlspecialchars($response, ENT_QUOTES)
  . "</pre>";
echo "<p><a href='/withdraw-other.php'>다시 시도</a></p>";
