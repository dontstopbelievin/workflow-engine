@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <body class="bg-white font-family-karla h-screen">

        <div class="w-full flex flex-wrap">

            <!-- Register Section -->
            <div class="w-full md:w-2/5 flex flex-col">

                <div class="flex justify-center md:justify-start pt-12 md:pl-12 md:-mb-12">
                    <a href="#" class="p-4"><img src="/images/astana-logo.png"></a>
                </div>

                <div class="flex flex-col justify-center md:justify-start my-auto pt-8 md:pt-0 px-8 md:px-24 lg:px-32">
                    <p class="text-center text-3xl">Электронные услуги</p>
                    <form class="flex flex-col pt-3 md:pt-8" onsubmit="event.preventDefault();">
                        <div class="flex flex-col pt-4">
                            <label for="name" class="text-lg">ФИО</label>
                            <input type="text" id="name" placeholder="Кайсаров Кайсар Кайсарулы"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="flex flex-col pt-4">
                            <label for="email" class="text-lg">Ваш email</label>
                            <input type="email" id="email" placeholder="your@email.com"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="flex flex-col pt-4">
                            <label for="password" class="text-lg">Придумайте пароль</label>
                            <input type="password" id="password" placeholder="Ваш пароль"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="flex flex-col pt-4">
                            <label for="confirm-password" class="text-lg">Повторите пароль</label>
                            <input type="password" id="confirm-password" placeholder="Ваш пароль"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <button type="submit"
                            class="btn btn-primary bg-indigo-500 text-white font-bold text-lg hover:bg-indigo-600 p-2 mt-8">
                            {{ __('Зарегистрироваться') }}
                        </button>
                    </form>
                    <div class="text-center pt-12 pb-12">
                        <p>Уже зарегистрированы? <a href="{{ route('login') }}" class="underline font-semibold">Авторизоваться</a>
                        </p>
                    </div>
                </div>

            </div>

            <!-- Image Section -->
            <div class="w-1/2">
                <img class="object-contain w-full h-screen hidden md:block" src="/images/shutterstock_1124764481.jpg">
            </div>
        </div>

    </body>
@endsection
