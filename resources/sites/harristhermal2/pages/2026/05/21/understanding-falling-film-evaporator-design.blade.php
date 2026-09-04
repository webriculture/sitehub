<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1"><title>Understanding falling film evaporator design - Harris Thermal</title>
<meta name="description" content="Learn the mathematical and metallurgical realities of falling film evaporator design, from calculating minimum wetting rates to specifying high-nickel alloys.">
<meta name="robots" content="max-image-preview:large">
<link rel="icon" href="/sites/harristhermal2/wp-content/uploads/2021/10/cropped-favicon-32x32.png" sizes="32x32">
<link rel="icon" href="/sites/harristhermal2/wp-content/uploads/2021/10/cropped-favicon-192x192.png" sizes="192x192">
<link rel="stylesheet" href="/sites/harristhermal2/wp-content/uploads/generatepress/fonts/fonts.css" media="all">
<link rel="stylesheet" href="/sites/harristhermal2/assets/css/tokens.css">
<link rel="stylesheet" href="/sites/harristhermal2/assets/css/chrome.css">
<link rel="stylesheet" href="/sites/harristhermal2/assets/css/base.css">
<link rel="stylesheet" href="/sites/harristhermal2/assets/css/post.css">
<link rel="stylesheet" href="/sites/harristhermal2/assets/css/widgets.css">
<script src="/sites/harristhermal2/assets/js/nav.js" defer></script>
<script src="/sites/harristhermal2/assets/js/reveal.js" defer></script>
<script src="/sites/harristhermal2/assets/js/consent.js" defer></script>
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
<script src="https://www.googletagmanager.com/gtag/js?id=GT-NMLFZCD" async></script>
<script>
window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}
gtag("set","linker",{"domains":["harristhermal.com"]});
gtag("js", new Date());
gtag("set", "developer_id.dZTNiMT", true);
gtag("config", "GT-NMLFZCD");
</script>
<script type="application/ld+json">{"@@context":"https://schema.org","@@type":["Organization","LocalBusiness"],"@@id":"https://harristhermal.com/#organization","name":"Harris Thermal Transfer Products","url":"https://harristhermal.com/","logo":"https://harristhermal.com/wp-content/uploads/2021/10/logo-for-light-background.png","description":"ASME U- and R-stamp certified industrial fabricator building custom TEMA shell and tube heat exchangers, ASME code pressure vessels, evaporators, and process equipment since 1885.","foundingDate":"1885","telephone":"+1-800-767-9507","address":{"@@type":"PostalAddress","streetAddress":"615 S. Springbrook Road","addressLocality":"Newberg","addressRegion":"OR","postalCode":"97132","addressCountry":"US"},"geo":{"@@type":"GeoCoordinates","latitude":45.3123,"longitude":-122.9585},"sameAs":["https://m.facebook.com/profile.php?id=122401714485102","https://www.linkedin.com/company/harris-thermal-transfer-products"],"knowsAbout":["ASME fabrication","TEMA shell and tube heat exchangers","pressure vessels","NQA-1 quality program","falling film evaporators","crystallizers","formaldehyde converters","high nickel alloy welding","titanium fabrication"]}</script>

