<!DOCTYPE html>
<html lang="fr" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Tableau de bord d'administration MFPT">
    <title>@yield('title', 'MFPT Admin')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" sizes="any">
    <link rel="icon" href="{{ asset('icon.svg') }}" type="image/svg+xml" sizes="any">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <!-- Preload critical resources -->
    <link rel="preload" href="{{ asset('css/app.css') }}" as="style">
    <link rel="preload" href="{{ asset('js/app.js') }}" as="script">

    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">

    <head>
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    </head>

    <!-- Styles -->
    @includeWhen(config('app.env') !== 'testing', 'partials.styles')
    @stack('styles')

    <!-- Scripts head -->
    @includeWhen(config('app.debug'), 'partials.scripts-head')
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Skip to main content -->
    <a href="#main-content" class="visually-hidden-focusable position-absolute top-0 start-0 p-2 bg-dark text-white">Aller au contenu principal</a>

    <!-- Barre de navigation -->
    @includeWhen(auth()->check(), 'partials.navbar')

    <!-- Contenu principal -->
    <main id="main-content" class="flex-shrink-0" role="main">
        <div class="container-fluid px-3 px-md-4">
            <div class="row g-0">
                <!-- Sidebar -->
                @auth
                    @unless(request()->is('/'))
                        <aside class="col-md-3 col-lg-2 d-none d-md-block sidebar-container" aria-label="Menu principal">
                            @include('partials.sidebar')
                        </aside>
                    @endunless
                @endauth

                <!-- Contenu dynamique -->
                <div class="@auth @unless(request()->is('/')) col-md-9 col-lg-10 @else col-12 @endunless @else col-12 @endauth main-content-container">
                    <div class="container-fluid py-3 py-md-4">
                        @include('partials.flash-messages')
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Pied de page -->
    @includeWhen(config('app.show_footer', true), 'partials.footer')

    <!-- Scripts -->
    @include('partials.scripts')
    @stack('scripts')
</body>
</html>
