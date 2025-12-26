<?php include __DIR__ . "/head.php"; ?>
<?php include __DIR__ . "/list-get.php"; ?>
<div class="layout">
  <!-- ===== 사이드바 ===== -->
 <?php include __DIR__ . "/side.php"; ?>

  <!-- ===== 메인 영역 ===== -->
  <div class="main">
    <!-- 상단바 -->
    <header class="topbar">
      <div class="topbar-left">
        <!-- 모바일 햄버거 버튼 -->
        <button class="sidebar-toggle-btn" id="sidebarToggle" aria-label="메뉴 열기">
          ☰
        </button>

        <div>
          <div class="topbar-title">신청 관리</div>
          <div class="topbar-subtitle">신청 목록 조회 및 등급/상태 관리를 할 수 있습니다.</div>
          <div class="breadcrumb">
            <span>홈</span>
            <span>신청 관리</span>
          </div>
        </div>
      </div>

      <div class="topbar-right">
        <div class="search-box">
         <form class="search-box" method="get" action="">
        <span class="search-icon">🔍</span>
        <input type="text" name="q" class="search-input" placeholder="이름, 아이디, 연락처 검색"
                value="<?= htmlspecialchars($q ?? '', ENT_QUOTES) ?>" />
        </form>
        </div>

        <div class="topbar-actions">
          <button class="icon-button" title="새로고침">
            ⟳
          </button>
          <div class="user-chip">
            <div class="user-avatar">KS</div>
            <div>
              <div class="user-name">관리자</div>
              <div class="user-role">마스터</div>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- 컨텐츠 -->
    <main class="content">
      <!-- 회원 목록 테이블 -->
      <section class="card" style="margin-top:20px;">
        <div class="card-header">
          <div>
            <div class="card-title">신청 목록</div>
          </div>
        </div>

        <div class="table-wrapper">
          <table>
            <thead>
            <tr>
                <th><input type="checkbox" /></th>
                <th>회원번호</th>
                <th>아이디 / 이름</th>
                <th>신청일</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                <?php if ($errorMsg): ?>
                <tr>
                    <td colspan="5" class="text-sm" style="padding:16px; color:#ef4444;">
                    <?= htmlspecialchars($errorMsg, ENT_QUOTES) ?>
                    </td>
                </tr>

                <?php elseif (empty($appList)): ?>
                <tr>
                    <td colspan="5" class="text-sm" style="padding:16px; color:#6b7280;">
                    신청 내역이 없습니다.
                    </td>
                </tr>

                <?php else: ?>
                
                <?php foreach ($appList as $row): ?>
                    <?php
                        $applyId   = $row['APPLY_ID'] ?? '';
                        $accountNo = $row['ACCOUNT_NO'] ?? '';
                        $name      = $row['NAME'] ?? '';
                        $createdAt = $row['CREATED_AT'] ?? '';
                        $status    = $row['STATUS'] ?? '';

                        $dateStr = $createdAt ? date('y-m-d H:i', strtotime($createdAt)) : '';
                    ?>
                    <tr>
                        <td><input type="checkbox" name="chk[]" value="<?= htmlspecialchars($applyId, ENT_QUOTES) ?>" /></td>

                        <td class="text-sm"><?= htmlspecialchars($applyId, ENT_QUOTES) ?></td>

                        <td class="text-sm">
                        <?= htmlspecialchars($accountNo, ENT_QUOTES) ?><br />
                        <span class="text-muted text-sm"><?= htmlspecialchars($name, ENT_QUOTES) ?></span>
                        </td>

                        <td><?= htmlspecialchars($dateStr, ENT_QUOTES) ?></td>

                        <td>
                        <button type="button"
                                class="btn-confirm"
                                data-id="<?= htmlspecialchars($applyId, ENT_QUOTES) ?>"
                                data-account="<?= htmlspecialchars($accountNo, ENT_QUOTES) ?>">
                            확인
                        </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                <?php endif; ?>
                </tbody>
          </table>
        </div>
      </section>

    </main>
  </div>
</div>

<script>
  // 사이드바 토글 (모바일)
  const sidebarToggle = document.getElementById('sidebarToggle');
  const sidebar = document.getElementById('sidebar');

  if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener('click', function () {
      sidebar.classList.toggle('open');
    });

    document.addEventListener('click', function (e) {
      const target = e.target;
      const isClickInsideSidebar = sidebar.contains(target);
      const isClickToggle = sidebarToggle.contains(target);

      if (!isClickInsideSidebar && !isClickToggle && window.innerWidth <= 768) {
        sidebar.classList.remove('open');
      }
    });
  }
</script>

</body>
</html>
