<?php
$search = trim($_GET['q'] ?? '');         
$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 20;

$postFields = [
    'search' => $search,
    'page'  => $page,
    'list' => $limit,
];

$ch = curl_init('https://api.thxdeal.com/api/member/testMemberAppList.php');
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $postFields,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
]);

$response = curl_exec($ch);
$curlErr  = $response === false ? curl_error($ch) : null;
curl_close($ch);

$appList = [];
$totalCount = 0;
$errorMsg = null;

if (!$errorMsg) {
  $json = json_decode($response, true);

  if (!is_array($json) || !isset($json['resCode'])) {
    $errorMsg = "응답 파싱 실패";
  } elseif ((int)$json['resCode'] !== 0) {
    $errorMsg = $json['message'] ?? '요청 실패';
  } else {
    $appList   = $json['data'] ?? [];
    $totalLine = (int)($json['totalLine'] ?? 0);

    // 검색(q) 필터 (이름/아이디/연락처)
    if ($q !== '') {
      $appList = array_values(array_filter($appList, function($row) use ($q) {
        $hay = ($row['NAME'] ?? '') . ' ' . ($row['ACCOUNT_NO'] ?? '') . ' ' . ($row['PHONE'] ?? '');
        return mb_stripos($hay, $q) !== false;
      }));
    }
  }
}

?>