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
                        <h3 class="card-title font-weight-bold text-center">Редактирование Данных</h3>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                    <div class="card-body" id="items">
                        <form action="{{ route('user.update',  ['user' => $user]) }}" method="POST">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="form-group">
                                <label for="name">ФИО</label>
                                <input type="text" id="name" class="form-control" name="name" value="{{$user->name}}">
                            </div>
                            <div class="form-group">
                                <label for="phone">Номер телефона</label>
                                <input type="text" name="phone" class="form-control" id="phone" value="{{$user->phone}}">
                            </div>
                            <button type="submit" class="btn btn-primary">Обновить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection