<!doctype html>
<html lang="ko">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>홈페이지 시작 인트로</title>
  <style>
    :root{
      --bg:#0f1224; --panel:#12172e; --text:#fff; --muted:rgba(255,255,255,.72);
      --brand1:#ff7a18; --brand2:#af2cff; --glass:rgba(255,255,255,.06);
    }
    *{box-sizing:border-box}
    html,body{height:100%}
    body{margin:0; font:16px/1.55 system-ui,-apple-system,Segoe UI,Roboto,Pretendard,Noto Sans KR,Apple SD Gothic Neo,Arial,sans-serif; color:var(--text); background:var(--bg)}
    /* 메인 페이지 컨테이너 (데모) */
    .page{min-height:100%; opacity:0; transform:translateY(8px); transition:opacity .5s ease, transform .5s ease;}
    .page.show{opacity:1; transform:none}

    /* ===== Splash / Intro Overlay ===== */
    .splash{position:fixed; inset:0; z-index:9999; display:grid; place-items:center; overflow:hidden;
      background:
        radial-gradient(900px 500px at 10% 10%, #2b164e 0%, transparent 55%),
        radial-gradient(800px 700px at 90% 90%, #2a2d5e 0%, transparent 55%),
        linear-gradient(120deg, #0f1020, #141b33);
      color:#fff;
    }
    .splash::after{content:""; position:absolute; inset:-30% -20% -40% -20%; pointer-events:none; background:conic-gradient(from 0deg, rgba(255,255,255,.07), transparent 50%); filter:blur(60px)}

    .s-box{ position:relative; width:min(92vw,860px); display:grid; grid-template-columns:1.1fr 1fr; gap:28px; align-items:center; padding:28px; border-radius:28px; background:var(--glass); backdrop-filter: blur(14px); border:1px solid rgba(255,255,255,.15); box-shadow: 0 20px 60px rgba(0,0,0,.45);}
    @media (max-width:860px){ .s-box{ grid-template-columns:1fr; gap:18px; } }

    .brand{ display:flex; align-items:center; gap:10px; font-weight:800; letter-spacing:.3px; }
    .brand-dot{ width:12px; height:12px; border-radius:50%; background:conic-gradient(from 0deg, var(--brand1), var(--brand2)); box-shadow:0 0 14px rgba(255,255,255,.55) inset, 0 0 14px rgba(255,255,255,.25); }

    .title{ margin:6px 0 2px; font-size:clamp(24px,2.8vw,32px); font-weight:800 }
    .subtitle{ margin:0 0 16px; color:var(--muted) }

    .progress{ display:flex; align-items:center; gap:10px; margin:16px 0 8px; }
    .bar{ flex:1; height:10px; background:rgba(255,255,255,.14); border-radius:999px; overflow:hidden; position:relative; }
    .bar-fill{ height:100%; width:0%; background:linear-gradient(90deg, var(--brand1), var(--brand2)); border-radius:inherit; box-shadow:0 0 20px rgba(255,255,255,.25) }
    .pct{ width:48px; text-align:right; font-variant-numeric:tabular-nums; color:var(--muted) }

    .tip{ margin-top:6px; color:var(--muted); display:flex; align-items:center; gap:8px; min-height:28px; }
    .dot{ width:8px; height:8px; border-radius:50%; background:var(--muted); opacity:.8; }

    .cta{ display:flex; gap:12px; margin-top:18px }
    .btn{ border:0; padding:12px 16px; border-radius:14px; background:linear-gradient(135deg, var(--brand1), var(--brand2)); color:#fff; font-weight:700; cursor:not-allowed; opacity:.75; transition: transform .2s ease, opacity .2s ease, box-shadow .2s ease; box-shadow:0 8px 30px rgba(0,0,0,.35) }
    .btn:enabled{ cursor:pointer; opacity:1 }
    .btn:enabled:hover{ transform: translateY(-1.5px); box-shadow:0 12px 40px rgba(0,0,0,.4) }
    .btn-ghost{ background:transparent; border:1px solid rgba(255,255,255,.25) }

    /* 카드 프리뷰 */
    .preview{ display:grid; place-items:center }
    .cc{ position:relative; width:min(88vw,360px); height:220px; border-radius:22px; background:#0b0b0f; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,.5); border:1px solid rgba(255,255,255,.08); }
    .cc .logo{ position:absolute; top:18px; right:20px; font-weight:900; letter-spacing:1px; color:#fff }
    .cc .chip{ position:absolute; left:22px; top:64px; width:50px; height:36px; border-radius:8px; background:linear-gradient(180deg, #ffcf66, #c6842a); box-shadow: inset 0 0 12px rgba(0,0,0,.4) }
    .cc .name{ position:absolute; left:22px; bottom:22px; color:#fff; letter-spacing:.6px }
    .cc .brand{ position:absolute; right:22px; bottom:18px; font-weight:800; color:#92d9ff }
    .shine{ position:absolute; inset:-10%; transform: rotate(18deg); background: linear-gradient(90deg, transparent, rgba(255,255,255,.35), transparent) }

    @media (prefers-reduced-motion:no-preference){
      .float{ animation: float 4s ease-in-out infinite }
      .pulse{ animation: pulse 1.8s ease-in-out infinite }
      .scan{ animation: scan 1.7s linear infinite }
      @keyframes float{ 0%,100%{ transform: translateY(0)} 50%{ transform: translateY(-6px)} }
      @keyframes pulse{ 0%,100%{ opacity:.6 } 50%{ opacity:1 } }
      @keyframes scan{ from{ transform:translateX(-120%) rotate(18deg) } to{ transform: translateX(120%) rotate(18deg)} }
    }

    /* Splash hide 애니메이션 */
    .splash.hide{ opacity:0; transform:scale(.98); transition: opacity .55s ease, transform .55s ease; pointer-events:none }

    /* 스크롤 잠금 */
    .no-scroll{ overflow:hidden }

    /* 데모 메인 내용 */
    header{ padding:28px 20px; background:linear-gradient(180deg, #10142a, transparent); position:sticky; top:0 }
    .hero{ padding:48px 20px; display:grid; gap:14px }
    .hero h1{ font-size:clamp(28px, 3.4vw, 42px); margin:0 }
    .grid{ display:grid; grid-template-columns:repeat(3,1fr); gap:16px; padding:20px }
    .card{ background:var(--panel); border:1px solid rgba(255,255,255,.08); padding:18px; border-radius:16px }
    @media (max-width:840px){ .grid{ grid-template-columns:1fr } }
  </style>
</head>
<body class="no-scroll">
  <!-- ===== Splash / Intro ===== -->
  <div class="splash" id="splash" aria-label="초기 로딩 화면" role="dialog" aria-modal="true">
    <div class="s-box">
      <section>
        <div class="brand"><span class="brand-dot"></span>THX Deal</div>
        <h1 class="title">시작 준비 중</h1>
        <p class="subtitle">맞춤 혜택과 포인트를 안전하게 불러오고 있어요.</p>
        <div class="progress">
          <div class="bar" aria-label="진행률" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
            <div class="bar-fill" id="fill"></div>
          </div>
          <div class="pct" id="pct">0%</div>
        </div>
        <div class="tip"><span class="dot pulse"></span><span id="tip">초기화 중…</span></div>
        <div class="cta">
          <button class="btn" id="enter" disabled>입장하기</button>
          <button class="btn btn-ghost" id="skip">건너뛰기</button>
        </div>
      </section>
      <aside class="preview float">
        <div class="cc">
          <div class="logo">THX</div>
          <div class="chip"></div>
          <div class="name">CHAN TAI MAN</div>
          <div class="brand">VISA</div>
          <div class="shine scan"></div>
        </div>
      </aside>
    </div>
  </div>

  <!-- ===== Main page (demo) ===== -->
  <main class="page" id="page">
    <header>
      <div class="brand"><span class="brand-dot"></span>THX Deal</div>
    </header>
    <section class="hero">
      <h1>홈페이지 본문</h1>
      <p class="subtitle">이 영역은 실제 사이트 콘텐츠로 대체하면 됩니다.</p>
    </section>
    <section class="grid">
      <div class="card">콘텐츠 A</div>
      <div class="card">콘텐츠 B</div>
      <div class="card">콘텐츠 C</div>
    </section>
  </main>

  <script>
    // ===== Splash Controller =====
    const el = {
      splash: document.getElementById('splash'),
      page: document.getElementById('page'),
      fill: document.getElementById('fill'),
      pct: document.getElementById('pct'),
      tip: document.getElementById('tip'),
      enter: document.getElementById('enter'),
      skip: document.getElementById('skip'),
      bar: null
    };

    const tips = [
      '혜택 정보를 정리하는 중…',
      '안전한 연결을 확인하고 있어요…',
      '포인트 적립 규칙을 불러오는 중…',
      '개인화 추천을 준비하고 있어요…',
      '보안 검사를 통과하는 중…',
    ];

    const started = performance.now();
    const MIN_SHOW_MS = 900; // 최소 표시 시간 (과도한 깜빡임 방지)
    const tipEvery = 900;
    let lastTip = started;

    function setProgress(v){
      const n = Math.max(0, Math.min(100, v));
      el.fill.style.width = n + '%';
      el.pct.textContent = n.toFixed(0) + '%';
      el.fill.parentElement.setAttribute('aria-valuenow', n);
      if(n > 70) el.enter.disabled = false;
    }

    function nextTip(){ el.tip.textContent = tips[(Math.random()*tips.length)|0]; }

    // 부드러운 진행률 애니메이션 (로드 이벤트 전까지 90% 근처까지)
    let rafId;
    function animate(){
      const elapsed = performance.now() - started;
      const t = Math.min(1, elapsed / 4200); // 4.2초 기준 ease
      const eased = 1 - Math.pow(1 - t, 3);
      const target = 90 * eased; // 최대 90%
      setProgress(target);
      if(performance.now() - lastTip > tipEvery){ lastTip = performance.now(); nextTip(); }
      rafId = requestAnimationFrame(animate);
    }
    rafId = requestAnimationFrame(animate);

    // 실제 자원 로드 완료 후 마무리
    function finish(){
      cancelAnimationFrame(rafId);
      const done = () => {
        setProgress(100);
        el.splash.classList.add('hide');
        document.body.classList.remove('no-scroll');
        el.page.classList.add('show');
        setTimeout(() => el.splash.remove(), 600);
      };
      const wait = Math.max(0, MIN_SHOW_MS - (performance.now() - started));
      setTimeout(done, wait);
    }

    window.addEventListener('load', finish);

    // 사용자 제어: 바로 들어가기 / 건너뛰기
    el.enter.addEventListener('click', finish);
    el.skip.addEventListener('click', finish);
  </script>
</body>
</html>
