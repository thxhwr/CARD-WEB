<?php $pageTitle = "로그인"; ?>
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
            <h1 class="appbar__title">로그인</h1>
            <a href="/index.php" class="nav-btn home-btn" aria-label="홈"><img src="/assets/icons/icon-home.svg"></a>
        </nav>
    </header>

    <main class="page">
        <section class="container--narrow">

            <div class="login-logo">
                <img src="/assets/icons/logo-h.svg" alt="">
                <p>땡스딜에 오신 것을 환영합니다.</p>
            </div>

            <form id="loginForm" class="login-form" autocomplete="off" >
                <div class="f-group login-id">
                    <input type="text" name="id" id="login_id" class=" f-input" placeholder="아이디 입력" required>
                </div>

                <div class="f-group login-pw">
                    <input type="password"  name="pw" id="login_pw" class=" f-input" placeholder="비밀번호 입력" required>
                </div>

                <button class="btn-submit" type="submit">로그인</button>

                <div class="login-options">
                    <div class="login-keep">
                        <input type="checkbox" id="keepLogin" hidden>
                        <label for="keepLogin" class="keep-label">로그인 상태 유지</label>
                    </div>
                    <div class="login-keep">
                        <a href="#" class="find-link">아이디/비밀번호 찾기</a>
                        <img src="/assets/icons/btn-next-arrow-right-g.png">
                    </div>    
                </div>
            </form>
            <p id="loginError" style="color:#f44; font-size:12px; display:none;"></p>
            <p class="copyright">© THX Deal Corp.</p>

        </section>
    </main>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', async function(e) {
  e.preventDefault();

  const id = document.getElementById('login_id').value.trim();
  const pw = document.getElementById('login_pw').value.trim();
  const errorBox = document.getElementById('loginError');
  errorBox.style.display = 'none';

  const formData = new FormData();
  formData.append('memberId', id);
  formData.append('memberPw', pw);

  try {
    const res = await fetch('https://api.thxdeal.com/api/login/memberLogin.php', {
      method: 'POST',
      body: formData,
    });

    if (!res.ok) throw new Error("HTTP 오류: " + res.status);

    const data = await res.json();
    console.log(data);

    // 여기는 API 응답 구조에 맞게 수정해야 함
    if (data.result === "OK") {
      // (필요하면) 로컬 저장
    //   localStorage.setItem("loginToken", data.token || "");

    //   // 성공 후 이동
    //   window.location.href = "/mypage.php";
        console.log(data);
    } else {
      errorBox.textContent = data.message || "아이디 또는 비밀번호가 올바르지 않습니다.";
      errorBox.style.display = 'block';
    }

  } catch (err) {
    console.error(err);
    errorBox.textContent = "로그인 중 오류가 발생했습니다.";
    errorBox.style.display = 'block';
  }
});
</script>

</body>
</html>
