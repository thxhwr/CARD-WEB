<?php include __DIR__ . "/head.php"; ?>

<div class="layout">
  <!-- ===== 사이드바 ===== -->
 <?php include __DIR__ . "/side.php"; ?>

  <!-- ===== 메인 영역 ===== -->
  <div class="main">
    <h1 class="admin-title">카드 신청 관리</h1>

    <!-- 🔍 검색 / 필터 -->
    <div class="admin-filter">
        <input type="text" placeholder="이름 / 아이디 / 추천인 검색">
        <select>
        <option value="">전체 상태</option>
        <option value="pending">대기</option>
        <option value="approved">승인</option>
        <option value="rejected">반려</option>
        </select>
        <button class="btn-search">조회</button>
    </div>

    <!-- 📋 리스트 -->
    <div class="admin-table-wrap">
        <table class="admin-table">
        <thead>
            <tr>
            <th>번호</th>
            <th>신청일시</th>
            <th>이름</th>
            <th>아이디</th>
            <th>추천인</th>
            <th>수령</th>
            <th>연락처</th>
            <th>상태</th>
            <th>관리</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <td>12</td>
            <td>25-12-24 15:09</td>
            <td>홍길동</td>
            <td>user01@gmail.com</td>
            <td>ref01@gmail.com</td>
            <td>방문</td>
            <td>010-1234-5678</td>
            <td><span class="badge pending">대기</span></td>
            <td>
                <button class="btn-sm">상세</button>
            </td>
            </tr>

            <tr>
            <td>11</td>
            <td>25-12-24 14:22</td>
            <td>김철수</td>
            <td>user02@gmail.com</td>
            <td>ref02@gmail.com</td>
            <td>방문</td>
            <td>010-9876-5432</td>
            <td><span class="badge approved">승인</span></td>
            <td>
                <button class="btn-sm">상세</button>
            </td>
            </tr>
        </tbody>
        </table>
    </div>
    </div>