<link rel="canonical" href="https://ht2.demo.webriculture.com/2026/05/21/understanding-falling-film-evaporator-design/"><meta property="og:type" content="article">
<meta property="og:site_name" content="Harris Thermal - Heat Exchangers, Pressure Vessels, Fabrication, Portland Oregon">
<meta property="og:title" content="Understanding falling film evaporator design - Harris Thermal">
<meta property="og:url" content="https://ht2.demo.webriculture.com/2026/05/21/understanding-falling-film-evaporator-design/">
<meta property="og:image" content="https://ht2.demo.webriculture.com/sites/harristhermal2/wp-content/uploads/2022/06/harris_pressure_vessel-scaled.jpg">
<meta property="og:description" content="Learn the mathematical and metallurgical realities of falling film evaporator design, from calculating minimum wetting rates to specifying high-nickel alloys.">
<script type="application/ld+json">{"@@context":"https://schema.org","@@type":"BreadcrumbList","itemListElement":[{"@@type":"ListItem","position":1,"name":"Home","item":"https://ht2.demo.webriculture.com/"},{"@@type":"ListItem","position":2,"name":"Understanding falling film evaporator design","item":"https://ht2.demo.webriculture.com/2026/05/21/understanding-falling-film-evaporator-design/"}]}</script>
<script type="application/ld+json">{"@@context":"https://schema.org","@@type":"BlogPosting","@@id":"https://ht2.demo.webriculture.com/2026/05/21/understanding-falling-film-evaporator-design/#blogposting","headline":"Understanding falling film evaporator design","name":"Understanding falling film evaporator design - Harris Thermal","description":"Learn the mathematical and metallurgical realities of falling film evaporator design, from calculating minimum wetting rates to specifying high-nickel alloys.","url":"https://ht2.demo.webriculture.com/2026/05/21/understanding-falling-film-evaporator-design/","mainEntityOfPage":{"@@type":"WebPage","@@id":"https://ht2.demo.webriculture.com/2026/05/21/understanding-falling-film-evaporator-design/"},"datePublished":"2026-05-21T11:07:01-07:00","dateModified":"2026-05-21T11:07:01-07:00","inLanguage":"en-US","author":{"@@type":"Organization","name":"Harris Thermal Transfer Products"},"publisher":{"@@id":"https://harristhermal.com/#organization"},"image":"https://ht2.demo.webriculture.com/sites/harristhermal2/wp-content/uploads/2022/06/harris_pressure_vessel-scaled.jpg","articleSection":["Heat Exchangers","Materials & Metallurgy"],"keywords":["chemical processing","falling film evaporator","heat transfer","high-nickel alloys","pharmaceutical recovery","tube wetting","vapor recompression"]}</script>

</head>
<body>

<div class="ht-topbar">
  <div class="ht-wrap">
    <span class="ht-certs">ASME U &amp; R Stamp · TEMA · NQA-1 Quality Program</span>
    <span>Call us: <a href="tel:800-767-9507">800-767-9507</a></span>
  </div>
</div>

<header class="ht-header">
  <div class="ht-wrap ht-nav">
    <a class="ht-brand" href="/"><img src="/sites/harristhermal2/wp-content/uploads/2025/10/http-logo.png" alt="Harris Thermal" width="220" height="49"></a>
    <nav class="ht-mainnav" aria-label="Primary">
      <ul>
        <li><a href="/products-services/">Products &amp; Services</a>
          <ul class="ht-sub">
            <li><a href="/shell-and-tube-heat-exchangers/">Shell &amp; Tube Heat Exchangers</a></li>
            <li><a href="/pressure-vessels-tanks/">Pressure Vessels / Tanks</a></li>
            <li><a href="/other-fabrication/">Other Fabrication</a></li>
            <li><a href="/machining-drilling/">Machining / Drilling</a></li>
            <li><a href="/repairs/">Repairs</a></li>
          </ul>
        </li>
        <li><a href="/industries-served/">Industries</a>
          <ul class="ht-sub">
            <li><a href="/oil-and-gas-industry-solutions/">Oil &amp; Gas</a></li>
            <li><a href="/chemical-industry-equipment/">Chemical</a></li>
            <li><a href="/formaldehyde-converters-and-resin/">Formaldehyde &amp; Resins</a></li>
            <li><a href="/pulp-and-paper-industry-solutions/">Pulp &amp; Paper</a></li>
            <li><a href="/food-processing-equipment/">Food Processing</a></li>
            <li><a href="/mining-and-minerals-equipment/">Mining &amp; Minerals</a></li>
            <li><a href="/power-generation/">Power Generation</a></li>
            <li><a href="/nuclear/">Nuclear</a></li>
            <li><a href="/data-center-cooling-equipment/">Data Centers</a></li>
            <li><a href="/water-treatment/">Water Treatment</a></li>
            <li><a href="/sugar-processing-equipment/">Sugar Processing</a></li>
            <li><a href="/liquefied-natural-gas-equipment/">LNG</a></li>
            <li><a href="/general-manufacturing-industry/">General Manufacturing</a></li>
          </ul>
        </li>
        <li><a href="/capabilities/">Capabilities</a>
          <ul class="ht-sub">
            <li><a href="/fabrication/">Fabrication</a></li>
            <li><a href="/machining/">Machining</a></li>
            <li><a href="/materials/">Materials</a></li>
            <li><a href="/engineering/">Engineering</a></li>
            <li><a href="/quality-control-safety/">Quality Control</a></li>
            <li><a href="/safety/">Safety</a></li>
            <li><a href="/logistics-and-shipping/">Logistics &amp; Shipping</a></li>
          </ul>
        </li>
        <li><a href="/resources/">Resources</a>
          <ul class="ht-sub">
            <li><a href="/category/industry-insights/">Industry Insights</a></li>
            <li><a href="/harris-thermal-transfer-products-faqs/">FAQs</a></li>
          </ul>
        </li>
        <li><a href="/about-us/">About</a>
          <ul class="ht-sub">
            <li><a href="/certifications/">Certifications</a></li>
            <li><a href="/employment/">Employment</a></li>
          </ul>
        </li>
        <li><a href="/contact-us/">Contact</a>
        </li>
      </ul>
      <a class="ht-cta-btn" href="/get-a-quote/">Get a Quote</a>
    </nav>
    <button class="ht-hamburger" aria-label="Menu" aria-expanded="false" onclick="htToggleMenu(this)">
      <span></span><span></span><span></span>
    </button>
  </div>
  <div class="ht-mobile-menu" id="htMobileMenu">
    <details><summary>Products &amp; Services</summary>
      <a href="/products-services/">Overview</a>
      <a href="/shell-and-tube-heat-exchangers/">Shell &amp; Tube Heat Exchangers</a>
      <a href="/pressure-vessels-tanks/">Pressure Vessels / Tanks</a>
      <a href="/other-fabrication/">Other Fabrication</a>
      <a href="/machining-drilling/">Machining / Drilling</a>
      <a href="/repairs/">Repairs</a>
    </details>
    <details><summary>Industries</summary>
      <a href="/industries-served/">Overview</a>
      <a href="/oil-and-gas-industry-solutions/">Oil &amp; Gas</a>
      <a href="/chemical-industry-equipment/">Chemical</a>
      <a href="/formaldehyde-converters-and-resin/">Formaldehyde &amp; Resins</a>
      <a href="/pulp-and-paper-industry-solutions/">Pulp &amp; Paper</a>
      <a href="/food-processing-equipment/">Food Processing</a>
      <a href="/mining-and-minerals-equipment/">Mining &amp; Minerals</a>
      <a href="/power-generation/">Power Generation</a>
      <a href="/nuclear/">Nuclear</a>
      <a href="/data-center-cooling-equipment/">Data Centers</a>
      <a href="/water-treatment/">Water Treatment</a>
      <a href="/sugar-processing-equipment/">Sugar Processing</a>
      <a href="/liquefied-natural-gas-equipment/">LNG</a>
      <a href="/general-manufacturing-industry/">General Manufacturing</a>
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
    <a href="/resources/">Resources</a>
    <details><summary>About</summary>
      <a href="/about-us/">About Us</a>
      <a href="/certifications/">Certifications</a>
      <a href="/employment/">Employment</a>
    </details>
    <a href="/contact-us/">Contact</a>
    <a href="/get-a-quote/"><strong>Get a Quote →</strong></a>
  </div>
