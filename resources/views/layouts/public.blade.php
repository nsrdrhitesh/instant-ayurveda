<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $pageTitle = $__env->yieldContent('title', $website['brand_name']);
        $pageDescription = $__env->yieldContent('description', $website['default_description'] ?? '');
        $socialTitle = $__env->yieldContent('ogtitle', $pageTitle);
        $socialDescription = $__env->yieldContent('ogdescription', $pageDescription);
        $socialUrl = $__env->yieldContent('canonical', url()->current());
        $shareImage = $__env->yieldContent('ogimage', $socialImage?->url ?? asset('images/instant-ayurved/img/dr.jpg'));
        $brandImage = $brandLogo?->url ?? asset('images/instant-ayurved/img/favicon.svg').'?v=2';
    @endphp
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <meta name="robots" content="{{ $__env->yieldContent('robots', 'index,follow') }}">
    <link rel="canonical" href="{{ $socialUrl }}">
    <meta property="og:type" content="{{ $__env->yieldContent('ogtype', 'website') }}">
    <meta property="og:title" content="{{ $socialTitle }}">
    <meta property="og:description" content="{{ $socialDescription }}">
    <meta property="og:url" content="{{ $socialUrl }}">
    <meta property="og:image" content="{{ $shareImage }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $socialTitle }}">
    <meta name="twitter:description" content="{{ $socialDescription }}">
    <meta name="twitter:image" content="{{ $shareImage }}">
    <link rel="icon" href="{{ $brandImage }}" type="{{ $brandLogo?->mime ?? 'image/svg+xml' }}">
    <link rel="stylesheet" href="{{ asset('css/blog.css') }}?v=20261126">
    <link rel="stylesheet" href="{{ asset('css/public.css') }}?v=20261127">
    <link rel="stylesheet" href="{{ asset('css/spatial.css') }}?v=20261127-5">
    <script defer src="{{ asset('js/public.js') }}?v=20261126"></script>
    @stack('head')
    <script type="application/ld+json">{!! app(\App\Services\CentreSchema::class)->encode(app(\App\Services\CentreSchema::class)->organization()) !!}</script>
</head>
<body class="centre-public">
<a class="skip" href="#main">Skip to content</a>
@if(($website['contact_verified'] ?? '0') === '1')
    <div class="site-ribbon spatial-contact">
        @if(!empty($website['phone']))<a href="tel:{{ preg_replace('/[^0-9+]/', '', $website['phone']) }}">{{ $website['phone'] }}</a>@endif
        @if(!empty($website['email']))<a href="mailto:{{ $website['email'] }}">{{ $website['email'] }}</a>@endif
    </div>
@endif
<header class="site-header">
    <a class="centre-brand" href="{{ route('home') }}" aria-label="InstantAyurved home">
        <img src="{{ $brandImage }}" alt="" width="58" height="58">
        <span>{{ $website['brand_name'] }}</span>
    </a>
    <button class="nav-toggle" aria-label="Menu" aria-controls="public-nav" aria-expanded="false" type="button">
        <svg aria-hidden="true" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="display:block">
            <path d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
    <nav id="public-nav" aria-label="Main navigation">
        <a href="{{ route('home') }}">Home</a>
        <details class="reference-nav-menu">
            <summary>About Us</summary>
            <div>
                <a href="{{ route('about') }}">About InstantAyurved</a>
                <a href="{{ route('doctor') }}">{{ $website['founder_name'] ?? 'Dr. Tejas Kadam' }}</a>
                <a href="{{ route('facility') }}">Our Facility</a>
            </div>
        </details>
        <details class="reference-nav-menu">
            <summary>Services</summary>
            <div>
                <a href="{{ route('services') }}">All services</a>
                @foreach($navigationServices as $navigationService)
                    <a href="{{ $navigationService->public_url }}">{{ $navigationService->name }}</a>
                @endforeach
            </div>
        </details>
        <a href="{{ route('treatment-videos') }}">Treatments</a>
        <a href="{{ route('blog.index') }}">Blog</a>
        <a href="{{ route('contact') }}">Contact</a>
        <a class="btn btn-small" href="{{ route('contact') }}">Book Appointment</a>
    </nav>
</header>
<main id="main" tabindex="-1">
    @if(session('success'))<div class="notice container" role="status">{{ session('success') }}</div>@endif
    @yield('content')
    @include('public.faqs')
