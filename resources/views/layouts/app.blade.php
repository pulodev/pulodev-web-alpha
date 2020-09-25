<!-- =====================================================================================================
============================== Halooo !!! ngintip aja nih ================================================
==========================================================================================================

NYARI APA NIH? HEHE...
SELAMAT BELAJAR, JANGAN JADI ORANG BIASA !!! HUSST JANGAN BILANG BILANG UDAH LIAT INI !

.-')      ('-.  .-. .-')                            ('-.     ('-. .-.      .-. .-')               _ .-') _                .-') _
( OO ).  _(  OO) \  ( OO )                          ( OO ).-.( OO )  /      \  ( OO )             ( (  OO) )              ( OO ) )
(_)---\_)(,------.,--. ,--.  .-'),-----.  ,--.       / . --. /,--. ,--.      ,--. ,--.  .-'),-----. \     .'_   ,-.-') ,--./ ,--,'  ,----.
/    _ |  |  .---'|  .'   / ( OO'  .-.  ' |  |.-')   | \-.  \ |  | |  |      |  .'   / ( OO'  .-.  ',`'--..._)  |  |OO)|   \ |  |\ '  .-./-')
\  :` `.  |  |    |      /, /   |  | |  | |  | OO ).-'-'  |  ||   .|  |      |      /, /   |  | |  ||  |  \  '  |  |  \|    \|  | )|  |_( O- )
'..`''.)(|  '--. |     ' _)\_) |  |\|  | |  |`-' | \| |_.'  ||       |      |     ' _)\_) |  |\|  ||  |   ' |  |  |(_/|  .     |/ |  | .--, \
.-._)   \ |  .--' |  .   \    \ |  | |  |(|  '---.'  |  .-.  ||  .-.  |      |  .   \    \ |  | |  ||  |   / : ,|  |_.'|  |\    | (|  | '. (_/
\       / |  `---.|  |\   \    `'  '-'  ' |      |   |  | |  ||  | |  |      |  |\   \    `'  '-'  '|  '--'  /(_|  |   |  | \   |  |  '--'  |
`-----'  `------'`--' '--'      `-----'  `------'   `--' `--'`--' `--'      `--' '--'      `-----' `-------'   `--'   `--'  `--'   `------'

==========================================================================================================
==========================================================================================================
=======================================================================================================-->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <meta name="author" content="@yield('author', '@kodingclub')">
    <meta name="description" content="@yield('desc')">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@kodingclub">
    <meta name="twitter:creator" content="@yield('author', '@kodingclub')">
    <meta name="twitter:title" content="@yield('title')">
    <meta name="twitter:url" content="https://koding.club">
    <meta name="twitter:description" content="@yield('desc')">
    <meta name="twitter:image:src" content="@yield('img')">

    <meta property="og:title" content="@yield('title')" />
    <meta property="og:description" content="@yield('desc')" />
    <meta property="og:image" content="@yield('img')">

    @yield("metaextra")

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
    <nav class="navbar">
        <div class="navbar-menu">
        <a class="navbar-item" href="/">Home</a>
        @if (Auth::guest())
            <a class="navbar-item" href="/register">Register</a>
            <a class="navbar-item" href="/login">Login</a>
        @else   
            <a class="navbar-item" href="/{{'@'.Auth::user()->username}}">Profil</a>
            <a class="navbar-item" href="/logout">Logout</a>
            <a class="navbar-item button is-info mt-1" href='/link/create'>Link Baru +</a>
            &nbsp;
            <a class="navbar-item button is-info mt-1" href='/resource/create'>RSS Baru +</a>
        @endif
    </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        @include('layouts.footer')
    </footer>
</body>