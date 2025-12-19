<?php
session_start();
// 사용자가 입력한 값
$name = $_POST['name'] ?? '';
$phone = $_POST['phone'] ?? '';
$referral = $_POST['referral'] ?? '';
$address = $_POST['zipcode'].''.$_POST['address'].''.$_POST['address_detail'] ?? '';
echo $_POST['zipcode'];
echo $_POST['address'];
echo $_POST['address_detail'];
echo $address;
// 간단 유효성 검증
// if ($id === '' || $pw === '') {
//     header('Location: /login.php?error=1');
//     exit;
// }

// API로 보낼 데이터 (필드명은 API 문서에 맞게 수정)
$postFields = [
    'accountNo' => $_SESSION['user_No'],
  'referrerAccountNo' => $referral,
  'name' => $name,
  'phone' => $phone,
  'address' => $address,
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
print_r($data);
// if ($data['resCode'] == "0") {
//     if (!empty($_POST['remember_me'])) {
//         $lifetime = 60 * 60 * 24 * 30;
//     } else {
//         $lifetime = 0;
//     }
//     session_set_cookie_params([
//         'lifetime' => $lifetime,
//         'path'     => '/',
//         'secure'   => isset($_SERVER['HTTPS']), 
//         'httponly' => true,
//         'samesite' => 'Lax',
//     ]);
//     session_start();

//     $_SESSION['user_Status'] = $data['data']['status'];
//     $_SESSION['user_No'] = $data['data']['accountNo'] ?? null;
//     $_SESSION['user_Id']    = $data['data']['userId'] ?? null;


//     session_regenerate_id(true);

//     header('Location: /index.php');
//     exit;
// } else {

//     header('Location: /login.php?error=1');
//     exit;
// }
