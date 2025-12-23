<?php $pageTitle = "카드 신청"; ?>
<!doctype html>
<html lang="ko">
<head>
  <?php 
    include __DIR__ . "/auth.php";
    include __DIR__ . "/head.php"; 
    ?>
</head>
<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<body>
    <div class="app">
    
        <header class="appbar-apply">
            <nav class="appbar__inner container--narrow" aria-label="상단 내비게이션">
                <a href="javascript:history.back()" class="nav-btn" aria-label="뒤로가기">
                    <img src="/assets/icons/btn-next-arrow-left-dg.svg" width="24px" height="24px">
                </a>
                <h1 class="appbar__title">카드 신청</h1>
                <a href="/index.php" class="nav-btn home-btn" aria-label="홈"><img src="/assets/icons/icon-home.svg"></a>
            </nav>
        </header>

        <!-- 본문 -->
        <main class="page">
            <section class="apply-form">

                <form id="cardApplyForm" class="form" action="/apply-process.php" method="post">
                    <!-- <div class="f-group is-disabled">
                        <label class="f-label required" for="userid">아이디</label>
                        <input id="userid" name="userid" class="f-input" type="text" placeholder="땡스페이 아이디를 입력해주세요" required>
                    </div> -->

                    <!-- 비밀번호 -->
                    <!-- <div class="f-group is-disabled">
                        <label class="f-label required" for="pin">비밀번호</label>
                        <input id="pin" name="pin" class="f-input" type="password" inputmode="numeric" placeholder="땡스페이 비밀번호를 입력해주세요" required>
                    </div> -->

                    <!-- 이름 -->
                    <div class="f-group is-disabled">
                        <label class="f-label required" for="name">이름</label>
                        <input id="name" name="name" class="f-input" type="text" placeholder="이름을 입력해주세요" required>
                    </div>

                    <!-- 영문 이름 -->
                    <!-- <div class="f-group is-disabled">
                        <label class="f-label required" for="ename">영문 이름</label>
                        <input id="ename" name="ename" class="f-input" type="text" placeholder="영문 이름을 입력해주세요" required>
                    </div> -->

                    <!-- 배송지 -->
                    <!-- <div class="f-group is-disabled">
                        <label class="f-label required" for="address">배송지</label>
                        <input id="address" name="address" class="f-input" type="text" placeholder="카드 배송을 받을 주소를 입력해주세요" required>
                    </div> -->
                    <div class="f-group address-group is-disabled">
                        <label class="f-label">배송지</label>

                        <!-- 우편번호 -->
                        <div class="addr-row">
                            <input type="text" id="zipcode" name="zipcode" class="f-input" placeholder="우편번호" readonly>
                            <button type="button" class="btn-zip" onclick="execDaumPostcode()">
                            우편번호 검색
                            </button>
                        </div>

                        <!-- 기본 주소 -->
                        <input type="text" id="address" class="f-input" name="address" placeholder="기본 주소" readonly>

                        <!-- 상세 주소 -->
                        <input type="text" id="address_detail" class="f-input" name="address_detail" placeholder="상세 주소 입력">
                    </div>
                    <!-- 연락처 -->
                    <div class="f-group is-disabled">
                        <label class="f-label required" for="phone">전화번호</label>
                        <input id="phone" name="phone" class="f-input" type="tel" inputmode="tel" placeholder="카드 소유자 전화번호를 입력해주세요" pattern="[0-9\-]{9,20}" required>
                    </div>
                    <!-- <div class="f-group is-disabled">
                        <label class="f-label required" for="account">계좌번호</label>
                        <select name="bank" class="bank-select">
                            <option value="">은행 선택</option>
                            <option value="국민은행">국민은행(KB)</option>
                            <option value="신한은행">신한은행</option>
                            <option value="우리은행">우리은행</option>
                            <option value="하나은행">하나은행</option>
                            <option value="농협은행">농협은행(NH)</option>
                            <option value="기업은행">기업은행(IBK)</option>
                            <option value="산업은행">산업은행(KDB)</option>
                            <option value="수협은행">수협은행</option>

                          
                            <option value="부산은행">부산은행</option>
                            <option value="경남은행">경남은행</option>
                            <option value="광주은행">광주은행</option>
                            <option value="전북은행">전북은행</option>
                            <option value="제주은행">제주은행</option>
                            <option value="대구은행">대구은행</option>

                         
                            <option value="카카오뱅크">카카오뱅크</option>
                            <option value="토스뱅크">토스뱅크</option>
                            <option value="케이뱅크">케이뱅크(KBANK)</option>

                           
                            <option value="씨티은행">한국씨티은행</option>
                            <option value="HSBC">HSBC은행</option>
                            <option value="JP Morgan">JP Morgan Chase</option>
                            <option value="BOA">뱅크오브아메리카(BOA)</option>
                            <option value="SC제일은행">SC제일은행</option>
                            <option value="BNP Paribas">BNP Paribas</option>
                            <option value="중국공상은행">중국공상은행(ICBC)</option>
                            <option value="중국은행">중국은행(BOC)</option>
                            <option value="중국건설은행">중국건설은행(CCB)</option>
                            <option value="도이치은행">도이치은행</option>
                            <option value="미즈호은행">미즈호은행</option>
                            <option value="미쓰비시UFJ은행">미쓰비시UFJ은행(MUFG)</option>

                           
                            <option value="새마을금고">새마을금고</option>
                            <option value="신협">신협</option>
                            <option value="우체국">우체국</option>
                            <option value="저축은행">저축은행(각 지역 SB)</option>
                        </select>
                        <input id="account" name="account"  style="margin-top: 10px;" class="f-input" type="number"  placeholder="카드 소유자 계죄번호를 입력해주세요" pattern="[0-9\-]{9,20}" required>
                    </div> -->
                    <div class="f-group is-disabled">
                        <label class="f-label required" for="referral">추천인</label>
                        <input id="referral" name="referral" class="f-input" type="text"  placeholder="카드 소유자의 추천인을 입력해주세요" required>
                    </div>
                    <!-- 하단 고정 버튼 -->
                    <div class="form-actions">
                        <?php
                        $error = $_GET['error'] ?? null;

                        if ($error === '1') {
                            echo '<p style="padding-top:5%;text-align:center;margin:auto 0;color:#f44;font-size:12px;">이미 신청하였습니다.</p>';
                        } elseif ($error === '2') {
                            echo '<p style="padding-top:5%;text-align:center;margin:auto 0;color:#f44;font-size:12px;">잔액이 부족합니다.</p>';
                        }
                        ?>
                        <button class="apply-submit" type="submit" disabled onclick="location.href('apply-complete.php')">
                        카드 신청
                        </button>
                    </div>
                </form>
            </section>
        </main>

        <?php include __DIR__ . "/footer.php"; ?>
    </div>

    <script>
        (function(){
            const form = document.getElementById('cardApplyForm');
            const submitBtn = form.querySelector('.apply-submit');

            function toggleDisabledState(){
                form.querySelectorAll('.f-group').forEach(g=>{
                const inp = g.querySelector('.f-input');
                if(!inp) return;

                if (inp.value.trim() !== "") {
                    // 값 있음 → 활성화
                    g.classList.remove('is-disabled');
                    inp.disabled = false;
                } else {
                    // 값 없음 → 원래 비활성 필드였다면 다시 비활성
                    if(g.classList.contains('was-disabled')){
                    g.classList.add('is-disabled');
                    inp.disabled = true;
                    }
                }
                });
            }

            function toggleSubmit(){
                const required = form.querySelectorAll('[required]');
                const ok = Array.from(required).every(i => i.value.trim().length > 0);
                submitBtn.disabled = !ok;
            }

            
            form.querySelectorAll('.f-input').forEach(inp=>{
                const group = inp.parentElement;
                inp.addEventListener('focus', ()=> group.classList.add('is-focus'));
                inp.addEventListener('blur',  ()=> group.classList.remove('is-focus'));
            });

            form.addEventListener('input', ()=>{ toggleDisabledState(); toggleSubmit(); });
            form.addEventListener('change', ()=>{ toggleDisabledState(); toggleSubmit(); });

            toggleDisabledState(); toggleSubmit();

            form.addEventListener('submit', (e)=>{
                //e.preventDefault();
                // alert("신청되었습니다.");
                // location.href = "apply-complete.php";
            });
            })();
            

            function execDaumPostcode() {
                new daum.Postcode({
                    oncomplete: function(data) {
                    let addr = '';

                    // 도로명 주소 우선
                    if (data.userSelectedType === 'R') {
                        addr = data.roadAddress;
                    } else {
                        addr = data.jibunAddress;
                    }

                    document.getElementById('zipcode').value = data.zonecode;
                    document.getElementById('address').value = addr;

                    // 상세주소로 포커스 이동
                    document.getElementById('address_detail').focus();
                    }
                }).open();
                }
    </script>

</body>
</html>
