@props(['index'])
<svg class="reference-trust-icon" aria-hidden="true" viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
    @switch($index)
        @case(0)
            <circle cx="12" cy="6" r="3"/>
            <path d="M4 21v-3a6 6 0 0 1 6-6h4a6 6 0 0 1 6 6v3M8 13v4m0 0a2 2 0 0 0 4 0v-2m4-2v4"/>
            <circle cx="16" cy="18.5" r="1.5"/>
            @break
        @case(1)
            <circle cx="7" cy="11" r="2"/>
            <path d="M3 6v14m0-4h18m0 4v-7a3 3 0 0 0-3-3h-6v6"/>
            @break
        @case(2)
            <path d="m3 10 9-7 9 7M5 9v12h14V9m-7 2v6m-3-3h6"/>
            @break
        @case(3)
            <circle cx="12" cy="8" r="5"/>
            <path d="m9 12-2 9 5-3 5 3-2-9m-5-4 1.5 1.5L14 7"/>
            @break
    @endswitch
</svg>