</header>

<section class="ht-hero">
  <div class="ht-wrap">
    <div class="ht-crumb"><a href="/">Home</a> / Understanding falling film evaporator design</div>
    <h1>Understanding falling film evaporator design</h1>
    <div class="ht-date">Published May 21, 2026</div>
  </div>
</section>
<div class="ht-postwrap">
  <div class="ht-wrap">
    <article class="ht-article">
      <div class="ht-post-body">
<p>A practitioner on an extraction engineering forum recently shared a failure experience. Their friction-fit falling film evaporator failed under operating conditions of -70°C and 50 psi. It was the only unit in the facility to fail, leading the team to adopt a preference for fully welded designs. For decades, process engineers sized evaporators using extrapolated heat transfer correlations and standard 300-series stainless steel. As facilities push toward zero liquid discharge and low-temperature vapor recompression, these generalized assumptions trigger chronic tube fouling and rapid material degradation.</p>
<p><strong>TL;DR</strong></p>
<ul>
<li>Standard heat transfer models underestimate low-temperature performance by up to three times.</li>
<li>Adding surface area without sufficient inlet flow breaks the minimum wetting rate and causes dry-out.</li>
<li>Boiling acid environments require fully welded construction and high-nickel alloys to prevent severe tube failure.</li>
<li>Mechanical vapor recompression cuts energy consumption compared to single-effect designs.</li>
</ul>
<h2>The mechanics of falling film evaporation</h2>
<p>Falling film evaporation relies on gravity-assisted thin-film vaporization inside vertical tubes. Liquid enters the top calandria, passes through a distribution plate or weir system, and flows down the inner tube walls as a continuous, uniform film. Steam or hot gas on the shell side transfers latent heat through the tube wall, causing the falling liquid to boil. Vapor and concentrated liquid exit the bottom of the vessel into a centrifugal separator. The separator removes entrained liquid droplets from the vapor stream so the recovered distillate remains pure.</p>
<p>Residence time inside the tubes is measured in seconds. The rapid transit protects heat-sensitive liquids from thermal degradation, making the design standard for pharmaceutical recovery and chemical concentration.</p>
<p>Industrial facilities rely on these units to manage massive throughput with minimal fluid inventory. Brine concentrators operating on this principle routinely achieve <a href="/water-treatment/">water recovery rates</a> greater than 90 percent for zero liquid discharge systems.</p>
<h2>The math behind the minimum wetting rate (MWR)</h2>
<h3>The distribution bottleneck</h3>
<p>The design parameter for any falling film system is the minimum wetting rate. Engineers define this as the minimum mass flow rate per unit circumference required to keep the tube wall completely covered. It is typically expressed in kilograms per meter-second. The calculation must account for the specific gravity and viscosity of the fluid at operating temperatures. High-viscosity fluids demand higher mass flow rates to overcome internal shear resistance and maintain the film.</p>
<p>Dropping below this mass flow rate causes the liquid film to tear. The exposed tube wall overheats rapidly, creating <a href="https://www.sciencedirect.com/science/article/abs/pii/S0960308506705545">dry patches and chronic fouling</a>. Solids precipitate directly onto the bare metal. Once a single tube begins to foul, it creates a hydraulic feedback loop. The restricted tube takes less liquid, forcing excess volume into adjacent tubes, which destabilizes the distribution profile across the entire bundle.</p>
<p>Preventing failure requires precision-engineered distribution plates at the top of the calandria. Engineers on professional forums emphasize that falling film evaporator design is fundamentally different from standard heat exchangers because of the liquid distribution requirement. Without specialized weirs or distribution trays, the system suffers from dry spots. If the feed pump fluctuates or the distribution is uneven, the system drops below the minimum wetting rate.</p>
<h3>The surface area misconception</h3>
<p>The case for increasing total heat transfer surface area to resolve poor evaporation rates is real: more square footage theoretically equals more capacity. But it breaks when feed pumps cannot maintain sufficient flow across the expanded bundle, which is the scenario most facilities face during capacity upgrades.</p>
<p>Spreading a fixed volume of liquid over an expanded tube bundle means the film will thin and break. Facilities end up paying a higher capital cost to force dry-out.</p>
<h3>Geometrical surface modifications</h3>
<p>Modifying vertical tubular surfaces with geometrical features improves evaporation rates by <a href="https://www.sciencedirect.com/science/article/pii/S0255270123001939">50 to over 100 percent</a> compared to smooth surfaces.</p>
<p>These enhancements work across standard industrial flow rates. Grooved or fluted walls induce turbulence within the falling film, increasing the heat transfer coefficient without requiring a higher total mass flow rate to maintain coverage.</p>
<h2>Thermal boundary conditions and heat transfer miscalculations</h2>
<p>Process engineers cannot rely on extrapolated heat transfer correlations. Low-temperature evaporation dynamics differ from shell-and-tube assumptions. Extrapolated correlations underestimate horizontal heat transfer at low saturation temperatures (280 to 305 K) by two to three fold (<a href="https://www.osti.gov/servlets/purl/2478362">Oak Ridge National Laboratory</a>).</p>
<p>Classic models frequently overlook bubble-assisted evaporation. Bubble-assisted evaporation creates localized turbulence that disrupts the thermal boundary layer. The physical behavior of the boiling film changes, transferring heat much faster than thermodynamic tables predict. Relying on simple estimates leads to inefficient, oversized units that cost more to fabricate and install. Over-engineering the vessel inflates capital expenditure and introduces operational inefficiencies. An oversized unit requires more heating medium to reach steady state, negating the energy benefits of the falling film design.</p>
<p>Engineers sizing equipment for low-temperature recovery must use updated correlations validated for thin-film boiling across standard operating flows. Modern universal correlations, validated against datasets of nearly a thousand points, cover heat fluxes from 7.7 to 208 kW/m2. These datasets allow engineers to size evaporators correctly.</p>
<h2>Material constraints in corrosive and ZLD environments</h2>
<h3>The limits of standard stainless</h3>
<p>Standard 300-series metallurgy fails rapidly in aggressive concentration processes. It degrades under boiling acids and high-chloride brines.</p>
<p>An industrial falling film evaporator on ammonium nitrate service suffered a <a href="https://www.sciencedirect.com/science/article/pii/S1877705816004665">severe tube breach</a> due to boiling acid corrosion on standard tubes. The plant operated with a damaged evaporator for a year while waiting out a 12-month lead time for a custom replacement. The resulting downtime highlights the risks of aggressive boiling environments on standard tube bundles.</p>
<h3>Vacuum integrity and extreme cycling</h3>
<p>Process leaks reduce product purity and compromise vacuum systems. Friction-fit tubes <a href="https://future4200.com/t/open-source-design-project-falling-film-evaporator/4354?page=10">can fail</a> under extreme temperature cycling and deep vacuum conditions. Expanding and contracting mechanically at -70°C breaks the friction seal, allowing the heating medium to contaminate the process fluid. The resulting cross-contamination ruins product batches and damages downstream equipment. Field practitioners working with high vacuum argue that only fully welded tube sheets provide the necessary reliability.</p>
<h3>High-spec alloys and welded construction</h3>
<p>The physical survival of the vessel requires precise fabrication to code. Industrial evaporators built to <a href="/pressure-vessels-tanks/">ASME Section VIII Div. 1</a> and <a href="/resources/">TEMA standards</a> (Class B and C) provide the structural defense against chemical failure.</p>
<p>Fabricating the tube sheets and distribution plates from high-spec alloys like duplex stainless steel and Hastelloy prevents aggressive corrosion in zero liquid discharge environments. These high-nickel alloys resist the pitting and stress-corrosion cracking that degrade standard stainless steel in brine concentration applications. Fully welded tube-to-tubesheet joints lock the boundary between the shell side and tube side, securing vacuum integrity regardless of temperature swings. At Harris Thermal, controlling the welding environment through an in-house fabrication model allows these specialized materials to retain their structural properties under extreme cycling.</p>
<h2>Driving efficiency with vapor recompression</h2>
<p>Integrating vapor recompression alters the operational footprint of the facility.</p>
<ul>
<li>Integrating mechanical vapor recompression with multi-effect falling film systems reduces energy consumption by 42 percent compared to single-effect designs.</li>
<li>Food processing applications see an increase in production capacity of up to 15 percent while maintaining flavor profiles due to lower operating temperatures.</li>
<li>The system architecture shifts from relying purely on live steam to recycling latent heat directly from the process vapor.</li>
<li>Compressors raise the temperature and pressure of the exhaust vapor, feeding it back into the shell side as the heating medium.</li>
</ul>
<p>Operating Mechanical Vapor Recompression (MVR) technology requires precise control over the boiling point elevation. However, reducing boiler fuel consumption justifies the mechanical complexity for continuous operations. The compressor acts as an open heat pump. It captures the low-pressure vapor exiting the separator and compresses it to a higher pressure and temperature. Centrifugal fans or positive displacement blowers typically handle this compression, depending on the required pressure lift. Practitioners weigh the energy efficiency of MVR against the mechanical simplicity of multi-effect thermal designs, noting that compressors introduce vibration and noise that require careful structural integration.</p>
<h2>Securing reliable evaporation</h2>
<p>Understanding why a friction-fit tube fails at -70°C is the first step toward reliable operation. Securing the minimum wetting rate prevents dry-out, while applying accurate low-temperature correlations and specifying the correct metallurgy allows the unit to survive the chemical load. Mechanical design, thermal modeling, and metallurgy can no longer be treated as isolated variables. In modern zero liquid discharge and low-temperature environments, they operate as a single integrated system.</p>


