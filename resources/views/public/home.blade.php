@extends('layouts.public')
@section('title', $experience['search_title'])
@section('description', $experience['search_description'])
@section('content')
<section class="spatial-hero">
    <div class="container spatial-grid">
        <div class="spatial-copy">
            <p class="spatial-label">{{ $experience['home_label'] }}</p>
            <h1>{{ $website['hero_title'] ?? 'Experience authentic Ayurvedic healing.' }}</h1>
            <p>{{ $website['hero_description'] ?? $experience['search_answer'] }}</p>
            <div class="hero-actions">
                <a class="btn" href="{{ route('contact') }}">Book appointment</a>
                <a class="spatial-link" href="#care">Explore treatments <span aria-hidden="true">↘</span></a>
            </div>
        </div>
        @include('public.callback')
    </div>
</section>
<div class="reference-trust">
    <div class="container">
        @foreach(preg_split('/\R/', $experience['home_trust_items'], -1, PREG_SPLIT_NO_EMPTY) as $item)
            @php([$value, $label] = array_pad(explode('|', $item, 2), 2, ''))
            <div><x-trust-icon :index="$loop->index" /><strong>{{ trim($value) }}</strong><span>{{ trim($label) }}</span></div>
        @endforeach
    </div>
</div>
<section class="section container spatial-grid reference-doctor">
    <img src="{{ $portrait?->url ?? asset('images/instant-ayurved/img/dr.jpg') }}" alt="{{ $website['founder_name'] }}" loading="lazy">
    <div>
        <p class="eyebrow">{{ $experience['home_doctor_heading'] }}</p>
        <h2>{{ $website['founder_name'] }}</h2>
        <p><strong>{{ $website['founder_intro'] }}</strong></p>
        <div class="prose">{!! $website['story_html'] ?? '' !!}</div>
        <div class="hero-actions">
            <a class="btn" href="{{ route('doctor') }}">Know more</a>
            <a class="text-link" href="{{ route('contact') }}">Book consultation</a>
        </div>
    </div>
</section>
<section class="section container" id="care">
    <div class="section-heading split">
        <h2>{{ $experience['home_services_heading'] }}</h2>
        <a class="text-link" href="{{ route('services') }}">All services →</a>
    </div>
    @include('public.service-cards')
</section>
<section class="spatial-facility">
    <div class="container spatial-grid">
        <img src="{{ asset('images/instant-ayurved/img/hospital.jpg') }}" alt="InstantAyurved hospital" loading="lazy">
        <div>
            <h2>{{ $experience['home_facility_heading'] }}</h2>
            <p>{{ $experience['home_facility_copy'] }}</p>
            <a class="text-link" href="{{ route('facility') }}">See our facilities →</a>
        </div>
    </div>
</section>
@include('public.location-cards')
<section class="section reference-values">
    <div class="container">
        <h2>{{ $experience['home_values_heading'] }}</h2>
        <div class="cards">
            @foreach(preg_split('/\R/', $experience['home_values_items'], -1, PREG_SPLIT_NO_EMPTY) as $item)
                @php([$title, $description] = array_pad(explode('|', $item, 2), 2, ''))
                <article class="quote-card"><h3>{{ trim($title) }}</h3><p>{{ trim($description) }}</p></article>
            @endforeach
        </div>
    </div>
</section>
@if($reviews->isNotEmpty())
<section class="section container">
    <div class="section-heading split"><h2>{{ $experience['home_review_heading'] }}</h2><a class="text-link" href="{{ route('reviews') }}">All reviews →</a></div>
    <div class="cards">
        @foreach($reviews as $review)
            @include('public.review-card', ['review' => $review])
        @endforeach
    </div>
</section>
@endif
@if($featuredVideos->isNotEmpty())
<section class="section container">
    <div class="section-heading split">
        <h2>{{ $experience['home_video_heading'] }}</h2>
        <a class="text-link" href="{{ route('treatment-videos') }}">View all videos →</a>
    </div>
    <div class="cards">
        @foreach($featuredVideos as $video)
            @include('public.video-card')
        @endforeach
    </div>
</section>
@endif
@if($posts->isNotEmpty())
<section class="section container">
    <div class="section-heading split"><h2>Ayurveda journal</h2><a class="text-link" href="{{ route('blog.index') }}">Visit the blog →</a></div>
    <div class="cards">
        @foreach($posts as $post)
            <article class="journal-card">
                @if($post->media)<a href="{{ $post->public_url }}"><img loading="lazy" src="{{ $post->media->url }}" alt="{{ $post->media->alt }}"></a>@endif
                <h3><a href="{{ $post->public_url }}">{{ $post->title }}</a></h3>
                <p>{{ $post->description }}</p>
            </article>
        @endforeach
    </div>
</section>
@endif
<section class="container spatial-answer" aria-label="About InstantAyurved">
    <p>{{ $experience['search_answer'] }}</p>
    <a href="{{ route('about') }}">About the hospital</a>
</section>
<section class="container spatial-cta">
    <div>
        <h2>{{ $experience['home_cta_heading'] }}</h2>
        <p>{{ $experience['home_cta_copy'] }}</p>
    </div>
    <a class="btn" href="{{ route('contact') }}">Request a consultation</a>
</section>
@endsection
