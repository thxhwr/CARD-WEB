<?php
// 사용자가 입력한 값
$id = $_POST['id'] ?? '';
$pw = $_POST['pw'] ?? '';

// 간단 유효성 검증
if ($id === '' || $pw === '') {
    header('Location: /login.php?error=1');
    exit;
}

// API로 보낼 데이터 (필드명은 API 문서에 맞게 수정)
$postFields = [
  'memberId' => $id,
  'memberPw' => $pw,
];

$ch = curl_init('https://api.thxdeal.com/api/login/memberLogin.php');
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $postFields,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
]);

$response = curl_exec($ch);
if ($response === false) {
    curl_close($ch);
    header('Location: /login.php?error=1');
    exit;
}
curl_close($ch);

// 응답 JSON 파싱 (형식에 맞게 조정)
$data = json_decode($response, true);
if ($data['resCode'] == "0") {
    $lifetime = 60 * 60 * 24 * 30;
    session_set_cookie_params([
        'lifetime' => $lifetime,
        'path'     => '/',
        'secure'   => isset($_SERVER['HTTPS']), 
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();

    $_SESSION['user_Status'] = $data['data']['status'];
    $_SESSION['user_No'] = $data['data']['accountNo'] ?? null;
    $_SESSION['user_Id']    = $data['data']['userId'] ?? null;
    $_SESSION['user_Card'] = $data['data'][''] ?? null;

    session_regenerate_id(true);

    header('Location: /index.php');
    exit;
} else {

    header('Location: /login.php?error=1');
    exit;
}
