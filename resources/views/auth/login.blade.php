@extends('layouts.app')

@section('title')
    Авторизация
@endsection

@section('content')

    <head>
        <title>Вход без ЭЦП</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
            rel="stylesheet" />
        <link rel="stylesheet" href="../assets/css/tailwind.output.css" />
        <script src="https://www.google.com/recaptcha/api.js"></script>
    </head>

    <body class="pt-8">
        <div class="flex items-center min-h-screen p-6">
            <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
                <div class="flex flex-col overflow-y-auto md:flex-row">
                    <div class="h-32 md:h-auto md:w-1/2">
                        <img aria-hidden="true" class="object-contain w-full h-full dark:hidden"
                            src="/images/shutterstock_1124764481.jpg" alt="Office" />
                        <img aria-hidden="true" class="hidden object-contain w-full h-full dark:block"
                            src="../assets/img/login-office-dark.jpeg" alt="Office" />
                    </div>
                    <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                        <div class="w-full">
                            <div class="flex justify-center md:justify-start">
                                <a href="#" class="p-4"><img src="/images/astana-logo.png"></a>
                            </div>
                            <h1 class="mb-4 text-center text-xl font-semibold text-gray-700 dark:text-gray-200">
                                Вход без ЭЦП
                            </h1>
                            <form class="flex flex-col pt-3 md:pt-8" action="/login" method="post">
                                @csrf
                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Ваш email</span>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                                        class="@error('email') is-invalid @enderror block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                        placeholder="aset@gmail.com" />
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </label>
                                <label class="block mt-4 text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Ваш пароль</span>
                                    <input
                                        class="@error('password') is-invalid @enderror block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                        placeholder="***************" type="password" name="password" id="password" />
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </label>
                                <div class="g-recaptcha mt-4 text-sm" data-sitekey="6LcOIv4ZAAAAAOH6sKrJvbkej4SoRlrOI6dw0yeU"></div>
                                <button type="submit"
                                    class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-900 hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue
">
                                    {{ __('Войти') }}
                                </button>
                                @if (Route::has('password.request'))
                                    <a class="flex flex-wrap text-sm font-medium text-blue-800 hover:underline" href="{{ route('password.request') }}">
                                        {{ __('Сменить пароль') }}
                                    </a>
                                @endif
                            </form>
                            <a class="flex flex-wrap text-sm font-medium text-blue-800 hover:underline"
                                href="/loginwithecp">
                                Вход по ЭЦП
                            </a>
                    {{-- <div class="text-center pt-12 pb-12">
                        <p>Еще не зарегистрирован? <a href="{{ route('register') }}"
                                class="underline font-semibold">Зарегистрироваться</a></p>
                    </div> --}}
                </div>
            </div>
        </div>
    </body>

    </html>
@endsection
