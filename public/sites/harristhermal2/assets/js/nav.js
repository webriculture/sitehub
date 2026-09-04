// Harris Thermal — modern chrome behavior (mobile menu)
function htToggleMenu(btn){
  var m = document.getElementById('htMobileMenu');
  var open = m.classList.toggle('ht-open');
  btn.setAttribute('aria-expanded', open);
}
