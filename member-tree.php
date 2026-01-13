<?php
session_start();
require_once __DIR__ . "/auth.php"; 
require_once __DIR__ . "/member-tree-get.php"; 
function maskName($name) {
    $len = mb_strlen($name, 'UTF-8');

    if ($len <= 1) {
        return $name; // 한 글자는 그대로
    }

    if ($len == 2) {
        return mb_substr($name, 0, 1, 'UTF-8') . '*';
    }

    return mb_substr($name, 0, 1, 'UTF-8')
         . str_repeat('*', $len - 2)
         . mb_substr($name, -1, 1, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include __DIR__ . "/head.php"; ?>
</head>
<body>
<div class="app">
    <header class="appbar-apply">
        <nav class="appbar__inner container--narrow" aria-label="상단 내비게이션">
            <a href="javascript:history.back()" class="nav-btn" aria-label="뒤로가기">
                <img src="/assets/icons/btn-next-arrow-left-dg.svg" width="24" height="24" alt="">
            </a>
            <h1 class="appbar__title">추천인</h1>
            <a href="/index.php" class="nav-btn home-btn" aria-label="홈">
                <img src="/assets/icons/icon-home.svg" alt="">
            </a>
        </nav>
    </header>

    <main class="page">
        <div class="tree-wrap">

            <div class="tree-header">
                <div style="margin:0 auto;">
                    <div class="root-info">
                        <b>옆으로 스크롤(줄을 밀면)시 모두 확인 가능합니다.</b>
                    </div>
                </div>
            </div>

            <!-- 루트 -->
            <div class="tree-level">
                <div class="tree-row">
                    <div class="node-card node-root">
                        <div class="node-account">
                            <?= htmlspecialchars($myAccountNo, ENT_QUOTES) ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                $firstDept = $minDept;
                $firstNodes = ($firstDept !== null && isset($levels[$firstDept])) ? $levels[$firstDept] : [];
            ?>

          <?php if (empty($level2)): ?>
            <p class="empty-text">표시할 추천인이 없습니다. (2대 없음)</p>
          <?php else: ?>
            <div class="tree-level-label">2대</div>

            <div class="tree-level">
              <div class="tree-row">
                <?php foreach ($level2 as $n): 
                    
                  ?>
                  <button type="button"
                    class="tree-node-card js-node"
                    data-gen="2"
                    data-account="<?= htmlspecialchars($n['accountNo'], ENT_QUOTES) ?>">
                    <div class="tree-node-name"><?= htmlspecialchars(maskName($n['name']), ENT_QUOTES) ?></div>
                    <div class="tree-node-account"><?= htmlspecialchars($n['accountNo'], ENT_QUOTES) ?></div>
                  </button>
                <?php endforeach; ?>
              </div>
            </div>

            <div id="treeAppendArea"></div>
            <p id="treeMsg" class="muted small" style="text-align:center;margin-top:10px;"></p>
          <?php endif; ?>

        </div>
    </main>
</div>
<script>
(() => {
  const appendArea = document.getElementById('treeAppendArea');
  const msg = document.getElementById('treeMsg');

  const MAX_GEN = 4;
  let currentGen = 2; // 처음 화면이 2대까지 있으니까

  function setMsg(t, ok=true){
    if(!msg) return;
    msg.textContent = t || '';
    msg.style.color = ok ? '#16a34a' : '#ef4444';
    msg.style.fontWeight = '700';
  }

  function escapeHtml(s){
    return String(s).replace(/[&<>"']/g, m => ({
      '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'
    }[m]));
  }
function maskName(name) {
  if (!name) return '';

  const chars = [...name]; // 유니코드 안전
  const len = chars.length;

  if (len <= 1) return name;
  if (len === 2) return chars[0] + '*';

  return chars[0] + '*'.repeat(len - 2) + chars[len - 1];
}

async function loadParent(accountNo){
  const res = await fetch('/tree-next.php', {
    method:'POST',
    headers:{'Content-Type':'application/json'},
    body: JSON.stringify({accountNo})
  });

  const text = await res.text();     // ✅ 먼저 text로 받기
  try{
    return JSON.parse(text);         // ✅ 그 다음 JSON 파싱
  }catch(e){
    console.error('JSON parse fail:', text);
    throw new Error('JSON 파싱 실패(서버 출력에 디버그/에러가 섞였을 가능성)');
  }
}

  function renderLevel(gen, nodes){
    const label = `<div class="tree-level-label" data-gen="${gen}">${gen}대</div>`;
    const cards = nodes.map(n => `
      <button type="button" class="tree-node-card js-node"
        data-gen="${gen}"
        data-account="${escapeHtml(n.accountNo)}">
        <div class="tree-node-name">${maskName(escapeHtml(n.name || ''))}</div>
        <div class="tree-node-account">${escapeHtml(n.accountNo || '')}</div>
      </button>
    `).join('');

    const level = `
      <div class="tree-level" data-gen="${gen}">
        <div class="tree-row">${cards}</div>
      </div>
    `;
    return label + level;
  }

  function removeAfterGen(gen){
    // gen보다 큰 레벨들은 모두 삭제(다시 클릭했을 때 재구성)
    appendArea.querySelectorAll('[data-gen]').forEach(el => {
      const g = Number(el.getAttribute('data-gen'));
      if (g > gen) el.remove();
    });
    currentGen = gen;
  }

  document.addEventListener('click', async (e) => {
    const btn = e.target.closest('.js-node');
    if(!btn) return;

    const clickedGen = Number(btn.dataset.gen || '2');
    const account = btn.dataset.account;

    // 이미 4대까지 있으면 끝
    if(clickedGen >= MAX_GEN){
      setMsg(`최대 ${MAX_GEN}대까지만 확인 가능합니다.`, false);
      return;
    }

    // 예전(2대/3대)을 다시 눌렀으면 그 뒤 레벨 삭제하고 다시 조회
    if (clickedGen < currentGen) {
      removeAfterGen(clickedGen);
    }

    // 다음 대를 붙일 수 있는 상태인지 체크
    if(currentGen >= MAX_GEN){
      setMsg(`최대 ${MAX_GEN}대까지만 확인 가능합니다.`, false);
      return;
    }

    setMsg('조회중...');

    try{
      const data = await loadParent(account);
      if(!data.ok){
        setMsg(data.message || '조회 실패', false);
        return;
      }

      if(!data.nodes || data.nodes.length === 0){
        setMsg('해당 사용자의 상위 추천인이 없습니다. (최상단)', false);
        return;
      }

      const nextGen = clickedGen + 1;

      // 혹시 이미 nextGen이 출력되어 있으면(중복) 지우고 새로
      removeAfterGen(clickedGen);

      appendArea.insertAdjacentHTML('beforeend', renderLevel(nextGen, data.nodes));
      currentGen = nextGen;

      setMsg(`${nextGen}대 추천인을 표시했습니다.`);
    }catch(err){
      setMsg('네트워크 오류로 조회 실패', false);
    }
  });
})();
</script>


</body>
</html>
