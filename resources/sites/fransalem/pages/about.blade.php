@extends('site::partials.layout')

@section('title', 'About | FRAN')
@section('description', 'FRAN — the Family Resource Advocacy Network — is a hub of resources and support for Northeast Salem families, launched by the Larry and Jeanette Epping Family Foundation and managed by the Catholic Community Services Fostering Hope Initiative.')

@section('content')
    <section class="section" id="about">
        <div class="container grid cols-2 about-layout">
            <div class="panel orange illustrated-panel">
                <p class="eyebrow text-black">About FRAN</p>
                <h1 class="section-title small">Family Resource Advocacy Network</h1>
                <p class="about-subtitle">A hub of resources and support for Northeast Salem families.</p>
                <p>Professionally managed by the Catholic Community Services Fostering Hope Initiative, Family Resource Advocacy Network (FRAN) was launched by the Larry and Jeanette Epping Family Foundation as a welcoming community gathering space and a front door to the social services and self-sufficiency programs Northeast Salem families rely on.</p>
                <p>Rather than sending families across town from office to office, FRAN brings partner organizations together in one place, where advocates help you navigate programs, classes, and resources with dignity and without runaround. The tagline of FRAN, <em>Supporting Northeast Salem Together</em>, echoes the mission of providing one place for families to be supported, build connections and form community.</p>
                <blockquote class="about-quote">
                    <p>&ldquo;FRAN is a community social-service hub built on the understanding that everyone, at some point in their lives, faces adversity. Our goal is to provide a safe, welcoming space where individuals and families can navigate those challenges and begin to overcome them. Whether someone arrives seeking stability, support, education, or simply a moment of reassurance, we want every person who walks through our doors to feel one thing immediately &mdash; everything is going to be OK. Through navigation services, self-sufficiency resources, social and behavioral support, and health and wellness opportunities, FRAN helps young people and families build resilience and create lifelong pathways to opportunity.&rdquo;</p>
                    <footer>&mdash;Gary Epping<br>President, Larry &amp; Jeanette Epping Family Foundation</footer>
                </blockquote>
            </div>
            <div class="stack">
                <h2 class="mini-heading">What You Can Do Here</h2>
                <a class="notice notice-link" href="/find-support"><strong>Connect with local support.</strong><br>Find community organizations serving Northeast Salem families, explore service options and connect directly with participating providers.</a>
                <a class="notice notice-link" href="/contact"><strong>Take your first step.</strong><br>Not sure where to begin? Contact us or visit FRAN to explore which resources and community partners have the right resources for you.</a>
                <a class="notice notice-link" href="/events"><strong>Engage with your community.</strong><br>Explore events, workshops and classes happening at FRAN and join others from your community for education and connection.</a>
                <figure class="rounded-photo about-page-photo">
                    <img src="/sites/fransalem/assets/photos/fran-building.jpg" alt="The FRAN building exterior with its tall vertical FRAN sign">
                </figure>
            </div>
        </div>
    </section>
@endsection
