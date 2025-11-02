<?php 
ini_set ('error_reporting', E_ALL);
ini_set ('display_errors', '1');
error_reporting (E_ALL|E_STRICT);

$mysqli = mysqli_init();

// SSL 설정
$mysqli->ssl_set(
    '/home/thxdeal/mysql_certs/client-key.pem',
    '/home/thxdeal/mysql_certs/client-cert.pem',
    '/home/thxdeal/mysql_certs/ca.pem',
    NULL,
    NULL
);

// 서버 인증서 검증 옵션 설정
$mysqli->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);

// 실제 연결
if (!$mysqli->real_connect(
    '72.60.237.149', 
    'thxdeal', 
    'dealThx11223@#', 
    'THXDEAL_DB', 
    37722, 
    NULL, 
    MYSQLI_CLIENT_SSL
)) {
    die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}

echo "SSL 연결 성공";


?>