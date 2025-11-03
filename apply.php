<?php $pageTitle = "카드 신청"; ?>
<!doctype html>
<html lang="ko">
<head>
  <?php include __DIR__ . "/head.php"; ?>
</head>
<body>
    <div class="app">
    
        <header class="appbar-apply">
            <nav class="appbar__inner container--narrow" aria-label="상단 내비게이션">
                <a href="javascript:history.back()" class="nav-btn" aria-label="뒤로가기">
                    <img src="/assets/icons/btn-next-arrow-left-dg.svg" width="24px" height="24px">
                </a>
                <h1 class="appbar__title" style="font-size:16px;font-weight:500;margin:0;">카드 신청</h1>
                <a href="/index.php" class="nav-btn home-btn" aria-label="홈"><img src="/assets/icons/icon-home.svg"></a>
            </nav>
        </header>

        <!-- 본문 -->
        <main class="page">
            <section class="apply-form">

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
                        <label class="f-label required" for="ename">영문 이름</label>
                        <input id="ename" name="ename" class="f-input" type="text" placeholder="영문 이름을 입력해주세요" required>
                    </div>

                    <!-- 배송지 -->
                    <div class="f-group is-disabled">
                        <label class="f-label required" for="address">배송지</label>
                        <input id="address" name="address" class="f-input" type="text" placeholder="카드 배송을 받을 주소를 입력해주세요" required>
                    </div>

                    <!-- 연락처 -->
                    <div class="f-group is-disabled">
                        <label class="f-label required" for="phone">연락처</label>
                        <input id="phone" name="phone" class="f-input" type="tel" inputmode="tel" placeholder="카드 소유자 전화번호를 입력해주세요" pattern="[0-9\-]{9,20}" required>
                    </div>

                    <!-- 하단 고정 버튼 -->
                    <div class="form-actions">
                        <button class="btn-submit" type="submit" disabled onclick="location.href('apply-complete.php')">
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
            const submitBtn = form.querySelector('.btn-submit');

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
                e.preventDefault();
                alert("신청되었습니다.");
                location.href = "apply-complete.php";
            });
            })();

    </script>

</body>
</html>
