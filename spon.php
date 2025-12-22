<?php
session_start();

// 1) 로그인한 회원 계정(트리 기준이 되는 계정)
$memberNo = $_SESSION['user_No'] ?? null; // 예: "kni1993@naver.com"
if ($memberNo === null) {
    die('로그인 정보가 없습니다.');
}

// 2) API 호출 (testMemberSpon.php)
$postFields = [
    'accountNo' => $memberNo,
];

$ch = curl_init('https://api.thxdeal.com/api/member/testMemberSpon.php');
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $postFields,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false, // 필요하면 true로 변경
]);

$response = curl_exec($ch);

if ($response === false) {
    $error = curl_error($ch);
    curl_close($ch);
    die('API 호출 실패: ' . $error);
}
curl_close($ch);

// 3) JSON → 배열
$data = json_decode($response, true);
if (!is_array($data) || ($data['resCode'] ?? -1) !== 0 || empty($data['data'])) {
    // var_dump($response); // 디버그용
    die('API 응답 오류');
}

$root = $data['data']; // 루트 노드(1대)

// 4) 재귀로 트리 HTML 만들기
function renderNode(array $node)
{
    // 노드 정보
    $name      = htmlspecialchars($node['name']      ?? '', ENT_QUOTES);
    $accountNo = htmlspecialchars($node['accountNo'] ?? '', ENT_QUOTES);
    $userId    = (int)($node['userId'] ?? 0);
    $dept      = isset($node['dept'])   ? (int)$node['dept']   : null;
    $deptNo    = isset($node['deptNo']) ? (int)$node['deptNo'] : null;

    echo '<li>';
    echo '  <div class="node-card">';
    echo '      <div class="node-name">' . $name . '</div>';
    echo '      <div class="node-meta">ID: ' . $userId;
    if (!is_null($dept))   echo ' · LV ' . $dept;
    if (!is_null($deptNo)) echo ' · NO ' . $deptNo;
    echo '      </div>';
    echo '      <div class="node-account">' . $accountNo . '</div>';
    echo '  </div>';

    // 자식이 있으면 하위 <ul>로 재귀 출력
    if (!empty($node['children']) && is_array($node['children'])) {
        echo '<ul>';
        foreach ($node['children'] as $child) {
            renderNode($child);
        }
        echo '</ul>';
    }

    echo '</li>';
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

        .tree-container {
            max-width: 900px;
            margin: 0 auto;
            overflow-x: auto; /* 가로로 넓어질 때 스크롤 */
            padding-bottom: 24px;
        }

        .tree-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        /* 기본 트리 구조 */
        .tree {
            position: relative;
            display: inline-block;     /* 내용만큼만 */
            padding-top: 20px;
        }

        .tree ul {
            padding-top: 20px;
            position: relative;
            transition: all .5s;
            list-style: none;
            padding-left: 0;
            text-align: center;
        }

        .tree li {
            display: inline-block;
            vertical-align: top;
            text-align: center;
            position: relative;
            padding: 20px 5px 0 5px;
        }

        /* 부모-자식 연결 가로선/세로선 */
        .tree li::before,
        .tree li::after {
            content: '';
            position: absolute;
            top: 0;
            border-top: 1px solid #d1d5db;
            width: 50%;
            height: 20px;
        }

        .tree li::before {
            right: 50%;
        }

        .tree li::after {
            left: 50%;
            border-left: 1px solid #d1d5db;
        }

        /* 부모가 자식 하나만 가지는 경우 선 조정 */
        .tree li:only-child::before,
        .tree li:only-child::after {
            display: none;
        }

        .tree li:only-child {
            padding-top: 0;
        }

        /* 첫째 자식 */
        .tree li:first-child::before {
            border: 0;
        }

        /* 마지막 자식 */
        .tree li:last-child::after {
            border: 0;
        }

        /* 자식들의 위쪽 세로선 */
        .tree ul ul::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            border-left: 1px solid #d1d5db;
            width: 0;
            height: 20px;
        }

        /* 노드 카드 스타일 */
        .node-card {
            display: inline-block;
            background: #ffffff;
            border-radius: 12px;
            padding: 10px 14px;
            min-width: 140px;
            max-width: 180px;
            text-align: left;
            box-shadow: 0 2px 10px rgba(15,23,42,0.08);
            border-top: 3px solid #f97316; /* 살짝 포인트 */
            font-size: 13px;
        }

        .node-name {
            font-size: 14px;
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
    </style>
</head>
<body>

<div class="tree-container">
    <div class="tree-title">추천인 계보</div>

    <div class="tree">
        <ul>
            <?php renderNode($root); ?>
        </ul>
    </div>
</div>

</body>
</html>
