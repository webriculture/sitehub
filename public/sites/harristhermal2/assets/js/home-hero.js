// Harris Thermal — homepage hero slideshow: 4 slides, 6s autoplay, dot controls.
// EXTRACTED VERBATIM from the inline <script> at the end of V1's homepage body.
// Loaded with defer from <head> via the page's pageJs front-matter, so it runs
// the moment parsing ends - no later than V1's inline copy did.
//
// V1 also inlined a toggleMenu() and a scroll-reveal IIFE here. Both were
// duplicates of src/js/nav.js and src/js/reveal.js and are NOT carried
// forward; the shared copies drive the homepage now.
(function(){
  var slides = document.querySelectorAll('.hero .slide');
  var dotsBox = document.getElementById('heroDots');
  var idx = 0, timer;
  slides.forEach(function(_, i){
    var b = document.createElement('button');
    b.setAttribute('aria-label', 'Slide ' + (i+1));
    if (i === 0) b.classList.add('active');
    b.addEventListener('click', function(){ show(i); restart(); });
    dotsBox.appendChild(b);
  });
  var dots = dotsBox.querySelectorAll('button');
  function show(i){
    slides[idx].classList.remove('active');
    dots[idx].classList.remove('active');
    idx = i;
    slides[idx].classList.add('active');
    dots[idx].classList.add('active');
  }
  function next(){ show((idx + 1) % slides.length); }
  function restart(){ clearInterval(timer); timer = setInterval(next, 6000); }
  restart();
})();
