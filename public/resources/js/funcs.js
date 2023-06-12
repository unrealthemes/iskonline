const $ = (el, item=document) => item.querySelector(el);
const $$ = (el, item=document) => item.querySelectorAll(el);

export {$, $$};