<h2>FAQs about falling film evaporator design</h2>

<h3>How does a falling film evaporator compare to forced circulation for high-viscosity fluids?</h3>
<p>Forced circulation evaporators outperform falling film designs when processing fluids with high viscosity or high solids content. Falling film units require low-viscosity feeds to maintain a continuous thin film and prevent dry-out. According to <a href="/shell-and-tube-heat-exchangers/">Harris Thermal&#8217;s research</a>, falling film systems are best suited for heat-sensitive liquids requiring short residence times.</p>


<h3>How do I monitor falling film evaporator fouling in real time?</h3>
<p>Operators use IoT-enabled sensors to track the heat transfer coefficient and fluid density, often called brix analysis. Real-time data from motorized density sensors allows for dynamic adjustment of the wetting rate to prevent dry points. Industry 4.0 frameworks trigger maintenance when performance drops to <a href="https://tridiagonal.ai/blogs/forecasting-failures-smart-maintenance-of-falling-film-evaporators-in-the-sugar-manufacturing-industry">20 percent</a> of the design coefficient.</p>


<h3>Should I use co-current or counter-current flow in my evaporator design?</h3>
<p>High-capacity industrial units typically use co-current flow where vapor and liquid both move downward. This configuration prevents vapor-liquid entrainment and film disruption that often occurs at high velocities in counter-current setups. Co-current designs ensure the vapor stream does not impede the gravity-driven liquid film.</p>


