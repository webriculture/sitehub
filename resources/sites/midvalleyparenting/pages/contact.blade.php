@extends('site::partials.layout')

@section('title', 'Contact | Mid-Valley Parenting')
@section('description', 'Contact Mid-Valley Parenting — Parent Education Coordinators in Polk and Yamhill Counties.')

@section('content')
    <section class="page-hero">
        <p class="eyebrow">Get in touch</p>
        <h1>Contact us</h1>
        <p class="page-intro">Questions about classes, resources, or partnering with us? Send a message and we'll get back to you.</p>
    </section>

    <div class="page-wrap prose">
        <x-site-form key="contact" />

        <h2>More questions?</h2>
        <p>Contact a Parent Education Coordinator directly:</p>
        <div class="county-grid">
            <div class="county-card">
                <h3>Polk County</h3>
                <p class="role">Abby Warren — Community Training &amp; Education Supervisor</p>
                <p><a href="tel:+15037511644">503-751-1644</a></p>
                <p><a href="mailto:warren.abby@co.polk.or.us">warren.abby@co.polk.or.us</a></p>
                <p>1407 Monmouth Independence Hwy.<br>Monmouth, OR 97361</p>
            </div>
            <div class="county-card">
                <h3>Yamhill County</h3>
                <p class="role">Shealyn Wippert — Parent Engagement Specialist</p>
                <p><a href="tel:+19714610532">971-461-0532</a></p>
                <p><a href="mailto:swippert@yamhillcco.org">swippert@yamhillcco.org</a></p>
                <p>807 NE 3rd Street<br>McMinnville, OR 97128</p>
            </div>
        </div>

        <p style="margin-top: 2em;">Like us on <a href="https://www.facebook.com/MidValleyParenting" rel="noopener">Facebook</a> — find us at facebook.com/MidValleyParenting.</p>
    </div>
@endsection
