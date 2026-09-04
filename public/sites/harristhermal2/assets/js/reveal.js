// Harris Thermal — scroll reveal for .px-reveal elements.
// EXTRACTED VERBATIM from V1, where this same IIFE is inlined at the end of
// <body> on every V1 page. Loaded with defer from <head> instead: a deferred
// script is fetched during parsing and executes the moment parsing ends, so it
// runs no later than the V1 inline copy and cannot flash un-revealed content.
(function(){
  if (!('IntersectionObserver' in window)) {
    document.querySelectorAll('.px-reveal').forEach(function(el){ el.classList.add('in'); });
    return;
  }
  var io = new IntersectionObserver(function(entries){
    entries.forEach(function(e){
      if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
    });
  }, {threshold: 0.12});
  document.querySelectorAll('.px-reveal').forEach(function(el){ io.observe(el); });
})();