</main>
@unless(request()->routeIs('home'))
<section class="closing container">
    <div><p class="eyebrow">BEGIN WITH A CONSULTATION</p><h2>Care built around<br>your individual needs.</h2><p>Speak with Dr. Tejas Kadam or request a call back.</p></div>
    <a class="btn" href="{{ route('contact') }}">Book Consultation <span aria-hidden="true">↗</span></a>
</section>
@endunless
<footer class="site-footer">
    <div class="container footer-grid">
        <div>
            <a class="centre-brand" href="{{ route('home') }}"><img src="{{ $brandImage }}" alt="" width="52" height="52"><span>{{ $website['brand_name'] }}</span></a>
            <p>Authentic Ayurvedic care combining traditional knowledge with modern clinical practice.</p>
            <small>Dr. Tejas Kadam · M.S. (Shalya Tantra)</small>
            @include('public.newsletter')
        </div>
        <div>
            <h3>Explore</h3>
            <a href="{{ route('doctor') }}">Dr. Tejas Kadam</a>
            <a href="{{ route('facility') }}">Our Facility</a>
            <a href="{{ route('services') }}">Services</a>
            <a href="{{ route('treatment-videos') }}">Treatment Videos</a>
            <a href="{{ route('blog.index') }}">Blog</a>
            <a href="{{ route('privacy') }}">Privacy</a>
            <a href="{{ route('terms') }}">Terms</a>
        </div>
        <div>
            <h3>Our Services</h3>
            @foreach($navigationServices as $navigationService)
                <a href="{{ $navigationService->public_url }}">{{ $navigationService->name }}</a>
            @endforeach
        </div>
        <div>
            <h3>Get in touch</h3>
            @if(($website['contact_verified'] ?? '0') === '1')
                @if(!empty($website['phone']))<a href="tel:{{ preg_replace('/[^0-9+]/', '', $website['phone']) }}">{{ $website['phone'] }}</a>@endif
                @if(!empty($website['email']))<a href="mailto:{{ $website['email'] }}">{{ $website['email'] }}</a>@endif
                @if(!empty($website['address']))<p>{{ $website['address'] }}</p>@endif
            @endif
            @foreach(['instagram'=>'Instagram','facebook'=>'Facebook','youtube'=>'YouTube'] as $key=>$label)
                @if(!empty($website[$key]))<a href="{{ $website[$key] }}" target="_blank" rel="noopener noreferrer">{{ $label }} ↗</a>@endif
            @endforeach
        </div>
    </div>
    <div class="container footer-bottom reference-footer-credit">
        <p>InstantAyurved. All rights reserved.</p>
        <p>Developed by <a href="https://hiteshahire.in/">Hitesh Ahire</a></p>
    </div>
</footer>
<div class="contact-shortcuts">
    @if(($website['whatsapp_verified'] ?? '0') === '1' && !empty($website['whatsapp']))
        <a class="whatsapp-shortcut" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $website['whatsapp']) }}?text={{ rawurlencode('Hello Dr. Tejas Kadam, I would like to enquire about an Ayurvedic consultation.') }}" target="_blank" rel="noopener noreferrer" aria-label="Contact InstantAyurved on WhatsApp"><svg aria-hidden="true" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="#fff" stroke-width="1.8" stroke-linejoin="round">
            <path d="M20.5 11.6a8.5 8.5 0 0 1-12.7 7.4l-4.4 1.2 1.2-4.3A8.5 8.5 0 1 1 20.5 11.6Z"/>
            <path fill="#fff" stroke="none" d="M8.2 7.5c.4-.3 1-.2 1.2.2l.9 1.7c.2.4-.1.8-.5 1.2.6 1.3 1.7 2.4 3.1 3 .4-.4.8-.8 1.2-.6l1.7.9c.5.2.5.8.3 1.2-.5.8-1.3 1.2-2.3 1-3.4-.7-6-3.3-6.5-6.5-.2-.9.2-1.7.9-2.1Z"/>
        </svg></a>
    @endif
    <button class="talk-shortcut" type="button" data-talk-open aria-haspopup="dialog">Book a Call <span aria-hidden="true">↗</span></button>
</div>
<dialog id="talk-dialog" aria-labelledby="talk-title">
    <button type="button" class="dialog-close" data-talk-close aria-label="Close consultation form">×</button>
    <p class="eyebrow">A FIRST STEP</p><h2 id="talk-title">Request a call back</h2>
    @include('public.inquiry-form',['widget'=>true,'selectedService'=>null,'formToken'=>app(\App\Services\PublicSubmissions::class)->token(request())])
</dialog>
<script defer src="{{ asset('js/blog.js') }}"></script>
</body>
</html>
