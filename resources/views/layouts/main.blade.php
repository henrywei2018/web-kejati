<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Basic -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} | Porto - Multipurpose Website Template</title>
    <meta name="keywords" content="{{ $metaKeywords }}" />
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="author" content="okler.net">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('img/logo-kejati.png') }}" type="image/x-icon" />
    <link rel="apple-touch-icon" href="{{ asset('img/logo-kejati.png') }}">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

    <!-- Web Fonts -->
    <link id="googleFonts"
        href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/animate/animate.compat.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/simple-line-icons/css/simple-line-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/owl.carousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/owl.carousel/assets/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/magnific-popup/magnific-popup.min.css') }}">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/theme-elements.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/theme-blog.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/theme-shop.css') }}">

    <!-- Demo CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/demos/demo-accounting-1.css') }}">

    <!-- Skin CSS -->
    <link id="skinCSS" rel="stylesheet" href="{{ asset('frontend/css/skins/skin-accounting-1.css') }}">

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">

    @stack('styles')
    @livewireStyles
</head>

<body class="{{ $bodyClass ?? '' }}">
    <div class="body">
        <!-- Header Component -->
        @livewire('components.header')

        <!-- Main Content -->
        <div role="main" class="main px-3 px-lg-5">
            @isset($slot)
                {{ $slot }}
            @else
                @yield('content')
            @endisset
        </div>

        <!-- Footer Component -->
        @livewire('components.footer')
    </div>

    <!-- Off Canvas -->
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasMain"
        aria-labelledby="offcanvasMain">
        <div class="offcanvas-header">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="mb-4" id="offCanvasLogo"></div>
            <nav class="offcanvas-nav w-100" id="offCanvasNav"></nav>
        </div>
    </div>

    <!-- Vendor Scripts -->
    <script src="{{ asset('frontend/vendor/plugins/js/plugins.min.js') }}"></script>

    <!-- Theme Base, Components and Settings -->
    <script src="{{ asset('frontend/js/theme.js') }}"></script>

    <!-- Demo -->
    <script src="{{ asset('frontend/js/demos/demo-accounting-1.js') }}"></script>

    <!-- Theme Custom -->
    <script src="{{ asset('frontend/js/custom.js') }}"></script>

    <!-- Theme Initialization Files -->
    <script src="{{ asset('frontend/js/theme.init.js') }}"></script>

    @stack('scripts')
    @livewireScripts
</body>

</html>
