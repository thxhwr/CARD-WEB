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

                    <div class="f-group is-disabled">
                        <label class="f-label required" for="name">이름</label>
                        <input id="name" name="name" class="f-input" type="text" placeholder="이름을 입력해주세요" required>
                        <div id="nameMsg" class="muted small" style="margin-top:8px;"></div>
                    </div>
                     <div class="f-group is-disabled">
                        <label class="f-label required" for="phone">전화번호</label>
                        <input id="phone" name="phone" class="f-input" type="tel" inputmode="tel" placeholder="카드 소유자 전화번호를 입력해주세요" pattern="[0-9\-]{9,20}" required>
                    </div>
                    <div class="f-group address-group is-disabled">
                        <label class="f-label">배송지</label>
                        <div class="addr-row">
                            <input type="text" id="zipcode" name="zipcode" class="f-input" placeholder="우편번호" readonly>
                            <button type="button" class="btn-zip" onclick="execDaumPostcode()">
                            우편번호 검색
                            </button>
                        </div>
                        <input type="text" id="address" class="f-input" name="address" placeholder="기본 주소" readonly>
                        <input type="text" id="address_detail" class="f-input" name="address_detail" placeholder="상세 주소 입력">
                        <div id="addressMsg" class="muted small" style="margin-top:8px;"></div>
                    </div>
                    <div class="f-group" id="receiveGroup">
                        <label class="f-label required">수령 방법</label>
                        <div class="choice-row">
                            <label class="choice">
                            <input type="radio" name="receive_type" value="visit" checked required>
                            <span>방문 수령</span>
                            </label>
                            <!-- <label class="choice">
                            <input type="radio" name="receive_type" disable value="delivery">
                            <span>택배 수령</span>
                            </label> -->
                        </div>
                        <p class="muted small" style="margin-top:8px;">
                            현재는 <b>방문 수령</b>만 가능합니다. <br>(택배 수령은 추후 제공)
                        </p>
                    </div>
                    <div class="f-group is-disabled" id="referralGroup">
                        <label class="f-label required" for="referral">추천인 아이디</label>

                        <div class="addr-row">
                            <input id="referral" name="referral" class="f-input" type="text" placeholder="추천인 아이디를 입력해주세요" required>
                            <!-- <button type="button" class="btn-zip" id="referralCheckBtn">조회</button> -->
                        </div>

                        <div id="referralMsg" class="muted small" style="margin-top:8px;"></div>

                        <!-- 본인 확인(재입력) -->
                        <!-- <div style="margin-top:12px;">
                            <label class="f-label required" for="referral_confirm">추천인 아이디 재확인</label>
                            <div class="addr-row">
                                 <input id="referral_confirm" name="referral_confirm" class="f-input" type="text" placeholder="한번 더 동일하게 입력해주세요" required>
                            </div>
                            <div id="referralConfirmMsg" class="muted small" style="margin-top:8px;"></div>
                        </div> -->

                        <div class="muted small" style="margin-top:10px; color:#e11d48; font-size:14px;font-weight:700;">
                            ※ 추천인은 <u>등록(신청 완료) 후 절대 변경 불가</u>합니다.
                        </div>
                        <input type="hidden" name="referral_checked" id="referral_checked" value="0">
                    </div>
                    <!-- 하단 고정 버튼 -->
                    <div class="form-actions">
                        <?php
                        $error = $_GET['error'] ?? null;

                        if ($error === '1005') {
                            echo '<p style="padding-bottom:5%;text-align:center;margin:auto 0;color:#f44;font-size:18px;">이미 신청하였습니다.</p>';
                        } elseif ($error === '5001') {
                            echo '<p style="padding-bottom:5%;text-align:center;margin:auto 0;color:#f44;font-size:18px;">잔액이 부족합니다.</p>';
                        } elseif ($error === '4001') {
                            echo '<p style="padding-bottom:5%;text-align:center;margin:auto 0;color:#f44;font-size:18px;">존재하지 않는 추천인입니다.</p>';
                        } elseif ($error === '1006') {
                            echo '<p style="padding-bottom:5%;text-align:center;margin:auto 0;color:#f44;font-size:18px;">이미 동일한 연락처가 존재합니다.</p>';
                        }elseif ($error === 'name_required') {
                            echo '<p style="padding-bottom:5%;text-align:center;margin:auto 0;color:#f44;font-size:18px;">이름을 입력해 주세요.</p>';
                        } elseif ($error === 'name_invalid') {
                            echo '<p style="padding-bottom:5%;text-align:center;margin:auto 0;color:#f44;font-size:18px;">이름은 한글 또는 영문만 입력할 수 있습니다.<br>(숫자/특수문자 불가)</p>';
                        } elseif ($error === 'address_required') {
                            echo '<p style="padding-bottom:5%;text-align:center;margin:auto 0;color:#f44;font-size:18px;">배송지를 입력해 주세요.</p>';
                        } elseif ($error === 'phone_required') {
                            echo '<p style="padding-bottom:5%;text-align:center;margin:auto 0;color:#f44;font-size:18px;">전화번호를 입력해 주세요.</p>';
                        } elseif ($error === 'phone_invalid') {
                            echo '<p style="padding-bottom:5%;text-align:center;margin:auto 0;color:#f44;font-size:18px;">전화번호 형식이 올바르지 않습니다.</p>';
                        } elseif ($error === 'referral') {
                            echo '<p style="padding-bottom:5%;text-align:center;margin:auto 0;color:#f44;font-size:18px;">추천인을 입력해주세요.</p>';
                        } elseif ($error === 'api_fail') {
                            echo '<p style="padding-bottom:5%;text-align:center;margin:auto 0;color:#f44;font-size:18px;">서버 통신에 실패했습니다. <br>잠시 후 다시 시도해주세요.</p>';
                        } elseif ($error === 'api_parse') {
                            echo '<p style="padding-bottom:5%;text-align:center;margin:auto 0;color:#f44;font-size:18px;">서버 응답 처리 중 오류가 발생했습니다.</p>';
                        } elseif ($error === 'api_unknown') {
                            echo '<p style="padding-bottom:5%;text-align:center;margin:auto 0;color:#f44;font-size:18px;">신청 처리에 실패했습니다. <br>다시 시도해주세요.</p>';
                        } elseif ($error === 'login') {
                            echo '<p style="padding-bottom:5%;text-align:center;margin:auto 0;color:#f44;font-size:18px;">로그인이 필요합니다.</p>';
                        }
                        ?>
                        <!-- <button class="apply-submit" type="submit" disabled> -->
                        <button class="apply-submit" type="submit" >
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

            const referralInput = document.getElementById('referral');
            const referralConfirm = document.getElementById('referral_confirm');
            const referralCheckBtn = document.getElementById('referralCheckBtn');
            const referralMsg = document.getElementById('referralMsg');
            const referralConfirmMsg = document.getElementById('referralConfirmMsg');
            const referralCheckedHidden = document.getElementById('referral_checked');

            function setMsg(el, text, ok){
                el.textContent = text || '';
                el.style.color = ok ? '#16a34a' : '#ef4444';
                el.style.fontWeight = '700';
            }
            function normalizeId(v){
                return (v || '').trim();
            }
            function checkReferralConfirm(){
                const a = normalizeId(referralInput.value);
                const b = normalizeId(referralConfirm.value);

                if(!b){
                referralConfirmMsg.textContent = '';
                toggleSubmit();
                return;
                }

                if(a === b){
                setMsg(referralConfirmMsg, '재확인 완료: 동일합니다.', true);
                }else{
                setMsg(referralConfirmMsg, '추천인 아이디가 일치하지 않습니다.', false);
                }
                toggleSubmit();
            }
            
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
            
            async function checkReferral(){
                const id = normalizeId(referralInput.value);
                referralCheckedHidden.value = '0';
                submitBtn.disabled = true;

                if(!id){
                setMsg(referralMsg, '추천인 아이디를 입력해주세요.', false);
                toggleSubmit();
                return;
                }

                setMsg(referralMsg, '조회 중...', true);

                try{
                // ✅ 여기에 추천인 조회 API를 연결
                const res = await fetch('/referral-check.php', {
                    method: 'POST',
                    headers: {'Content-Type':'application/json'},
                    body: JSON.stringify({ referral: id })
                });
                const data = await res.json();

                if(data.ok){
                    setMsg(referralMsg, `확인 완료: ${data.name ? data.name+' ('+id+')' : id} 추천인 등록 가능합니다.`, true);
                    referralCheckedHidden.value = '1';
                }else{
                    setMsg(referralMsg, data.message || '해당 추천인 아이디가 회원 명단에 없습니다. 추천인 등록 불가능합니다.', false);
                    referralCheckedHidden.value = '0';
                }
                }catch(e){
                setMsg(referralMsg, '조회 실패: 잠시 후 다시 시도해주세요.', false);
                referralCheckedHidden.value = '0';
                }

                toggleSubmit();
            }

            function toggleSubmit(){
                // 1) required 텍스트/전화번호/hidden 등: 값 있는지 체크
                const requiredInputs = form.querySelectorAll('input[required]:not([type="radio"])');
                const allFilled = Array.from(requiredInputs).every(inp => inp.value.trim().length > 0);

                // 2) required 라디오 그룹: 선택되어 있는지 체크
                const requiredRadios = form.querySelectorAll('input[type="radio"][required]');
                let radioOk = true;
                if (requiredRadios.length) {
                const radioNames = [...new Set(Array.from(requiredRadios).map(r => r.name))];
                radioOk = radioNames.every(name => !!form.querySelector(`input[name="${name}"]:checked`));
                }

                submitBtn.disabled = !(allFilled && radioOk);
            }

            form.querySelectorAll('.f-input').forEach(inp=>{
                const group = inp.parentElement;
                inp.addEventListener('focus', ()=> group.classList.add('is-focus'));
                inp.addEventListener('blur',  ()=> group.classList.remove('is-focus'));
            });

            // 추천인 관련 이벤트
            referralCheckBtn.addEventListener('click', checkReferral);

            // 추천인 값이 바뀌면 “조회 다시” 강제
            referralInput.addEventListener('input', ()=>{
                referralCheckedHidden.value = '0';
                referralMsg.textContent = '';
                checkReferralConfirm();
                toggleSubmit();
            });

            referralConfirm.addEventListener('input', checkReferralConfirm);

            // 기존 이벤트
            form.addEventListener('input', ()=>{ toggleDisabledState(); toggleSubmit(); });
            form.addEventListener('change', ()=>{ toggleDisabledState(); toggleSubmit(); });

            toggleDisabledState(); 
            toggleSubmit();



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
