<?php $pageTitle = "후원인계보"; ?>
<?php
session_start();

// 예: 로그인한 회원 번호
$memberNo = $_SESSION['user_Id'] ?? null;

$postFields = [
  'userId' => $memberNo,
];
print_r($postFields);
// API URL (경로는 네 프로젝트 구조에 맞게 수정)
$ch = curl_init('https://api.thxdeal.com/api/member/testMemberSpon.php');
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $postFields,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
]);
// 1) API 호출
$response = curl_exec($ch);

print_r($response);

if ($response === false) {
    // 실패 시 빈 배열로
    $level1 = $level2 = $level3 = [];
} else {
    // 2) JSON → 배열
    $data = json_decode($response, true);

    // ★ 여기서부터는 "실제 응답 구조"에 맞게 키만 맞춰주면 됨
    // 예시: { "level1":[...], "level2":[...], "level3":[...] }
    $level1 = $data['level1'] ?? [];
    $level2 = $data['level2'] ?? [];
    $level3 = $data['level3'] ?? [];

    // 만약 이렇게 생겼다면:
    // { "result":"ok", "data": { "lv1":[...], "lv2":[...], "lv3":[...] } }
    // $level1 = $data['data']['lv1'] ?? [];
    // $level2 = $data['data']['lv2'] ?? [];
    // $level3 = $data['data']['lv3'] ?? [];
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include __DIR__ . "/head.php"; ?>
<title>추천인 계보</title>

<style>
    body {
        margin: 0;
        padding: 16px;
        background: #f7f7f9;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .genealogy-wrap {
        max-width: 480px;
        margin: 0 auto;
    }

    .gene-title {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .gene-block {
        background: #fff;
        padding: 16px;
        border-radius: 14px;
        margin-bottom: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .gene-level {
        font-size: 14px;
        font-weight: 600;
        color: #e88a50;
        margin-bottom: 10px;
    }

    .gene-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .gene-list li {
        padding: 12px 14px;
        background: #fafafa;
        border-radius: 10px;
        margin-bottom: 8px;
        font-size: 15px;
        border: 1px solid #eee;
    }

    .gene-none {
        padding: 10px 0;
        color: #aaa;
        font-size: 14px;
    }
</style>
</head>
<body>

<div class="genealogy-wrap">
    
    <div class="gene-title">추천인 계보</div>

    <!-- 1대 -->
    <div class="gene-block">
        <div class="gene-level">1대 추천인</div>
        <ul class="gene-list">
            <!-- PHP로 반복 출력 -->
            <li>김철수</li>
            <li>박민수</li>
        </ul>
        <!-- 추천인이 없으면 -->
        <!-- <div class="gene-none">등록된 1대 추천인이 없습니다.</div> -->
    </div>

    <!-- 2대 -->
    <div class="gene-block">
        <div class="gene-level">2대 추천인</div>
        <ul class="gene-list">
            <li>이영희</li>
            <li>정소라</li>
        </ul>
        <!-- 없을 때:
        <div class="gene-none">등록된 2대 추천인이 없습니다.</div>
        -->
    </div>

    <!-- 3대 -->
    <div class="gene-block">
        <div class="gene-level">3대 추천인</div>
        <ul class="gene-list">
            <li>최하은</li>
        </ul>
        <!-- 없을 때:
        <div class="gene-none">등록된 3대 추천인이 없습니다.</div>
        -->
    </div>

</div>

</body>
</html>
