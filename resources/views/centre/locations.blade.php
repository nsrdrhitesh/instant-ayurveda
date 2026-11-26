@extends('layouts.admin')
@section('title','Hospital Locations')
@section('description','Manage the published hospital and clinic locations.')
@section('content')
<section class="card">
    <h2>Add location</h2>
    <form method="post" action="{{ route('locations.store') }}" class="form-grid">
        @csrf
        @include('centre.location-fields',['location'=>null])
        <button class="button primary" type="submit">Add location</button>
    </form>
</section>
@foreach($locations as $location)
<section class="card">
    <h2>{{ $location->name }}</h2>
    <form method="post" action="{{ route('locations.update',$location) }}" class="form-grid">
        @csrf @method('PUT')
        @include('centre.location-fields',['location'=>$location])
        <div class="actions"><button class="button primary" type="submit">Save location</button></div>
    </form>
    <form method="post" action="{{ route('locations.destroy',$location) }}" onsubmit="return confirm('Remove this location?')">
        @csrf @method('DELETE')<button class="button danger" type="submit">Remove</button>
    </form>
</section>
@endforeach
@endsection
