<?php
session_start();
$myAccountNo = $_SESSION['user_No'] ?? null; 
if (!$myAccountNo) {
    echo "로그인이 필요합니다.";
    exit;
}

$searchInput   = isset($_GET['accountNo']) ? trim($_GET['accountNo']) : null;
$rootAccountNo = ($searchInput === null || $searchInput === '')
    ? $myAccountNo
    : $searchInput;

$errorMsg = '';
$root     = null;
$levels   = [];

$postFields = [
    'accountNo' => $rootAccountNo,
];

$ch = curl_init('https://api.thxdeal.com/api/member/testMemberSpon.php');
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

/* -----------------------------------------------------
 * 3. JSON 디코드 & 에러 처리
 *    - 존재하지 않는 계정이면 문구만 띄우고 계보는 없음
 * --------------------------------------------------- */
if (!$errorMsg) {
    $data = json_decode($response, true);

    if (!is_array($data) || ($data['resCode'] ?? -1) !== 0 || empty($data['data'])) {
        // 없는 계정이라고 가정
        $errorMsg = "존재하지 않는 계정입니다.";
    } else {
        $root = $data['data'];
    }
}

/* -----------------------------------------------------
 * 4. 루트 기준으로 아래 3대만 depth별 분리 (루트 자신은 제외)
 * --------------------------------------------------- */
if ($root) {
    // relDepth: 1 = 자식, 2 = 손자, 3 = 증손
    function collectDescendants3Gen(array $node, int $relDepth, array &$levels, int $maxDepth = 3)
    {
        if ($relDepth >= 1 && $relDepth <= $maxDepth) {
            if (!isset($levels[$relDepth])) {
                $levels[$relDepth] = [];
            }

            $levels[$relDepth][] = [
                'name'      => $node['name']      ?? '',
                'accountNo' => $node['accountNo'] ?? '',
                'userId'    => $node['userId']    ?? null,
                'dept'      => $node['dept']      ?? null,   // 줄 번호
                'deptNo'    => $node['deptNo']    ?? null,   // 그 줄에서 순서
            ];
        }

        if ($relDepth >= $maxDepth) {
            return;
        }

        if (!empty($node['children']) && is_array($node['children'])) {
            foreach ($node['children'] as $child) {
                collectDescendants3Gen($child, $relDepth + 1, $levels, $maxDepth);
            }
        }
    }

    collectDescendants3Gen($root, 0, $levels, 3);

    // 각 세대 안에서 deptNo 순으로 정렬
    foreach ($levels as $relDepth => &$nodes) {
        usort($nodes, function ($a, $b) {
            return ($a['deptNo'] ?? 0) <=> ($b['deptNo'] ?? 0);
        });
    }
    unset($nodes);

    ksort($levels); // 1 → 3 순서
}
?>
<?php $pageTitle = "추천인"; ?>
<!DOCTYPE html>
<html lang="ko">
<head>
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
            <a href="/index.php" class="nav-btn home-btn" aria-label="홈"></a>
        </nav>
    </header>

    <main class="page">
        <div class="tree-wrap">

            <div class="tree-header">
                <div>
                    <div class="tree-title">추천계보</div>
                    <div class="root-info">
                        기준 계정:
                        <strong><?= htmlspecialchars($rootAccountNo, ENT_QUOTES) ?></strong>
                        (이 계정을 루트로, 아래 3대까지만 표시)
                    </div>
                </div>
            </div>

            <?php if ($errorMsg): ?>
                <!-- 존재하지 않는 계정 / API 에러 등 -->
                <p class="error-text"><?= htmlspecialchars($errorMsg, ENT_QUOTES) ?></p>

            <?php elseif (!$root): ?>
                <p class="empty-text">루트 정보를 가져오지 못했습니다.</p>

            <?php else: ?>

                <!-- 루트(나 또는 검색한 계정) 카드 -->
                <div class="tree-level">
                    <div class="tree-row">
                        <div class="node-card node-root">
                            <div class="node-name">
                                <?= htmlspecialchars($root['name'] ?? '', ENT_QUOTES) ?>
                            </div>
                            <div class="node-meta">
                                줄: <?= (int)($root['dept'] ?? 0) ?>
                                · 순서 <?= (int)($root['deptNo'] ?? 0) ?>
                            </div>
                            <div class="node-account">
                                <?= htmlspecialchars($root['accountNo'] ?? '', ENT_QUOTES) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 루트 기준 아래 3대 -->
                <?php if (empty($levels)): ?>
                    <p class="empty-text">표시할 추천인 계보가 없습니다. (밑으로 3대가 없음)</p>
                <?php else: ?>
                    <?php foreach ($levels as $relDepth => $nodes): ?>
                        <div class="tree-level">
                            <div class="tree-row">
                                <?php foreach ($nodes as $n): ?>
                                    <div class="node-card">
                                        <div class="node-name">
                                            <?= htmlspecialchars($n['name'], ENT_QUOTES) ?>
                                        </div>
                                        <div class="node-meta">
                                            줄: <?= (int)($n['dept'] ?? 0) ?>
                                            · 순서 <?= (int)($n['deptNo'] ?? 0) ?>
                                        </div>
                                        <div class="node-account">
                                            <?= htmlspecialchars($n['accountNo'], ENT_QUOTES) ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            <?php endif; ?>

        </div>
    </main>
</div>
</body>
</html>
