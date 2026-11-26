@extends('layouts.public')
@php($pageCopy = app(\App\Services\ExperienceSettings::class)->content($website))
@section('title',$website['founder_name'] ?? 'Dr. Tejas Kadam')
@section('description',$pageCopy['doctor_page_description'])
@section('content')
<section class="page-intro container"><h1>{{ $website['founder_name'] ?? 'Dr. Tejas Kadam' }}</h1><p>{{ $website['founder_intro'] }}</p></section>
@if($pageCopy['doctor_page_content'])
<section class="section container prose">{!! $pageCopy['doctor_page_content'] !!}</section>
@else
<section class="section container detail-grid">
    <div class="prose">
        <img class="founder-portrait" src="{{ asset('images/instant-ayurved/img/dr.jpg') }}" alt="Dr. Tejas Kadam" style="max-height:520px;object-fit:cover;">
        <h2>Integrating traditional Ayurvedic knowledge</h2>
        <p>Dr. Tejas Kadam brings over 15 years of clinical experience and a focused specialisation in Ayurvedic surgery, Panchakarma and Kshar Sutra therapy.</p>
        <h2>Education</h2>
        <ul><li>M.S. in Shalya Tantra (Ayurvedic Surgery)</li><li>BAMS (Bachelor of Ayurvedic Medicine and Surgery)</li></ul>
        <h2>Areas of care</h2>
        <ul><li>Ayurvedic surgery and Kshar Sutra therapy</li><li>Panchakarma and detoxification</li><li>Chronic musculoskeletal disorders</li><li>Digestive, metabolic and lifestyle conditions</li><li>Yoga therapy and Ayurvedic nutrition</li></ul>
        <h2>Clinical philosophy</h2>
        <p>Every treatment plan begins with individual assessment. Care is designed around constitution, symptoms, lifestyle and the most appropriate traditional intervention, with clear discussion of expected benefits and limitations.</p>
    </div>
    <aside class="info-card"><h2>Book a consultation</h2><p>Discuss your condition, treatment options and suitability for Panchakarma or surgery.</p><a class="btn" href="{{ route('contact') }}">Request appointment <span>↗</span></a></aside>
</section>
@endif
@endsection
