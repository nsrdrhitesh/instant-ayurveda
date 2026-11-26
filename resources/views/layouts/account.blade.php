<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow,noarchive">
    <title>@yield('title') · InstantAyurved</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/instant-ayurved/img/favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/account.css') }}?v=editorial-20261105">
    <script defer src="{{ asset('js/account.js') }}?v=editorial-20261105"></script>
</head>
<body>
<main class="account-shell">
    <a href="{{ route('home') }}" class="brand"><img src="{{ asset('images/instant-ayurved/img/favicon.svg') }}" width="56" height="56" alt=""><span>Instant<small>Ayurveda</small></span></a>
    <section class="panel">
        @yield('content')
    </section>
    <p class="footnote">A space to be heard, understood and supported.</p>
</main>
</body>
</html>
