<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Harris Thermal Transfer Products — ASME-Certified Industrial Fabrication Since 1885</title>
<meta name="description" content="Harris Thermal designs and fabricates custom TEMA shell and tube heat exchangers, ASME code pressure vessels, evaporators, and other industrial equipment. Serving customers worldwide since 1885.">
<link rel="icon" href="/sites/harristhermal/wp-content/uploads/2021/10/cropped-favicon-32x32.png" sizes="32x32">
<link rel="icon" href="/sites/harristhermal/wp-content/uploads/2021/10/cropped-favicon-192x192.png" sizes="192x192">
<style>
:root{
  --navy:#021a47;
  --navy-2:#04255f;
  --blue:#0e51a1;
  --blue-bright:#1d6fd1;
  --ink:#1a2333;
  --muted:#5a6577;
  --line:#e3e8f0;
  --bg-soft:#f4f6fa;
  --white:#ffffff;
  --radius:14px;
  --shadow:0 10px 30px rgba(2,26,71,.10);
  --shadow-lg:0 24px 60px rgba(2,26,71,.18);
}
*{margin:0;padding:0;box-sizing:border-box}
html{scroll-behavior:smooth}
body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;color:var(--ink);line-height:1.65;background:var(--white);-webkit-font-smoothing:antialiased}
img{max-width:100%;display:block}
a{color:var(--blue);text-decoration:none}
a:hover{color:var(--blue-bright)}
.wrap{max-width:1200px;margin:0 auto;padding:0 24px}

