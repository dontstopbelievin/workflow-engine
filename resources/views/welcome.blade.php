<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Добро пожаловать</title>

        <!-- Link to CSS -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Styles -->
        <style>
            html, body {
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

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
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
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        {{-- <a href="{{ url('/home') }}">Home</a> --}}
                    @else
                        <a href="{{ route('login') }}">Авторизация</a>

                        {{-- @if (Route::has('register'))
                            <a href="{{ route('register') }}">Зарегистрироваться</a>
                        @endif --}}
                    @endauth
                </div>
            @endif

            <div class="content">
                <section class="text-gray-700 body-font">
                    <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center">
                      <div class="lg:flex-grow md:w-1/2 lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
                        <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">Добро пожаловать!</h1>
                        <p class="mb-8 leading-relaxed">Для начала не забудьте пройти авторизацию</p>
                        <div class="flex justify-center">
                            <a href="/services">
                                <button class="inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">Войти</button>
                            </a>
                        </div>
                      </div>
                      <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6">
                        <img class="object-cover object-center rounded" alt="hero" src="/images/Way-of-Working-720x600.jpeg">
                      </div>
                    </div>
                  </section>
            </div>
        </div>
    </body>
</html>
