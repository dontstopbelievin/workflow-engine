<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

   

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Link to CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

    </style><!-- Link to CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                    <!-- Right Side Of Navbar -->
                    <div class="top-right links text-center">
                            <!-- Authentication Links -->
                            @guest
                                <a href="{{ route('login') }}">Авторизация</a>
                                @if (Route::has('register'))
                                    {{-- <a href="{{ route('register') }}">Зарегистрироваться</a> --}}
                                @endif
                                @else
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                            {{ __('Выйти') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                            @endguest
                    </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
<script src=//www.gstatic.com/firebasejs/4.9.1/firebase.js></script>
<script type=text/javascript>
    var session_id = "{!! (Session::getId())?Session::getId():'' !!}";
    var user_id = "{!! (Auth::user())?Auth::user()->id:'' !!}";

    // Initialize Firebase
    var config = {
        apiKey: "firebase.api_key",
        authDomain: "firebase.auth_domain",
        databaseURL: "firebase.database_url",
        storageBucket: "firebase.storage_bucket",
    };
    firebase.initializeApp(config);

    var database = firebase.database();

    if({!! Auth::user() !!}) {
        firebase.database().ref('/users/' + user_id + '/session_id').set(session_id);
    }

    firebase.database().ref('/users/' + user_id).on('value', function(snapshot2) {
        var v = snapshot2.val();

        if(v.session_id != session_id) {
            toastr.warning('Your account login from another device!!', 'Warning Alert', {timeOut: 3000});
            setTimeout(function() {
                window.location = '/login';
            }, 4000);
        }
    });
</script>
</html>
