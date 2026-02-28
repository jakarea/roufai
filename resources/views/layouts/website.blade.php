<!doctype html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO -->
    <title>@yield('title', 'আব্দুর রউফ - AI Creative Training Platform')</title>
    <meta name="description" content="@yield('description', 'বাংলাদেশের শীর্ষ এআই ক্রিয়েটিভ ট্রেনিং প্ল্যাটফর্ম')">
    <meta name="keywords" content="@yield('keywords', 'AI, Creative, Training, Bangladesh, এআই, ক্রিয়েটিভ, ট্রেনিং')">

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('og_title', 'আব্দুর রউফ - AI Creative Training Platform')">
    <meta property="og:description" content="@yield('og_description', 'বাংলাদেশের শীর্ষ এআই ক্রিয়েটিভ ট্রেনিং প্ল্যাটফর্ম')">
    <meta property="og:image" content="@yield('og_image', asset('/images/og-image.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@100..900&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/css/website.css', 'resources/js/website.js'])

    <!-- Critical CSS - Inline to prevent FOUC -->
    <style>
        body{
            font-family: "Noto Sans Bengali", sans-serif;
        }
        .get-bg {
            background: linear-gradient(180deg, #011A1D 0%, #010E10 100%);
        }
        .bg-step-img {
            background: linear-gradient(180deg, #011A1D 0%, #010E10 100%);
        }

        /* Loading state to prevent FOUC */
        #page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #0A0A0A;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 99999;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        #page-loader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loader-spinner {
            width: 50px;
            height: 50px;
            border: 3px solid rgba(232, 80, 255, 0.1);
            border-top-color: #E850FF;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Hide content until loaded */
        body.loading #main-content {
            display: none;
        }
    </style>

    @yield('styles')
</head>

<body class="bg-[#0A0A0A] relative loading">

    <!-- Page Loader -->
    <div id="page-loader">
        <div class="loader-spinner"></div>
    </div>

    {{-- <img src="{{ asset('webiste-images/hero-ellipse.svg') }}" alt="ellipse"
            class="absolute left-0 top-0 lg:object-contain lg:h-auto">  --}}

    {{-- Main Content --}}
    <div id="main-content">
        @yield('content')
    </div> 

    {{-- Footer --}}
    @include('website.partials.footer')

    <!-- Scripts - Move JS after inline script -->
    @yield('scripts')
    @vite(['resources/js/app.jsx'])

    <script>
        // Remove loader when page is fully loaded
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.body.classList.remove('loading');
                const loader = document.getElementById('page-loader');
                if (loader) {
                    loader.classList.add('hidden');
                    setTimeout(() => {
                        loader.style.display = 'none';
                    }, 300);
                }
            }, 100);
        });

        // Fallback: remove loader after 3 seconds even if not fully loaded
        setTimeout(function() {
            document.body.classList.remove('loading');
            const loader = document.getElementById('page-loader');
            if (loader && !loader.classList.contains('hidden')) {
                loader.classList.add('hidden');
                setTimeout(() => {
                    loader.style.display = 'none';
                }, 300);
            }
        }, 3000);
    </script>
</body>

</html>
