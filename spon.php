<?php
session_start();

/* -----------------------------------------------------
 * 0. 기준 계정 (로그인한 사람)
 * --------------------------------------------------- */
$myAccountNo = $_SESSION['user_No'] ?? null;   // 예: "kni1993@naver.com"
if (!$myAccountNo) {
    echo "로그인이 필요합니다.";
    exit;
}

/* -----------------------------------------------------
 * 1. 검색 값 처리
 *    - 빈값이면 내 계정으로 조회
 * --------------------------------------------------- */
$searchInput   = isset($_GET['accountNo']) ? trim($_GET['accountNo']) : null;
$rootAccountNo = ($searchInput === null || $searchInput === '')
    ? $myAccountNo
    : $searchInput;

$errorMsg = '';
$root     = null;
$levels   = [];

/* -----------------------------------------------------
 * 2. API 호출
 * --------------------------------------------------- */
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
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<title>추천인 계보</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
    body {
        margin: 0;
        padding: 16px;
        background: #f7f7f9;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .tree-wrap {
        max-width: 1120px;
        margin: 0 auto;
    }

    .tree-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
        flex-wrap: wrap;
    }

    .tree-title {
        font-size: 20px;
        font-weight: 700;
    }

    .root-info {
        font-size: 13px;
        color: #6b7280;
    }

    .search-form {
        display: flex;
        gap: 8px;
        margin-top: 8px;
    }

    .search-input {
        padding: 8px 10px;
        border-radius: 999px;
        border: 1px solid #d1d5db;
        min-width: 220px;
        font-size: 13px;
    }

    .search-btn {
        padding: 8px 14px;
        border-radius: 999px;
        border: none;
        background: #111827;
        color: #fff;
        font-size: 13px;
        cursor: pointer;
    }

    .tree-level {
        margin-bottom: 24px;
        text-align: center;
        overflow-x: auto; /* 같은 세대 가로로 길어지면 스크롤 */
    }

    .tree-row {
        display: inline-flex;
        justify-content: center;
        gap: 14px;
        flex-wrap: nowrap;      /* 같은 세대는 한 줄에 고정 */
    }

    .node-card {
        background: #ffffff;
        padding: 14px 18px;
        border-radius: 18px;
        box-shadow: 0 10px 20px rgba(15,23,42,0.08);
        min-width: 180px;
        max-width: 220px;
        text-align: left;
        border-top: 3px solid #f97316;
        font-size: 13px;
    }

    .node-root {
        border-top-color: #6366f1; /* 루트는 색만 살짝 다르게 */
    }

    .node-name {
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .node-meta {
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 2px;
    }

    .node-account {
        font-size: 12px;
        color: #4b5563;
        word-break: break-all;
    }

    .empty-text, .error-text {
        font-size: 24px;
        color: #9ca3af;
        margin-top: 12px;
        text-align: center;
    }

    .error-text {
        color: #ef4444;
    }
</style>
</head>
<body>

<div class="tree-wrap">

    <div class="tree-header">
        <div>
            <div class="tree-title">추천인 계보</div>
            <div class="root-info">
                기준 계정:
                <strong><?= htmlspecialchars($rootAccountNo, ENT_QUOTES) ?></strong>
                (이 계정을 루트로, 아래 3대까지만 표시)
            </div>
        </div>

        <form class="search-form" method="get">
            <input type="text"
                   name="accountNo"
                   class="search-input"
                   placeholder="계보를 보고 싶은 계정(accountNo)을 입력"
                   value="<?= htmlspecialchars($searchInput ?? '', ENT_QUOTES) ?>">
            <button type="submit" class="search-btn">검색</button>
        </form>
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

</body>
</html>
