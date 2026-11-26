@extends('layouts.public')
@section('title', 'Treatment Videos')
@section('description', 'Watch Ayurvedic treatment and health education videos from Dr. Tejas Kadam.')
@section('content')
<section class="page-intro container">
    <h1>Ayurvedic treatment videos</h1>
    <p>Educational videos from Dr. Tejas Kadam.</p>
</section>
<section class="section container">
    <form method="get" action="{{ route('treatment-videos') }}">
        <label for="category">Category</label>
        <select name="category" id="category">
            <option value="">All categories</option>
            @foreach($categories as $option)
                <option value="{{ $option }}" @selected($category === $option)>{{ $option }}</option>
            @endforeach
        </select>
        <button class="btn" type="submit">Filter</button>
    </form>
    <div class="cards">
        @forelse($videos as $video)
            @include('public.video-card')
        @empty
            <p>No videos are available in this category.</p>
        @endforelse
    </div>
</section>
@endsection
