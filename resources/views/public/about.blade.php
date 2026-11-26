@extends('layouts.public')
@php($pageCopy = app(\App\Services\ExperienceSettings::class)->content($website))
@section('title',$pageCopy['about_page_title'])
@section('description',$pageCopy['about_page_description'])
@section('content')
<section class="page-intro container"><h1>{{ $pageCopy['about_page_title'] }}</h1><p>{{ $pageCopy['about_page_description'] }}</p></section>
@if($pageCopy['about_page_content'])
<section class="section container prose">{!! $pageCopy['about_page_content'] !!}</section>
@else
<section class="section container detail-grid">
    <div class="prose"><h2>Our purpose</h2><p>To make traditional Ayurvedic knowledge accessible through careful assessment, personalised plans and respectful communication.</p><h2>Our approach</h2><p>We combine Ayurvedic diagnosis, classical therapies and practical lifestyle guidance. Plans may include herbal medicine, diet, Panchakarma, therapeutic yoga or specialised Ayurvedic procedures.</p><h2>Our standard of care</h2><ul><li>Individual case evaluation</li><li>Transparent consultation and follow-up</li><li>Traditional therapies with modern hygiene practices</li><li>Care focused on long-term wellbeing</li></ul></div>
    <aside class="info-card"><h2>Start with an assessment</h2><p>Share your concerns and suitable appointment options will be discussed with the care team.</p><a class="btn" href="{{ route('contact') }}">Book consultation <span>↗</span></a></aside>
</section>
@endif
@endsection