<h3>How often should I schedule Cleaning-in-Place for a falling film evaporator?</h3>
<p>Cleaning-in-Place frequency depends on the degradation of the heat transfer coefficient rather than a fixed calendar schedule. Most facilities initiate a wash cycle once the coefficient drops by 15 to 20 percent from the baseline. Predictive maintenance models use high-frequency sensor data to identify when fouling begins to restrict flow.</p>


<h3>What does excessive vibration or noise indicate in an MVR falling film system?</h3>
<p>Excessive vibration and noise typically signal mechanical issues within the compressor or centrifugal fan. These symptoms often indicate underlying problems with the pressure lift or structural integration of the recompression unit. Operators must monitor these signals to prevent damage to the compressor blades and ensure the stability of the boiling point elevation.</p>

      </div>
<footer class="ht-post-meta">
  <p class="ht-post-tax"><span class="ht-vh">Categories </span><a href="/category/industry-insights/heat-exchangers/" rel="category tag">Heat Exchangers</a>, <a href="/category/industry-insights/materials-metallurgy/" rel="category tag">Materials &amp; Metallurgy</a></p>
  <p class="ht-post-tax"><span class="ht-vh">Tags </span><a href="/tag/chemical-processing/" rel="tag">chemical processing</a>, <a href="/tag/falling-film-evaporator/" rel="tag">falling film evaporator</a>, <a href="/tag/heat-transfer/" rel="tag">heat transfer</a>, <a href="/tag/high-nickel-alloys/" rel="tag">high-nickel alloys</a>, <a href="/tag/pharmaceutical-recovery/" rel="tag">pharmaceutical recovery</a>, <a href="/tag/tube-wetting/" rel="tag">tube wetting</a>, <a href="/tag/vapor-recompression/" rel="tag">vapor recompression</a></p>
  <nav class="ht-post-nav" aria-label="Posts">
    <div class="ht-post-prev"><a href="/2026/05/21/asme-vs-non-code-pressure-vessels-when-compliance-is-actually-required/" rel="prev" aria-label="Previous article: ASME vs non-code pressure vessels: when compliance is actually required">ASME vs non-code pressure vessels: when compliance is actually required</a></div>
    <div class="ht-post-next"><a href="/2026/06/04/what-is-a-zero-liquid-discharge-zld-system/" rel="next" aria-label="Next article: What is a zero liquid discharge (ZLD) system?">What is a zero liquid discharge (ZLD) system?</a></div>
  </nav>
