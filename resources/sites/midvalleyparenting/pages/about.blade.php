@extends('site::partials.layout')

@section('title', 'About Us | Mid-Valley Parenting')
@section('description', 'Mid-Valley Parenting is a two-county parenting education hub through the Oregon Parenting Education Collaborative serving Polk and Yamhill Counties.')

@section('content')
    <section class="page-hero">
        <p class="eyebrow">Who we are</p>
        <h1>About Mid-Valley Parenting</h1>
        <p class="page-intro">A two-county parenting education hub serving families across Polk and Yamhill Counties.</p>
    </section>

    <div class="page-wrap prose">
        <p>Mid-Valley Parenting is a two-county parenting education hub through the <a href="https://orparenting.org/" rel="noopener">Oregon Parenting Education Collaborative (OPEC)</a> that includes both Polk and Yamhill Counties. Mid-Valley Parenting focuses on collaboration with partners to provide evidence-based parenting education in both English and Spanish across the region. We work to normalize parenting education with positive messaging and family engagement programming that promotes healthy family activities and early learning.</p>

        <h2>Our Mission</h2>
        <p>Mid-Valley Parenting's mission is to provide parenting education for all, resulting in connected and thriving communities. Our vision is that community partners collaborate to ensure lifelong learning to improve the cycle of family outcomes.</p>

        <h2>Focus Areas</h2>
        <ul>
            <li>Providing families with coordinated services and support</li>
            <li>Increasing parents' knowledge of child development &amp; realistic expectations</li>
            <li>Connecting parents with each other to build a strong support network</li>
            <li>Increasing children's readiness to learn</li>
            <li>Normalizing parenting education</li>
        </ul>

        <h2>For More Information</h2>
        <p>Contact one of our Parent Education Coordinators:</p>
        <div class="county-grid">
            <div class="county-card">
                <h3>Polk County</h3>
                <p class="role">Abby Warren — Community Training &amp; Education Supervisor</p>
                <p><a href="tel:+15037511644">503-751-1644</a></p>
                <p><a href="mailto:warren.abby@co.polk.or.us">warren.abby@co.polk.or.us</a></p>
            </div>
            <div class="county-card">
                <h3>Yamhill County</h3>
                <p class="role">Shealyn Wippert — Parent Engagement Specialist</p>
                <p><a href="tel:+19714610532">971-461-0532</a></p>
                <p><a href="mailto:swippert@yamhillcco.org">swippert@yamhillcco.org</a></p>
            </div>
        </div>

        <p style="margin-top: 2em;">Like us on <a href="https://www.facebook.com/MidValleyParenting" rel="noopener">Facebook</a> — find us at facebook.com/MidValleyParenting, or search Mid-Valley Parenting.</p>
    </div>

    <section class="cta-band">
        <h2>Ready to get started?</h2>
        <p>Find a class that fits your family, or reach out and we'll point you in the right direction.</p>
        <a class="btn btn-primary" href="/classes">Find a Class</a>
    </section>
@endsection
