@extends('site::partials.layout')

@section('title', 'FRAN | Family Resource Advocacy Network')

@section('content')
    <section class="hero">
        <div class="container">
            <div class="hero-shell">
                <div class="hero-banner" aria-label="FRAN family support message">
                    <img src="/sites/fransalem/assets/photos/hero-family-piggyback.jpg" alt="A caregiver smiling while giving a child a piggyback ride">
                    <div class="stack hero-copy">
                        <p class="eyebrow">Family Resource Advocacy Network</p>
                        <h1>Family.<br>Connection.<br>Community.</h1>
                        <p class="lead"><em>Supporting Northeast Salem Together.</em></p>
                        <div class="hero-actions">
                            <a class="button primary" href="/find-support">Find Support</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="wave" aria-hidden="true"></div>

    <section class="section-tight intro-band">
        <div class="container panel sky">
            <div class="grid cols-2 intro-layout">
                <div class="intro-copy">
                    <p class="eyebrow">Welcome to FRAN</p>
                    <h2 class="section-title small">A Friendly Starting Point for Local Family Services</h2>
                    <p class="lead">Find local organizations, resources and support in one welcoming place. Whether you are looking for health resources, early learning, community connections and more, FRAN can help you find the starting point.</p>
                    <div class="intro-actions">
                        <a class="button primary" href="/find-support">Community Partners</a>
                        <a class="button ghost" href="/about">About FRAN</a>
                    </div>
                </div>
                <figure class="rounded-photo intro-photo">
                    <img src="/sites/fransalem/assets/photos/family-photo.jpg" alt="A family of five laughing together at home">
                </figure>
            </div>
        </div>
    </section>

    <section class="section support-section" id="support">
        <div class="container">
            <div class="text-center narrow">
                <p class="eyebrow">How FRAN can help</p>
                <h2 class="section-title small">Find the Right Support for Your Family</h2>
            </div>
            <div class="grid cols-2">
                <article class="service-card image-service-card">
                    <img class="card-photo" src="/sites/fransalem/assets/photos/healthcare-support.jpg" alt="A child receiving a healthcare checkup">
                    <div class="icon-bubble bubble-support-blue"><img src="/sites/fransalem/assets/icons/health-wellness.svg" alt="" aria-hidden="true"></div>
                    <h3>Food, Health &amp; Wellness</h3>
                    <p>Connect with health, dental, postpartum, food assistance and other wellness resources for children and caregivers.</p>
                    <details class="partner-dropdown">
                        <summary class="button small service-learn-more">EXPLORE PARTNERS</summary>
                        <ul class="partner-dropdown-list">
                            <li><a href="/about">Fostering Hope Initiative</a></li>
                            <li><a href="https://familybuildingblocks.org/" target="_blank" rel="noopener">Family Building Blocks</a></li>
                            <li><a href="https://www.jdhealthandwellness.com/" target="_blank" rel="noopener">JD Health &amp; Wellness</a></li>
                            <li><a href="https://www.co.marion.or.us/HLT" target="_blank" rel="noopener">Marion County Health &amp; Human Services</a></li>
                            <li><a href="https://northwesthumanservices.org/" target="_blank" rel="noopener">Northwest Human Services</a></li>
                        </ul>
                    </details>
                </article>
                <article class="service-card image-service-card">
                    <img class="card-photo" src="/sites/fransalem/assets/photos/housing-utilities.jpg" alt="A child standing near the window of a playhouse">
                    <div class="icon-bubble bubble-support-blue"><img src="/sites/fransalem/assets/icons/housing-utilities.svg" alt="" aria-hidden="true"></div>
                    <h3>Housing &amp; Utilities</h3>
                    <p>Learn where to turn for support with household stability, utilities, and essential needs.</p>
                    <details class="partner-dropdown">
                        <summary class="button small service-learn-more">EXPLORE PARTNERS</summary>
                        <ul class="partner-dropdown-list">
                            <li><a href="/about">Fostering Hope Initiative</a></li>
                            <li><a href="https://www.co.marion.or.us/HA" target="_blank" rel="noopener">Marion County Housing Authority</a></li>
                        </ul>
                    </details>
                </article>
                <article class="service-card image-service-card">
                    <img class="card-photo" src="/sites/fransalem/assets/photos/parenting-support.jpg" alt="An adult holding hands with a child wearing a backpack">
                    <div class="icon-bubble bubble-support-blue"><img src="/sites/fransalem/assets/icons/parenting-support.svg" alt="" aria-hidden="true"></div>
                    <h3>Parenting &amp; Early Learning Support</h3>
                    <p>Find programs to help strengthen families and explore early education, childcare, school readiness, and child development resources and partners.</p>
                    <details class="partner-dropdown">
                        <summary class="button small service-learn-more">EXPLORE PARTNERS</summary>
                        <ul class="partner-dropdown-list">
                            <li><a href="/about">Fostering Hope Initiative</a></li>
                            <li><a href="https://familybuildingblocks.org/" target="_blank" rel="noopener">Family Building Blocks</a></li>
                            <li><a href="https://oregonaeyc.org/" target="_blank" rel="noopener">Oregon Association for the Education of Young Children</a></li>
                        </ul>
                    </details>
                </article>
                <article class="service-card image-service-card">
                    <img class="card-photo" src="/sites/fransalem/assets/photos/laptop-resources.jpg" alt="An advocate pointing out resources on a laptop while meeting with a community member">
                    <div class="icon-bubble bubble-support-blue"><img src="/sites/fransalem/assets/icons/community-referrals.svg" alt="" aria-hidden="true"></div>
                    <h3>Community Support &amp; Referrals</h3>
                    <p>Find local organizations and supports that can guide you toward the next helpful step.</p>
                    <details class="partner-dropdown">
                        <summary class="button small service-learn-more">EXPLORE PARTNERS</summary>
                        <ul class="partner-dropdown-list">
                            <li><a href="/about">Fostering Hope Initiative</a></li>
                            <li><a href="https://familybuildingblocks.org/" target="_blank" rel="noopener">Family Building Blocks</a></li>
                            <li><a href="https://punxwithpurpose.org/" target="_blank" rel="noopener">Punx With Purpose</a></li>
                            <li><a href="https://www.co.marion.or.us/HLT" target="_blank" rel="noopener">Marion County Health &amp; Human Services</a></li>
                            <li><a href="https://northwesthumanservices.org/" target="_blank" rel="noopener">Northwest Human Services</a></li>
                        </ul>
                    </details>
                </article>
            </div>
        </div>
    </section>

    <section class="section events-band" id="events">
        <div class="container">
            <div class="text-center narrow">
                <p class="eyebrow">Events at FRAN</p>
                <h2 class="section-title small">Happening Soon</h2>
                <p class="lead">Workshops, classes and community events for the whole family.</p>
            </div>
            <div class="events-teaser">
                <x-site-events limit="1" />
            </div>
            <p class="events-more text-center"><a class="button" href="/events">All Events &amp; Classes</a></p>
        </div>
    </section>
@endsection
