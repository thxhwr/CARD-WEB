<?php
$search = trim($_GET['q'] ?? '');         
$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 20;

$postFields = [
    // 'search' => $search,
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
if ($curlErr) {
  $errorMsg = "API 호출 실패: " . $curlErr;
} else {
  $data = json_decode($response, true);
  print_r($data);
  if (!is_array($data)) {
    $errorMsg = "응답 JSON 파싱 실패";
  } else if ((string)($data['resCode'] ?? '') !== '0') {
    $errorMsg = ($data['message'] ?? '조회 실패');
  } else {
    $appList = $data['data']['list'] ?? ($data['data'] ?? []);
    if (!is_array($appList)) $appList = [];

    $totalCount = (int)($data['data']['count'] ?? $data['totalLine'] ?? 0);
  }
}
?>