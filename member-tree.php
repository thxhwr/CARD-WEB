<?php
session_start();
require_once __DIR__ . "/auth.php"; // ✅ head 밖에서 먼저

$myAccountNo = $_SESSION['user_No'] ?? null;
if (!$myAccountNo) {
    echo "로그인이 필요합니다.";
    exit;
}

// API 호출
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

// list 꺼내기 (너가 보여준 구조가 [0]=>... 라면 아래가 다를 수 있어)
// 보통: $list = $data['data']['list'] ?? [];
$list = $data['data']['list'] ?? ($data['data'] ?? []);
if (!is_array($list)) $list = [];

// ✅ list가 "0번부터 시작하는 배열"이 아닐 때 보정
// (예: ['list'=>...] 같은 형태가 아니라 이미 list 자체일 때)
if ($list && !isset($list[0]) && isset($data[0])) {
    $list = $data;
}

// dept 최소값 구해서 "1대 기준" 만들기
$minDept = null;
foreach ($list as $row) {
    $d = (int)($row['dept'] ?? 0);
    if ($d <= 0) continue;
    if ($minDept === null || $d < $minDept) $minDept = $d;
}

// minDept가 없으면 빈값
$levels = [];

if ($minDept !== null) {
    $from = $minDept;       // 1대
    $to   = $minDept + 2;   // 3대까지

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

    // deptNo 정렬
    foreach ($levels as &$nodes) {
        usort($nodes, fn($a,$b) => ($a['deptNo'] ?? 0) <=> ($b['deptNo'] ?? 0));
    }
    unset($nodes);

    ksort($levels);
}

$pageTitle = "추천인";
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include __DIR__ . "/head.php"; ?>
</head>
<body>
<div class="app">
    <header class="appbar-apply">
        <nav class="appbar__inner container--narrow" aria-label="상단 내비게이션">
            <a href="javascript:history.back()" class="nav-btn" aria-label="뒤로가기">
                <img src="/assets/icons/btn-next-arrow-left-dg.svg" width="24" height="24" alt="">
            </a>
            <h1 class="appbar__title">추천인</h1>
            <a href="/index.php" class="nav-btn home-btn" aria-label="홈">
                <img src="/assets/icons/icon-home.svg" alt="">
            </a>
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

            <!-- 루트 -->
            <div class="tree-level">
                <div class="tree-row">
                    <div class="node-card node-root">
                        <div class="node-account">
                            <?= htmlspecialchars($myAccountNo, ENT_QUOTES) ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (empty($levels)): ?>
                <p class="empty-text">표시할 추천인 계보가 없습니다.<br>(밑으로 3대가 없음)</p>
            <?php else: ?>
                <?php foreach ($levels as $dept => $nodes): ?>
                    <div class="tree-level-label">
                        <?= (int)($dept - $minDept + 1) ?>대
                    </div>

                    <div class="tree-level">
                        <div class="tree-row">
                            <?php foreach ($nodes as $n): ?>
                                <div class="tree-node-card">
                                    <div class="tree-node-name">
                                        <?= htmlspecialchars($n['name'], ENT_QUOTES) ?>
                                    </div>
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
