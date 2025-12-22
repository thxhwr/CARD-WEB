<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8" />
  <title>쇼핑몰 관리자</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="preload" href="./assets/css/main.css" as="style">
<link rel="stylesheet" href="./assets/css/main.css">
</head>
<body>

<div class="layout">
  <!-- ===== 사이드바 ===== -->
    <?php include __DIR__ . "/side.php"; ?>

  <!-- ===== 메인 영역 ===== -->
  <div class="main">
    <!-- 상단바 -->
    <header class="topbar">
      <div class="topbar-left">
        <!-- 모바일에서만 보이는 햄버거 버튼 -->
        <button class="sidebar-toggle-btn" id="sidebarToggle" aria-label="메뉴 열기">
          ☰
        </button>

        <div>
          <div class="topbar-title">대시보드</div>
          <div class="topbar-subtitle">오늘 기준 주요 지표를 확인하세요.</div>
          <div class="breadcrumb">
            <span>홈</span>
            <span>대시보드</span>
          </div>
        </div>
      </div>

      <div class="topbar-right">
        <div class="search-box">
          <span class="search-icon">🔍</span>
          <input type="text" class="search-input" placeholder="주문번호, 고객명 검색" />
        </div>

        <div class="topbar-actions">
          <button class="icon-button" title="알림">
            🔔
          </button>
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
      <!-- 요약 카드 -->
      <section class="summary-grid">
        <article class="summary-card">
          <div class="summary-label">오늘 매출</div>
          <div class="summary-value">₩ 482,300</div>
          <div class="summary-meta">
            <span class="summary-badge">어제 대비</span>
            <span class="summary-change up">
              ▲ 12.4%
            </span>
          </div>
        </article>

        <article class="summary-card">
          <div class="summary-label">오늘 주문수</div>
          <div class="summary-value">37건</div>
          <div class="summary-meta">
            <span class="summary-badge">결제완료 29건</span>
            <span class="summary-change up">
              ▲ 6건
            </span>
          </div>
        </article>

        <article class="summary-card">
          <div class="summary-label">취소 / 환불</div>
          <div class="summary-value">3건</div>
          <div class="summary-meta">
            <span class="summary-badge">환불 진행중 1건</span>
            <span class="summary-change down">
              ▼ 2건
            </span>
          </div>
        </article>

        <article class="summary-card">
          <div class="summary-label">신규 회원</div>
          <div class="summary-value">12명</div>
          <div class="summary-meta">
            <span class="summary-badge">전체 2,341명</span>
            <span class="summary-change up">
              ▲ 5명
            </span>
          </div>
        </article>
      </section>

      <!-- 주문 / 상품 영역 -->
      <section class="grid-2">
        <!-- 최근 주문 -->
        <section class="card">
          <div class="card-header">
            <div>
              <div class="card-title">최근 주문</div>
              <div class="card-subtitle">최근 7일간 주문 내역 일부만 표시됩니다.</div>
            </div>
            <div class="card-actions">
              <button class="pill">전체보기</button>
            </div>
          </div>

          <div class="table-wrapper">
            <table>
              <thead>
              <tr>
                <th>주문일시</th>
                <th>주문번호</th>
                <th>주문자</th>
                <th>결제금액</th>
                <th>상태</th>
                <th>배송</th>
              </tr>
              </thead>
              <tbody>
              <tr>
                <td>2025-12-22<br><span class="text-sm text-muted">14:32</span></td>
                <td class="text-sm">20251222-00041</td>
                <td class="text-sm">홍길동</td>
                <td class="text-right">₩ 32,000</td>
                <td><span class="badge paid">결제완료</span></td>
                <td class="text-sm text-muted">준비중</td>
              </tr>
              <tr>
                <td>2025-12-22<br><span class="text-sm text-muted">13:18</span></td>
                <td class="text-sm">20251222-00040</td>
                <td class="text-sm">김영희</td>
                <td class="text-right">₩ 18,500</td>
                <td><span class="badge.ship-ready badge">배송준비</span></td>
                <td class="text-sm text-muted">택배</td>
              </tr>
              <tr>
                <td>2025-12-22<br><span class="text-sm text-muted">11:07</span></td>
                <td class="text-sm">20251222-00039</td>
                <td class="text-sm">이민수</td>
                <td class="text-right">₩ 74,900</td>
                <td><span class="badge pending">입금대기</span></td>
                <td class="text-sm text-muted">무통장</td>
              </tr>
              <tr>
                <td>2025-12-21<br><span class="text-sm text-muted">17:55</span></td>
                <td class="text-sm">20251221-00038</td>
                <td class="text-sm">박지수</td>
                <td class="text-right">₩ 42,500</td>
                <td><span class="badge cancel">주문취소</span></td>
                <td class="text-sm text-muted">고객요청</td>
              </tr>
              </tbody>
            </table>
          </div>
        </section>

        <!-- 상품 간단 등록 -->
        <section class="card">
          <div class="card-header">
            <div>
              <div class="card-title">상품 간편 등록</div>
              <div class="card-subtitle">자주 등록하는 기본 필드만 모아두었습니다.</div>
            </div>
            <div class="card-actions">
              <button class="pill">전체 폼 열기</button>
            </div>
          </div>

          <form>
            <div class="form-grid">
              <div class="form-row">
                <label class="form-label">상품명<span>*</span></label>
                <input type="text" class="form-input" placeholder="예) 뉴욕 치즈케이크 조각" />
              </div>
              <div class="form-row">
                <label class="form-label">노출 상태</label>
                <select class="form-select">
                  <option>판매중</option>
                  <option>품절</option>
                  <option>비노출</option>
                </select>
              </div>

              <div class="form-row">
                <label class="form-label">판매가<span>*</span></label>
                <input type="number" class="form-input" placeholder="예) 5200" />
              </div>
              <div class="form-row">
                <label class="form-label">재고수량</label>
                <input type="number" class="form-input" placeholder="예) 30" />
              </div>

              <div class="form-row">
                <label class="form-label">카테고리</label>
                <select class="form-select">
                  <option>케이크</option>
                  <option>샌드위치</option>
                  <option>커피 / 음료</option>
                  <option>굿즈</option>
                </select>
              </div>
              <div class="form-row">
                <label class="form-label">간단 설명</label>
                <input type="text" class="form-input" placeholder="간단한 특징을 작성하세요." />
              </div>

              <div class="form-row" style="grid-column: 1 / -1;">
                <label class="form-label">관리 메모</label>
                <textarea class="form-textarea" placeholder="내부용 메모 (고객에게는 노출되지 않습니다)."></textarea>
                <div class="form-help">
                  실제 개발 시 여기서 필수값 체크 → 저장 버튼 클릭 시 서버에 전송하는 구조로 사용하시면 됩니다.
                </div>
              </div>
            </div>

            <div class="form-footer">
              <div class="form-help">
                * 필수 입력 항목입니다.
              </div>
              <div>
                <button type="button" class="ghost-button">임시 저장</button>
                <button type="submit" class="primary-button">
                  저장하기
                  <span>→</span>
                </button>
              </div>
            </div>
          </form>
        </section>
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

    // 사이드바 외부 클릭 시 닫기 (모바일용)
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
