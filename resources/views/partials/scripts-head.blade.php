<!-- resources/views/partials/scripts-head.blade.php -->

<!-- Meta Tags Essentiels -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="@yield('meta-description', 'Tableau de bord administratif MFPT')">
<meta name="keywords" content="MFPT, administration, tableau de bord, gestion">

<!-- Préchargement des ressources critiques -->
<link rel="preload" href="{{ asset('fonts/poppins-v20-latin-regular.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="preconnect" href="https://cdn.jsdelivr.net">
<link rel="dns-prefetch" href="https://cdn.jsdelivr.net">


<!-- Chargement du CSS -->
<link href="{{ mix('css/app.css') }}" rel="stylesheet">

<!-- Chargement du JS -->
<script src="{{ mix('js/app.js') }}" defer></script>


<!-- Chargement conditionnel des polyfills -->
<script>
    // Test des fonctionnalités modernes
    var supports = {
        es6: typeof Promise !== 'undefined' &&
             typeof Set !== 'undefined' &&
             typeof Object.assign !== 'undefined',
        intersectionObserver: 'IntersectionObserver' in window,
        fetch: 'fetch' in window
    };

    // Chargement des polyfills si nécessaire
    if (!supports.es6 || !supports.intersectionObserver || !supports.fetch) {
        var polyfillUrl = 'https://polyfill.io/v3/polyfill.min.js?features=';
        var features = [];

        if (!supports.es6) features.push('es6');
        if (!supports.intersectionObserver) features.push('IntersectionObserver');
        if (!supports.fetch) features.push('fetch');

        document.write('<script src="' + polyfillUrl + features.join('%2C') + '" crossorigin="anonymous"><\/script>');
    }
</script>

<!-- Analytics (optionnel) -->
@production
    <script async src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'GA_MEASUREMENT_ID');
    </script>
@endproduction

<!-- Préchargement du CSS principal -->
<link rel="preload" href="{{ mix('css/app.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="{{ mix('css/app.css') }}"></noscript>

<!-- Chargement non bloquant des icônes Bootstrap -->
<link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</noscript>

<!-- Scripts de configuration initiaux -->
<script>
    // Configuration globale
    window.AppConfig = {
        csrfToken: document.querySelector('meta[name="csrf-token"]').content,
        environment: '{{ config('app.env') }}',
        baseUrl: '{{ url('/') }}',
        locale: '{{ app()->getLocale() }}',
        timezone: '{{ config('app.timezone') }}'
    };

    // Gestion des erreurs globales
    window.addEventListener('error', function(e) {
        if (window.console && console.error) {
            console.error('Global error:', e.error || e.message, e);
        }

        // En production, envoyer l'erreur au serveur
        @production
            fetch('/api/log-error', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.AppConfig.csrfToken
                },
                body: JSON.stringify({
                    message: e.message,
                    stack: e.error ? e.error.stack : null,
                    url: window.location.href
                })
            });
        @endproduction
    });
</script>
