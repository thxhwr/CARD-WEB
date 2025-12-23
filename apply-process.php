<?php
session_start();
// 사용자가 입력한 값
$name = $_POST['name'] ?? '';
$phone = $_POST['phone'] ?? '';
$referral = $_POST['referral'] ?? '';
$zipcode        = $_POST['zipcode'] ?? '';
$addr           = $_POST['address'] ?? '';
$addr_detail    = $_POST['address_detail'] ?? '';

$address = $zipcode . ' ' . $addr . ' ' . $addr_detail;

$postFields = [
  'accountNo' => $_SESSION['user_No'],
  'referrerAccountNo' => $referral,
  'name' => $name,
  'phone' => $phone,
  'address' => $address,
  'userId' => $_SESSION['user_Id'],
];
print_r($postFields);
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
    header('Location: /login.php?error=1');
    exit;
} else if($data['resCode'] == "5001"){
    header('Location: /login.php?error=2');
    exit;
} else{
    header('Location: /apply-complete.php');
    exit;
}
