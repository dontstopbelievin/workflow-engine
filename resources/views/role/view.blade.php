@extends('layouts.master')

@section('title')
   Просмотр Роли
@endsection

@section('content')
<div class="main-panel">
        <div class="content">
            <div class="container-fluid">
                <div class="card-header">
                    <h4 class="card-title">Пользователи с ролью <i>"{{$role->name}}"</i></h4>
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
                                <tr class="p-3 mb-5 rounded text-secondary">
                                    <th class="text-center border-0">№</th>
                                    <th class="w-50 text-left border-0">Имя</th>
                                    <th class="text-left border-0">Телефон</th>
                                    <th class="text-left border-0">Почта</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($role->users as $user)
                                <tr class="p-3 mb-5 rounded">
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
@endsection

@section('scripts')
@endsection
