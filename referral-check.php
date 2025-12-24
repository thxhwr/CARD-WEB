<?php
header('Content-Type: application/json; charset=utf-8');

$raw = file_get_contents("php://input");
$body = json_decode($raw, true);

$referral = trim($body['referral'] ?? '');

if ($referral === '') {
  echo json_encode(['ok' => false, 'message' => '추천인 아이디가 비어있습니다.']);
  exit;
}

// DB 연결 (너 프로젝트 DB 연결 파일로 교체)
require_once __DIR__ . "/db.php"; // $pdo

try {
  $stmt = $pdo->prepare("SELECT name, accountNo FROM members WHERE accountNo = :id LIMIT 1");
  $stmt->execute([':id' => $referral]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($row) {
    echo json_encode([
      'ok' => true,
      'name' => $row['name'] ?? null,
      'accountNo' => $row['accountNo']
    ]);
  } else {
    echo json_encode([
      'ok' => false,
      'message' => '입력한 추천인 아이디가 회원 명단에 없습니다. 추천인 등록 불가능합니다.'
    ]);
  }
} catch (Exception $e) {
  echo json_encode(['ok' => false, 'message' => '서버 오류로 조회에 실패했습니다.']);
}
