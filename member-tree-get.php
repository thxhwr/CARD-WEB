<?php
session_start();

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
  CURLOPT_TIMEOUT        => 10,
]);

$response = curl_exec($ch);
if ($response === false) {
  echo "API 호출 실패: " . curl_error($ch);
  curl_close($ch);
  exit;
}
curl_close($ch);

$data = json_decode($response, true);
if (!is_array($data)) {
  echo "응답 JSON 파싱 실패";
  exit;
}

if (($data['resCode'] ?? 1) !== 0) {
  echo "API 오류: " . htmlspecialchars($data['message'] ?? 'unknown');
  exit;
}

/**
 * ✅ list 안전하게 뽑기 (현재 구조: data.list)
 */
$list = $data['data']['list'] ?? [];
if (!is_array($list)) $list = [];

/**
 * ✅ dept 무시: 2대에 전부 넣기
 */
$level2 = [];
foreach ($list as $row) {
  if (!is_array($row)) continue;

  $level2[] = [
    'name'      => (string)($row['name'] ?? ''),
    'accountNo' => (string)($row['accountNo'] ?? ''),
    'userId'    => $row['userId'] ?? null,
    'createdAt' => (string)($row['createdAt'] ?? ''),
    'deptNo'    => $row['deptNo'] ?? null, // 정렬용으로만 쓰고 dept는 무시
  ];
}

/**
 * ✅ 보기 좋게 deptNo로만 정렬(없으면 0)
 */
usort($level2, fn($a, $b) => (int)($a['deptNo'] ?? 0) <=> (int)($b['deptNo'] ?? 0));

$pageTitle = "추천계보";
?>
