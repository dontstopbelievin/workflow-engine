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
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <h4 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
                                    Восстановление пароля
                                </h4>
                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label class="block text-sm">
                                            <span class="text-gray-700 dark:text-gray-400">Введите почтовый адрес</span>
                                            <input
                                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                                type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus/>
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                        </label>
                                    </div>
                                    <!-- You should use a button here, as the anchor is only used for the example  -->
                                    <div>
                                        
                                    </div>
                                    <button type="submit"
                                        class="btn btn-primary"
                                        >{{ __('Отправить ссылку на восстановление пароля') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
</div>
</div>
@endsection
