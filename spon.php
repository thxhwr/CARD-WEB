<?php
session_start();

// 0. 기준 계정 (로그인한 사람)
$myAccountNo = $_SESSION['user_No'] ?? null;   // 예: "kni1993@naver.com"
if (!$myAccountNo) {
    die("로그인이 필요합니다.");
}

// 1. 검색 값이 있으면 그 사람을 루트로, 없으면 나를 루트로
$rootAccountNo = $_GET['accountNo'] ?? '';
$rootAccountNo = trim($rootAccountNo) !== '' ? trim($rootAccountNo) : $myAccountNo;

// 2. API 호출
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
    die("API 호출 실패: " . curl_error($ch));
}
curl_close($ch);

// 3. JSON 디코드
$data = json_decode($response, true);
if (!is_array($data) || ($data['resCode'] ?? -1) !== 0 || empty($data['data'])) {
    // 필요하면 var_dump($response);로 디버깅
    die("API 응답 오류");
}

$root = $data['data'];   // 검색한 사람(또는 나) 정보 + 트리

// 4. "나 제외, 밑에 3대까지" depth(세대)별로 분리
//    ▷ relDepth: 1 = 자식, 2 = 손자, 3 = 증손
$levels = [];  // $levels[1], $levels[2], $levels[3]

function collectDescendants3Gen(array $node, int $relDepth, array &$levels, int $maxDepth = 3)
{
    // relDepth 0 = 자기 자신 → 출력 X
    if ($relDepth >= 1 && $relDepth <= $maxDepth) {
        if (!isset($levels[$relDepth])) {
            $levels[$relDepth] = [];
        }

        $levels[$relDepth][] = [
            'name'      => $node['name']      ?? '',
            'accountNo' => $node['accountNo'] ?? '',
            'userId'    => $node['userId']    ?? null,
            'dept'      => $node['dept']      ?? null,   // 실제 "줄" 번호
            'deptNo'    => $node['deptNo']    ?? null,   // 그 줄에서 순서
        ];
    }

    // 3대까지만 보기 때문에 더 내려갈 필요 없으면 return
    if ($relDepth >= $maxDepth) {
        return;
    }

    if (!empty($node['children']) && is_array($node['children'])) {
        foreach ($node['children'] as $child) {
            collectDescendants3Gen($child, $relDepth + 1, $levels, $maxDepth);
        }
    }
}

// 루트 기준으로 0부터 시작 → 자식이 1대, 손자가 2대, 증손이 3대
collectDescendants3Gen($root, 0, $levels, 3);

// 각 세대 안에서 deptNo 순으로 정렬 (줄: X, 순서: Y)
foreach ($levels as $relDepth => &$nodes) {
    usort($nodes, function ($a, $b) {
        return ($a['deptNo'] ?? 0) <=> ($b['deptNo'] ?? 0);
    });
}
unset($nodes);

// relDepth 순으로 정렬 (1 → 3)
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

    /* 한 세대(자식/손자/증손) 라인 */
    .tree-level {
        margin-bottom: 24px;
        text-align: center;
        overflow-x: auto; /* 세대별 가로 스크롤 */
    }

    .tree-row {
        display: inline-flex;     /* 한 줄로 쭉 나열 */
        justify-content: center;
        gap: 14px;
        flex-wrap: nowrap;       /* 줄바꿈 금지 → 같은 dept는 무조건 한 줄 */
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

    .empty-text {
        font-size: 13px;
        color: #9ca3af;
        margin-top: 12px;
        text-align: center;
    }
</style>
</head>
<body>

<div class="tree-wrap">

    <!-- 상단: 제목 + 검색 폼 -->
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
                   value="<?= htmlspecialchars($rootAccountNo === $myAccountNo ? '' : $rootAccountNo, ENT_QUOTES) ?>">
            <button type="submit" class="search-btn">검색</button>
        </form>
    </div>

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

</div>

</body>
</html>
