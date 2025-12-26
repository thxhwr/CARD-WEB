<?php include __DIR__ . "/head.php"; ?>

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
          <span class="search-icon">🔍</span>
          <input type="text" class="search-input" placeholder="이름, 아이디, 연락처 검색" />
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
            <div class="card-title">회원 목록</div>
            <div class="card-subtitle">더블 클릭 시 상세 팝업(또는 상세 페이지)로 이동하도록 추후 개발하면 좋습니다.</div>
          </div>
          <div class="card-actions">
            <span class="text-sm text-muted">정렬: 가입일 내림차순</span>
            <button class="pill">엑셀 다운로드</button>
          </div>
        </div>

        <div class="table-wrapper">
          <table>
            <thead>
            <tr>
              <th><input type="checkbox" /></th>
              <th>회원번호</th>
              <th>아이디 / 이름</th>
              <th>회원등급</th>
              <th>누적구매</th>
              <th>마지막 로그인</th>
              <th>상태</th>
              <th>가입일</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td><input type="checkbox" /></td>
              <td class="text-sm">M0002341</td>
              <td class="text-sm">
                user01<br />
                <span class="text-muted text-sm">홍길동</span>
              </td>
              <td><span class="badge">VIP</span></td>
              <td class="text-right">₩ 182,300<br /><span class="text-sm text-muted">총 7회</span></td>
              <td>2025-12-22<br /><span class="text-sm text-muted">13:21</span></td>
              <td><span class="badge paid">정상</span></td>
              <td>2024-08-12</td>
            </tr>
            <tr>
              <td><input type="checkbox" /></td>
              <td class="text-sm">M0002338</td>
              <td class="text-sm">
                coffee_love<br />
                <span class="text-muted text-sm">김영희</span>
              </td>
              <td><span class="badge">우수회원</span></td>
              <td class="text-right">₩ 92,700<br /><span class="text-sm text-muted">총 4회</span></td>
              <td>2025-12-20<br /><span class="text-sm text-muted">09:02</span></td>
              <td><span class="badge pending">휴면</span></td>
              <td>2023-11-02</td>
            </tr>
            <tr>
              <td><input type="checkbox" /></td>
              <td class="text-sm">M0002321</td>
              <td class="text-sm">
                guest_123<br />
                <span class="text-muted text-sm">이민수</span>
              </td>
              <td><span class="badge">일반회원</span></td>
              <td class="text-right">₩ 12,900<br /><span class="text-sm text-muted">총 1회</span></td>
              <td>2025-10-11<br /><span class="text-sm text-muted">21:10</span></td>
              <td><span class="badge cancel">탈퇴</span></td>
              <td>2023-05-27</td>
            </tr>
            <!-- 필요 시 더미 데이터 더 추가해도 됩니다 -->
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
