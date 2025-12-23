<?php
// 항상 제일 위에
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['user_No'])) {
    header('Location: /index.php');
    exit;
}




function curlPost(string $url, array $postData = [], int $timeout = 10): array
{
    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_POST            => true,
        CURLOPT_POSTFIELDS      => http_build_query($postData),
        CURLOPT_RETURNTRANSFER  => true,
        CURLOPT_SSL_VERIFYPEER  => true,   // 가능하면 true
        CURLOPT_TIMEOUT         => $timeout,
        CURLOPT_CONNECTTIMEOUT  => 5,
    ]);

    $body = curl_exec($ch);
    $errno = curl_errno($ch);
    $error = curl_error($ch);
    $http  = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($errno) {
        return ['ok' => false, 'http' => $http, 'error' => $error, 'body' => $body];
    }

    $json = json_decode($body, true);
    if (!is_array($json)) {
        return ['ok' => false, 'http' => $http, 'error' => 'JSON decode failed', 'body' => $body];
    }

    return ['ok' => true, 'http' => $http, 'data' => $json];
}