@extends('layouts.admin')
@section('title', 'Newsletter subscribers')
@section('content')
<section class="card">
    <h2>Subscribers</h2>
    @forelse($subscribers as $subscriber)
        <p>{{ $subscriber->email }} <small>{{ $subscriber->consented_at }}</small></p>
    @empty
        <p>No subscriptions yet.</p>
    @endforelse
    {{ $subscribers->links() }}
</section>
@endsection
