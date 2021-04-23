@extends('layouts.app')
@section('content')
<title>Вход без ЭЦП</title>
<div class="main-panel" style="width: 100%">
    <div class="content">
        <div class="row justify-content-center">
            <div class="card" style="width: 50%; text-align:center;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6" style="white-space: nowrap;">
                            <span style="display: inline-block;height: 100%;vertical-align: middle;"></span>
                            <img src="/images/shutterstock_1124764481.jpg" style="width: 100%;vertical-align: middle;" />
                        </div>
                        <div class="col-md-6">
                            <form action="/login" method="post">
                                <div>
                                    <a href="#" class="p-4"><img src="/images/astana-logo.png"></a>
                                </div>
                                <h5 class="mb-4 text-center text-xl font-semibold text-gray-700 dark:text-gray-200"
                                style="margin:40px;">
                                    Авторизация без ЭЦП
                                </h5>
                                @csrf
                                <div class="md-form md-outline">
                                    <label data-error="wrong" data-success="right" for="login-email" style="float: left;"><b>Ваш email</b></label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control"/>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="md-form md-outline">
                                    <label data-error="wrong" data-success="right" for="login-password" style="float: left;"><b>Ваш пароль</b></label>
                                    <input placeholder="***************" type="password" name="password" id="password" class="form-control"/>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="g-recaptcha mt-4 text-sm" data-sitekey="6LcOIv4ZAAAAAOH6sKrJvbkej4SoRlrOI6dw0yeU" data-size="invisible"></div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <p>
                                        <a href="auth/reset-password/">Забыли пароль?</a>
                                    </p>
                                </div>
                                <div class="text-center pb-2">
                                    <button type="submit" class="btn btn-primary mb-4">{{ __('Войти') }}</button>
                                    <div>
                                        @if (Route::has('password.request'))
                                            <a class="flex flex-wrap text-sm font-medium text-blue-800 hover:underline" href="{{ route('password.request') }}">
                                                {{ __('Сменить пароль') }}
                                            </a>
                                        @endif
                                    </div>
                                    <div>
                                        <a class="flex flex-wrap text-sm font-medium text-blue-800 hover:underline"
                                            href="/loginwithecp">
                                            Вход по ЭЦП
                                        </a>  
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://www.google.com/recaptcha/api.js?hl=ru" async defer></script>
@append