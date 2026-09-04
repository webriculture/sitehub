@extends('site::partials.layout')

@section('title', 'Find Support | FRAN')
@section('description', 'Explore the local providers partnering with FRAN — health, housing, parenting, early learning, and community support organizations serving Northeast Salem families.')

@section('content')
    <section class="page-head">
        <div class="container text-center narrow">
            <p class="eyebrow">Find Support with FRAN</p>
            <h1 class="section-title">Explore Local Providers</h1>
            <p class="lead">Select a provider to learn more about their services and connect with them directly.</p>
        </div>
    </section>

    <section class="section" id="providers">
        <div class="container">
            <div class="provider-grid partner-grid find-support-grid">
                <article class="provider-card partner-card">
                    {{-- FHI professionally manages FRAN itself, so its card stays on-site for now;
     ask the client what they want visitors to land on (their CCS program page?). --}}
                    <a class="partner-name-mark" href="/about">Fostering Hope Initiative</a>
                    <p>A neighborhood-based collective impact initiative by Catholic Community Services, we provide community health, residential and pregnancy services. Our mission is to champion the positive development of children and adults, strengthening families, and building community.</p>
                    <p class="partner-categories">Food, Health &amp; Wellness | Housing &amp; Utilities | Parenting &amp; Early Learning Support | Community Support &amp; Referrals</p>
                </article>
                <article class="provider-card partner-card">
                    <a class="partner-name-mark" href="https://familybuildingblocks.org/" target="_blank" rel="noopener">Family Building Blocks</a>
                    <p>Keeping children safe and families together, we are the relief nursery serving Marion and Polk counties, partnering with families to prevent child abuse and neglect.</p>
                    <p class="partner-categories">Food, Health &amp; Wellness | Parenting &amp; Early Learning Support | Community Support &amp; Referrals</p>
                </article>
                <article class="provider-card partner-card">
                    <a class="partner-name-mark" href="https://www.jdhealthandwellness.com/" target="_blank" rel="noopener">JD Health &amp; Wellness</a>
                    <p>More than a clinic, we are a community of healers, mentors, and guides who walk alongside you. Whether you’re seeking freedom from addiction, support for your teen’s mental health, or a trusted partner in your family’s ongoing wellness, our team meets you with compassion, respect, and understanding.</p>
                    <p class="partner-categories">Food, Health &amp; Wellness</p>
                </article>
                <article class="provider-card partner-card">
                    <a class="partner-name-mark" href="https://www.co.marion.or.us/HLT" target="_blank" rel="noopener">Marion County Health &amp; Human Services</a>
                    <p>We provide access to services and build partnerships to advance healthy communities, including behavioral health, public health, intellectual and developmental disabilities services, and more.</p>
                    <p class="partner-categories">Food, Health &amp; Wellness | Community Support &amp; Referrals</p>
                </article>
                <article class="provider-card partner-card">
                    <a class="partner-name-mark" href="https://www.co.marion.or.us/HA" target="_blank" rel="noopener">Marion County Housing Authority</a>
                    <p>Our mission is to make Marion County a better place to live by developing, administering, and maintaining safe, decent, affordable housing for its citizens.</p>
                    <p class="partner-categories">Housing &amp; Utilities</p>
                </article>
                <article class="provider-card partner-card">
                    <a class="partner-name-mark" href="https://northwesthumanservices.org/" target="_blank" rel="noopener">Northwest Human Services</a>
                    <p>We believe health care is a human right and remain committed to treating everyone with dignity, kindness and respect. We provide medical, dental, mental health, and social services.</p>
                    <p class="partner-categories">Food, Health &amp; Wellness | Community Support &amp; Referrals</p>
                </article>
                <article class="provider-card partner-card">
                    <a class="partner-name-mark" href="https://oregonaeyc.org/" target="_blank" rel="noopener">Oregon Association for the Education of Young Children</a>
                    <p>Our mission is to promote high-quality, early learning for all young children, birth through age 8, by connecting early childhood practice, policy, and research. We advance a diverse, dynamic early childhood profession and support all who care for, educate, and work on behalf of young children.</p>
                    <p class="partner-categories">Parenting &amp; Early Learning Support</p>
                </article>
                <article class="provider-card partner-card">
                    <a class="partner-name-mark" href="https://punxwithpurpose.org/" target="_blank" rel="noopener">Punx With Purpose</a>
                    <p>We empower the at-risk youth of Marion and Polk Counties by meeting them where they are, seeking to provide safer spaces where our youth can gather and receive the resources they need to succeed as they grow into functional community members.</p>
                    <p class="partner-categories">Community Support &amp; Referrals</p>
                </article>
            </div>
            <p class="provider-more text-center"><em>More community partners to come!</em></p>
        </div>
    </section>
@endsection
