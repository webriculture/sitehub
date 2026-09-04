@extends('site::partials.layout')

@section('title', 'Family Resources | Mid-Valley Parenting')
@section('description', 'Age-specific developmental toolkits and trusted parenting resources for families in Polk and Yamhill Counties.')

@section('content')
    <section class="page-hero">
        <p class="eyebrow">Family resources</p>
        <h1>Resources for parents and caregivers</h1>
        <p class="page-intro">Helpful information, activities, and local connections to support your child's development from birth through the early years.</p>
    </section>

    <div class="page-wrap wide prose">
        <h2>Age-Specific Developmental Tool Kits</h2>
        <p>These books have resources, activities, and information to support parents in the development of their children from birth to 5 years old. You can download and share the books here:</p>

        <div class="doc-grid">
            <div class="doc-card">
                <strong>Learning with Your Baby</strong>
                <span>Birth to 2 years old</span>
                <span class="doc-links">
                    <a href="/sites/midvalleyparenting/docs/toolkit-birth-2-en.pdf">English (PDF)</a>
                    <a href="/sites/midvalleyparenting/docs/toolkit-birth-2-es.pdf" lang="es">Español (PDF)</a>
                </span>
            </div>
            <div class="doc-card">
                <strong>Getting Ready for School One Step at a Time</strong>
                <span>2–3 years old</span>
                <span class="doc-links">
                    <a href="/sites/midvalleyparenting/docs/toolkit-2-3-en.pdf">English (PDF)</a>
                    <a href="/sites/midvalleyparenting/docs/toolkit-2-3-es.pdf" lang="es">Español (PDF)</a>
                </span>
            </div>
            <div class="doc-card">
                <strong>Preparing for Kindergarten Success</strong>
                <span>4–5 years old</span>
                <span class="doc-links">
                    <a href="/sites/midvalleyparenting/docs/toolkit-4-5-en.pdf">English (PDF)</a>
                    <span class="doc-unavailable" lang="es">Versión en español no disponible actualmente</span>
                </span>
            </div>
        </div>

        <h2>More Resources for Parents</h2>
        <ul class="resource-list">
            <li><a href="https://www.211info.org/" rel="noopener">211info</a><p>Finding the necessary resources for your specific needs.</p></li>
            <li><a href="http://www.parentinginfo.org/" rel="noopener">Just in Time Parenting Information</a><p>Newsletters for the age of your child.</p></li>
            <li><a href="https://www.pbs.org/parents/" rel="noopener">PBS Parents</a><p>Parenting resources from a friendly and inviting site.</p></li>
            <li><a href="http://www.readyatfive.org/" rel="noopener">Ready at Five</a><p>Parenting tips to promote school readiness.</p></li>
            <li><a href="http://www.creatingops.org/" rel="noopener">Creating Opportunities</a><p>Supporting families of children with or suspected of having developmental disabilities in Polk, Yamhill, and Marion Counties.</p></li>
            <li><a href="http://www.mvparents.com/" rel="noopener">MVParents.com</a><p>Information and support to help your kids grow up to be healthy, caring, and responsible adults.</p></li>
            <li><a href="http://thinkkids.org/" rel="noopener">Think:Kids — Rethinking Challenging Behavior</a><p>An evidence-based approach for helping children with behavioral challenges.</p></li>
            <li><a href="http://autismsocietyoregon.org/" rel="noopener">Autism Society of Oregon</a><p>Support and information for individuals with Autism, their families, and their service providers.</p></li>
            <li><a href="http://agesandstages.com/" rel="noopener">Ages and Stages Questionnaire</a><p>Developmental and social-emotional screening for children from one month to 5½ years.</p></li>
            <li><a href="http://oregoninclusivecc.org/what-we-do/" rel="noopener">Oregon Inclusive Child Care Program</a><p>Help with supports and accommodations in child care.</p></li>
            <li><a href="https://www.ohsu.edu/xd/outreach/occyshn/oregon-family-to-family-health-information-center" rel="noopener">Oregon Family to Family Health Information Center</a><p>Information for families navigating the complex world of special health care needs.</p></li>
            <li><a href="http://thriveby-5.com/" rel="noopener">Thrive By Five</a><p>Teach your preschooler about spending and saving.</p></li>
            <li><a href="https://www.zerotothree.org/parenting-resources/" rel="noopener">Zero to Three</a><p>Information focusing on the early development of your child.</p></li>
            <li><a href="http://parentinghub.org/" rel="noopener">Marion-Polk Early Learning Hub</a><p>What's happening in the Polk and Marion Counties Early Learning Hub.</p></li>
            <li><a href="https://yamhillearlylearning.org/" rel="noopener">Yamhill County Early Learning Hub</a><p>What's happening in Yamhill County's Early Learning Hub.</p></li>
        </ul>
    </div>

    <section class="cta-band">
        <h2>Looking for something local?</h2>
        <p>Search 211info for services near you, or contact a coordinator and we'll help you find the right fit.</p>
        <a class="btn btn-primary" href="/contact">Contact Us</a>
    </section>
@endsection
