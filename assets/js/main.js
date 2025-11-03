const $root = document.documentElement;
const $burger = document.querySelector('[data-burger]');
const $backdrop = document.querySelector('[data-backdrop]');
function toggleNav(open) {
  if (open) {
    document.body.classList.add('nav-open');
  } else {
    document.body.classList.remove('nav-open');
  }
}
if ($burger)
  $burger.addEventListener('click', () =>
    toggleNav(!document.body.classList.contains('nav-open'))
  );
if ($backdrop) $backdrop.addEventListener('click', () => toggleNav(false));

const $ = (sel, ctx = document) => ctx.querySelector(sel);
const $$ = (sel, ctx = document) => [...ctx.querySelectorAll(sel)];

const on = (el, ev, fn) => el.addEventListener(ev, fn);

on(document, 'click', (e) => {
  if (e.target.matches('[data-open-menu]')) {
    document.body.classList.add('menu-open');
  }
  if (e.target.matches('[data-close-menu]')) {
    document.body.classList.remove('menu-open');
  }
});

// drawer
function initDrawer() {
  const burger = $('[data-burger]');
  const backdrop = $('.backdrop');
  const drawer = $('.drawer');
  const open = () => {
    backdrop?.classList.add('is-open');
    drawer?.classList.add('is-open');
  };
  const close = () => {
    backdrop?.classList.remove('is-open');
    drawer?.classList.remove('is-open');
  };
  on(burger, 'click', open);
  on(backdrop, 'click', close);
  on(document, 'keydown', (e) => e.key === 'Escape' && close());
}

document.addEventListener('DOMContentLoaded', () => {
  initDrawer();
});

document.addEventListener('DOMContentLoaded', () => {
  const tabs = [...document.querySelectorAll('.tabbar .tab')];
  const isCard = (t) => t.classList.contains('tab--card');

  // 초기: 카드 탭 제외하고 기본 src/선택 src 준비
  tabs.forEach((t) => {
    if (isCard(t)) return;
    const img = t.querySelector('img');
    if (!img) return;
    const src = img.getAttribute('src');
    t.dataset.normal = src;
    t.dataset.selected = src.replace('.svg', '-sel.svg'); // 파일 규칙: xxx.svg ↔ xxx-sel.svg
  });

  // 클릭 처리
  tabs.forEach((t) => {
    t.addEventListener('click', (e) => {
      // 카드 탭은 항상 고정 상태이므로 클릭해도 스타일 변경 없음(필요하면 내비게이션만)
      if (isCard(t)) return;

      // 나머지 4개만 상태 토글
      tabs.forEach((other) => {
        if (isCard(other)) return; // 카드 탭 건드리지 않음
        other.classList.remove('is-current');
        const i = other.querySelector('img');
        if (i && other.dataset.normal) i.src = other.dataset.normal;
      });

      t.classList.add('is-current');
      const img = t.querySelector('img');
      if (img && t.dataset.selected) img.src = t.dataset.selected;
    });
  });

  // 필요시: 초기 선택값 지정(예: '검색')
  const first = tabs.find((t) => !isCard(t));
  if (first) {
    first.classList.add('is-current');
    const img = first.querySelector('img');
    if (img) img.src = first.dataset.selected;
  }
});
