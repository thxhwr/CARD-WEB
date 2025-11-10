    <!doctype html>
<html lang="ko">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Loading…</title>
  <style>
    :root{
      --bg1:#0f1020; --bg2:#12192f; --fg:#ffffff; --muted:rgba(255,255,255,.7);
      --brand:#ff7a18; --brand2:#af2cff; --glass:rgba(255,255,255,.08);
    }
    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      margin:0; color:var(--fg); background: radial-gradient(1200px 600px at 10% 10%, #2b164e 0%, transparent 60%),
        radial-gradient(1000px 800px at 90% 90%, #34255a 0%, transparent 60%),
        linear-gradient(120deg, var(--bg1), var(--bg2));
      font:16px/1.5 system-ui, -apple-system, Segoe UI, Roboto, Pretendard, Noto Sans KR, Apple SD Gothic Neo, Arial, sans-serif;
      overflow:hidden;
    }
    @media (prefers-reduced-motion: no-preference){
      body{ animation: hue 20s linear infinite; }
      @keyframes hue{ from{ filter:hue-rotate(0deg)} to{ filter:hue-rotate(360deg)} }
    }

    .wrap{ position:relative; height:100%; display:grid; place-items:center; padding:24px; }

    .card{ width:min(90vw, 960px); display:grid; grid-template-columns: 1.1fr 1fr; gap:28px; align-items:center; }
    @media (max-width:840px){ .card{ grid-template-columns: 1fr; gap:18px; } }

    .panel{ background:var(--glass); backdrop-filter: blur(12px); border:1px solid rgba(255,255,255,.12); border-radius:24px; padding:24px; box-shadow: 0 10px 45px rgba(0,0,0,.35); }

    .brand{ display:flex; align-items:center; gap:10px; font-weight:800; letter-spacing:.3px; }
    .brand-dot{ width:10px; height:10px; border-radius:50%; background:conic-gradient(from 0deg, var(--brand), var(--brand2)); box-shadow:0 0 12px rgba(255,255,255,.55) inset, 0 0 12px rgba(255,255,255,.25); }

    .title{ margin:6px 0 2px; font-size:clamp(22px, 2.4vw, 28px); font-weight:800; }
    .subtitle{ margin:0 0 16px; color:var(--muted) }

    .progress{
      display:flex; align-items:center; gap:10px; margin:16px 0 8px;
    }
    .bar{ flex:1; height:10px; background:rgba(255,255,255,.12); border-radius:999px; overflow:hidden; position:relative; }
    .bar-fill{ height:100%; width:0%; background:linear-gradient(90deg, var(--brand), var(--brand2)); border-radius:inherit; box-shadow:0 0 20px rgba(255,255,255,.25);
    }
    .pct{ width:48px; text-align:right; font-variant-numeric: tabular-nums; color:var(--muted)}

    .tip{ margin-top:6px; color:var(--muted); display:flex; align-items:center; gap:8px; min-height:28px; }
    .tip-dot{ width:8px; height:8px; border-radius:50%; background:var(--muted); opacity:.8; }

    .cta{ display:flex; gap:12px; margin-top:18px; }
    .btn{ border:0; padding:12px 16px; border-radius:14px; background:linear-gradient(135deg, var(--brand), var(--brand2)); color:#fff; font-weight:700; cursor:not-allowed; opacity:.7; transition: transform .2s ease, opacity .2s ease, box-shadow .2s ease; box-shadow:0 8px 30px rgba(0,0,0,.35); }
    .btn:enabled{ cursor:pointer; opacity:1; }
    .btn:enabled:hover{ transform: translateY(-1.5px); box-shadow:0 12px 40px rgba(0,0,0,.4); }
    .btn-ghost{ background:transparent; border:1px solid rgba(255,255,255,.2); color:#fff; }

    /* Showcase skeleton card */
    .preview{ display:grid; place-items:center; }
    .cc{ position:relative; width:min(88vw,360px); height:220px; border-radius:22px; background: #0b0b0f; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,.5); border:1px solid rgba(255,255,255,.08); }
    .cc .logo{ position:absolute; top:18px; right:20px; font-weight:900; letter-spacing:1px; color:#fff; }
    .cc .chip{ position:absolute; left:22px; top:64px; width:50px; height:36px; border-radius:8px; background:linear-gradient(180deg, #ffcf66, #c6842a); box-shadow: inset 0 0 12px rgba(0,0,0,.4); }
    .cc .name{ position:absolute; left:22px; bottom:22px; color:#fff; letter-spacing:.6px}
    .cc .brand{ position:absolute; right:22px; bottom:18px; font-weight:800; color:#92d9ff }
    .shine{ position:absolute; inset:-10%; transform: rotate(18deg); background: linear-gradient(90deg, transparent, rgba(255,255,255,.35), transparent); }
    @media (prefers-reduced-motion: no-preference){
      .float{ animation: float 4s ease-in-out infinite; }
      .pulse{ animation: pulse 1.8s ease-in-out infinite; }
      .scan{ animation: scan 1.7s linear infinite; }
      .blink{ animation: blink 1s steps(2,end) infinite; }
      @keyframes float{ 0%,100%{ transform: translateY(0)} 50%{ transform: translateY(-6px)} }
      @keyframes pulse{ 0%,100%{ opacity:.6 } 50%{ opacity:1 } }
      @keyframes scan{ from{ transform:translateX(-120%) rotate(18deg) } to{ transform: translateX(120%) rotate(18deg)} }
      @keyframes blink{ 50%{ opacity:0 } }
    }

    footer{ position:absolute; inset:auto 0 14px; display:flex; justify-content:center; color:rgba(255,255,255,.55); font-size:12px; }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="card">
      <section class="panel">
        <div class="brand"><span class="brand-dot"></span>THX Deal</div>
        <h1 class="title">오프라인 카드 발급 준비 중</h1>
        <p class="subtitle">맞춤 혜택과 포인트를 안전하게 불러오고 있어요.</p>

        <div class="progress">
          <div class="bar" aria-label="진행률" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
            <div class="bar-fill"></div>
          </div>
          <div class="pct" id="pct">0%</div>
        </div>

        <div class="tip" id="tip">
          <span class="tip-dot pulse"></span>
          <span>초기화 중…</span>
        </div>

        <div class="cta">
          <button class="btn" id="continue" disabled>계속하기</button>
          <button class="btn btn-ghost" id="retry" hidden>다시 시도</button>
        </div>
      </section>

      <aside class="panel preview float">
        <div class="cc">
          <div class="logo">THX</div>
          <div class="chip"></div>
          <div class="name">CHAN TAI MAN</div>
          <div class="brand">VISA</div>
          <div class="shine scan"></div>
        </div>
      </aside>
    </div>
    <footer>빠르고 가벼운 바닐라 JS 로딩 컴포넌트</footer>
  </div>

  <script>
    // ---------- Config ----------
    const tips = [
      "혜택 정보를 정리하는 중…",
      "안전한 연결을 확인하고 있어요…",
      "포인트 적립 규칙을 불러오는 중…",
      "개인화 추천을 준비하고 있어요…",
      "보안 검사를 통과하는 중…",
    ];
    const DURATION_MS = 4800;          // 전체 로딩 시간(모의)
    const JITTER = 8;                   // 진행률 불규칙성

    // ---------- Elements ----------
    const bar = document.querySelector('.bar');
    const fill = document.querySelector('.bar-fill');
    const pct = document.getElementById('pct');
    const tip = document.getElementById('tip').lastElementChild;
    const btn = document.getElementById('continue');
    const retry = document.getElementById('retry');

    // ---------- Progress Logic ----------
    const start = performance.now();
    const tipEvery = 900; // ms
    let lastTip = 0;

    function setProgress(v){
      const clamped = Math.max(0, Math.min(100, v));
      fill.style.width = clamped + '%';
      bar.setAttribute('aria-valuenow', clamped);
      pct.textContent = clamped.toFixed(0) + '%';
    }

    function nextTip(){
      tip.textContent = tips[(Math.random() * tips.length) | 0];
    }

    function loop(ts){
      const elapsed = ts - start;
      // easeOutCubic
      const t = Math.min(1, elapsed / DURATION_MS);
      const eased = 1 - Math.pow(1 - t, 3);
      const noise = (Math.random() * JITTER) - (JITTER/2);
      setProgress(eased * 100 + noise);

      if(ts - lastTip > tipEvery){
        nextTip(); lastTip = ts;
      }

      if(t < 1){
        requestAnimationFrame(loop);
      } else {
        complete();
      }
    }

    function complete(){
      setProgress(100);
      btn.disabled = false;
      btn.textContent = '입장하기';
      btn.addEventListener('click', () => document.body.classList.add('loaded'));
    }

    // Optional: simulate occasional error (comment out if not needed)
    // setTimeout(() => { if(Math.random() < 0.0){
    //   tip.textContent = '네트워크 오류가 발생했어요.';
    //   retry.hidden = false; retry.onclick = () => location.reload();
    // }}, 1600);

    requestAnimationFrame(loop);
  </script>
</body>
</html>
