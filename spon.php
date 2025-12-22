<?php
session_start();

// 로그인한 사용자 계정
$memberNo = $_SESSION['user_No'] ?? null;
if (!$memberNo) die("로그인 필요");

$postFields = [
    'accountNo' => $memberNo,
];

$ch = curl_init('https://api.thxdeal.com/api/member/testMemberSpon.php');
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $postFields,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
]);

$response = curl_exec($ch);

print_r($response);
if ($response === false) {
    die("API 호출 실패: ".curl_error($ch));
}
curl_close($ch);

$data = json_decode($response, true);
if (($data['resCode'] ?? -1) !== 0) die("API 응답 오류");

$root = $data['data'];
// --------------------------------------------------------------------------
// 1) 계보 트리를 dept 기준으로 분리
// --------------------------------------------------------------------------
$levels = [];  // $levels[1] = [노드들...], $levels[2] = [...], ...

function collectByDept($node, &$levels) {
    $dept = $node['dept'];
    if (!isset($levels[$dept])) $levels[$dept] = [];

    $levels[$dept][] = [
        'name'      => $node['name'],
        'accountNo' => $node['accountNo'],
        'userId'    => $node['userId'],
        'dept'      => $node['dept'],
        'deptNo'    => $node['deptNo'],
    ];

    if (!empty($node['children'])) {
        foreach ($node['children'] as $child) {
            collectByDept($child, $levels);
        }
    }
}

collectByDept($root, $levels);

// --------------------------------------------------------------------------
// 2) 각 dept 라인별로 deptNo 순서대로 정렬
// --------------------------------------------------------------------------
foreach ($levels as $dept => &$list) {
    usort($list, function($a, $b) {
        return $a['deptNo'] <=> $b['deptNo'];
    });
}
unset($list);

// dept 순서대로 정렬
ksort($levels);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<title>추천인 계보</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body {
    margin:0; padding:16px;
    background:#f7f7f9;
    font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;
}

.tree-wrap {
    max-width:900px;
    margin:0 auto;
    overflow-x:auto;
}

.tree-title {
    font-size:20px;
    font-weight:700;
    margin-bottom:20px;
}

/* Depth(줄) */
.tree-level {
    margin-bottom:24px;
    text-align:center;
}

.tree-row {
    display:flex;
    justify-content:center;
    gap:14px;
    flex-wrap:wrap;
}

/* 카드 디자인 */
.node-card {
    background:#fff;
    padding:12px 16px;
    border-radius:12px;
    box-shadow:0 2px 10px rgba(0,0,0,0.06);
    min-width:140px;
    max-width:180px;
    text-align:left;
    border-top:3px solid #f97316;
}

.node-name { font-size:14px; font-weight:600; margin-bottom:4px; }
.node-meta { font-size:12px; color:#6b7280; margin-bottom:3px; }
.node-account { font-size:12px; color:#4b5563; word-break:break-all; }
</style>
</head>
<body>

<div class="tree-wrap">
    <div class="tree-title">추천인 계보</div>

    <?php foreach ($levels as $dept => $nodes): ?>
        <div class="tree-level">
            <div class="tree-row">
                <?php foreach ($nodes as $n): ?>
                <div class="node-card">
                    <div class="node-name"><?= htmlspecialchars($n['name']) ?></div>
                    <div class="node-meta">
                        줄  : <?= $n['userId'] ?> · 순서 <?= $n['deptNo'] ?>
                    </div>
                    <div class="node-account"><?= htmlspecialchars($n['accountNo']) ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>

</div>

</body>
</html>
