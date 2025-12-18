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

print_r($data);
if (isset($data['result']) && $data['result'] === 'OK') {
    if (!empty($_POST['remember_me'])) {
        // 30일 동안 유지
        $lifetime = 60 * 60 * 24 * 30;
    } else {
        // 브라우저 닫으면 삭제 (0)
        $lifetime = 0;
    }
    session_set_cookie_params([
        'lifetime' => $lifetime,
        'path'     => '/',
        'secure'   => isset($_SERVER['HTTPS']), // https 쓸 때 true
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
    // 세션에 로그인 정보 저장
    $_SESSION['user_id']   = $data['id'];
    $_SESSION['user_name'] = $data['name'];
    $_SESSION['memberNo'] = $data['memberNo'] ?? null;
    $_SESSION['token']    = $data['token'] ?? null;

    // 보안상 세션ID 재발급
    session_regenerate_id(true);

    //header('Location: /index.php');
    //exit;
} else {
    // 실패 처리
    //header('Location: /login.php?error=1');
    //exit;
}
