<?php $pageTitle = "출금 완료"; ?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <?php include __DIR__ . "/auth.php"; ?>
  <?php include __DIR__ . "/head.php"; ?>
  <style>
    .complete-wrap{padding:18px 0 28px}
    .complete-card{background:#fff;border-radius:18px;padding:18px 16px;box-shadow:0 6px 20px rgba(0,0,0,.06)}
    .complete-icon{width:64px;height:64px;border-radius:999px;background:rgba(255,122,61,.12);display:flex;align-items:center;justify-content:center;margin:6px auto 14px}
    .badge{display:inline-flex;align-items:center;padding:6px 10px;border-radius:999px;background:rgba(255,122,61,.10);color:#ff7a3d;font-size:12px;font-weight:900;margin:0 auto 12px}
    .complete-title{text-align:center;font-size:20px;font-weight:900;margin:0 0 6px}
    .complete-desc{text-align:center;color:#6b7280;font-weight:800;font-size:14px;line-height:1.5;margin:0 0 18px}
    .divider{height:1px;background:#edf1f5;margin:14px 0}
    .kv{display:flex;justify-content:space-between;gap:12px;padding:10px 2px;font-size:15px;font-weight:800}
    .kv .k{color:#6b7280}
    .kv .v{color:#111827;font-weight:900;text-align:right}
    .btn-row{display:flex;flex-direction:column;gap:10px;margin-top:16px}
    .btn-sub{display:block;text-align:center;padding:14px 14px;border-radius:999px;border:2px solid rgba(255,122,61,.40);color:#ff7a3d;font-weight:900;text-decoration:none;background:#fff}
  </style>
</head>
<?php
$toId   = trim($_GET['accountNo'] ?? '');
$amount = (int)preg_replace('/\D+/', '', (string)($_GET['amount'] ?? '0'));
$bal    = (int)preg_replace('/\D+/', '', (string)($_GET['bal'] ?? '0'));
$msg    = trim($_GET['msg'] ?? '성공');
$when   = date('Y-m-d H:i');
?>
<body>
<div class="app">
  <header class="appbar-apply">
    <nav class="appbar__inner container--narrow" aria-label="상단 내비게이션">
      <a href="./mypage.php" class="nav-btn" aria-label="뒤로가기">
        <img src="/assets/icons/btn-next-arrow-left-dg.svg" width="24" height="24" alt="">
      </a>
      <h1 class="appbar__title">출금</h1>
      <a href="/index.php" class="nav-btn home-btn" aria-label="홈"></a>
    </nav>
  </header>

  <main class="page">
    <section class="apply-form">
      <div class="complete-wrap container--narrow">
        <div class="complete-card">
          <div class="complete-icon" aria-hidden="true">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="none">
              <path d="M20 6L9 17l-5-5" stroke="#ff7a3d" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>

          <div class="badge">출금 완료</div>

          <h2 class="complete-title">출금이 완료되었습니다</h2>
          <div class="divider"></div>

          <div class="kv">
            <div class="k">출금 금액</div>
            <div class="v"><?= $amount ? number_format($amount)."원" : "-" ?></div>
          </div>
          <div class="kv">
            <div class="k">출금 후 잔액</div>
            <div class="v"><?= number_format($bal)."원" ?></div>
          </div>
          <div class="kv">
            <div class="k">처리 일시</div>
            <div class="v"><?= htmlspecialchars($when, ENT_QUOTES) ?></div>
          </div>

          <div class="btn-row">
            <a class="btn-sub" href="/withdraw-other.php">추가 출금하기</a>
            <a class="btn-sub" href="/point-history.php?type=TP">출금/포인트 내역 보기</a>
            <button class="apply-submit" type="button" onclick="location.href='/mypage.php'">마이페이지로</button>
          </div>
        </div>
      </div>
    </section>
  </main>
</div>
</body>
</html>
