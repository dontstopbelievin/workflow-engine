@extends('layouts.master')

@section('title')
    Список ролей
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Список ролей</h4>
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
                                <th>ID</th>
                                <th>Название роли</th>
                                <th>Дата создания</th>
                                <th>Изменить</th>
                                <th>Удалить</th>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td><a href="/role/{{$role->id}}">{{$role->id}}</a></td>
                                    <td>{{$role->role_name}}</td>
                                    <td>{{$role->created_at->toDateString() }}</td>
                                    <td><a href="/role-edit/{{$role->id}}" class="btn btn-success">Изменить</a></td>
                                    <td>
                                        <form action="/role-delete/{{$role->id}}" method="post">
                                            {{csrf_field()}}
                                            {{method_field('Удалить')}}
                                            <button type="submit" class="btn btn-danger">Удалить</button>
                                        </form>
                                    </td>
                                </tr>
                               
                                @endforeach  
                            </tbody>
                        </tablе>
                        <a href="/roles/create" class="btn btn-primary">Создать роль</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection