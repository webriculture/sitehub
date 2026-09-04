@extends('site::partials.layout')

@section('title', 'Mid-Valley Parenting | Classes, Resources, and Support for Families')

@section('content')
    <section class="hero section-pad" aria-labelledby="hero-title">
        <div class="hero-copy reveal">
            <p class="eyebrow">Because we care</p>
            <h1 id="hero-title">Parenting support, classes, and resources for Mid-Valley families.</h1>
            <p class="hero-text">Parenting is hard work, but it is also a special opportunity and an adventure. Mid-Valley Parenting is here to support your journey with classes, resources, and community connections for parents and caregivers.</p>
            <div class="button-row">
                <a class="btn btn-primary" href="/classes">Find a Class</a>
                <a class="btn btn-secondary" href="/resources">Explore Resources</a>
            </div>
        </div>
    </section>

    <section class="class-search" id="classes" aria-labelledby="class-search-title">
        <div class="search-panel reveal">
            <div class="search-copy">
                <p class="eyebrow">Upcoming classes</p>
                <h2 id="class-search-title">Find the right class for your family.</h2>
                <p>Search upcoming classes and parent discussion groups by topic, location, date, format, or language.</p>
            </div>

            <div class="search-cta">
                <a class="btn btn-primary" href="/classes">Browse All Classes</a>
            </div>
        </div>

        <div class="home-classes reveal">
            <x-site-events kind="class" />
        </div>
    </section>

    <section class="pathways section-pad" aria-labelledby="pathways-title">
        <div class="section-heading reveal">
            <p class="eyebrow">Start here</p>
            <h2 id="pathways-title">How can we help today?</h2>
            <p>Choose a starting point and find classes, resources, events, and support for your family.</p>
        </div>

        <div class="bento-grid">
            <a class="path-card large image-card reveal" href="/classes">
                <span class="path-photo" aria-hidden="true"></span>
                <span class="path-icon">01</span>
                <h3>Classes</h3>
                <p>Check out upcoming parenting classes, parent discussion groups, and learning opportunities for families.</p>
                <strong>Find a Class →</strong>
            </a>
            <a class="path-card reveal" href="/resources">
                <span class="path-icon">02</span>
                <h3>Family Resources</h3>
                <p>Find resources, activities, and information to support parents and caregivers in the development of their children.</p>
                <strong>Explore Resources →</strong>
            </a>
            <a class="path-card warm reveal" href="/events">
                <span class="path-icon">03</span>
                <h3>Workshops &amp; Activities</h3>
                <p>Explore upcoming workshops, activities, and community opportunities being offered in your area.</p>
                <strong>View Events →</strong>
            </a>
            <a class="path-card sage reveal" href="/es" lang="es">
                <span class="path-icon">04</span>
                <h3>Recursos en Español</h3>
                <p>Encuentre clases, recursos e información para apoyar a padres, cuidadores y familias.</p>
                <strong>Ver Recursos →</strong>
            </a>
            <a class="path-card dark reveal" href="/providers">
                <span class="path-icon">05</span>
                <h3>For Providers</h3>
                <p>Find information for parent educators, community partners, and organizations supporting families.</p>
                <strong>Provider Information →</strong>
            </a>
        </div>
    </section>

    <section class="story-band" id="about" aria-labelledby="story-title">
        <div class="story-image reveal">
            <img src="/sites/midvalleyparenting/img/support-close-to-home.jpg" alt="Parent reading with children at home">
        </div>
        <div class="story-copy reveal">
            <p class="eyebrow">Working together</p>
            <h2 id="story-title">Support that feels close to home.</h2>
            <p>Mid-Valley Parenting brings community partners together to provide parenting education and resources for families in Polk and Yamhill Counties. Through classes, activities, and trusted local connections, we help parents and caregivers build knowledge, confidence, and support.</p>
            <a class="btn btn-light" href="/about">About Mid-Valley Parenting</a>
        </div>
    </section>

    <section class="steps section-pad" aria-labelledby="steps-title">
        <div class="section-heading reveal">
            <p class="eyebrow">Simple steps</p>
            <h2 id="steps-title">Finding support is simple.</h2>
        </div>
        <div class="step-grid">
            <article class="step-card reveal">
                <span>1</span>
                <h3>Search</h3>
                <p>Search for a class, event, or resource.</p>
            </article>
            <article class="step-card reveal">
                <span>2</span>
                <h3>Choose</h3>
                <p>Choose what fits your family's needs.</p>
            </article>
            <article class="step-card reveal">
                <span>3</span>
                <h3>Connect</h3>
                <p>Register, attend, or connect with local support.</p>
            </article>
        </div>
    </section>

    <section class="resources-events section-pad" aria-label="Resources and events">
        <article class="feature-panel resources-panel reveal" id="resources">
            <p class="eyebrow">Family resources</p>
            <h2>Resources for parents and caregivers.</h2>
            <p>Find helpful information, activities, and local resources to support your child's development from birth through the early years and beyond.</p>
            <a class="btn btn-secondary" href="/resources">Browse Resources</a>
        </article>

        <article class="feature-panel events-panel reveal" id="events">
            <p class="eyebrow">Upcoming events</p>
            <h2>What's happening for families near you.</h2>
            <p>Workshops, family activities, and community events are offered throughout the year across Polk and Yamhill Counties.</p>
            <a class="btn btn-primary" href="/events">View Events</a>
        </article>
    </section>

    <section class="provider-section" id="providers" aria-labelledby="provider-title">
        <div class="provider-copy reveal">
            <p class="eyebrow">For providers and community partners</p>
            <h2 id="provider-title">Working with local partners to support families.</h2>
            <p>Mid-Valley Parenting works with local partners to connect families with classes, events, and trusted resources.</p>
            <a class="btn btn-primary" href="/providers">Provider Information</a>
        </div>
        <div class="provider-list reveal">
            <span>Parent Educators</span>
            <span>Funded Class Series</span>
            <span>Workshops &amp; Activities</span>
            <span>Mini-Grants</span>
        </div>
    </section>

    <section class="spanish-section" id="espanol" aria-labelledby="spanish-title">
        <div class="spanish-card reveal">
            <p class="eyebrow">Recursos en Español</p>
            <h2 id="spanish-title" lang="es">Recursos para familias en español.</h2>
            <p lang="es">Encuentre clases, recursos e información para apoyar a padres, cuidadores y familias.</p>
            <a class="btn btn-primary" href="/es" lang="es">Ver Recursos</a>
        </div>
    </section>

    <section class="contact-cta" id="contact" aria-labelledby="contact-title">
        <div class="reveal">
            <p class="eyebrow">Need help?</p>
            <h2 id="contact-title">Need help finding the right class or resource?</h2>
            <p>Contact Mid-Valley Parenting and we'll help point you in the right direction.</p>
            <a class="btn btn-light" href="/contact">Contact Us</a>
        </div>
    </section>
@endsection
