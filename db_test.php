<?php 

$mysqli = mysqli_init();

mysqli_ssl_set(
    $mysqli,
    '/home/thxdeal/mysql_certs/client-key.pem',
    '/home/thxdeal/mysql_certs/client-cert.pem',
    '/home/thxdeal/mysql_certs/ca.pem',
    NULL, NULL
);

mysqli_real_connect(
    $mysqli,
    "72.60.237.149",                    // DB 서버 IP
    "thxdeal",                    // 사용자명
    "dealTHX11223@#",                   // 비밀번호
    "THXDEAL_DB",                 // 데이터베이스명
    37722,                         // 포트
    NULL,
    MYSQLI_CLIENT_SSL
);

if (!mysqli_real_connect($mysqli, '1.1.1.1', 'jiheon1992', '비밀번호', 'DB이름', 1234, NULL, MYSQLI_CLIENT_SSL)) {
    die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}

echo "SSL connection success!";
?>