<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <meta name="author" content="@yield('author', '@pulodev')">
    <meta name="description" content="@yield('desc')">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@pulodev">
    <meta name="twitter:creator" content="@yield('author', '@pulodev')">
    <meta name="twitter:title" content="@yield('title')">
    <meta name="twitter:url" content="https://pulo.dev">
    <meta name="twitter:description" content="@yield('desc')">
    <meta name="twitter:image:src" content="@yield('img', 'https://ik.imagekit.io/pulodev/pulodev-card_ovGTz2WNu8S.png')">

    <meta property="og:title" content="@yield('title')" />
    <meta property="og:description" content="@yield('desc')" />
    <meta property="og:image" content="@yield('img', 'https://ik.imagekit.io/pulodev/pulodev-card_ovGTz2WNu8S.png')">

    @yield("metaextra")

    @if (App::environment('local') || App::environment('testing'))
        <meta name="robots" content="noindex" /> 
    @else
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-180312472-1"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-180312472-1');
        </script>
    @endif

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;600&family=Quicksand&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.0/css/bulma.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
</head>

<body>
    <div id="base-container">
        <nav class="navbar is-info" role="navigation" aria-label="main navigation">
            <div class="container">
            <div class="navbar-brand has-background-primary">
                <a class="navbar-item" href="/">
                <img src="https://ik.imagekit.io/pulodev/logo-text-white_nO4dn6hwTz5Q.png" alt="logo pulodev">
                </a>

                <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>

            <div class="navbar-menu" id="nav-menu">
                @if (!Auth::guest())
                    <div class="navbar-start">   
                        <a class="navbar-item" href="/{{'@'.Auth::user()->username}}">Profil</a>
                        <a class="navbar-item" href='/link/create'>Link Baru +</a>
                        <a class="navbar-item" href='/resource/create'>RSS Baru +</a>
                    </div>

                    <div class="navbar-end">
                        <a class="navbar-item" href="/logout">Logout</a>
                    </div>
                @else
                    <div class="navbar-end">
                        <a class="navbar-item" href="/register">Daftar</a>
                        <a class="navbar-item" href="/login">Masuk</a>
                    </div>
                @endif
            </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const navBurger = $('.navbar-burger')[0]
                    navBurger.addEventListener('click', function() {
                            navBurger.classList.toggle('is-active');
                            $('#nav-menu').classList.toggle('is-active');
                    })
                });
            </script>
        </nav>
        <div id="main-container">
            <main>
                @yield('content')
            </main>

            <footer>
                @include('layouts.footer')
            </footer>
        </div>
    </div>
</body>
</html>