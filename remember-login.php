<?php
// 세션 비로그인 상태일 때만 자동 로그인 시도
if (!isset($_SESSION['user_No']) && !empty($_COOKIE['remember_me'])) {


    // 쿠키에서 selector, validator 구분
    [$selector, $validator] = explode(':', $_COOKIE['remember_me'], 2);

    // selector로 DB 조회
    $stmt = $pdo->prepare("
        SELECT user_No, validator_hash, expires_at 
        FROM remember_tokens 
        WHERE selector = ?
    ");
    $stmt->execute([$selector]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // 만료시간 확인
        if (strtotime($row['expires_at']) >= time()) {

            // validator 값 검증
            if (hash_equals($row['validator_hash'], hash('sha256', $validator))) {

                // 자동 로그인 성공 → 세션 생성
                $_SESSION['user_No'] = $row['user_No'];
                session_regenerate_id(true);

            } else {
                // 위조 시 토큰 삭제
                $pdo->prepare("DELETE FROM remember_tokens WHERE selector = ?")
                    ->execute([$selector]);
            }
        } else {
            // 만료 시 토큰 삭제
            $pdo->prepare("DELETE FROM remember_tokens WHERE selector = ?")
                ->execute([$selector]);
        }
    }
}
