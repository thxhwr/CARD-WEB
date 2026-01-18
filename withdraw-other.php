<?php $pageTitle = "출금"; ?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include __DIR__ . "/auth.php"; ?>
    <?php include __DIR__ . "/head.php"; ?>
</head>
<?php
  $csrf = bin2hex(random_bytes(32));
  $_SESSION['csrf_withdraw_other'] = $csrf;

  $availableBalance = null; // 예: 150000;
?>
<style>
  .wrap{max-width:520px;margin:24px auto;padding:16px}
  .card{background:#fff;border-radius:14px;padding:18px;box-shadow:0 6px 20px rgba(0,0,0,.06)}
  h1{font-size:18px;margin:0 0 14px}
  label{display:block;font-size:13px;font-weight:700;margin:12px 0 6px}
  input,select{width:100%;padding:12px;border:1px solid #e5e7eb;border-radius:12px;font-size:14px;box-sizing:border-box}
  .row{display:flex;gap:10px}
  .row > *{flex:1}
  .hint{font-size:12px;color:#6b7280;margin-top:6px;line-height:1.4}
  .warn{font-size:12px;color:#b91c1c;margin-top:6px;line-height:1.4}
  .btn{width:100%;margin-top:16px;padding:12px 14px;border:0;border-radius:12px;font-weight:800;font-size:15px;cursor:pointer}
  .btn:disabled{opacity:.5;cursor:not-allowed}
  .btn-primary{background:#111827;color:#fff}
  .hr{height:1px;background:#eef2f7;margin:14px 0}
  .badge{display:inline-block;padding:4px 10px;border-radius:999px;background:#eef2ff;color:#3730a3;font-size:12px;font-weight:700}
  .mini{font-size:12px;color:#374151}
  .right{display:flex;justify-content:space-between;align-items:center;gap:10px}
</style>
<body>
<div class="app">
    <header class="appbar-apply">
        <nav class="appbar__inner container--narrow" aria-label="상단 내비게이션">
            <a href="./mypage.php" class="nav-btn" aria-label="뒤로가기">
                <img src="/assets/icons/btn-next-arrow-left-dg.svg" width="24px" height="24px">
            </a>
            <h1 class="appbar__title">출금</h1>
            <a href="/index.php" class="nav-btn home-btn" aria-label="홈"></a>
        </nav>
    </header>
    <div class="card">
      <div class="right">
        <h1>출금</h1>
        <?php if ($availableBalance !== null): ?>
          <span class="badge">출금 가능 <?= number_format((int)$availableBalance) ?>원</span>
        <?php endif; ?>
      </div>
      <form id="withdrawForm" method="post" action="/withdraw-other-action.php" autocomplete="off">
        <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf, ENT_QUOTES) ?>">

        <label>받는 아이디</label>
        <input type="text" name="holder_name" id="holder_name" placeholder="입금 받을 아이디" maxlength="30" required>

        <label>출금 금액(원)</label>
        <input type="text" name="amount" id="amount" placeholder="예: 50,000" inputmode="numeric" required>
        <div class="hint">금액은 숫자만 입력 가능. 수수료/최소출금 정책이 있다면 서버에서 최종 검증합니다.</div>
        <label style="display:flex;gap:10px;align-items:flex-start;margin-top:14px;">
          <input type="checkbox" id="agree" style="width:auto;margin-top:2px;">
          <span class="mini">
            본인은 해당 아이디로 출금 신청할 권한이 있으며, 잘못된 아이디 입력으로 발생한 책임은 본인에게 있습니다.
          </span>
        </label>

        <div id="msg" class="warn" style="display:none;"></div>

        <button type="submit" class="btn btn-primary" id="submitBtn" disabled>출금 신청</button>
      </form>
    </div>
  </div>
</div>
<script>
(function(){
  const form = document.getElementById('withdrawForm');
  const submitBtn = document.getElementById('submitBtn');
  const agree = document.getElementById('agree');
  const msg = document.getElementById('msg');

  const holder = document.getElementById('holder_name');
  const bank = document.getElementById('bank_code');
  const acct = document.getElementById('account_no');
  const amount = document.getElementById('amount');

  function setMsg(text){
    if(!text){
      msg.style.display = 'none';
      msg.textContent = '';
      return;
    }
    msg.style.display = 'block';
    msg.textContent = text;
  }

  function onlyDigits(v){ return (v || '').replace(/[^\d]/g,''); }

  acct.addEventListener('input', () => {
    acct.value = onlyDigits(acct.value);
    toggle();
  });

  amount.addEventListener('input', () => {
    const digits = onlyDigits(amount.value);
    amount.value = digits ? Number(digits).toLocaleString('ko-KR') : '';
    toggle();
  });

  [holder, bank, agree].forEach(el => el.addEventListener('input', toggle));
  agree.addEventListener('change', toggle);

  function toggle(){
    setMsg('');

    const holderOk = holder.value.trim().length >= 2;
    const bankOk   = bank.value.trim() !== '';
    const acctOk   = onlyDigits(acct.value).length >= 8; // 너무 짧으면 막기
    const amtDigits = onlyDigits(amount.value);
    const amt = amtDigits ? parseInt(amtDigits, 10) : 0;

    if (amtDigits && amt <= 0) setMsg('출금 금액을 확인해주세요.');
    const ok = holderOk && bankOk && acctOk && (amt > 0) && agree.checked;

    submitBtn.disabled = !ok;
  }

  // 초기
  toggle();

  form.addEventListener('submit', (e) => {
    if(submitBtn.disabled){
      e.preventDefault();
      setMsg('필수 항목을 입력하고 동의 체크 후 진행해주세요.');
    }
  });
})();
</script>
</body>
</html>
