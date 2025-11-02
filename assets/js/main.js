const $root = document.documentElement;
const $burger = document.querySelector('[data-burger]');
const $backdrop = document.querySelector('[data-backdrop]');
function toggleNav(open){
  if(open){ document.body.classList.add('nav-open'); }
  else{ document.body.classList.remove('nav-open'); }
}
if($burger) $burger.addEventListener('click', ()=> toggleNav(!document.body.classList.contains('nav-open')));
if($backdrop) $backdrop.addEventListener('click', ()=> toggleNav(false));
