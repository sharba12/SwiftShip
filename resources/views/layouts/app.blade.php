<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'MyApp') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/swiftship-logo.svg') }}">
    <link rel="shortcut icon" href="{{ asset('images/swiftship-logo.svg') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    @include('partials.theme')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-light">
    @include('layouts.navigation')

    <main class="py-4 container">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
