@if($locations->isNotEmpty())
@php
    $schema = app(\App\Services\CentreSchema::class);
    $locationSchema = app(\App\Services\ExperienceSettings::class)->locations($locations, $schema->organization()['@id']);
@endphp
@if($locationSchema['@graph'])
    <script type="application/ld+json">{!! $schema->encode($locationSchema) !!}</script>
@endif
<section class="section container">
    <div class="section-heading"><h2>Hospital locations</h2></div>
    <div class="cards">
        @foreach($locations as $location)
            <article class="quote-card" id="location-{{ $location->id }}">
                <h3>{{ $location->name }}</h3>
                <p>{{ implode(', ', array_filter([$location->address, $location->city, trim($location->state.' '.$location->postal_code)])) }}</p>
                @unless($location->address && $location->phone)
                    <p>Some visitor details are pending verification.</p>
                @endunless
                @if($location->phone)
                    <p><a href="tel:{{ preg_replace('/[^0-9+]/', '', $location->phone) }}">{{ $location->phone }}</a></p>
                @endif
                @if($location->email)
                    <p><a href="mailto:{{ $location->email }}">{{ $location->email }}</a></p>
                @endif
                @if($location->opening_hours)
                    <p>{{ $location->opening_hours }}</p>
                @endif
                @if($location->map_url)
                    <a class="text-link" href="{{ $location->map_url }}">Open map</a>
                @endif
            </article>
        @endforeach
    </div>
</section>
@endif
