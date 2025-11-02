<?php 

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    try {
        $mysqli = new mysqli("72.60.237.149", "thxdeal", "dealThx11223@#", "THXDEAL_DB","37722");
        echo "✅ DB 연결 성공!";
    } catch (mysqli_sql_exception $e) {
        echo "❌ DB 연결 실패: " . $e->getMessage();
    }

    echo "success";
?>