@extends('layouts.app')

@section('title')
    Личный Кабинет
@endsection

@section('content')
    <div class="main-panel">
      <div class="content">
        <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title font-weight-bold text-center">Личный Кабинет</h4>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="card-body" id="items">

                        <p><b>ФИО</b>: {{$user->sur_name}} {{$user->first_name}} {{$user->middle_name}}</p>
                        <p><b>Роль</b>: {{$user->role->name}}</p>
                        <p><b>Номер Телефона</b>: {{$user->telephone}}</p>
                        <p><b>Почтовый адрес</b>: {{$user->email}}</p>

                        <a class="btn btn-primary" href="{{ url('user/edit', ['user' => $user]) }}">Редактировать данные</a>
                        <br>
                        <br>
                        @if (Route::has('password.request'))
                            <a class="btn btn-primary"  class="flex flex-wrap text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline" href="{{ url('password/change') }}">
                                {{ __('Сменить пароль') }}
                            </a>
                        @endif
                        <br>
                        <br>
                        <p>Дата последнего удачного входа:
                            @if ($user->current_login_at)
                                {{date('Y-m-d', strtotime($user->current_login_at))}}
                            @else
                                -
                            @endif
                        </p>
                        <p>Время последнего удачного входа:
                            @if ($user->current_login_at)
                                {{date('H:i:s', strtotime($user->current_login_at))}}
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
