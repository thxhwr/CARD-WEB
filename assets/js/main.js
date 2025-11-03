const $root = document.documentElement;
const $burger = document.querySelector('[data-burger]');
const $backdrop = document.querySelector('[data-backdrop]');
function toggleNav(open){
  if(open){ document.body.classList.add('nav-open'); }
  else{ document.body.classList.remove('nav-open'); }
}
if($burger) $burger.addEventListener('click', ()=> toggleNav(!document.body.classList.contains('nav-open')));
if($backdrop) $backdrop.addEventListener('click', ()=> toggleNav(false));

const $ = (sel, ctx = document) => ctx.querySelector(sel);
const $$ = (sel, ctx = document) => [...ctx.querySelectorAll(sel)];


const on = (el, ev, fn) => el.addEventListener(ev, fn);

on(document, "click", (e) => {
  if (e.target.matches("[data-open-menu]")) {
    document.body.classList.add("menu-open");
  }
  if (e.target.matches("[data-close-menu]")) {
    document.body.classList.remove("menu-open");
  }
});
