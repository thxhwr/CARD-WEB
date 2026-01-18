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
                  <label class="f-label required" for="name">입금 받을 아이디</label>
                  <input name="holder_name" id="holder_name" class="f-input" type="text" placeholder="아이디를 입력해주세요" required>
              </div>
              <div class="f-group is-disabled">
                  <label class="f-label required" for="name">입금 하실 금액</label>
                  <input name="amount" id="amount" class="f-input" type="text" placeholder="금액을 입력해주세요" placeholder="예: 50000" inputmode="numeric" required>
                  <div id="nameMsg" class="muted small" style="margin-top:8px;">금액은 숫자만 입력 가능. 수수료/최소출금 정책이 있다면 서버에서 최종 검증합니다.</div>
              </div>
               <label style="display:flex;gap:10px;align-items:flex-start;margin-top:14px;">
                <input type="checkbox" id="agree" style="width:auto;margin-top:2px;">
                <span class="mini">
                  본인은 해당 아이디로 출금 신청할 권한이 있으며, 잘못된 아이디 입력으로 발생한 책임은 본인에게 있습니다.
                </span>
              </label>
              <div id="msg" class="warn" style="display:none;"></div>
              <button class="apply-submit" type="submit"disabled >
                출금하기
              </button>
          </form>
      </section>
    </main>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('cardApplyForm');
  if (!form) return;

  const submitBtn = form.querySelector('.apply-submit');

  const holderInput = document.getElementById('holder_name'); // 입금 받을 아이디
  const amountInput = document.getElementById('amount');      // 금액
  const agreeChk    = document.getElementById('agree');
  const msgEl       = document.getElementById('msg');

  // (선택) 최소 출금 금액 정책이 있으면 숫자로 넣어두면 됨
  const MIN_AMOUNT = 1000;

  function onlyDigits(v){
    return (v || '').toString().replace(/[^\d]/g, '');
  }

  function formatWithComma(digits){
    if (!digits) return '';
    // 너무 큰 숫자 방지 (선택)
    const n = Number(digits);
    if (!Number.isFinite(n)) return digits;
    return n.toLocaleString('ko-KR');
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
    // parseInt 안전 처리
    return parseInt(digits, 10) || 0;
  }

  function toggleSubmit(){
    setMsg('');

    const holder = (holderInput?.value || '').trim();
    const amount = getAmountValue();
    const agreed = !!agreeChk?.checked;

    const holderOk = holder.length >= 2; // 아이디 최소 길이(원하면 1로 낮춰도 됨)
    const amountOk = amount > 0;
    const minOk    = amount === 0 ? false : (amount >= MIN_AMOUNT);

    let ok = holderOk && amountOk && minOk && agreed;

    // 안내 메시지
    if (!holderOk && holder.length > 0) {
      setMsg('아이디를 확인해주세요.');
      ok = false;
    } else if (amountOk && !minOk) {
      setMsg(`최소 출금 금액은 ${MIN_AMOUNT.toLocaleString('ko-KR')}원입니다.`);
      ok = false;
    } else if (!agreed && (holderOk && amountOk)) {
      // 동의만 안 했을 때는 굳이 빨간 메시지 싫으면 이 라인은 지워도 됨
      setMsg('동의 체크 후 진행해주세요.');
      ok = false;
    }

    if (submitBtn){
      submitBtn.disabled = !ok;
    }
  }

  // 금액 입력: 숫자만 + 콤마
  if (amountInput){
    amountInput.addEventListener('input', () => {
      const digits = onlyDigits(amountInput.value);

      // 커서 튐 최소화: 콤마 넣기 전/후 길이 차이로 보정
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

    // 붙여넣기/드래그 대응
    amountInput.addEventListener('paste', () => {
      setTimeout(() => {
        const digits = onlyDigits(amountInput.value);
        amountInput.value = formatWithComma(digits);
        toggleSubmit();
      }, 0);
    });
  }

  // 아이디 입력 체크
  if (holderInput){
    holderInput.addEventListener('input', toggleSubmit);
    holderInput.addEventListener('blur', toggleSubmit);
  }

  // 동의 체크
  if (agreeChk){
    agreeChk.addEventListener('change', toggleSubmit);
  }

  // 제출 시 최종 검증(프론트 우회 방지용 UX)
  form.addEventListener('submit', (e) => {
    toggleSubmit();
    if (submitBtn && submitBtn.disabled){
      e.preventDefault();
      // msg는 toggleSubmit에서 설정됨
    }
  });

  // 초기 상태
  toggleSubmit();
});
</script>

</body>
</html>
