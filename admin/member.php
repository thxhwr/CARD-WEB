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
          <div class="topbar-title">회원 관리</div>
          <div class="topbar-subtitle">회원 목록 조회 및 등급/상태 관리를 할 수 있습니다.</div>
          <div class="breadcrumb">
            <span>홈</span>
            <span>회원 관리</span>
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

      <!-- 상단 요약 카드 (회원용) -->
      <section class="summary-grid">
        <article class="summary-card">
          <div class="summary-label">전체 회원수</div>
          <div class="summary-value">2,341명</div>
          <div class="summary-meta">
            <span class="summary-badge">오늘 가입 12명</span>
            <span class="summary-change up">▲ 0.5%</span>
          </div>
        </article>

        <article class="summary-card">
          <div class="summary-label">휴면 회원</div>
          <div class="summary-value">132명</div>
          <div class="summary-meta">
            <span class="summary-badge">1년 이상 미접속</span>
            <span class="summary-change up">▲ 3명</span>
          </div>
        </article>

        <article class="summary-card">
          <div class="summary-label">탈퇴 회원</div>
          <div class="summary-value">87명</div>
          <div class="summary-meta">
            <span class="summary-badge">최근 30일 5명</span>
            <span class="summary-change down">▼ 2명</span>
          </div>
        </article>

        <article class="summary-card">
          <div class="summary-label">SMS / 이메일 동의</div>
          <div class="summary-value">1,589명</div>
          <div class="summary-meta">
            <span class="summary-badge">마케팅 동의율 68%</span>
            <span class="summary-change up">▲ 1.2%</span>
          </div>
        </article>
      </section>

      <!-- 필터 + 목록 레이아웃 -->
      <section class="grid-2">
        <!-- 검색 / 필터 영역 -->
        <section class="card">
          <div class="card-header">
            <div>
              <div class="card-title">회원 검색</div>
              <div class="card-subtitle">조건을 선택 후 검색 버튼을 눌러주세요.</div>
            </div>
          </div>

          <form>
            <div class="form-grid">
              <div class="form-row">
                <label class="form-label">가입일자</label>
                <input type="date" class="form-input" />
              </div>
              <div class="form-row">
                <label class="form-label">~</label>
                <input type="date" class="form-input" />
              </div>

              <div class="form-row">
                <label class="form-label">회원등급</label>
                <select class="form-select">
                  <option>전체</option>
                  <option>일반회원</option>
                  <option>우수회원</option>
                  <option>VIP</option>
                </select>
              </div>

              <div class="form-row">
                <label class="form-label">상태</label>
                <select class="form-select">
                  <option>전체</option>
                  <option>정상</option>
                  <option>휴면</option>
                  <option>탈퇴</option>
                  <option>로그인 제한</option>
                </select>
              </div>

              <div class="form-row">
                <label class="form-label">가입경로</label>
                <select class="form-select">
                  <option>전체</option>
                  <option>일반 가입</option>
                  <option>카카오</option>
                  <option>네이버</option>
                  <option>Apple</option>
                </select>
              </div>

              <div class="form-row">
                <label class="form-label">검색어</label>
                <input type="text" class="form-input" placeholder="이름, 아이디, 연락처, 이메일" />
              </div>
            </div>

            <div class="form-footer">
              <div class="form-help">
                복수 조건을 함께 설정할 수 있습니다.
              </div>
              <div>
                <button type="button" class="ghost-button">조건 초기화</button>
                <button type="submit" class="primary-button">
                  검색하기
                  <span>→</span>
                </button>
              </div>
            </div>
          </form>
        </section>

        <!-- 간단 회원 통계/메모 영역 -->
        <section class="card">
          <div class="card-header">
            <div>
              <div class="card-title">회원 요약</div>
              <div class="card-subtitle">필터 결과 기준 주요 지표입니다.</div>
            </div>
          </div>

          <div class="form-grid">
            <div class="form-row">
              <label class="form-label">검색 결과 수</label>
              <div class="form-help">총 <strong>128명</strong> (페이지당 20명 표시)</div>
            </div>
            <div class="form-row">
              <label class="form-label">평균 구매 건수</label>
              <div class="form-help">회원당 평균 <strong>3.2건</strong></div>
            </div>
            <div class="form-row">
              <label class="form-label">평균 누적 결제금액</label>
              <div class="form-help">회원당 평균 <strong>₩ 41,200</strong></div>
            </div>

            <div class="form-row" style="grid-column: 1 / -1;">
              <label class="form-label">관리자 메모</label>
              <textarea class="form-textarea" placeholder="이 검색 조건/캠페인에 대한 관리 메모를 남겨두면 편해요."></textarea>
            </div>
          </div>
        </section>
      </section>

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

        <!-- 페이징 -->
        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:12px; gap:8px; flex-wrap:wrap;">
          <div class="form-help">
            선택한 회원에게: 
            <button type="button" class="ghost-button">SMS 발송</button>
            <button type="button" class="ghost-button">이메일 발송</button>
            <button type="button" class="ghost-button">등급 변경</button>
          </div>
          <div style="display:flex; align-items:center; gap:4px; font-size:13px;">
            <button class="icon-button" type="button">«</button>
            <button class="icon-button" type="button">‹</button>
            <span style="padding:0 4px;">1 / 7</span>
            <button class="icon-button" type="button">›</button>
            <button class="icon-button" type="button">»</button>
          </div>
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
