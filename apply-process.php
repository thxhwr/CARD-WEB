<?php
session_start();
// 사용자가 입력한 값
$name = $_POST['name'] ?? '';
$phone = $_POST['phone'] ?? '';
$zipcode        = $_POST['zipcode'] ?? '';
$addr           = $_POST['address'] ?? '';
$addr_detail    = $_POST['address_detail'] ?? '';
$receiveType = $_POST['receive_type'] ?? 'visit';
$referral = trim($_POST['referral'] ?? '');
$referralConfirm = trim($_POST['referral_confirm'] ?? ''); 
$refChecked = $_POST['referral_checked'] ?? '0';
$address = $zipcode . ' ' . $addr . ' ' . $addr_detail;


if ($referral === '' || $refChecked !== '1') {
  header("Location: /apply.php?error=referral");
  exit;
}
if ($referralConfirm === '' || $referral !== $referralConfirm) {
  header("Location: /apply.php?error=referral_confirm");
  exit;
}

$stmt = $pdo->prepare("SELECT accountNo FROM members WHERE accountNo = :id LIMIT 1");
$stmt->execute([':id' => $referral]);
$exists = $stmt->fetchColumn();

if (!$exists) {
  header("Location: /apply.php?error=referral_notfound");
  exit;
}

$postFields = [
  'accountNo' => $_SESSION['user_No'],
  'referrerAccountNo' => $referral,
  'name' => $name,
  'phone' => $phone,
  'address' => $address,
  'userId' => $_SESSION['user_Id'],
];

$ch = curl_init('https://api.thxdeal.com/api/member/testMemberInsert.php');
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $postFields,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
]);

$response = curl_exec($ch);
if ($response === false) {
    curl_close($ch);
   
}
curl_close($ch);

// 응답 JSON 파싱 (형식에 맞게 조정)
$data = json_decode($response, true);

if ($data['resCode'] == "1005") {
    header('Location: /apply.php?error=1');
    exit;
} else if($data['resCode'] == "5001"){
    header('Location: /apply.php?error=2');
    exit;
} else{
    header('Location: /apply-complete.php');
    exit;
}
