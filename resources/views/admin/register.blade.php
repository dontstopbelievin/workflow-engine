@extends('layouts.master')

@section('title')
    Зарегистрированные пользователи
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Зарегистрированные пользователи | Всего: {{$usersCount}}</h4>
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
                                <th>№</th>
                                <th>Имя</th>
                                <th>Телефон</th>
                                <th>Почта</th>
                                <th>Роль</th>
                                <th><button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Изменить"><i class="fa fa-edit"></i></button></th>
                                <th><button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Удалить"><i class="fa fa-trash"></i></button></th>
                                
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                              <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->phone}}</td>
                                <td>{{$user->email}}</td>
                                @if ($user->role)
                                <td>{{$user->role->name}}</td>
                                @else 
                                <td>-</td>
                                @endif
                                <td><a href="/user-edit/{{$user->id}}" class="btn btn-success">ИЗМЕНИТЬ</a></td>
                                <td>
                                    <form action="/user-delete/{{$user->id}}" method="post">
                                        {{csrf_field()}}
                                        {{method_field('DELETE')}}
                                        <button type="submit" class="btn btn-danger">УДАЛИТЬ</button>
                                    </form>
                                </td>  
                              </tr>   
                              @endforeach                             
                            </tbody>
                        </tablе>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection