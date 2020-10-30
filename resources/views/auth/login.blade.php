@extends('layouts.app')

@section('title')
    Авторизация
@endsection

@section('content')

    <html :class="{ 'theme-dark': dark } bg-gray-50 dark:bg-gray-900" x-data="data()" lang="en">

    <head>
        <title>Вход без ЭЦП</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
            rel="stylesheet" />
        <link rel="stylesheet" href="../assets/css/tailwind.output.css" />
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <script src="../assets/js/init-alpine.js"></script>
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
                                    <input type="email" name="email" id="email"
                                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                        placeholder="aset@gmail.com" />
                                </label>
                                <label class="block mt-4 text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Ваш пароль</span>
                                    <input
                                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                        placeholder="***************" type="password" name="password" id="password" />
                                </label>

                <div class="flex flex-col justify-center md:justify-start my-auto pt-8 md:pt-0 px-8 md:px-24 lg:px-32">
                    <p class="text-center text-3xl">Электронные услуги</p>
                    <form class="flex flex-col pt-3 md:pt-8" action="/login" method="post">
                        @csrf
                        <div class="flex flex-col pt-4">
                            <label for="email" class="text-lg">Ваш email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="@error('email') is-invalid @enderror shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline required">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="flex flex-col pt-4">
                            <label for="password"  class="text-lg">Пароль</label>
                            <input type="password" name="password" id="password"
                                class="@error('password') is-invalid @enderror shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline"  required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <button type="submit"
                            class="btn btn-primary bg-indigo-500 text-white font-bold text-lg hover:bg-indigo-600 p-2 mt-8">
                            {{ __('Войти') }}
                        </button>
                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Забыли пароль?') }}
                            </a>
                        @endif
                    </form>
                    <a class="flex flex-wrap text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline"
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
