<?php $pageTitle = "후원인계보"; ?>
<?php
session_start();

// 예: 로그인한 회원 accountNo (이메일 같은 값)
$memberNo = $_SESSION['user_No'] ?? null;

if ($memberNo === null) {
    die('로그인 정보가 없습니다.');
}

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

// 1) API 호출
$response = curl_exec($ch);

if ($response === false) {
    $error = curl_error($ch);
    curl_close($ch);
    die('API 호출 실패: ' . $error);
}
curl_close($ch);

// 2) JSON → 배열
$data = json_decode($response, true);

if (!is_array($data) || ($data['resCode'] ?? -1) !== 0 || empty($data['data'])) {
    // 필요하면 var_dump($response) 찍어보기
    die('API 응답 오류');
}

$root = $data['data'];

// 3) 트리 → 일렬 배열로 만들기 (위에서 아래로)
//    + 3대까지만 보고 싶으면 $maxDepth = 3 으로 제한
$nodes = [];

function flattenTree(array $node, int $depth, array &$list, int $maxDepth = 3) {
    if ($depth > $maxDepth) {
        return;
    }

    $list[] = [
        'userId'    => $node['userId']    ?? null,
        'name'      => $node['name']      ?? '',
        'accountNo' => $node['accountNo'] ?? '',
        'dept'      => $node['dept']      ?? null,
        'deptNo'    => $node['deptNo']    ?? null,
        'depth'     => $depth,
    ];

    if (!empty($node['children']) && is_array($node['children'])) {
        foreach ($node['children'] as $child) {
            flattenTree($child, $depth + 1, $list, $maxDepth);
        }
    }
}

// 루트부터 depth 1로 시작
flattenTree($root, 1, $nodes, 3);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<?php include __DIR__ . "/head.php"; ?>
<style>
    body {
        margin: 0;
        padding: 16px;
        background: #f7f7f9;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .timeline-wrap {
        max-width: 600px;
        margin: 0 auto;
        position: relative;
        padding: 20px 0;
    }

    /* 가운데 세로선 */
    .timeline-wrap::before {
        content: "";
        position: absolute;
        top: 0;
        bottom: 0;
        left: 50%;
        width: 2px;
        background: #e5e7eb;
        transform: translateX(-50%);
    }

    .timeline-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .timeline-node {
        position: relative;
        width: 100%;
        margin: 18px 0;
    }

    .timeline-card {
        max-width: 46%;
        background: #fff;
        border-radius: 12px;
        padding: 12px 14px;
        box-shadow: 0 2px 10px rgba(15,23,42,0.08);
        font-size: 14px;
    }

    /* 왼쪽 카드 */
    .timeline-node.left .timeline-card {
        margin-right: auto;
        margin-left: 0;
    }

    /* 오른쪽 카드 */
    .timeline-node.right .timeline-card {
        margin-left: auto;
        margin-right: 0;
    }

    /* 가운데선 ↔ 카드 연결선 */
    .timeline-node::before {
        content: "";
        position: absolute;
        top: 18px;
        width: 20px;
        border-top: 2px solid #e5e7eb;
    }

    .timeline-node.left::before {
        right: 50%;
        margin-right: 2px;
    }

    .timeline-node.right::before {
        left: 50%;
        margin-left: 2px;
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

    /* depth(세대)에 따라 색 주고 싶으면 */
    .depth-1 .timeline-card { border-left: 3px solid #6366f1; }
    .depth-2 .timeline-card { border-left: 3px solid #22c55e; }
    .depth-3 .timeline-card { border-left: 3px solid #f97316; }
</style>
</head>
<body>

<div class="timeline-wrap">
    <?php if (empty($nodes)): ?>
        <p>표시할 추천인 계보가 없습니다.</p>
    <?php else: ?>
        <ul class="timeline-list">
            <?php foreach ($nodes as $idx => $n): 
                // 0번째부터 왼쪽/오른쪽/왼쪽/오른쪽 ...
                $side = ($idx % 2 === 0) ? 'left' : 'right';
            ?>
                <li class="timeline-node <?= $side ?> depth-<?= (int)$n['depth'] ?>">
                    <div class="timeline-card">
                        <div class="node-name">
                            <?= htmlspecialchars($n['name'], ENT_QUOTES) ?>
                        </div>
                        <div class="node-meta">
                            ID: <?= (int)$n['userId'] ?> · LV <?= (int)$n['dept'] ?> / NO <?= (int)$n['deptNo'] ?>
                        </div>
                        <div class="node-account">
                            <?= htmlspecialchars($n['accountNo'], ENT_QUOTES) ?>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

</body>
</html>
