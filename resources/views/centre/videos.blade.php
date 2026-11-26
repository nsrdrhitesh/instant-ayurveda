@extends('layouts.admin')
@section('title', 'Treatment Videos')
@section('description', 'Manage the public YouTube video catalogue.')
@section('content')
@foreach(collect([null])->concat($videos) as $video)
<section class="card">
    <h2>{{ $video?->title ?? 'Add video' }}</h2>
    <form method="post" action="{{ $video ? route('videos-admin.update', $video) : route('videos-admin.store') }}" class="form-grid">
        @csrf
        @if($video) @method('PUT') @endif
        <label>YouTube URL <input name="youtube_url" type="url" required value="{{ $video ? 'https://youtu.be/'.$video->youtube_id : '' }}"></label>
        <label>Title <input name="title" required maxlength="180" value="{{ $video?->title }}"></label>
        <label>Category <input name="category" maxlength="100" value="{{ $video?->category }}"></label>
        <label>Description <textarea name="description" maxlength="3000">{{ $video?->description }}</textarea></label>
        <label>Display order <input name="display_order" type="number" min="0" max="9999" required value="{{ $video?->display_order ?? 0 }}"></label>
        <label><input name="published" type="checkbox" value="1" @checked($video?->published)> Published</label>
        <label><input name="featured" type="checkbox" value="1" @checked($video?->featured)> Featured</label>
        <button class="button primary" type="submit">{{ $video ? 'Save video' : 'Add video' }}</button>
    </form>
    @if($video)
        <form method="post" action="{{ route('videos-admin.destroy', $video) }}" onsubmit="return confirm('Remove this video?')">
            @csrf @method('DELETE')
            <button class="button danger" type="submit">Remove video</button>
        </form>
    @endif
</section>
@endforeach
@endsection
