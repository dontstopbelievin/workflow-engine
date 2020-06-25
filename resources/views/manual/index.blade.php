@extends('layouts.master')

@section('title')
   Справочники
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Справочники</h4>
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
                                <th>Наименование поля</th>
                                <th>Дата создания</th>
                                <th>Изменить</th>
                                <th>Удалить</th>
                            </thead>
                            <tbody>
                                @foreach($fieldValue as $value)
                                <tr>
                                    <td>{{$value->id}}</td>
                                    <td>{{$value->field_name}}</td>
                                    <td>{{$value->created_at->toDateString() }}</td>
                                    <td><a href="/manual-edit/{{$value->id}}" class="btn btn-success">Изменить</a></td>
                                    <td>
                                        <form action="/manual-delete/{{$value->id}}" method="post">
                                            {{csrf_field()}}
                                            {{method_field('Удалить')}}
                                            <button type="submit" class="btn btn-danger">Удалить</button>
                                        </form>
                                    </td>
                                </tr>
                            
                                @endforeach  
                            </tbody>
                        </tablе>
                        <a href="/manual/create" class="btn btn-primary">Создать поле</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection