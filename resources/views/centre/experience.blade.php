@extends('layouts.admin')
@section('title', 'Homepage, SEO & GEO')
@section('content')
<section class="card">
    <form method="post" action="{{ route('experience.update') }}" class="form-grid">
        @csrf @method('PUT')
        <p>Blank search fields are generated from your website settings. The public quick answer also provides the default search description.</p>
        @foreach($fields as $key => [$label, $default, $max])
            <label>{{ $label }}
                <textarea name="{{ $key }}" maxlength="{{ $max }}" rows="{{ $max > 120 ? 3 : 1 }}" placeholder="{{ $preview[$key] }}">{{ old($key, $settings[$key] ?? '') }}</textarea>
                @error($key)<small>{{ $message }}</small>@enderror
            </label>
        @endforeach
        <button class="button primary" type="submit">Save settings</button>
    </form>
</section>
<section class="card">
    <h2>Source blog archive</h2>
    <p>Import the source article and listing excerpts as drafts for editorial review. Existing slugs are skipped.</p>
    <form method="post" action="{{ route('experience.import-articles') }}">
        @csrf
        <button class="button primary" type="submit">Import article drafts</button>
    </form>
</section>
@endsection
