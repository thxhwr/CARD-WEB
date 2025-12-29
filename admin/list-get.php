<?php
// list-get.php

$q = trim($_GET['q'] ?? '');     
$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 20;

$postFields = [
  'search' => $q,   
  'page'   => $page,
  'list'   => $limit,
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
  $json = json_decode($response, true);

  if (!is_array($json) || !isset($json['resCode'])) {
    $errorMsg = "응답 파싱 실패";
  } elseif ((int)$json['resCode'] !== 0) {
    $errorMsg = $json['message'] ?? '요청 실패';
  } else {
    $appList   = $json['data'] ?? [];
    $totalLine = (int)($json['totalLine'] ?? 0);


    if ($q !== '') {
      // ---------- 유틸 ----------
      $normalize = function(string $s): string {
        $s = mb_strtolower($s, 'UTF-8');
        $s = preg_replace('/\s+/u', '', $s);         
        $s = str_replace(['-', '–', '—'], '', $s);   
        return $s ?? '';
      };

      $ngrams = function(string $s, int $n = 2): array {
        $len = mb_strlen($s, 'UTF-8');
        if ($len <= $n) return [$s];
        $out = [];
        for ($i = 0; $i <= $len - $n; $i++) {
          $out[] = mb_substr($s, $i, $n, 'UTF-8');
        }
        return $out;
      };


      $jaccard = function(string $a, string $b) use ($normalize, $ngrams): float {
        $a = $normalize($a);
        $b = $normalize($b);
        if ($a === '' || $b === '') return 0.0;

        $A = array_count_values($ngrams($a, 2));
        $B = array_count_values($ngrams($b, 2));

        $inter = 0;
        $union = 0;

        $keys = array_unique(array_merge(array_keys($A), array_keys($B)));
        foreach ($keys as $k) {
          $va = $A[$k] ?? 0;
          $vb = $B[$k] ?? 0;
          $inter += min($va, $vb);
          $union += max($va, $vb);
        }
        return $union > 0 ? ($inter / $union) : 0.0;
      };

      $qNorm = $normalize($q);

      $appList = array_values(array_filter($appList, function($row) use ($q, $qNorm, $normalize, $jaccard) {
        $name  = (string)($row['NAME'] ?? '');
        $email = (string)($row['ACCOUNT_NO'] ?? '');
        $phone = (string)($row['PHONE'] ?? '');

        // 1) 기본 부분일치(정규화 후)
        $hay = $normalize($name . ' ' . $email . ' ' . $phone);
        if ($qNorm !== '' && mb_stripos($hay, $qNorm, 0, 'UTF-8') !== false) {
          return true;
        }


        $simName  = $jaccard($q, $name);
        $simEmail = $jaccard($q, $email);

        // 기준값은 상황 따라 조절 (0.55~0.7 사이 권장)
        return ($simName >= 0.60) || ($simEmail >= 0.65);
      }));
    }
  }
}
?>
