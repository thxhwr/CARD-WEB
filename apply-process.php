<?php
session_start();

function go_error(string $code): void {
  header('Location: /apply.php?error=' . urlencode($code));
  exit;
}

// 로그인 체크(안전)
if (empty($_SESSION['user_No']) || empty($_SESSION['user_Id'])) {
  go_error('login');
}

// 사용자가 입력한 값
$name           = trim($_POST['name'] ?? '');
$phone          = trim($_POST['phone'] ?? '');
$zipcode        = trim($_POST['zipcode'] ?? '');
$addr           = trim($_POST['address'] ?? '');
$addr_detail    = trim($_POST['address_detail'] ?? '');
$receiveType    = trim($_POST['receive_type'] ?? 'visit');
$referral       = trim($_POST['referral'] ?? '');
$referralConfirm = trim($_POST['referral_confirm'] ?? '');
$refChecked     = trim($_POST['referral_checked'] ?? '0');


if ($name === '') {
  go_error('name_required');
}
if (!preg_match('/^[가-힣a-zA-Z]+$/u', $name)) {
  go_error('name_invalid');
}

if ($phone === '') {
  go_error('phone_required');
}
if (!preg_match('/^[0-9\-]{9,20}$/', $phone)) {
  go_error('phone_invalid');
}

if ($zipcode === '' || $addr === '' || $addr_detail === '') {
  go_error('address_required');
}

$address = $zipcode . ' ' . $addr . ' ' . $addr_detail;

// -------------------------
// (선택) 추천인 검증을 다시 켤 경우 여기서 처리
// -------------------------
// if ($referral === '' || $refChecked !== '1') {
if ($referral === ''){
    go_error('referral');
}

// if ($referralConfirm === '' || $referral !== $referralConfirm){
//     go_error('referral_confirm');
// }

$postFields = [
  'accountNo'         => $_SESSION['user_No'],
  'referrerAccountNo' => $referral,
  'name'              => $name,
  'phone'             => $phone,
  'address'           => $address,
  'userId'            => $_SESSION['user_Id'],
];

$ch = curl_init('https://api.thxdeal.com/api/member/testMemberApp.php');
curl_setopt_array($ch, [
  CURLOPT_POST           => true,
  CURLOPT_POSTFIELDS     => $postFields,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_TIMEOUT        => 15,
]);

$response = curl_exec($ch);
if ($response === false) {
  curl_close($ch);
  go_error('api_fail');
}
curl_close($ch);

$data = json_decode($response, true);
if (!is_array($data) || !isset($data['resCode'])) {
  go_error('api_parse');
}


if ($data['resCode'] == "1005") {
  go_error('1005');
} elseif ($data['resCode'] == "5001") {
  go_error('5001');
} elseif ($data['resCode'] == "4001") {
  go_error('4001');
} elseif ($data['resCode'] == "1006") {
  go_error('1006');
} elseif ($data['resCode'] == "0") {
    print_r($data);
//   header('Location: /apply-complete.php');
//   exit;
} else {
  go_error('api_unknown');
}