</footer>

    </article>
  </div>
</div>
<section class="ht-cta-band">
  <div class="ht-wrap">
    <div>
      <h2>Ready to start your next project?</h2>
      <p>Tell us about your application, timeline, and budget &mdash; our engineering team will help you get it built right the first time.</p>
    </div>
    <div class="ht-ctas">
      <a class="ht-btn ht-btn-primary" href="/get-a-quote/">Get an Estimate</a>
      <a class="ht-btn ht-btn-ghost" href="/contact-us/">Contact Us</a>
    </div>
  </div>
</section>


<footer class="ht-footer">
  <div class="ht-wrap">
    <div class="ht-fgrid">
      <div>
        <img class="ht-flogo" src="/sites/harristhermal2/wp-content/uploads/2025/10/http-logo.png" alt="Harris Thermal">
        <p class="ht-tagline">Exceeding client expectations for over 140 years.</p>
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
    <div class="ht-fbottom"><span>Copyright © Harris Thermal Transfer Products 2026 — All rights reserved. <span class="ht-devbuild">· Development Build: Wave 6.6</span></span>
      <div class="ht-fsocial">
        <a href="https://m.facebook.com/profile.php?id=122401714485102">Facebook</a>
        <a href="https://www.linkedin.com/company/harris-thermal-transfer-products">LinkedIn</a>
        <a href="/contact-us/">Contact</a>
      </div>
    </div>
  </div>
</footer>

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

<x-accessibility-toolbar />
<x-scroll-to-top />
</body>
</html>
