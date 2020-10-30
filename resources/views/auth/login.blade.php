@extends('layouts.app')

@section('content')
    <body class="bg-white h-screen">

        <div class="w-full flex flex-wrap">

            <!-- Login Section -->
            <div class="w-full md:w-2/5 flex flex-col">

                <div class="flex justify-center md:justify-start pt-12 md:pl-12 md:-mb-24">
                    <a href="#" class="p-4"><img src="/images/astana-logo.png"></a>
                </div>

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
                    {{-- <div class="text-center pt-12 pb-12">
                        <p>Еще не зарегистрирован? <a href="{{ route('register') }}"
                                class="underline font-semibold">Зарегистрироваться</a></p>
                    </div> --}}
                </div>

            </div>

            <!-- Image Section -->
            <div class="w-1/2">
                <img class="object-contain w-full h-screen hidden md:block" src="/images/shutterstock_1124764481.jpg">
            </div>
        </div>

    </body>
@endsection
