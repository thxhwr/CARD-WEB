<?php 

$mysqli = mysqli_init();

mysqli_ssl_set(
    $mysqli,
    '/home/thxdeal/mysql_certs/client-key.pem',
    '/home/thxdeal/mysql_certs/client-cert.pem',
    '/home/thxdeal/mysql_certs/ca.pem',
    NULL, NULL
);

if (!mysqli_real_connect($mysqli, '72.60.237.149', 'thxdeal', 'dealThx11223@#', 'THXDEAL_DB', 37722, NULL, MYSQLI_CLIENT_SSL)) {
    die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}

echo "SSL connection success!";
?>