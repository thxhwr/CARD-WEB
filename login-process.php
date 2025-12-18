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

// 예: { "result":"OK", "memberNo":123, "token":"..." } 라고 가정
if (isset($data['result']) && $data['result'] === 'OK') {
    session_start();
    $_SESSION['memberNo'] = $data['memberNo'] ?? null;
    $_SESSION['token']    = $data['token'] ?? null;

    print_r($response);
    // header('Location: /index.php');
    // exit;
} else {
    // 실패 처리
        print_r($response);
    // header('Location: /login.php?error=1');
    // exit;
}
