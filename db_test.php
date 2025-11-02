<?php 
ini_set ('error_reporting', E_ALL);
ini_set ('display_errors', '1');
error_reporting (E_ALL|E_STRICT);


$host = '72.60.237.149';  // MySQL 서버 IP
$user = 'thxdeal';     // MySQL 사용자
$pass = 'dealThx11223@#';
$db   = 'THXDEAL_DB';
$port = 37722;              // MariaDB 포트

$mysqli = mysqli_init();

// SSL 설정
mysqli_ssl_set(
    $mysqli,
    '/home/thxdeal/mysql_certs/client-key.pem',
    '/home/thxdeal/mysql_certs/client-cert.pem',
    '/home/thxdeal/mysql_certs/ca.pem',
    NULL,
    NULL
);

// SSL 옵션과 함께 연결
if (!mysqli_real_connect($mysqli, $host, $user, $pass, $db, $port, NULL, MYSQLI_CLIENT_SSL)) {
    die('MySQL 연결 실패: (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}

echo 'MySQL SSL 연결 성공!';

?>