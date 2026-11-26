<div class="cards service-cards reference-service-cards">
@forelse($services as $s)
    <article class="service-card">
        @if($s->image_url)
            <a class="service-card-image" href="{{ $s->public_url }}"><img loading="lazy" src="{{ $s->image_url }}" alt="{{ $s->media?->alt ?? $s->name }}"></a>
        @endif
        <h3><a href="{{ $s->public_url }}">{{ $s->name }}</a></h3>
        <p>{{ $s->summary }}</p>
        <a class="text-link" href="{{ $s->public_url }}">Learn more <span aria-hidden="true">→</span></a>
    </article>
@empty
    <p>Contact us to discuss available treatments.</p>
@endforelse
@if(isset($experience) && !$services->contains('slug', 'online-consultation'))
    <article class="service-card">
        <a class="service-card-image" href="{{ route('contact') }}"><img loading="lazy" src="{{ asset('images/instant-ayurved/img/services/Online-Consultation.jpg') }}" alt=""></a>
        <h3><a href="{{ route('contact') }}">{{ $experience['home_online_title'] }}</a></h3>
        <p>{{ $experience['home_online_copy'] }}</p>
        <a class="text-link" href="{{ route('contact') }}">Book consultation <span aria-hidden="true">→</span></a>
    </article>
@endif
</div>
