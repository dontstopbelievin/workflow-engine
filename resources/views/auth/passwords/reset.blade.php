@extends('layouts.app')

@section('content')
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
                            <div>
                                <div>
                                    <a href="#" class="p-4"><img src="/images/astana-logo.png"></a>
                                </div>
                                <h5 class="mb-4 text-center text-xl font-semibold text-gray-700 dark:text-gray-200"
                                style="margin:40px;">
                                    Сброс пароля
                                </h5>
                                <div id="errorDiv" style="background: orange"></div>
                                <div class="text-center pb-2">
                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf
            
                                    <input type="hidden" name="token" value="{{ $token }}">
            
                                    <div class="form-group py-2">
                                        <div class="col-md-6 offset-md-3">
                                            <label for="password" class="mb-4 font-normal text-gray-700 dark:text-gray-200">{{ __('Новый пароль') }}</label>
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror border rounded-md block w-full px-12 py-1 mt-2 leading-2" name="password" required autocomplete="new-password">
            
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
            
                                    <div class="form-group row py-2">
                                        <div class="col-md-6 offset-md-3">
                                            <label for="password-confirm" class="mb-4 font-normal text-gray-700 dark:text-gray-200">{{ __('Повторите пароль') }}</label>
                                            <input id="password-confirm" type="password" class="form-control border rounded-md block w-full px-12 py-1 mt-2 leading-2" name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6 offset-md-3">
                                            <input id="email" type="hidden" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
            
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
            
                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-3">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Сбросить пароль') }}
                                            </button>
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
    </div>
</div>
@endsection
