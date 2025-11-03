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
  const tabs = document.querySelectorAll('.tabbar .tab');

  tabs.forEach((tab) => {
    const img = tab.querySelector('img');
    if (!img) return;

    const src = img.getAttribute('src');

    // 일반 버전 & 선택 버전 경로 만들기
    const selectedSrc = src.replace('.svg', '-sel.svg');

    // 활성 상태면 → 선택 아이콘 적용
    if (tab.classList.contains('is-active')) {
      img.setAttribute('src', selectedSrc);
    }

    // 클릭 시 탭 전환
    tab.addEventListener('click', () => {
      tabs.forEach((t) => {
        t.classList.remove('is-active');
        const i = t.querySelector('img');
        if (i) {
          const normal = i.getAttribute('src').replace('-sel.svg', '.svg');
          i.setAttribute('src', normal);
        }
      });

      tab.classList.add('is-active');
      img.setAttribute('src', selectedSrc);
    });
  });
});
