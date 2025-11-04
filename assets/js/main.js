document.addEventListener('DOMContentLoaded', () => {
  const tabs = [...document.querySelectorAll('.tabbar .tab')];
  const isCard = (t) => t.classList.contains('tab--card');

  tabs.forEach((t) => {
    if (isCard(t)) return;
    const img = t.querySelector('img');
    if (!img) return;
    const src = img.getAttribute('src');
    t.dataset.normal = src;
    t.dataset.selected = src.replace('.svg', '-sel.svg'); // 파일 규칙: xxx.svg ↔ xxx-sel.svg
  });

  tabs.forEach((t) => {
    t.addEventListener('click', (e) => {
      if (isCard(t)) return;

      tabs.forEach((other) => {
        if (isCard(other)) return;
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
  const first = isCard();
  if (first) {
    first.classList.add('is-current');
    const img = first.querySelector('img');
    if (img) img.src = first.dataset.selected;
  }
});
