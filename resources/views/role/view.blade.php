@extends('layouts.app')

@section('title')
   Просмотр Роли
@endsection

@section('content')
<div class="main-panel">
        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-3">
                                <a href="{{ url('role') }}" class="btn btn-info">Назад</a>
                            </div>
                            <div class="col-md-6">
                                <h4 class="card-title text-center">Пользователи с ролью <i>"{{$role->name}}"</i></h4>  
                            </div>
                        </div>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr class="rounded text-secondary">
                                        <th class="text-center border-0">№</th>
                                        <th class="text-left border-0">Имя</th>
                                        <th class="text-left border-0">Телефон</th>
                                        <th class="text-left border-0">Почта</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($role->users as $user)
                                    <tr class="rounded">
                                        <td class="text-center align-middle border">{{$loop->iteration}}</td>
                                        <td class="text-left align-middle border">{{$user->name}}</td>
                                        <td class="text-left align-middle border">{{$user->phone}}</td>
                                        <td class="text-left align-middle border">{{$user->email}}</td>
                                    </tr>   
                                    @endforeach                             
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection