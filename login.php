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

            <form id="loginForm" class="login-form" autocomplete="off">
                <div class="f-group login-id">
                    <input type="text" class=" f-input"  style="margin-bottom:10px" placeholder="아이디 입력" required>
                </div>

                <div class="f-group login-pw">
                    <input type="password"  class=" f-input" placeholder="비밀번호 입력" required>
                </div>

                <button class="btn-submit" type="submit">로그인</button>

                <div class="login-options">
                    <label class="keep-login">
                        <input type="checkbox"> 로그인 상태 유지
                    </label>
                    <a href="#" class="find-link">아이디/비밀번호 찾기 ></a>
                </div>
            </form>

            <p class="copyright">© THX Deal Corp.</p>

        </section>
    </main>

    <?php include __DIR__ . "/footer.php"; ?>
</div>
</body>
</html>
