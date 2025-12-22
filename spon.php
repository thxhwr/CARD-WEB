<?php
session_start();

// 로그인한 사용자
$myAccountNo = $_SESSION['user_No'] ?? null;
if (!$myAccountNo) die("로그인 필요");

// 검색된 계정이 있으면 그 계정을 루트로, 없으면 나를 루트로
$rootAccountNo = $_GET['accountNo'] ?? $myAccountNo;

$postFields = [
    'accountNo' => $rootAccountNo,
];

$ch = curl_init('https://api.thxdeal.com/api/member/testMemberSpon.php');
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $postFields,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false
]);
$response = curl_exec($ch);
if ($response === false) die("API 호출 실패");

$data = json_decode($response, true);
if (($data['resCode'] ?? -1) !== 0) die("API 응답 오류");

$root = $data['data'];  // 루트 노드 전체 구조

// -------------- 루트(나 또는 검색한 계정) 표시용 ------------------
$rootNodeUI = [
    'name'      => $root['name'],
    'accountNo' => $root['accountNo'],
    'userId'    => $root['userId'],
    'dept'      => $root['dept'],
    'deptNo'    => $root['deptNo']
];

// -------------- 자식/손자/증손(총 3대) 수집 ---------------------
$levels = [];  // $levels[1], $levels[2], $levels[3]

function collect3Gen($node, $relDepth, &$levels)
{
    if ($relDepth >= 1 && $relDepth <= 3) {
        if (!isset($levels[$relDepth])) $levels[$relDepth] = [];
        $levels[$relDepth][] = [
            'name'      => $node['name'],
            'accountNo' => $node['accountNo'],
            'userId'    => $node['userId'],
            'dept'      => $node['dept'],
            'deptNo'    => $node['deptNo']
        ];
    }

    if ($relDepth >= 3) return;

    if (!empty($node['children'])) {
        foreach ($node['children'] as $child) {
            collect3Gen($child, $relDepth + 1, $levels);
        }
    }
}

// 루트는 depth=0 → 출력은 별도, children은 relDepth 1부터 시작
collect3Gen($root, 0, $levels);

// 각 줄 정렬 (deptNo 순)
foreach ($levels as &$list) {
    usort($list, fn($a,$b)=>($a['deptNo']??0) <=> ($b['deptNo']??0));
}
unset($list);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<title>추천인 계보</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body {
    margin:0;
    padding:16px;
    background:#f7f7f9;
    font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;
}

.tree-wrap {
    max-width:1200px;
    margin:0 auto;
}

.tree-header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    margin-bottom:16px;
}

.tree-title {
    font-size:20px;
    font-weight:700;
}

.search-form {
    display:flex;
    gap:8px;
}

.search-input {
    padding:8px 12px;
    border-radius:8px;
    border:1px solid #ccc;
}

.search-btn {
    padding:8px 14px;
    border-radius:8px;
    background:#111;
    color:#fff;
    border:none;
    cursor:pointer;
}

/* 1줄(루트) + 3줄 */
.tree-level {
    margin-bottom:24px;
    text-align:center;
    overflow-x:auto;
}

.tree-row {
    display:inline-flex;
    justify-content:center;
    gap:14px;
    flex-wrap:nowrap; /* 한 줄에 모두 나열 */
}

/* 카드 디자인 */
.node-card {
    background:#fff;
    padding:14px 18px;
    border-radius:18px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    min-width:200px;
    text-align:left;
    border-top:3px solid #f97316;
}

.node-name {
    font-size:15px;
    font-weight:600;
    margin-bottom:6px;
}

.node-meta {
    font-size:12px;
    color:#6b7280;
    margin-bottom:3px;
}

.node-account {
    font-size:12px;
    color:#4b5563;
}
</style>
</head>
<body>

<div class="tree-wrap">

    <!-- 상단 -->
    <div class="tree-header">
        <div class="tree-title">추천인 계보</div>

        <form class="search-form" method="get">
            <input type="text" name="accountNo"
                   class="search-input"
                   placeholder="계정(accountNo)을 입력"
                   value="">
            <button class="search-btn">검색</button>
        </form>
    </div>

    <!-- ⭐ 첫 줄: 나(또는 검색한 사람) 표시 -->
    <div class="tree-level">
        <div class="tree-row">
            <div class="node-card" style="border-top-color:#6366f1;">
                <div class="node-name"><?= htmlspecialchars($rootNodeUI['name']) ?></div>
                <div class="node-meta">
                    줄: <?= $rootNodeUI['dept'] ?> · 순서 <?= $rootNodeUI['deptNo'] ?>
                </div>
                <div class="node-account"><?= htmlspecialchars($rootNodeUI['accountNo']) ?></div>
            </div>
        </div>
    </div>

    <!-- ⭐ 자식/손자/증손 3줄 출력 -->
    <?php foreach ($levels as $depth => $nodes): ?>
        <div class="tree-level">
            <div class="tree-row">
                <?php foreach ($nodes as $n): ?>
                    <div class="node-card">
                        <div class="node-name"><?= htmlspecialchars($n['name']) ?></div>
                        <div class="node-meta">
                            줄: <?= $n['dept'] ?> · 순서 <?= $n['deptNo'] ?>
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
