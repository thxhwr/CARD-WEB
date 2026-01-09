<?php
session_start();

$pageTitle = "포인트내역";

require_once __DIR__ . "/auth.php";
require_once __DIR__ . "/head.php";
require_once __DIR__ . "/point-history-get.php";
?>
<!DOCTYPE html>
<html lang="ko">
<body>
<div class="app">

    <header class="appbar-apply">
        <nav class="appbar__inner container--narrow" aria-label="상단 내비게이션">
            <a href="./mypage.php" class="nav-btn" aria-label="뒤로가기">
                <img src="/assets/icons/btn-next-arrow-left-dg.svg" width="24" height="24" alt="">
            </a>
            <h1 class="appbar__title">포인트내역</h1>
            <a href="/index.php" class="nav-btn home-btn" aria-label="홈"></a>
        </nav>
    </header>

    <main class="page">
        <div class="point-wrap">

            <!-- 타입 탭: TP/SP/LP (GET으로 페이지 유지) -->
            <div class="point-type-tabs">
                <a class="<?= $type==='TP'?'active':'' ?>" href="?type=TP&io=<?= htmlspecialchars($io) ?>">TP</a>
                <a class="<?= $type==='SP'?'active':'' ?>" href="?type=SP&io=<?= htmlspecialchars($io) ?>">SP</a>
                <a class="<?= $type==='LP'?'active':'' ?>" href="?type=LP&io=<?= htmlspecialchars($io) ?>">LP</a>
            </div>

            <!-- 보유 포인트 -->
            <div class="point-summary">
                <p class="label">보유 포인트</p>
                <p class="amount">
                    <?= number_format($currentBalance) ?><span><?= htmlspecialchars($type, ENT_QUOTES) ?></span>
                </p>
            </div>

            <!-- 필터: 전체/적립/사용 (GET으로) -->
            <div class="point-filter">
                <a class="<?= $io==='all'?'active':'' ?>"   href="?type=<?= htmlspecialchars($type, ENT_QUOTES) ?>&io=all">전체</a>
                <a class="<?= $io==='IN'?'active':'' ?>"  href="?type=<?= htmlspecialchars($type, ENT_QUOTES) ?>&io=IN">적립</a>
                <a class="<?= $io==='OUT'?'active':'' ?>" href="?type=<?= htmlspecialchars($type, ENT_QUOTES) ?>&io=OUT">사용</a>
            </div>

            <?php if ($errorMsg): ?>
                <p class="error-text"><?= htmlspecialchars($errorMsg, ENT_QUOTES) ?></p>

            <?php elseif (empty($items)): ?>
                <p class="empty-text">내역이 없습니다.</p>

            <?php else: ?>
                <?php
                    if (!is_array($items)) $items = [];
                ?>
                <ul class="point-list" id="pointList">
                    <?php foreach ($items as $row): ?>
                        <?php
                            $action = strtoupper(trim($row['ACTION_TYPE'] ?? ''));
                            $isOut  = ($action === 'OUT');

                            $cls  = $isOut ? 'OUT' : 'IN';
                            $sign = $isOut ? '-' : '+';

                            $title     = $row['DESCRIPTION'] ?? '포인트';
                            $amount    = (int)($row['AMOUNT'] ?? 0);

                            $createdAt = $row['CREATED_AT'] ?? '';
                            $dateStr = $createdAt
                                        ? date('y-m-d', strtotime($createdAt))
                                        : '';

                            $balAfter  = $row['_BALANCE_AFTER'] ?? null;
                        ?>

                        <li class="p-item <?= $cls ?>">
                            <div class="left">
                                <p class="left-title"><?= htmlspecialchars($title, ENT_QUOTES) ?></p>
                                <p class="date"><?= htmlspecialchars($dateStr, ENT_QUOTES) ?></p>
                            </div>
                            <div class="right">
                                <p class="value"><?= $sign ?><?= number_format($amount) ?> <?= htmlspecialchars($type ,ENT_QUOTES)?></p>
                                <?php if ($balAfter !== null): ?>
                                    <p class="balance">잔액 <?= number_format((int)$balAfter) ?> <?= htmlspecialchars($type ,ENT_QUOTES)?></p>
                                <?php endif; ?>
                            </div>
                        </li>

                    <?php endforeach; ?>
                </ul>
                <button
                id="loadMoreBtn"
                data-page="2"
                data-type="<?= htmlspecialchars($type, ENT_QUOTES) ?>"
                data-io="<?= htmlspecialchars($io, ENT_QUOTES) ?>"
                data-limit="<?= (int)$limit ?>"
                >
                더보기
                </button>
            <?php endif; ?>

        </div>
    </main>

    <?php require_once __DIR__ . "/footer.php"; ?>
</div>
<style>
html, body{
  height:100%;
  margin:0;
  overflow:hidden;
}
.app{
  height:100vh;
  display:flex;
  flex-direction:column;
}
.appbar-apply{ flex: 0 0 auto; }
footer, .footer{ flex: 0 0 auto; }
.page{
  flex: 1 1 auto;
  min-height: 0;          
  overflow: hidden;         
}

.point-wrap{
  height: 100%;
  display:flex;
  flex-direction:column;
  min-height:0;           
}

.point-type-tabs,
.point-summary,
.point-filter{
  flex: 0 0 auto;
}

.point-list{
  flex: 1 1 auto;
  min-height: 0;              
  overflow-y: auto;
  -webkit-overflow-scrolling: touch;
  overscroll-behavior: contain;

  margin: 0;
  list-style: none;
}

.point-list::-webkit-scrollbar{ width:0; height:0; }

#loadMoreBtn {
  width: 100%;
  padding: 14px;
  margin: 20px 0;
  border-radius: 12px;
  border: 1px solid #ddd;
  background: #fff;
  font-weight: 600;
}
</style>
<script>
$(function () {
  $(document).on('click', '#loadMoreBtn', function () {
    const btn = $(this);

    const page  = parseInt(btn.data('page'), 10);
    const type  = btn.data('type');
    const io    = btn.data('io');
    const limit = parseInt(btn.data('limit'), 10);

    btn.prop('disabled', true).text('불러오는 중...');

    $.get('/point_history_more.php', { page, type, io, limit }, function (html) {
      if (!html || !html.trim()) {
        btn.text('더 이상 내역이 없습니다');
        return;
      }

      $('#pointList').append(html);
      btn.data('page', page + 1);
      btn.prop('disabled', false).text('더보기');
    }).fail(function(){
      btn.prop('disabled', false).text('더보기');
      alert('서버 통신 오류');
    });
  });
});
</script>

