<?php
session_start();
require_once __DIR__ . "/auth.php"; 

$myAccountNo = $_SESSION['user_No'] ?? null;
if (!$myAccountNo) {
    echo "로그인이 필요합니다.";
    exit;
}


$postFields = ['accountNo' => $myAccountNo];

$ch = curl_init('https://api.thxdeal.com/api/member/testMemberReco.php');
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => http_build_query($postFields),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
]);

$response = curl_exec($ch);
if ($response === false) {
    $errorMsg = "API 호출 실패: " . curl_error($ch);
    curl_close($ch);
    echo $errorMsg;
    exit;
}
curl_close($ch);

$data = json_decode($response, true);

$list = $data['data']['list'] ?? ($data['data'] ?? []);
if (!is_array($list)) $list = [];

if ($list && !isset($list[0]) && isset($data[0])) {
    $list = $data;
}

$minDept = null;
foreach ($list as $row) {
    $d = (int)($row['dept'] ?? 0);
    if ($d <= 0) continue;
    if ($minDept === null || $d < $minDept) $minDept = $d;
}


$levels = [];

if ($minDept !== null) {
    $from = $minDept;      
    $to   = $minDept;
    // $to   = $minDept + 2;  

    foreach ($list as $row) {
        $dept = (int)($row['dept'] ?? 0);
        if ($dept < $from || $dept > $to) continue;

        if (!isset($levels[$dept])) $levels[$dept] = [];
        $levels[$dept][] = [
            'name'      => $row['name'] ?? '',
            'accountNo' => $row['accountNo'] ?? '',
            'userId'    => $row['userId'] ?? null,
            'dept'      => $dept,
            'deptNo'    => $row['deptNo'] ?? null,
            'createdAt' => $row['createdAt'] ?? '',
        ];
    }

    foreach ($levels as &$nodes) {
        usort($nodes, fn($a,$b) => ($a['deptNo'] ?? 0) <=> ($b['deptNo'] ?? 0));
    }
    unset($nodes);

    ksort($levels);
}

$pageTitle = "추천인";
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

            <?php if (empty($firstLevelNodes)): ?>
            <p class="empty-text">표시할 추천인이 없습니다.</p>
            <?php else: ?>
            <div class="tree-level-label">2대</div>
            <div class="tree-level">
                <div class="tree-row" id="treeRows">
                <?php foreach ($firstLevelNodes as $n): ?>
                    <!-- ✅ 클릭 가능하도록 button 처리 -->
                    <button type="button" class="tree-node-card js-node" data-account="<?= htmlspecialchars($n['accountNo'], ENT_QUOTES) ?>">
                    <div class="tree-node-name"><?= htmlspecialchars($n['name'], ENT_QUOTES) ?></div>
                    <div class="tree-node-account"><?= htmlspecialchars($n['accountNo'], ENT_QUOTES) ?></div>
                    </button>
                <?php endforeach; ?>
                </div>
            </div>

            <!-- ✅ 다음 레벨들이 붙을 자리 -->
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

  let currentGen = 2;      // 지금 화면에 있는 마지막 대(처음 2대까지 표시)
  const MAX_GEN = 4;

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

  function renderLevel(gen, nodes){
    const label = `<div class="tree-level-label">${gen}대</div>`;
    const cards = nodes.map(n => `
      <button type="button" class="tree-node-card js-node" data-account="${escapeHtml(n.accountNo)}">
        <div class="tree-node-name">${escapeHtml(n.name || '')}</div>
        <div class="tree-node-account">${escapeHtml(n.accountNo || '')}</div>
      </button>
    `).join('');

    const level = `
      <div class="tree-level">
        <div class="tree-row">
          ${cards}
        </div>
      </div>
    `;

    return label + level;
  }

  async function loadNext(accountNo){
    const res = await fetch('/reco-next.php', {
      method:'POST',
      headers:{'Content-Type':'application/json'},
      body: JSON.stringify({accountNo})
    });
    return await res.json();
  }

  // 이벤트 위임: 새로 추가된 카드도 클릭 가능
  document.addEventListener('click', async (e) => {
    const btn = e.target.closest('.js-node');
    if(!btn) return;

    if(currentGen >= MAX_GEN){
      setMsg(`최대 ${MAX_GEN}대까지만 확인 가능합니다.`, false);
      return;
    }

    const account = btn.dataset.account;
    setMsg('조회중...');

    try{
      const data = await loadNext(account);
      if(!data.ok){
        setMsg(data.message || '조회 실패', false);
        return;
      }
      if(!data.nodes || data.nodes.length === 0){
        setMsg('더 이상 위 추천인이 없습니다.', false);
        return;
      }

      const nextGen = currentGen + 1;

      // ✅ 다음 레벨 추가
      appendArea.insertAdjacentHTML('beforeend', renderLevel(nextGen, data.nodes));
      currentGen = nextGen;

      setMsg(`${currentGen}대까지 표시했습니다.`);

      // 추가된 레벨로 자연스럽게 이동(원하면)
      appendArea.lastElementChild?.scrollIntoView({behavior:'smooth', block:'center'});
    }catch(err){
      setMsg('네트워크 오류', false);
    }
  });
})();
</script>

</body>
</html>
