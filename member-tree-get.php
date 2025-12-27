<?php
$myAccountNo = $_SESSION['user_No'] ?? null;
if (!$myAccountNo) {
    echo "로그인이 필요합니다.";
    exit;
}


$postFields = ['accountNo' => $myAccountNo];

$ch = curl_init('https://api.thxdeal.com/api/member/testMemberReco.php');
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => http_build_query($postFields),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
]);

$response = curl_exec($ch);
if ($response === false) {
    $errorMsg = "API 호출 실패: " . curl_error($ch);
    curl_close($ch);
    echo $errorMsg;
    exit;
}
curl_close($ch);

$data = json_decode($response, true);

$list = $data['data']['list'] ?? ($data['data'] ?? []);
if (!is_array($list)) $list = [];

if ($list && !isset($list[0]) && isset($data[0])) {
    $list = $data;
}

$minDept = null;
foreach ($list as $row) {
    $d = (int)($row['dept'] ?? 0);
    if ($d <= 0) continue;
    if ($minDept === null || $d < $minDept) $minDept = $d;
}

$levels = [];

if ($minDept !== null) {
    $from = $minDept;
    $to   = $minDept + 2;
    // $to   = $minDept + 2;  

    foreach ($list as $row) {
        $dept = (int)($row['dept'] ?? 0);
        if ($dept < $from || $dept > $to) continue;

        if (!isset($levels[$dept])) $levels[$dept] = [];
        $levels[$dept][] = [
            'name'      => $row['name'] ?? '',
            'accountNo' => $row['accountNo'] ?? '',
            'userId'    => $row['userId'] ?? null,
            'dept'      => $dept,
            'deptNo'    => $row['deptNo'] ?? null,
            'createdAt' => $row['createdAt'] ?? '',
        ];
    }

    foreach ($levels as &$nodes) {
        usort($nodes, fn($a,$b) => ($a['deptNo'] ?? 0) <=> ($b['deptNo'] ?? 0));
    }
    unset($nodes);

    ksort($levels);
}

$pageTitle = "추천인";
?>