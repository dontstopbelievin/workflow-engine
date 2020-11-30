@extends('layouts.app')

@section('content')
    <html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">

    <head>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    </head>

    <body class=" bg-gray-50 dark:bg-gray-900">
        <div class="flex items-center min-h-screen p-6">
            <div class="flex-1 h-full max-w-md mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
                <div class="flex flex-col overflow-y-auto md:flex-row">
                    <div class="flex items-center justify-center p-6 sm:p-12">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="w-full">
                            <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
                                Сброс пароля
                            </h1>
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf
        
                                <input type="hidden" name="token" value="{{ $token }}">
        
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input id="email" type="hidden" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
        
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="form-group py-2">
                                    <label for="password" class="mb-4 font-normal text-gray-700 dark:text-gray-200">{{ __('Новый пароль') }}</label>
        
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror border rounded-md block w-full px-12 py-1 mt-2 leading-2" name="password" required autocomplete="new-password">
        
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="form-group row py-2">
                                    <label for="password-confirm" class="mb-4 font-normal text-gray-700 dark:text-gray-200">{{ __('Повторите пароль') }}</label>
        
                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control border rounded-md block w-full px-12 py-1 mt-2 leading-2" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>
        
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                            {{ __('Сбросить пароль') }}
                                        </button>
                                    </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>

@endsection
