@extends('layouts.master')

@section('title')
    Список Ролей
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Список Ролей | Всего: {{$rolesCount}}</h4>
                    <form action="{{ route('role.search') }}" method="POST" role="search">
                        {{ csrf_field() }}
                        <div class="input-group">
                            <input type="text" class="form-control" name="q"
                                placeholder="Введите название Роли"> <span class="input-group-btn">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="container">
                    @if(isset($details))
                        <p> Результаты поиска на <b> {{ $query }} </b> :</p>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Имя</th>
                                <th><button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Изменить"><i class="fa fa-edit"></i></button></th>
                                <th> <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Удалить"><i class="fa fa-trash"></i></button></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($details as $detail)
                            <tr>
                                <td><a href="{{ route('role.view', ['detail' => $detail]) }}">{{$detail->id}}</a></td>
                                <td>{{$detail->name}}</td>
                                <td><a href="{{ route('role.edit', ['detail' => $detail]) }}" class="btn btn-success">ИЗМЕНИТЬ</a></td>
                                <td>
                                    <form action="{{ route('role.delete', ['detail' => $detail]) }}" method="post">
                                        {{csrf_field()}}
                                        {{method_field('DELETE')}}
                                        <button type="submit" class="btn btn-danger">УДАЛИТЬ</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
                @if(empty($details))
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th>№</th>
                                <th>Имя</th>
                                <th>Дата создания</th>
                                <th><button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Изменить"><i class="fa fa-edit"></i></button></th>
                                <th> <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Удалить"><i class="fa fa-trash"></i></button></th>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td><a href="{{ route('role.view', ['role' => $role]) }}">{{$role->id}}</a></td>
                                    <td>{{$role->name}}</td>
                                    <td>{{$time->toDateString() }}</td>
                                    <td><a href="{{ route('role.edit', ['role' => $role]) }}" class="btn btn-success">ИЗМЕНИТЬ</a></td>
                                    <td>
                                        <form action="{{ route('role.delete', ['role' => $role]) }}" method="post">
                                            {{csrf_field()}}
                                            {{method_field('DELETE')}}
                                            <button type="submit" class="btn btn-danger">УДАЛИТЬ</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach  
                            </tbody>
                        </tablе>
                        <a href="{{ route('role.create') }}" class="btn btn-primary">Создать Роль</a>
                    </div>

                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection