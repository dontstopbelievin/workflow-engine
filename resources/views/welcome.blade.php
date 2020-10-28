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
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
            <div class="top-right links text-center">
                @auth
                    <a class="inline-block" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                        {{ __('Выйти') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <!-- This is an example component -->
                    <div class="inline-flex md:flex-wrap">
                        <div class="relative inline-flex">
                            <svg class="w-2 h-2 absolute top-0 right-0 m-4 pointer-events-none"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 412 232">
                                <path
                                    d="M206 171.144L42.678 7.822c-9.763-9.763-25.592-9.763-35.355 0-9.763 9.764-9.763 25.592 0 35.355l181 181c4.88 4.882 11.279 7.323 17.677 7.323s12.796-2.441 17.678-7.322l181-181c9.763-9.764 9.763-25.592 0-35.355-9.763-9.763-25.592-9.763-35.355 0L206 171.144z"
                                    fill="#648299" fill-rule="nonzero" />
                            </svg>
                            <select
                                class="border border-gray-300 rounded-full text-gray-600 h-10 pl-5 pr-10 bg-white hover:border-gray-400 focus:outline-none appearance-none">
                                <option disabled class="font-bold">Правила информационной безопасности</option>
                                <option type="submit" onclick="window.open('/policy docs/1 - Политика информ безопасности.pdf')">Политика информ. безопасности</option>
                                <option type="submit" onclick="window.open('/policy docs/2 - Правила организации физ защиты.pdf')">Правила организации физ защиты</option>
                                <option type="submit" onclick="window.open('/policy docs/3 - Правила использования моб устройств.pdf')">Правила организации моб. устройств</option>
                                <option type="submit" onclick="window.open('/policy docs/4 - Регламент резервного копирования.pdf')">Регламент резерв. копирования</option>
                                <option type="submit" onclick="window.open('/policy docs/5 - Правила использования крипто защиты.pdf')">Правила использования крипто защиты</option>
                                <option type="submit" onclick="window.open('/policy docs/6 - Правила организации аутентификации.pdf')">Правила организации аутентификации</option>
                                <option type="submit" onclick="window.open('/policy docs/7 - Правила организации антивирусного.pdf')">Правила организации антивирус.</option>
                                <option type="submit" onclick="window.open('/policy docs/8 - Инструкция о порядке действий пользователей.pdf')">Инструкция о порядке действий</option>
                                <option type="submit" onclick="window.open('/policy docs/9 - Методики оценки рисков.pdf')">Методики оценки рисков</option>
                                <option type="submit" onclick="window.open('/policy docs/10 - Правила идент, классиф и маркировки.pdf')">Правила идентиф, классиф и маркир.</option>
                                <option type="submit" onclick="window.open('/policy docs/11 - Правила обеспечения непрерывной.pdf')">Правила обеспечения непрерывной</option>
                                <option type="submit" onclick="window.open('/policy docs/12 - Правила инвентаризации и паспортизации.pdf')">Правила инвент. и паспортизации</option>
                                <option type="submit" onclick="window.open('/policy docs/13 - Правила проведения внутреннего аудита.pdf')">Правила проведения внутр. аудита</option>
                                <option type="submit" onclick="window.open('/policy docs/14 - Правила использования сети и почты.pdf')">Правила использования сети и почты</option>
                                <option type="submit" onclick="window.open('/policy docs/15 - Правила разгранечения прав доступа.pdf')">Правила разгранечения прав доступа</option>
                            </select>
                        </div>
                    </div>
                    <a href="{{ route('login') }}">Авторизоваться</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Зарегистрироваться</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="content">
            <section class="text-gray-700 body-font">
                <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center">
                    <div
                        class="lg:flex-grow md:w-1/2 lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
                        <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">Добро пожаловать!
                        </h1>
                        <p class="mb-2 leading-relaxed">Для начала не забудьте пройти авторизацию</p>
                        <div class="flex justify-center">
                            <a href="/dashboard">
                                <button
                                    class="inline-flex w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Войти</button>
                            </a>
                        </div>
                    </div>
                    <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6">
                        <img class="object-contain object-center rounded" alt="hero"
                            src="/images/Way-of-Working-720x600.jpeg">
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>

</html>
