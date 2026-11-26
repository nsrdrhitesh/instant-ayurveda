
@extends('layouts.public')
@section('title','Our Story')
@section('content')
<section class="page-intro container"><p class="eyebrow">THE HEART BEHIND INSTANTAYURVED</p><h1>A purpose rooted<br>in healing.</h1><p>{{ $website['founder_intro'] }}</p></section><section class="section container detail-grid"><article class="prose"><h2>{{ $website['founder_name'] }}</h2><p class="eyebrow">FOUNDER, INSTANTAYURVED</p>{!! $website['story_html'] !!}</article><aside>
@if($portrait)<figure><img class="founder-portrait" src="{{ $portrait->url }}" alt="{{ $portrait->alt }}"><figcaption>{{ $website['founder_name'] }}</figcaption></figure>
@endif<div class="story-mark"><span>15+</span><p>Years of practice.<br>Thousands of patients supported.</p><div aria-hidden="true">✳</div></div></aside></section>
@endsection
