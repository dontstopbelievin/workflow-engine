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
                        <h3 class="card-title font-weight-bold text-center">Редактирование Данных</h3>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                    <div class="card-body col-md-6" id="items">
                        <form action="{{ url('user/update',  ['user' => $user]) }}" method="POST">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="form-group" style="padding: 0px">
                              <label>Фамилия</label>
                              <input type="text" name="sur_name" value="{{$user->sur_name}}" class="form-control" required>
                            </div>
                            <div class="form-group" style="padding: 0px">
                              <label>Имя</label>
                              <input type="text" name="first_name" value="{{$user->first_name}}" class="form-control" required>
                            </div>
                            <div class="form-group" style="padding: 0px">
                              <label>Отчество</label>
                              <input type="text" name="middle_name" value="{{$user->middle_name}}" class="form-control" required>
                            </div>
                            <div class="form-group" style="padding: 0px 0px 10px 0px">
                                <label for="phone">Номер телефона</label>
                                <input type="text" name="phone" class="form-control" id="phone" value="{{$user->phone}}">
                            </div>
                            <div class="form-group">
                              <button type="submit" class="btn btn-info">Обновить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
