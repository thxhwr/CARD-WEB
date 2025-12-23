<?php
// 항상 제일 위에
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['user_No'])) {
    header('Location: /index.php');
    exit;
}




function curlPost(string $url, array $postData = [], int $timeout = 10): ?array
{
    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_POST            => true,
        CURLOPT_POSTFIELDS      => http_build_query($postData),
        CURLOPT_RETURNTRANSFER  => true,
        CURLOPT_SSL_VERIFYPEER  => false,   // 운영환경에선 true 권장
        CURLOPT_TIMEOUT         => $timeout,
    ]);

    $response = curl_exec($ch);

    if ($response === false) {
        curl_close($ch);
        return null;
    }

    curl_close($ch);

    // JSON 응답 가정
    $decoded = json_decode($response, true);
    return is_array($decoded) ? $decoded : null;
}


