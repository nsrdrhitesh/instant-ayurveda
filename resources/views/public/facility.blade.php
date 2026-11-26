@extends('layouts.public')
@php($pageCopy = app(\App\Services\ExperienceSettings::class)->content($website))
@section('title',$pageCopy['facility_page_title'])
@section('description',$pageCopy['facility_page_description'])
@section('content')
<section class="page-intro container"><h1>{{ $pageCopy['facility_page_title'] }}</h1><p>{{ $pageCopy['facility_page_description'] }}</p></section>
@if($pageCopy['facility_page_content'])
<section class="section container prose">{!! $pageCopy['facility_page_content'] !!}</section>
@else
<section class="section container">
    <div class="cards">
        @foreach([
            ['Panchakarma Department','Panchakarma-Department.jpg','Therapy rooms for Vamana, Virechana, Basti, Nasya and related procedures.'],
            ['Ayurvedic Surgery','Ayurvedic-Surgery-Department.jpg','Specialised surgical facilities for procedures including Kshar Sutra therapy.'],
            ['Yoga & Meditation','Yoga-Hall.jpg','Guided therapeutic yoga and meditation spaces.'],
            ['Diet & Nutrition','Diet-Department.jpg','Prakriti-based dietary planning and therapeutic nutrition.'],
            ['Herbal Pharmacy','Herbal-Garden.jpg','Medicinal herbs and Ayurvedic formulations supporting treatment plans.'],
            ['Reception & Care','Reception-Area.jpg','A welcoming reception and consultation process.']
        ] as $card)
        <article class="service-card"><img loading="lazy" src="{{ asset('images/instant-ayurved/img/'.$card[1]) }}" alt="{{ $card[0] }}"><h3>{{ $card[0] }}</h3><p>{{ $card[2] }}</p></article>
        @endforeach
    </div>
</section>
@endif
@include('public.location-cards')
@endsection
