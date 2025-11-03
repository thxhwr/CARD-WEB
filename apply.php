<?php $pageTitle = "카드 신청"; ?>
<!doctype html>
<html lang="ko">
<head>
  <?php include __DIR__ . "/head.php"; ?>
</head>
<body>
    <div class="app">
    
        <header class="appbar">
            <nav class="appbar__inner container--narrow" aria-label="상단 내비게이션" style="display:flex;align-items:center;gap:10px;justify-content:space-between;width:100%;max-width:600px;padding:0 16px;">
                <a href="javascript:history.back()" class="nav-btn" aria-label="뒤로가기">‹</a>
                <h1 class="appbar__title" style="font-size:16px;font-weight:700;margin:0;">카드 신청</h1>
                <a href="/index.php" class="nav-btn" aria-label="홈"><img src="/assets/icons/ico-gnb-card-home.svg"></a>
            </nav>
        </header>

        <!-- 본문 -->
        <main class="page">
            <section class="container--narrow">

                <form id="cardApplyForm" class="form">
                    <div class="f-group is-disabled">
                        <label class="f-label required" for="userid">아이디</label>
                        <input id="userid" name="userid" class="f-input" type="text" placeholder="땡스페이 아이디를 입력해주세요" required>
                    </div>

                    <!-- 비밀번호 -->
                    <div class="f-group is-disabled">
                        <label class="f-label required" for="pin">비밀번호</label>
                        <input id="pin" name="pin" class="f-input" type="password" inputmode="numeric" placeholder="땡스페이 비밀번호를 입력해주세요" required>
                    </div>

                    <!-- 이름 -->
                    <div class="f-group is-disabled">
                        <label class="f-label required" for="name">이름</label>
                        <input id="name" name="name" class="f-input" type="text" placeholder="이름을 입력해주세요" required>
                    </div>

                    <!-- 영문 이름 -->
                    <div class="f-group is-disabled">
                        <label class="f-label" for="ename">영문 이름</label>
                        <input id="ename" name="ename" class="f-input" type="text" placeholder="영문 이름을 입력해주세요">
                    </div>

                    <!-- 배송지 -->
                    <div class="f-group is-disabled">
                        <label class="f-label" for="address">배송지</label>
                        <input id="address" name="address" class="f-input" type="text" placeholder="카드 배송을 받을 주소를 입력해주세요">
                    </div>

                    <!-- 연락처 -->
                    <div class="f-group is-disabled">
                        <label class="f-label" for="phone">연락처</label>
                        <input id="phone" name="phone" class="f-input" type="tel" inputmode="tel" placeholder="카드 소유자 전화번호를 입력해주세요" pattern="[0-9\-]{9,20}">
                    </div>

                    <!-- 하단 고정 버튼 -->
                    <div class="form-actions">
                        <button class="btn-submit" type="submit" disabled>
                        카드 신청
                        <img src="/assets/icons/btn-next-arrow-right-w@2x.png" alt="" width="16" height="16" style="display:block;object-fit:contain;">
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
        const required = form.querySelectorAll('[required]');
        const submitBtn = form.querySelector('.btn-submit');

        // 값이 있으면 is-filled 클래스 부여 → 포커스 없어도 주황 라인 유지
        function syncFilledState(){
            form.querySelectorAll('.f-group').forEach(g=>{
            const inp = g.querySelector('.f-input');
            if(!inp) return;
            if (inp.value.trim()) g.classList.add('is-filled');
            else g.classList.remove('is-filled');
            });
        }

        function toggleSubmit(){
            const ok = Array.from(required).every(i => i.value.trim().length > 0);
            submitBtn.disabled = !ok;
        }

        form.addEventListener('input', ()=>{ syncFilledState(); toggleSubmit(); });
        form.addEventListener('change', ()=>{ syncFilledState(); toggleSubmit(); });

        // 포커스 라인 효과(이미 :focus-within으로 충분하지만 깔끔하게)
        form.querySelectorAll('.f-input').forEach(inp=>{
            inp.addEventListener('focus', ()=> inp.parentElement.classList.add('is-focus'));
            inp.addEventListener('blur',  ()=> inp.parentElement.classList.remove('is-focus'));
        });

        // 초기 상태 반영
        syncFilledState(); toggleSubmit();

        // 데모 제출
        form.addEventListener('submit', (e)=>{
            e.preventDefault();
            alert('제출되었습니다 (데모).');
        }); 
    })();
</script>

</body>
</html>