/* ===== Top utility bar ===== */
.topbar{background:var(--navy);color:#c8d4ea;font-size:.82rem;padding:7px 0;border-bottom:1px solid rgba(255,255,255,.08)}
.topbar .wrap{display:flex;justify-content:space-between;align-items:center;gap:16px}
.topbar a{color:#fff;font-weight:600}
.topbar .certs{letter-spacing:.06em;text-transform:uppercase}
@media(max-width:700px){.topbar .certs{display:none}.topbar .wrap{justify-content:center}}

/* ===== Header / Nav ===== */
header.site{position:sticky;top:0;z-index:100;background:rgba(2,26,71,.92);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);box-shadow:0 2px 20px rgba(0,0,0,.25)}
.nav{display:flex;align-items:center;justify-content:space-between;height:74px}
.brand img{width:220px;height:auto}
nav.main{display:flex;align-items:center;gap:2px}
nav.main>ul{display:flex;list-style:none;gap:2px}
nav.main>ul>li{position:relative}
nav.main>ul>li>a{display:block;padding:26px 14px;color:#eaf0fa;font-weight:600;font-size:.92rem;letter-spacing:.01em;transition:color .15s;position:relative}
nav.main>ul>li>a:hover{color:#fff}
nav.main>ul>li>a::after{content:"";position:absolute;left:14px;right:14px;bottom:16px;height:2px;background:var(--blue-bright);transform:scaleX(0);transition:transform .2s;transform-origin:left}
nav.main>ul>li:hover>a::after{transform:scaleX(1)}
nav.main .sub{position:absolute;top:100%;left:0;min-width:250px;background:#fff;border-radius:0 0 12px 12px;box-shadow:var(--shadow-lg);list-style:none;padding:8px 0;opacity:0;visibility:hidden;transform:translateY(8px);transition:all .18s}
nav.main li:hover>.sub{opacity:1;visibility:visible;transform:translateY(0)}
nav.main .sub a{display:block;padding:9px 20px;color:var(--ink);font-size:.9rem;font-weight:500}
nav.main .sub a:hover{background:var(--bg-soft);color:var(--blue)}
.cta-btn{display:inline-block;background:var(--blue-bright);color:#fff!important;font-weight:700;padding:11px 22px;border-radius:8px;font-size:.9rem;margin-left:14px;transition:background .15s,transform .15s;box-shadow:0 4px 14px rgba(29,111,209,.35)}
.cta-btn:hover{background:#2b7fe3;transform:translateY(-1px)}
.hamburger{display:none;background:none;border:0;cursor:pointer;padding:10px}
.hamburger span{display:block;width:26px;height:3px;background:#fff;margin:5px 0;border-radius:2px;transition:.2s}
@media(max-width:1020px){
  nav.main{display:none}
  .hamburger{display:block}
}

/* ===== Mobile menu ===== */
.mobile-menu{display:none;background:var(--navy-2);border-top:1px solid rgba(255,255,255,.08);max-height:calc(100vh - 74px);overflow-y:auto}
.mobile-menu.open{display:block}
.mobile-menu a{display:block;padding:13px 24px;color:#eaf0fa;font-weight:600;border-bottom:1px solid rgba(255,255,255,.06)}
.mobile-menu details{border-bottom:1px solid rgba(255,255,255,.06)}
.mobile-menu summary{padding:13px 24px;color:#eaf0fa;font-weight:600;cursor:pointer;list-style:none;display:flex;justify-content:space-between;align-items:center}
.mobile-menu summary::after{content:"+";font-size:1.2rem;color:#8fb4e8}
.mobile-menu details[open] summary::after{content:"–"}
.mobile-menu details a{padding-left:40px;font-weight:500;font-size:.92rem;border-bottom:0}

/* ===== Hero ===== */
.hero{position:relative;min-height:640px;display:flex;align-items:center;color:#fff;overflow:hidden;isolation:isolate}
.hero .slide{position:absolute;inset:0;background-size:cover;background-position:center;opacity:0;transition:opacity 1.6s ease;z-index:-2;transform:scale(1.04);animation:kenburns 14s ease-in-out infinite alternate}
.hero .slide.active{opacity:1}
@keyframes kenburns{from{transform:scale(1.04)}to{transform:scale(1.12)}}
.hero::after{content:"";position:absolute;inset:0;background:linear-gradient(100deg,rgba(2,26,71,.92) 0%,rgba(2,26,71,.72) 45%,rgba(2,26,71,.25) 100%);z-index:-1}
.hero-inner{padding:110px 0 130px;max-width:680px}
.eyebrow{display:inline-block;font-size:.8rem;font-weight:700;letter-spacing:.16em;text-transform:uppercase;color:#9dc1f5;background:rgba(29,111,209,.18);border:1px solid rgba(157,193,245,.35);padding:7px 16px;border-radius:999px;margin-bottom:22px}
.hero h1{font-size:clamp(2.2rem,4.6vw,3.6rem);line-height:1.12;font-weight:800;letter-spacing:-.02em;margin-bottom:20px}
.hero h1 em{font-style:normal;color:#7db4f7}
.hero p.lead{font-size:1.13rem;color:#d5e0f2;max-width:560px;margin-bottom:34px}
.hero-ctas{display:flex;gap:14px;flex-wrap:wrap}
.btn{display:inline-block;font-weight:700;padding:15px 30px;border-radius:9px;font-size:1rem;transition:transform .15s,box-shadow .15s,background .15s}
.btn-primary{background:var(--blue-bright);color:#fff;box-shadow:0 6px 20px rgba(29,111,209,.45)}
.btn-primary:hover{background:#2b7fe3;color:#fff;transform:translateY(-2px)}
.btn-ghost{background:rgba(255,255,255,.1);color:#fff;border:1px solid rgba(255,255,255,.35);backdrop-filter:blur(4px)}
.btn-ghost:hover{background:rgba(255,255,255,.18);color:#fff;transform:translateY(-2px)}
.hero-dots{position:absolute;bottom:34px;left:50%;transform:translateX(-50%);display:flex;gap:10px;z-index:2}
.hero-dots button{width:34px;height:4px;border-radius:2px;border:0;background:rgba(255,255,255,.3);cursor:pointer;transition:background .2s}
.hero-dots button.active{background:#fff}

/* ===== Stats band ===== */
.stats{background:transparent;position:relative;z-index:5}
.stats .wrap{display:grid;grid-template-columns:repeat(4,1fr);gap:1px;background:var(--line);border:1px solid var(--line);border-radius:var(--radius);overflow:hidden;margin-top:-58px;box-shadow:var(--shadow-lg)}
.stat{background:#fff;padding:30px 20px;text-align:center}
.stat .num{font-size:2.1rem;font-weight:800;color:var(--navy);letter-spacing:-.02em}
.stat .lbl{font-size:.85rem;color:var(--muted);font-weight:600;letter-spacing:.04em;text-transform:uppercase;margin-top:4px}
@media(max-width:800px){.stats .wrap{grid-template-columns:repeat(2,1fr)}}

/* ===== Sections ===== */
section.block{padding:96px 0}
section.block.soft{background:var(--bg-soft)}
.sec-head{max-width:720px;margin:0 auto 56px;text-align:center}
.sec-head .kicker{font-size:.8rem;font-weight:700;letter-spacing:.16em;text-transform:uppercase;color:var(--blue-bright);margin-bottom:12px}
.sec-head h2{font-size:clamp(1.8rem,3.2vw,2.5rem);font-weight:800;letter-spacing:-.02em;color:var(--navy);line-height:1.18;margin-bottom:16px}
.sec-head p{color:var(--muted);font-size:1.05rem}

/* Who we are split */
.split{display:grid;grid-template-columns:1.05fr 1fr;gap:64px;align-items:center}
.split .kicker{font-size:.8rem;font-weight:700;letter-spacing:.16em;text-transform:uppercase;color:var(--blue-bright);margin-bottom:12px}
.split h2{font-size:clamp(1.8rem,3vw,2.4rem);font-weight:800;letter-spacing:-.02em;color:var(--navy);line-height:1.18;margin-bottom:18px}
.split p{color:var(--muted);margin-bottom:16px}
.split ul.checks{list-style:none;margin:22px 0 28px;display:grid;grid-template-columns:1fr 1fr;gap:12px 24px}
.split ul.checks li{position:relative;padding-left:30px;font-weight:600;font-size:.95rem;color:var(--ink)}
.split ul.checks li::before{content:"";position:absolute;left:0;top:3px;width:19px;height:19px;border-radius:50%;background:var(--blue-bright);
  -webkit-mask:url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="black" d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20zm-1.2 14.4-4-4 1.6-1.6 2.4 2.4 5.2-5.2 1.6 1.6-6.8 6.8z"/></svg>') center/contain no-repeat;
  mask:url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="black" d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20zm-1.2 14.4-4-4 1.6-1.6 2.4 2.4 5.2-5.2 1.6 1.6-6.8 6.8z"/></svg>') center/contain no-repeat}
.photo-stack{position:relative}
.photo-stack .main-img{border-radius:var(--radius);box-shadow:var(--shadow-lg);width:100%;height:460px;object-fit:cover}
.photo-stack .badge{position:absolute;left:-26px;bottom:32px;background:var(--navy);color:#fff;border-radius:12px;padding:20px 26px;box-shadow:var(--shadow-lg)}
.photo-stack .badge .b-num{font-size:1.7rem;font-weight:800;color:#7db4f7}
.photo-stack .badge .b-lbl{font-size:.8rem;letter-spacing:.08em;text-transform:uppercase;color:#c8d4ea}
@media(max-width:920px){.split{grid-template-columns:1fr;gap:44px}.photo-stack .badge{left:16px}}

/* Cards */
.cards{display:grid;grid-template-columns:repeat(3,1fr);gap:28px}
.card{background:#fff;border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow);border:1px solid var(--line);transition:transform .2s,box-shadow .2s;display:flex;flex-direction:column}
.card:hover{transform:translateY(-6px);box-shadow:var(--shadow-lg)}
.card .thumb{height:210px;overflow:hidden}
.card .thumb img{width:100%;height:100%;object-fit:cover;transition:transform .4s}
.card:hover .thumb img{transform:scale(1.06)}
.card .body{padding:26px 26px 30px;display:flex;flex-direction:column;flex:1}
.card h3{font-size:1.25rem;font-weight:800;color:var(--navy);margin-bottom:10px;letter-spacing:-.01em}
.card p{color:var(--muted);font-size:.95rem;flex:1}
.card .more{margin-top:18px;font-weight:700;font-size:.92rem;color:var(--blue-bright)}
.card .more::after{content:" →";transition:margin .15s}
.card:hover .more::after{margin-left:4px}
@media(max-width:920px){.cards{grid-template-columns:1fr}}

/* Industry chips */
.chips{display:flex;flex-wrap:wrap;gap:12px;justify-content:center;max-width:900px;margin:0 auto}
.chip{background:#fff;border:1px solid var(--line);border-radius:999px;padding:10px 22px;font-weight:600;font-size:.92rem;color:var(--navy);transition:all .15s;box-shadow:0 2px 8px rgba(2,26,71,.05)}
.chip:hover{background:var(--navy);color:#fff;border-color:var(--navy);transform:translateY(-2px)}

/* Gallery */
.gallery{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
.gitem{position:relative;border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow);aspect-ratio:7/4;display:block}
.gitem img{width:100%;height:100%;object-fit:cover;transition:transform .4s}
.gitem:hover img{transform:scale(1.07)}
.gitem .cap{position:absolute;inset:auto 0 0 0;padding:36px 18px 14px;background:linear-gradient(transparent,rgba(2,26,71,.9));color:#fff;font-size:.88rem;font-weight:600;opacity:0;transform:translateY(8px);transition:all .25s}
.gitem:hover .cap{opacity:1;transform:translateY(0)}
@media(max-width:920px){.gallery{grid-template-columns:repeat(2,1fr)}}
@media(max-width:560px){.gallery{grid-template-columns:1fr}}

/* CTA band */
.cta-band{background:linear-gradient(115deg,var(--navy) 0%,var(--blue) 100%);color:#fff;padding:80px 0;position:relative;overflow:hidden}
.cta-band::before{content:"";position:absolute;right:-120px;top:-120px;width:420px;height:420px;border-radius:50%;background:rgba(255,255,255,.06)}
.cta-band::after{content:"";position:absolute;right:60px;bottom:-160px;width:320px;height:320px;border-radius:50%;background:rgba(255,255,255,.05)}
.cta-band .wrap{display:flex;justify-content:space-between;align-items:center;gap:32px;flex-wrap:wrap;position:relative;z-index:1}
.cta-band h2{font-size:clamp(1.7rem,3vw,2.3rem);font-weight:800;letter-spacing:-.02em;margin-bottom:8px}
.cta-band p{color:#c8d8f2;max-width:520px}

/* Footer */
footer.site{background:var(--navy);color:#b9c6dd;padding:70px 0 0;font-size:.93rem}
.f-grid{display:grid;grid-template-columns:1.4fr 1fr 1fr 1.2fr;gap:44px;padding-bottom:52px}
.f-grid img.f-logo{width:230px;margin-bottom:18px}
.f-grid h4{color:#fff;font-size:.85rem;letter-spacing:.12em;text-transform:uppercase;margin-bottom:18px}
.f-grid ul{list-style:none}
.f-grid ul li{margin-bottom:9px}
.f-grid a{color:#b9c6dd}
.f-grid a:hover{color:#fff}
.f-grid .tagline{font-style:italic;color:#8fa3c4;margin-top:6px}
.f-bottom{border-top:1px solid rgba(255,255,255,.1);padding:22px 0;display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap;font-size:.85rem;color:#8fa3c4}
.f-social{display:flex;gap:14px}
.f-social a{color:#b9c6dd;font-weight:600}
@media(max-width:920px){.f-grid{grid-template-columns:1fr 1fr}}
@media(max-width:560px){.f-grid{grid-template-columns:1fr}}

/* Scroll reveal */
.reveal{opacity:0;transform:translateY(26px);transition:opacity .7s ease,transform .7s ease}
.reveal.in{opacity:1;transform:none}
@media(prefers-reduced-motion:reduce){
  .reveal{opacity:1;transform:none;transition:none}
  .hero .slide{animation:none}
}
</style>

<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
(function () {
	var granted = false;
	try { granted = localStorage.getItem('cookie-consent') === 'accepted'; } catch (e) {}
	var state = granted ? 'granted' : 'denied';
	gtag('consent', 'default', {
		ad_storage: state,
		analytics_storage: state,
		ad_user_data: state,
		ad_personalization: state,
		functionality_storage: 'granted',
		security_storage: 'granted',
		wait_for_update: 500
	});
})();
</script>
<script id="google_gtagjs-js" src="https://www.googletagmanager.com/gtag/js?id=GT-NMLFZCD" async></script>
<script id="google_gtagjs-js-after">
window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}
gtag("set","linker",{"domains":["harristhermal.com"]});
gtag("js", new Date());
gtag("set", "developer_id.dZTNiMT", true);
gtag("config", "GT-NMLFZCD");
 window._googlesitekit = window._googlesitekit || {}; window._googlesitekit.throttledEvents = []; window._googlesitekit.gtagEvent = (name, data) => { var key = JSON.stringify( { name, data } ); if ( !! window._googlesitekit.throttledEvents[ key ] ) { return; } window._googlesitekit.throttledEvents[ key ] = true; setTimeout( () => { delete window._googlesitekit.throttledEvents[ key ]; }, 5 ); gtag( "event", name, { ...data, event_source: "site-kit" } ); }; 
//# sourceURL=google_gtagjs-js-after
</script>
<script id="googlesitekit-events-provider-optin-monster-js" src="/sites/harristhermal/wp-content/plugins/google-site-kit/dist/assets/js/googlesitekit-events-provider-optin-monster-132091ad0c1fac8ea7a5.js" defer></script>
<link rel='stylesheet' id='ht-site-widgets-css' href='/sites/harristhermal/wp-content/themes/generatepress-child/assets/css/site-widgets.css?v=1783621749' media='all' />
<script type="application/ld+json">{"@@context":"https://schema.org","@type":["Organization","LocalBusiness"],"@id":"/#organization","name":"Harris Thermal Transfer Products","url":"/","logo":"/sites/harristhermal/wp-content/uploads/2021/10/logo-for-light-background.png","description":"ASME U- and R-stamp certified industrial fabricator building custom TEMA shell and tube heat exchangers, ASME code pressure vessels, evaporators, and process equipment since 1885.","foundingDate":"1885","telephone":"+1-800-767-9507","address":{"@type":"PostalAddress","streetAddress":"615 S. Springbrook Road","addressLocality":"Newberg","addressRegion":"OR","postalCode":"97132","addressCountry":"US"},"geo":{"@type":"GeoCoordinates","latitude":45.3123,"longitude":-122.9585},"sameAs":["https://m.facebook.com/profile.php?id=122401714485102","https://www.linkedin.com/company/harris-thermal-transfer-products"],"knowsAbout":["ASME fabrication","TEMA shell and tube heat exchangers","pressure vessels","NQA-1 quality program","falling film evaporators","crystallizers","formaldehyde converters","high nickel alloy welding","titanium fabrication"]}</script>
<link rel="canonical" href="/">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Harris Thermal">
<meta property="og:title" content="Harris Thermal Transfer Products — ASME-Certified Industrial Fabrication Since 1885">
<meta property="og:url" content="/">
<meta property="og:image" content="/sites/harristhermal/wp-content/uploads/2022/06/harris_pressure_vessel-scaled.jpg">
<meta property="og:description" content="Harris Thermal designs and fabricates custom TEMA shell and tube heat exchangers, ASME code pressure vessels, evaporators, and other industrial equipment. Serving customers worldwide since 1885.">
</head>
<body>

<div class="topbar">
  <div class="wrap">
    <span class="certs">ASME U &amp; R Stamp&ensp;·&ensp;TEMA&ensp;·&ensp;NQA-1 Nuclear</span>
    <span>Call us: <a href="tel:800-767-9507">800-767-9507</a></span>
  </div>
</div>

<header class="site">
  <div class="wrap nav">
    <a class="brand" href="/"><img src="/sites/harristhermal/wp-content/uploads/2025/10/http-logo.png" alt="Harris Thermal" width="220" height="49"></a>
    <nav class="main" aria-label="Primary">
      <ul>
        <li><a href="/products-services/">Products &amp; Services</a>
          <ul class="sub">
            <li><a href="/shell-and-tube-heat-exchangers/">Shell &amp; Tube Heat Exchangers</a></li>
            <li><a href="/pressure-vessels-tanks/">Pressure Vessels / Tanks</a></li>
            <li><a href="/other-fabrication/">Other Fabrication</a></li>
            <li><a href="/machining-drilling/">Machining / Drilling</a></li>
            <li><a href="/repairs/">Repairs</a></li>
          </ul>
        </li>
        <li><a href="/capabilities/">Capabilities</a>
          <ul class="sub">
            <li><a href="/fabrication/">Fabrication</a></li>
            <li><a href="/machining/">Machining</a></li>
            <li><a href="/materials/">Materials</a></li>
            <li><a href="/engineering/">Engineering</a></li>
            <li><a href="/quality-control-safety/">Quality Control</a></li>
            <li><a href="/safety/">Safety</a></li>
            <li><a href="/logistics-and-shipping/">Logistics &amp; Shipping</a></li>
          </ul>
        </li>
        <li><a href="/industries-served/">Industries</a>
          <ul class="sub">
            <li><a href="/oil-and-gas-industry-solutions/">Oil &amp; Gas</a></li>
            <li><a href="/pulp-and-paper-industry-solutions/">Pulp &amp; Paper</a></li>
            <li><a href="/power-generation/">Power Generation</a></li>
            <li><a href="/water-treatment/">Water Treatment</a></li>
            <li><a href="/food-processing-equipment/">Food Processing</a></li>
            <li><a href="/mining-and-minerals-equipment/">Mining &amp; Minerals</a></li>
            <li><a href="/formaldehyde-converters-and-resin/">Formaldehyde &amp; Resins</a></li>
            <li><a href="/chemical-industry-equipment/">Chemical</a></li>
            <li><a href="/liquefied-natural-gas-equipment/">LNG</a></li>
            <li><a href="/nuclear/">Nuclear</a></li>
            <li><a href="/general-manufacturing-industry/">General Manufacturing</a></li>
          </ul>
        </li>
        <li><a href="/about-us/">About</a>
          <ul class="sub">
            <li><a href="/certifications/">Certifications</a></li>
            <li><a href="/employment/">Employment</a></li>
          </ul>
        </li>
        <li><a href="/resources/">Resources</a>
          <ul class="sub">
            <li><a href="/category/industry-insights/">Industry Insights</a></li>
            <li><a href="/harris-thermal-transfer-products-faqs/">FAQs</a></li>
          </ul>
        </li>
        <li><a href="/contact-us/">Contact</a></li>
      </ul>
      <a class="cta-btn" href="/get-a-quote/">Get a Quote</a>
    </nav>
    <button class="hamburger" aria-label="Menu" aria-expanded="false" onclick="toggleMenu(this)">
      <span></span><span></span><span></span>
    </button>
  </div>
  <div class="mobile-menu" id="mobileMenu">
    <details><summary>Products &amp; Services</summary>
      <a href="/products-services/">Overview</a>
      <a href="/shell-and-tube-heat-exchangers/">Shell &amp; Tube Heat Exchangers</a>
      <a href="/pressure-vessels-tanks/">Pressure Vessels / Tanks</a>
      <a href="/other-fabrication/">Other Fabrication</a>
      <a href="/machining-drilling/">Machining / Drilling</a>
      <a href="/repairs/">Repairs</a>
    </details>
    <details><summary>Capabilities</summary>
      <a href="/capabilities/">Overview</a>
      <a href="/fabrication/">Fabrication</a>
      <a href="/machining/">Machining</a>
      <a href="/materials/">Materials</a>
      <a href="/engineering/">Engineering</a>
      <a href="/quality-control-safety/">Quality Control</a>
      <a href="/safety/">Safety</a>
      <a href="/logistics-and-shipping/">Logistics &amp; Shipping</a>
    </details>
    <details><summary>Industries</summary>
      <a href="/industries-served/">Overview</a>
      <a href="/oil-and-gas-industry-solutions/">Oil &amp; Gas</a>
      <a href="/pulp-and-paper-industry-solutions/">Pulp &amp; Paper</a>
      <a href="/power-generation/">Power Generation</a>
      <a href="/water-treatment/">Water Treatment</a>
      <a href="/food-processing-equipment/">Food Processing</a>
      <a href="/mining-and-minerals-equipment/">Mining &amp; Minerals</a>
      <a href="/chemical-industry-equipment/">Chemical</a>
      <a href="/liquefied-natural-gas-equipment/">LNG</a>
      <a href="/nuclear/">Nuclear</a>
    </details>
    <details><summary>About</summary>
      <a href="/about-us/">About Us</a>
      <a href="/certifications/">Certifications</a>
      <a href="/employment/">Employment</a>
    </details>
    <a href="/resources/">Resources</a>
    <a href="/contact-us/">Contact</a>
    <a href="/get-a-quote/"><strong>Get a Quote →</strong></a>
  </div>
</header>

<!-- ===== Hero ===== -->
<section class="hero" id="hero">
  <div class="slide active" style="background-image:url('/sites/harristhermal/wp-content/uploads/2022/06/harris_pressure_vessel-scaled.jpg')"></div>
  <div class="slide" style="background-image:url('/sites/harristhermal/wp-content/uploads/2022/06/20180209_142912.jpg')"></div>
  <div class="slide" style="background-image:url('/sites/harristhermal/wp-content/uploads/2022/06/20211230_1348040-scaled.jpg')"></div>
  <div class="slide" style="background-image:url('/sites/harristhermal/wp-content/uploads/2022/08/DSC00773-1-scaled.jpg')"></div>
  <div class="wrap">
    <div class="hero-inner">
      <span class="eyebrow">ASME-Certified Fabrication · Since 1885</span>
      <h1>Custom industrial equipment, <em>built to handle the pressure.</em></h1>
      <p class="lead">Harris Thermal designs, builds, and repairs TEMA shell &amp; tube heat exchangers, ASME code pressure vessels, evaporators, and complete packaged systems — all fabricated in-house in Newberg, Oregon.</p>
      <div class="hero-ctas">
        <a class="btn btn-primary" href="/get-a-quote/">Get a Quote</a>
        <a class="btn btn-ghost" href="/products-services/">Explore Products &amp; Services</a>
      </div>
    </div>
  </div>
  <div class="hero-dots" id="heroDots"></div>
</section>

<!-- ===== Stats band ===== -->
<div class="stats">
  <div class="wrap">
    <div class="stat"><div class="num">1885</div><div class="lbl">Serving customers since</div></div>
    <div class="stat"><div class="num">50,000+</div><div class="lbl">Sq ft fabrication floor</div></div>
    <div class="stat"><div class="num">100%</div><div class="lbl">Built &amp; machined in-house</div></div>
    <div class="stat"><div class="num">12+</div><div class="lbl">Industries served</div></div>
  </div>
</div>

<!-- ===== Who we are ===== -->
<section class="block" id="who-we-are">
  <div class="wrap split">
    <div class="reveal">
      <div class="kicker">Who We Are</div>
      <h2>One trusted fabricator for your largest, most complex equipment.</h2>
      <p>Harris Thermal Transfer Products has served customers worldwide since 1885. We are an ASME-certified industrial fabricator with a passionate commitment to designing, building, and repairing custom equipment on time and with the highest level of quality.</p>
      <p>Our engineers, project managers, and craftsmen work directly with you to deliver economical designs in everything from stainless and duplex steels to nickel alloys, titanium, and zirconium — with complete packaged systems including structure, pumps, piping, and controls.</p>
      <ul class="checks">
        <li>TEMA shell &amp; tube heat exchangers</li>
        <li>ASME code pressure vessels</li>
        <li>Evaporators &amp; vapor bodies</li>
        <li>Columns, towers &amp; converters</li>
        <li>Storage tanks &amp; separators</li>
        <li>Complete packaged systems</li>
      </ul>
      <a class="btn btn-primary" href="/about-us/">More About Harris Thermal</a>
    </div>
    <div class="photo-stack reveal">
      <img class="main-img" src="/sites/harristhermal/wp-content/uploads/2022/06/20211229_093915-1024x768.jpg" alt="Heat exchanger fabrication at Harris Thermal" loading="lazy">
      <div class="badge">
        <div class="b-num">140+ yrs</div>
        <div class="b-lbl">Fabrication expertise</div>
      </div>
    </div>
  </div>
</section>

<!-- ===== What we do cards ===== -->
<section class="block soft" id="what-we-do">
  <div class="wrap">
    <div class="sec-head reveal">
      <div class="kicker">What We Do</div>
      <h2>Design. Fabricate. Repair.</h2>
      <p>Everything is fabricated on-site to exact customer specifications — so we control quality and timeline through the life of your project.</p>
    </div>
    <div class="cards">
      <a class="card reveal" href="/products-services/">
        <div class="thumb"><img src="/sites/harristhermal/wp-content/uploads/2022/06/20211229_093915-1024x768.jpg" alt="Shell and tube heat exchanger" loading="lazy"></div>
        <div class="body">
          <h3>Products &amp; Services</h3>
          <p>Shell-and-tube heat exchangers, pressure vessels, evaporators, reactors, condensers, columns, separators, storage tanks, skids, and mining equipment.</p>
          <span class="more">In-depth information</span>
        </div>
      </a>
      <a class="card reveal" href="/capabilities/">
        <div class="thumb"><img src="/sites/harristhermal/wp-content/uploads/2022/06/20180509_161521-1024x768.jpg" alt="Fabrication capabilities" loading="lazy"></div>
        <div class="body">
          <h3>Capabilities</h3>
          <p>Standard products plus fully custom builds — fabricated on-site from stainless steel, Hastelloy, Inconel, Monel, and other alloys to your exact specifications.</p>
          <span class="more">In-depth information</span>
        </div>
      </a>
      <a class="card reveal" href="/industries-served/">
        <div class="thumb"><img src="/sites/harristhermal/wp-content/uploads/2022/08/DSC00773-1-1024x768.jpg" alt="Industrial equipment installation" loading="lazy"></div>
        <div class="body">
          <h3>Industries Served</h3>
          <p>Proven experience across oil &amp; gas, pulp &amp; paper, power generation, water treatment, food processing, mining, chemical processing, and more.</p>
          <span class="more">In-depth information</span>
        </div>
      </a>
    </div>
  </div>
</section>

<!-- ===== Industries chips ===== -->
<section class="block" id="industries">
  <div class="wrap">
    <div class="sec-head reveal">
      <div class="kicker">Industries Served</div>
      <h2>Fabrication expertise across every process industry.</h2>
    </div>
    <div class="chips reveal">
      <a class="chip" href="/industries-served/#oil-gas">Oil &amp; Gas</a>
      <a class="chip" href="/industries-served/#pulp-paper">Pulp &amp; Paper</a>
      <a class="chip" href="/industries-served/#power-generation">Power Generation</a>
      <a class="chip" href="/industries-served/#renewable-energy">Renewable Fuels</a>
      <a class="chip" href="/industries-served/#waste-to-energy">Waste to Energy</a>
      <a class="chip" href="/industries-served/#water-treatment">Water Treatment / Desalination</a>
      <a class="chip" href="/industries-served/#food-processing">Food Processing</a>
      <a class="chip" href="/industries-served/#mining-minerals">Mining &amp; Minerals</a>
      <a class="chip" href="/industries-served/#chemical">Chemical</a>
      <a class="chip" href="/industries-served/#resins">Resins</a>
      <a class="chip" href="/industries-served/#liquid-natural-gas">LNG</a>
      <a class="chip" href="/nuclear/">Nuclear</a>
      <a class="chip" href="/industries-served/#general">General Industry</a>
    </div>
  </div>
</section>

<!-- ===== Gallery ===== -->
<section class="block soft" id="at-work">
  <div class="wrap">
    <div class="sec-head reveal">
      <div class="kicker">Harris Thermal At Work</div>
      <h2>Recent projects from our fabrication floor.</h2>
    </div>
    <div class="gallery">
      <a class="gitem reveal" href="/sites/harristhermal/wp-content/uploads/2022/08/DSC00773-scaled.jpg"><img src="/sites/harristhermal/wp-content/uploads/2022/08/DSC00773-scaled-700x300.jpg" alt="Evaporators installed onsite" loading="lazy"><span class="cap">Evaporators installed onsite — Nickel, Titanium, 6% Moly &amp; Duplex</span></a>
      <a class="gitem reveal" href="/sites/harristhermal/wp-content/uploads/2022/06/0421200209.jpg"><img src="/sites/harristhermal/wp-content/uploads/2022/06/0421200209-700x300.jpg" alt="Formaldehyde converter" loading="lazy"><span class="cap">Formaldehyde Converter for Resins Industry</span></a>
      <a class="gitem reveal" href="/sites/harristhermal/wp-content/uploads/2022/06/20180509_161521-scaled.jpg"><img src="/sites/harristhermal/wp-content/uploads/2022/06/20180509_161521-scaled-700x300.jpg" alt="Heat exchanger interior" loading="lazy"><span class="cap">Inside of Heat Exchanger prior to Tube Installation</span></a>
      <a class="gitem reveal" href="/sites/harristhermal/wp-content/uploads/2022/06/Vessel-Pictures-034-2.jpg"><img src="/sites/harristhermal/wp-content/uploads/2022/06/Vessel-Pictures-034-2-700x300.jpg" alt="U-tube bundles" loading="lazy"><span class="cap">U-Tube Bundles</span></a>
      <a class="gitem reveal" href="/sites/harristhermal/wp-content/uploads/2022/06/20220120_143930-rotated.jpg"><img src="/sites/harristhermal/wp-content/uploads/2022/06/20220120_143930-rotated-700x300.jpg" alt="Straight tube bundle assembly" loading="lazy"><span class="cap">Straight Tube Bundle Assembly</span></a>
      <a class="gitem reveal" href="/sites/harristhermal/wp-content/uploads/2022/06/Vessel-Pictures-044-7.jpg"><img src="/sites/harristhermal/wp-content/uploads/2022/06/Vessel-Pictures-044-7-700x300.jpg" alt="Knocked down evaporator" loading="lazy"><span class="cap">Large Knocked Down (KD) Evaporator</span></a>
      <a class="gitem reveal" href="/sites/harristhermal/wp-content/uploads/2022/06/20211229_094206-scaled.jpg"><img src="/sites/harristhermal/wp-content/uploads/2022/06/20211229_094206-scaled-700x300.jpg" alt="Multi-pass heat exchanger" loading="lazy"><span class="cap">Multi-Pass Heat Exchanger</span></a>
      <a class="gitem reveal" href="/sites/harristhermal/wp-content/uploads/2022/06/20211229_093743-1.jpg"><img src="/sites/harristhermal/wp-content/uploads/2022/06/20211229_093743-1-700x300.jpg" alt="Stainless steel heat exchanger" loading="lazy"><span class="cap">All Stainless-Steel Heat Exchanger</span></a>
      <a class="gitem reveal" href="/sites/harristhermal/wp-content/uploads/2022/06/20210302_085200-scaled.jpg"><img src="/sites/harristhermal/wp-content/uploads/2022/06/20210302_085200-scaled-700x300.jpg" alt="10ft diameter heater body" loading="lazy"><span class="cap">10ft. Diameter Heater Body for KD Evaporator</span></a>
    </div>
  </div>
</section>

<!-- ===== CTA band ===== -->
<section class="cta-band">
  <div class="wrap">
    <div class="reveal">
      <h2>Ready to start your next project?</h2>
      <p>Tell us about your application, timeline, and budget — our engineering team will help you get it built right the first time.</p>
    </div>
    <div class="hero-ctas reveal">
      <a class="btn btn-primary" href="/get-a-quote/">Get an Estimate</a>
      <a class="btn btn-ghost" href="/contact-us/">Contact Us</a>
    </div>
  </div>
</section>

<!-- ===== Footer ===== -->
<footer class="site">
  <div class="wrap">
    <div class="f-grid">
      <div>
        <img class="f-logo" src="/sites/harristhermal/wp-content/uploads/2025/10/http-logo.png" alt="Harris Thermal">
        <p class="tagline">Exceeding client expectations for over 100 years.</p>
      </div>
      <div>
        <h4>Services</h4>
        <ul>
          <li><a href="/shell-and-tube-heat-exchangers/">Shell &amp; Tube Heat Exchangers</a></li>
          <li><a href="/pressure-vessels-tanks/">Pressure Vessels / Tanks</a></li>
          <li><a href="/other-fabrication/">Other Fabrication</a></li>
          <li><a href="/machining-drilling/">Machining / Drilling</a></li>
          <li><a href="/repairs/">Repairs</a></li>
        </ul>
      </div>
      <div>
        <h4>Company</h4>
        <ul>
          <li><a href="/about-us/">About Us</a></li>
          <li><a href="/certifications/">Certifications</a></li>
          <li><a href="/industries-served/">Industries Served</a></li>
          <li><a href="/employment/">Employment</a></li>
          <li><a href="/category/industry-insights/">Industry Insights</a></li>
        </ul>
      </div>
      <div>
        <h4>Portland Metro</h4>
        <ul>
          <li>P.O. Box 820<br>615 S. Springbrook Road<br>Newberg, Oregon 97132</li>
          <li>TF: <a href="tel:800-767-9507">800-767-9507</a></li>
          <li>Tel: <a href="tel:503-538-1260">503-538-1260</a></li>
          <li>Fax: 503-538-4281</li>
          <li><a href="/get-a-quote/">Get an estimate →</a></li>
        </ul>
      </div>
    </div>
    <div class="f-bottom">
      <span>Copyright © Harris Thermal Transfer Products 2025 — All rights reserved.</span>
      <div class="f-social">
        <a href="https://m.facebook.com/profile.php?id=122401714485102">Facebook</a>
        <a href="https://www.linkedin.com/company/harris-thermal-transfer-products">LinkedIn</a>
        <a href="/contact-us/">Contact</a>
      </div>
    </div>
  </div>
</footer>

<script>
// Hero slideshow
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

// Mobile menu
function toggleMenu(btn){
  var m = document.getElementById('mobileMenu');
  var open = m.classList.toggle('open');
  btn.setAttribute('aria-expanded', open);
}

// Scroll reveal
(function(){
  if (!('IntersectionObserver' in window)) {
    document.querySelectorAll('.reveal').forEach(function(el){ el.classList.add('in'); });
    return;
  }
  var io = new IntersectionObserver(function(entries){
    entries.forEach(function(e){
      if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
    });
  }, {threshold: 0.12});
  document.querySelectorAll('.reveal').forEach(function(el){ io.observe(el); });
})();
</script>

<div id="cookie-consent" role="dialog" aria-live="polite" aria-label="Cookie consent" hidden>
	<p class="cc-text">
		We use cookies to analyze site traffic and improve your experience. You can
		accept analytics cookies or continue with only the cookies needed to run the site.
	</p>
	<div class="cc-actions">
		<button type="button" class="cc-btn cc-decline" id="cc-decline">Only Necessary</button>
		<button type="button" class="cc-btn cc-accept" id="cc-accept">Accept All</button>
	</div>
</div>
<script id="ht-cookie-consent-js" src="/sites/harristhermal/wp-content/themes/generatepress-child/assets/js/cookie-consent.js?v=1783621759"></script>
</body>
</html>
