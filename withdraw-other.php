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

  $had = curlPost(
    'https://api.thxdeal.com/api/point/balance.php',
        [ 'accountNo' => $_SESSION['user_No']]
    );

    if (!$had) {
        $errorMsg = '서버 통신 오류';
    } elseif (($had['resCode'] ?? -1) !== 0) {
        $errorMsg = $had['message'] ?? '요청 실패';
    }
    
  $availableBalance = $had['data']['data']['TP'] ?? 0;
?>
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

  <main class="page">
    <section class="apply-form">
      <form id="cardApplyForm" class="form" action="/withdraw-other-action.php" autocomplete="off" method="post">
        <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf, ENT_QUOTES) ?>">


        <div class="f-group is-disabled">
          <label class="f-label" for="withdrawable_view">출금가능한 금액</label>
          <input id="withdrawable_view" class="f-input" type="text" value="-" readonly style="font-size:20px">
          <!-- <div class="muted small" style="margin-top:8px;font-size: medium;">
            최소 출금 가능 금액은 <b>$10</b> 입니다. <br> 수수료는 <b>$1</b> 고정이며, <br>출금 시 <b>출금금액 + 수수료</b> 만큼 차감됩니다.
          </div> -->
        </div>

        <div class="f-group is-disabled">
          <label class="f-label required" for="amount">출금 금액</label>
          <input name="amount" id="amount" class="f-input" type="text" style="font-size:20px" placeholder="TP(=$)를 입력해주세요" inputmode="numeric" required>
        </div>


        <div class="muted small" style="margin-top:8px;font-size: medium;">
             최소 출금 가능 금액은 <b>$10</b> 입니다. <br> 수수료는 <b>$1</b> 고정이며, <br>출금 시 <b>출금금액 + 수수료</b> 만큼 차감됩니다.<br>(예: $10 출금 시 총 $11 필요)
          </div>
          
        <label style="display:flex;gap:10px;align-items:flex-start;margin-top:14px;">
          <input type="checkbox" id="agree" style="width:auto;margin-top:5px;">
          <span class="mini">출금에 동의합니다.</span>
        </label>

        <div id="msg" class="warn" style="display:none;color:red;margin:10px 0"></div>

        <button class="apply-submit" type="submit" disabled style="margin-top:10px">
          출금하기
        </button>
      </form>
    </section>
  </main>
</div>

<script>
  // 서버 보유 달러를 JS로 전달
  window.AVAILABLE_BALANCE = <?= (int)$availableBalance ?>; // 달러
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('cardApplyForm');
  if (!form) return;

  const submitBtn = form.querySelector('.apply-submit');
  const amountInput = document.getElementById('amount');
  const agreeChk    = document.getElementById('agree');
  const msgEl       = document.getElementById('msg');
  const withdrawableView = document.getElementById('withdrawable_view');

  // 고정 수수료 (달러)
  const FEE = 1;

  // 보유 달러 (서버에서 내려준 값)
  const AVAILABLE = Number(window.AVAILABLE_BALANCE ?? 0);

  // (선택) 최소 출금 금액 (달러)
  const MIN_AMOUNT = 10;

  function onlyDigits(v){
    return (v || '').toString().replace(/[^\d]/g, '');
  }

  function formatWithComma(digits){
    if (!digits) return '';
    const n = Number(digits);
    if (!Number.isFinite(n)) return digits;
    return n.toLocaleString('ko-KR');
  }

  function money(n){
    const num = Number(n || 0);
    if (!Number.isFinite(num)) return '0';
    return num.toLocaleString('ko-KR');
  }

  function setMsg(text){
    if (!msgEl) return;
    if (!text){
      msgEl.style.display = 'none';
      msgEl.textContent = '';
      return;
    }
    msgEl.style.display = 'block';
    msgEl.textContent = text;
  }

  function getAmountValue(){
    const digits = onlyDigits(amountInput?.value);
    if (!digits) return 0;
    return parseInt(digits, 10) || 0;
  }

  function updateWithdrawable(){
    // 출금가능한 금액 = 보유달러 - 수수료 (단, 음수면 0)
    const withdrawable = Math.max(0, AVAILABLE - FEE);
    if (withdrawableView){
      withdrawableView.value = `$ ${money(withdrawable)}`;
    }
    return withdrawable;
  }

  function toggleSubmit(){
    setMsg('');

    const amount = getAmountValue();     // 사용자가 입력한 출금 달러
    const agreed = !!agreeChk?.checked;

    const amountOk = amount > 0;
    const minOk    = amountOk && (amount >= MIN_AMOUNT);

    const withdrawable = updateWithdrawable();
    const withinWithdrawable = amountOk && (amount <= withdrawable);

    // 총 필요액 = 출금금액 + 수수료(1달러)
    const totalNeed = amountOk ? (amount + FEE) : 0;

    let ok = amountOk && minOk && withinWithdrawable && agreed;

    if (amountOk && !minOk){
      setMsg(`최소 출금 금액은 ${money(MIN_AMOUNT)}$ 입니다.`);
      ok = false;
    } else if (amountOk && !withinWithdrawable){
      // 잔액 기준으로는 (AVAILABLE >= amount + FEE)와 동일하지만,
      // 사용자에게 "출금가능한 금액" 기준으로 안내
      setMsg(`출금가능한 금액은 ${money(withdrawable)}$ 입니다. (수수료 ${FEE}$ 제외)`);
      ok = false;
    } else if (!agreed && amountOk){
      setMsg('동의 체크 후 진행해주세요.');
      ok = false;
    }

    if (submitBtn) submitBtn.disabled = !ok;
  }

  // 금액 입력: 숫자만 + 콤마
  if (amountInput){
    amountInput.addEventListener('input', () => {
      const digits = onlyDigits(amountInput.value);

      const prevLen = amountInput.value.length;
      const prevPos = amountInput.selectionStart || prevLen;

      const formatted = formatWithComma(digits);
      amountInput.value = formatted;

      const newLen = formatted.length;
      const diff = newLen - prevLen;
      const newPos = Math.max(0, prevPos + diff);
      try { amountInput.setSelectionRange(newPos, newPos); } catch(e){}

      toggleSubmit();
    });

    amountInput.addEventListener('paste', () => {
      setTimeout(() => {
        const digits = onlyDigits(amountInput.value);
        amountInput.value = formatWithComma(digits);
        toggleSubmit();
      }, 0);
    });
  }

  if (agreeChk){
    agreeChk.addEventListener('change', toggleSubmit);
  }

  form.addEventListener('submit', (e) => {
    toggleSubmit();
    if (submitBtn && submitBtn.disabled){
      e.preventDefault();
    }
  });

  // 초기 렌더
  updateWithdrawable();
  toggleSubmit();
});
</script>

</body>
</html>
