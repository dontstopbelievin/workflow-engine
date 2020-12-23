@extends('layouts.master')

@section('title')
    Личный Кабинет
@endsection

@section('content')
    <div class="main-panel">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold text-center">Личный Кабинет</h3>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                    <div class="card-body" id="items">

                        <p>Имя: {{$user->name}}</p>
                        <p>Роль: {{$user->role->name}}</p>
                        <p>Номер Телефона: {{$user->phone}}</p>
                        <p>Почтовый адрес: {{$user->email}}</p>

                        <a href="{{ route('user.edit', ['user' => $user]) }}">Редактировать данные</a>
                        <br>
                        <br>
                        @if (Route::has('password.request'))
                            <a class="flex flex-wrap text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline" href="{{ route('password.request') }}">
                                {{ __('Сменить пароль') }}
                            </a>
                        @endif
                        <br>
                        <br>
                        <p>Дата последнего удачного входа:
                            @if ($user->last_login_at)
                                {{date('Y-m-d', strtotime($user->last_login_at))}}
                            @else
                                -
                            @endif
                        </p>
                        <p>Время последнего удачного входа:
                            @if ($user->last_login_at)
                                {{date('H:i:s', strtotime($user->last_login_at))}}
                            @else
                                -
                            @endif
                        </p>
                        <p>Ip адрес последнего удачного входа: {{$user->last_login_ip}}</p>
                        <br>
                        <p>Дата последнего неудачного входа:
                            @if ($user->last_failed_login_at)
                                {{date('Y-m-d', strtotime($user->last_failed_login_at))}}
                            @else
                                -
                            @endif
                        </p>
                        <p>Время последнего неудачного входа:
                            @if ($user->last_failed_login_at)
                                {{date('H:i:s', strtotime($user->last_failed_login_at))}}
                            @else
                                -
                            @endif
                        </p>
                        <p>Ip адрес последнего неудачного входа: {{$user->last_failed_login_ip}}</p>


                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
