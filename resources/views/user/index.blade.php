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

                        <p>Имя: {{$user->name}}</p>
                        <p>Роль: {{$user->role->name}}</p>
                        <p>Номер Телефона: {{$user->phone}}</p>
                        <p>Почтовый адрес: {{$user->email}}</p>

                        <a class="btn btn-info" href="{{ url('user/edit', ['user' => $user]) }}">Редактировать данные</a>
                        <br>
                        <br>
                        @if (Route::has('password.request'))
                            <a class="btn btn-default"  class="flex flex-wrap text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline" href="{{ route('password.request') }}">
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
                        <hr>
                        <h5>Фильтровать заявки</h5>
                        <form class="" action="{{ url('user/filter') }}" method="post" class="">
                          {{ csrf_field( )}}
                          {{ method_field('GET') }}
                          <input type="text" name="id" value="1" style="display:none;">
                          <div class="form-group">
                            <label for="days">Выберите срок</label>
                            <select class="form-control rounded px-3 py-2" name="days">
                              <option value="10">10 дней</option>
                              <option value="30">30 дней</option>
                              <option value="60">60 дней</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="days">Выберите процесс</label>
                            <select class="form-control rounded px-3 py-2" name="process" required>
                              <option value="no" disabled selected>-</option>
                              @foreach($processes as $process)
                                <option value="{{$process->name}}">{{$process->name}}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <button type="submit" name="filter" class="btn btn-info">Фильтровать</button>
                          </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
