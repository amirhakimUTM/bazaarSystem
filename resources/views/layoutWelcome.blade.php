<!DOCTYPE html>
<html>

<head>
    <title>Pemuda GEMA Home
    </title>
    {{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('js/navbar.js') }}"></script> --}}

    <link rel="stylesheet" href="{{ asset('css/navbarWelcome.css') }}">
    <link rel="icon"
        href="https://lh3.googleusercontent.com/sFUuSENwas3aSplnXq5HXzsQm0ZA7D1ixJ8LE4opn9tJKKQvPVNSEBkOt_3m3zGrDZ-FD1Yp1AmchMss7M6Aj2A=w16383"
        type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        html,
        body {
            /* background-image: url('https://img.rawpixel.com/s3fs-private/rawpixel_images/website_content/rm456-010d-x.jpg?w=1200&h=1200&dpr=1&fit=clip&crop=default&fm=jpg&q=75&vib=3&con=3&usm=15&cs=srgb&bg=F4F4F3&ixlib=js-2.2.1&s=ddfae0564036e0a9cd5d20f02bb3cac7'); */
            background-color: #fff;
            background-repeat: no-repeat;
            /* background-size: 100% 100%; */
            background-size: cover;
            color: black;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100%;
            margin: 0;
        }
    </style>

</head>

<body>
    <div class="container-fluid">
        <div class="container-fluid">
            <nav class="navbar">
                <div class="logotitle">
                    <img src="{{ asset('picture/PemudaGEMA.png') }}" alt="Pemuda GEMA" width="40" height="40">
                    <a id="len1" class="hoverable" href="{{ route('home') }}">Pertubuhan Pemuda GEMA
                        Malaysia</a>
                </div>
                <ul>
                    @if (Route::has('login'))
                        @auth
                            <li><a href="{{ url('/home') }}" id="len1" class="hoverable">Dashboard</a></li>
                        @else
                            <li><a href="{{ route('login') }}" id="len1" class="hoverable">Log in</a></li>
                            @if (Route::has('register'))
                                <li><a href="{{ route('register') }}" id="len1" class="hoverable">Register</a></li>
                            @endif
                        @endauth
                    @endif
                    <li><a href="{{ url('/analysis/analysisByBazaar') }}" id="len1" class="hoverable">Analysis</a></li>
                </ul>
            </nav>
        </div>
        <main class="py-4">
            @yield('content')
        </main>
    </div>


</body>

</html>
