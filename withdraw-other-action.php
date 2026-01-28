<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

/**
 * 화면 렌더 함수들
 */
function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

function render_page($title, $bodyHtml){
  // 프로젝트 공통 head를 쓰고 싶으면 유지(없으면 주석 처리)
  $pageTitle = $title;
  ?>
  <!doctype html>
  <html lang="ko">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
      // 공통 스타일/메타 쓰는 경우
      if (file_exists(__DIR__ . "/head.php")) {
        include __DIR__ . "/head.php";
      }
    ?>
    <style>
      /* head.php가 있어도 안전하게 보조 스타일 */
      body{ background:#f6f7fb; }
      .result-wrap{ padding:18px 14px; }
      .result-card{
        background:#fff;
        border-radius:16px;
        padding:18px 16px;
        box-shadow:0 8px 24px rgba(0,0,0,.06);
        max-width:520px;
        margin:0 auto;
      }
      .result-title{ font-size:18px; font-weight:800; margin:0 0 10px; }
      .result-sub{ color:#6b7280; font-size:13px; margin:0 0 14px; line-height:1.45; }
      .result-list{ margin:0; padding-left:18px; }
      .result-list li{ margin:6px 0; line-height:1.45; }
      .btns{ display:flex; gap:10px; margin-top:14px; }
      .btn{
        display:inline-flex; align-items:center; justify-content:center;
        height:44px; padding:0 14px; border-radius:12px; border:1px solid #e5e7eb;
        background:#fff; text-decoration:none; font-weight:700; font-size:14px; color:#111827;
        width:100%;
      }
      .btn.primary{ background:#f0580f; color:#fff; }
      details{ margin-top:12px; }
      details summary{ cursor:pointer; font-weight:700; }
      pre{
        background:#0b1020; color:#dbeafe;
        padding:12px; border-radius:12px; overflow:auto; max-height:280px;
        margin-top:10px; font-size:12px;
      }
    </style>
  </head>
  <body>
    <div class="app">
      <header class="appbar-apply">
        <nav class="appbar__inner container--narrow" aria-label="상단 내비게이션">
          <a href="/withdraw-other.php" class="nav-btn" aria-label="뒤로가기">
            <img src="/assets/icons/btn-next-arrow-left-dg.svg" width="24" height="24" alt="">
          </a>
          <h1 class="appbar__title"><?= h($title) ?></h1>
          <a href="/index.php" class="nav-btn home-btn" aria-label="홈"></a>
        </nav>
      </header>

      <main class="page result-wrap">
        <section class="result-card">
          <?= $bodyHtml ?>
        </section>
      </main>
    </div>
  </body>
  </html>
  <?php
}

function fail_page(array $errors, $backUrl = '/withdraw-other.php', $raw = null){
  ob_start(); ?>
    <h2 class="result-title">출금 신청 실패</h2>
    <p class="result-sub">요청이 처리되지 않았습니다. 아래 내용을 확인한 뒤 다시 시도해 주세요.</p>

    <?php if ($errors): ?>
      <ul class="result-list">
        <?php foreach ($errors as $e): ?>
          <li><?= h($e) ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <div class="btns">
      <a class="btn" href="<?= h($backUrl) ?>">뒤로가기</a>
      <a class="btn primary" href="<?= h($backUrl) ?>">다시 시도</a>
    </div>

    <?php if ($raw !== null): ?>
      <details>
        <summary>응답 상세 보기</summary>
        <pre><?= h($raw) ?></pre>
      </details>
    <?php endif; ?>
  <?php
  $body = ob_get_clean();
  render_page('출금', $body);
  exit;
}

if (empty($_SESSION['user_No']) || empty($_SESSION['user_Id'])) {
  // go_error('login')가 프로젝트에 있으면 쓰고, 없으면 안전하게 이동
  if (function_exists('go_error')) go_error('login');
  header("Location: /auth/login.php");
  exit;
}

$csrf = $_POST['csrf'] ?? '';
if (empty($_SESSION['csrf_withdraw_other']) || !hash_equals($_SESSION['csrf_withdraw_other'], $csrf)) {
  http_response_code(400);
  fail_page(['요청이 올바르지 않습니다. (CSRF)'], '/withdraw-other.php');
}
unset($_SESSION['csrf_withdraw_other']);

function only_digits($v){ return preg_replace('/\D+/', '', (string)$v); }

$amount = only_digits($_POST['amount'] ?? '');

$errors = [];
if ($amount === '' || (int)$amount <= 0) $errors[] = '출금 금액을 확인해주세요.';

$minAmount = 10; // 최소 출금(달러 기준이면 10$)
if ((int)$amount > 0 && (int)$amount < $minAmount) $errors[] = "최소 출금 금액은 {$minAmount}$ 입니다.";


if ($errors) {
  http_response_code(400);
  fail_page($errors, '/withdraw-other.php');
}

$postFields = [
  'accountId' => $_SESSION['user_Id'],
  'accountNo' => $_SESSION['user_No'],
  'amount'    => $amount,
];

$ch = curl_init('https://api.thxdeal.com/api/member/memberWithdraw.php');
curl_setopt_array($ch, [
  CURLOPT_POST           => true,
  CURLOPT_POSTFIELDS     => $postFields,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_TIMEOUT        => 15,
]);

$response = curl_exec($ch);

$err = curl_error($ch);
$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($response === false) {
  http_response_code(500);
  fail_page(['서버 통신 오류가 발생했습니다. 잠시 후 다시 시도해주세요.'], '/withdraw-other.php', $err);
}


$data = json_decode($response, true);
if (!is_array($data)) {
  http_response_code(502);
  fail_page(['처리 결과를 확인할 수 없습니다. (응답 형식 오류)'], '/withdraw-other.php', $response);
}

$resCode = $data['resCode'] ?? null;
$resMsg  = $data['message'] ?? '처리 결과를 확인할 수 없습니다.';

if ((string)$resCode === '0') {
  $withdrawAmount = (int)($data['data']['withdrawAmount'] ?? (int)$amount);
  $remainBalance  = (int)($data['data']['remainBalance'] ?? 0);

  $q = http_build_query([
    'accountNo' => $_SESSION['user_No'],
    'amount'    => $withdrawAmount,
    'bal'       => $remainBalance,
    'msg'       => $resMsg,
  ]);

  header("Location: /withdraw-complete.php?$q");
  exit;
}

http_response_code(400);
fail_page([
  $resMsg ?: '출금 신청이 거절되었습니다. 정보를 확인 후 다시 시도해주세요.',
], '/withdraw-other.php', $response);
