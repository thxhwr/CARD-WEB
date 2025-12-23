<?php
session_start();
$myAccountNo = $_SESSION['user_No'] ?? null; 
if (!$myAccountNo) {
    echo "로그인이 필요합니다.";
    exit;
}

$postFields = [
    'accountNo' => $myAccountNo,
];

$ch = curl_init('https://api.thxdeal.com/api/member/testMemberReco.php');
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $postFields,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
]);

$response = curl_exec($ch);
if ($response === false) {
    $errorMsg = "API 호출 실패: " . curl_error($ch);
}
curl_close($ch);

$levels = [];

$list = $data['data']['list'] ?? [];
if (!is_array($list)) $list = [];

// dept 기준으로 2~4까지만(= 나 제외 3대) 모으기
foreach ($list as $row) {
    $dept = (int)($row['dept'] ?? 0);

    // 2=1대, 3=2대, 4=3대 (루트가 dept=1이라고 가정)
    if ($dept < 2 || $dept > 4) continue;

    if (!isset($levels[$dept])) $levels[$dept] = [];
    $levels[$dept][] = [
        'name'      => $row['name'] ?? '',
        'accountNo' => $row['accountNo'] ?? '',
        'userId'    => $row['userId'] ?? null,
        'dept'      => $dept,
        'deptNo'    => $row['deptNo'] ?? null,
    ];
}

// 같은 dept 안에서 deptNo 정렬
foreach ($levels as &$nodes) {
    usort($nodes, fn($a,$b) => ($a['deptNo'] ?? 0) <=> ($b['deptNo'] ?? 0));
}
unset($nodes);

// dept 순서대로
ksort($levels);

?>
<?php $pageTitle = "추천인"; ?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include __DIR__ . "/auth.php"; ?>
    <?php include __DIR__ . "/head.php"; ?>
</head>
</head>
<body>
<div class="app">
    <header class="appbar-apply">
        <nav class="appbar__inner container--narrow" aria-label="상단 내비게이션">
            <a href="javascript:history.back()" class="nav-btn" aria-label="뒤로가기">
                <img src="/assets/icons/btn-next-arrow-left-dg.svg" width="24px" height="24px">
            </a>
            <h1 class="appbar__title">추천인</h1>
            <a href="/index.php" class="nav-btn home-btn" aria-label="홈"><img src="/assets/icons/icon-home.svg"></a>
        </nav>
    </header>

    <main class="page">
        <div class="tree-wrap">

            <div class="tree-header">
                <div style="margin:0 auto;">
                    <div class="root-info">
                        <b>옆으로 스크롤(줄을 밀면)시 모두 확인 가능합니다.</b>
                    </div>
                </div>
            </div>
            <div class="tree-level">
                <div class="tree-row">
                    <div class="node-card node-root">
                        <div class="node-name">
                            <?= htmlspecialchars($myAccountNo '', ENT_QUOTES) ?>
                        </div>
                        <div class="node-account">
                            <?= htmlspecialchars($myAccountNo ?? '', ENT_QUOTES) ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (empty($levels)): ?>
                <p class="empty-text">표시할 추천인 계보가 없습니다.<br >(밑으로 3대가 없음)</p>
            <?php else: ?>
                <?php foreach ($levels as $relDepth => $nodes): ?>
                        <div class="tree-level-label">
                        <?= (int)$relDepth ?>대
                        </div>

                    <div class="tree-level">
                        <div class="tree-row">
                        <?php foreach ($nodes as $n): ?>
                            <div class="tree-node-card">
                            <div class="tree-node-name">
                                <?= htmlspecialchars($n['name'], ENT_QUOTES) ?>
                            </div>
                            <!-- <div class="tree-node-meta">
                                줄: <?= (int)($n['dept'] ?? 0) ?>
                                · 순서 <?= (int)($n['deptNo'] ?? 0) ?>
                            </div> -->
                            <div class="tree-node-account">
                                <?= htmlspecialchars($n['accountNo'], ENT_QUOTES) ?>
                            </div>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</div>
</body>
</html>
