<?php
session_start();

// 1) 로그인한 회원 계정(추천 계보 기준이 되는 사람)
$memberNo = $_SESSION['user_No'] ?? null; // 예: "kni1993@naver.com"

if ($memberNo === null) {
    die('로그인 정보가 없습니다.');
}

// 2) API 호출 준비
$postFields = [
    'accountNo' => $memberNo,
];

$ch = curl_init('https://api.thxdeal.com/api/member/testMemberSpon.php');
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $postFields,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false, // 필요시 true로 변경
]);

$response = curl_exec($ch);
print_r($response);
if ($response === false) {
    $error = curl_error($ch);
    curl_close($ch);
    die('API 호출 실패: ' . $error);
}
curl_close($ch);

// 3) JSON → 배열
$data = json_decode($response, true);

if (!is_array($data) || ($data['resCode'] ?? -1) !== 0 || empty($data['data'])) {
    // var_dump($response);
    die('API 응답 오류');
}

$root = $data['data']; // 트리의 루트 노드

// 4) 트리를 depth(깊이)별로 나누기
// $levels[1] = [ depth 1 노드들 배열 ]
// $levels[2] = [ depth 2 노드들 배열 ]
// ...
$levels = [];

function buildLevels(array $node, int $depth, array &$levels)
{
    // 현재 depth 레벨에 추가
    if (!isset($levels[$depth])) {
        $levels[$depth] = [];
    }

    $levels[$depth][] = [
        'userId'    => $node['userId']    ?? null,
        'name'      => $node['name']      ?? '',
        'accountNo' => $node['accountNo'] ?? '',
        'dept'      => $node['dept']      ?? null,
        'deptNo'    => $node['deptNo']    ?? null,
    ];

    // 자식들 처리
    if (!empty($node['children']) && is_array($node['children'])) {
        foreach ($node['children'] as $child) {
            buildLevels($child, $depth + 1, $levels);
        }
    }
}

// 루트는 depth 1부터 시작
buildLevels($root, 1, $levels);

// depth 순서대로 정렬(혹시라도 키가 꼬일 경우 대비)
ksort($levels);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include __DIR__ . "/head.php"; ?>
    <style>

        .tree-wrap {
            max-width: 640px;
            margin: 0 auto;
        }

        .tree-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .tree-level {
            text-align: center;
            margin: 20px 0 28px;
        }

        .tree-row {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 14px;
        }

        .tree-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 10px 14px;
            box-shadow: 0 2px 10px rgba(15,23,42,0.08);
            min-width: 120px;
            max-width: 180px;
            text-align: left;
            font-size: 13px;
        }

        .tree-name {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .tree-meta {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 2px;
        }

        .tree-account {
            font-size: 12px;
            color: #4b5563;
            word-break: break-all;
        }

        /* depth 별로 약간씩 느낌만 다르게 (선택사항) */
        .depth-1 .tree-card { border-top: 3px solid #6366f1; }
        .depth-2 .tree-card { border-top: 3px solid #22c55e; }
        .depth-3 .tree-card { border-top: 3px solid #f97316; }
        .depth-4 .tree-card { border-top: 3px solid #ec4899; }
        /* 5대 이상도 자동으로 그냥 카드로만 나옴 */
    </style>
</head>
<body>

<div class="tree-wrap">
    <div class="tree-title">후원 계보</div>

    <?php if (empty($levels)): ?>
        <p>표시할 후원 계보가 없습니다.</p>
    <?php else: ?>
        <?php foreach ($levels as $depth => $nodes): ?>
            <div class="tree-level depth-<?= (int)$depth ?>">
                <div class="tree-row">
                    <?php foreach ($nodes as $n): ?>
                        <div class="tree-card">
                            <div class="tree-name">
                                <?= htmlspecialchars($n['name'], ENT_QUOTES) ?>
                            </div>
                            <!-- <div class="tree-meta">
                                ID: <?= (int)$n['userId'] ?>
                                <?php if (!is_null($n['dept'])): ?>
                                    · LV <?= (int)$n['dept'] ?>
                                <?php endif; ?>
                                <?php if (!is_null($n['deptNo'])): ?>
                                    · NO <?= (int)$n['deptNo'] ?>
                                <?php endif; ?>
                            </div> -->
                            <div class="tree-account">
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
