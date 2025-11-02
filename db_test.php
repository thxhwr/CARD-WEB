<?php 

$mysqli = mysqli_init();

mysqli_ssl_set(
    $mysqli,
    "/etc/mysql/certs/client-key.pem",
    "/etc/mysql/certs/client-cert.pem",
    "/etc/mysql/certs/ca.pem",
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

if ($mysqli->connect_error) {
    die("DB 연결 실패: " . $mysqli->connect_error);
}
echo "✅ SSL DB 연결 성공!";

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    try {
        $mysqli = new mysqli("72.60.237.149", "thxdeal", "dealThx11223@#", "THXDEAL_DB","37722");
        echo "✅ DB 연결 성공!";
    } catch (mysqli_sql_exception $e) {
        echo "❌ DB 연결 실패: " . $e->getMessage();
    }

    echo "success";
?>