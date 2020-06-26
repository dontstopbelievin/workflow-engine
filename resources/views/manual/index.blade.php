@extends('layouts.master')

@section('title')
   Справочник
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1>Справочник</h1>
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
                                <th>Название поля</th>
                                <th>Дата создания</th>
                                <th>ИЗМЕНЕНИЕ</th>
                                <th>УДАЛЕНИЕ</th>
                            </thead>
                            <tbody>
                                @foreach($fieldValue as $value)
                                <tr>
                                    <td>{{$value->id}}</td>
                                    <td>{{$value->field_name}}</td>
                                    <td>{{$value->created_at->toDateString() }}</td>
                                    <td><a href="/manual-edit/{{$value->id}}" class="btn btn-success">ИЗМЕНИТЬ</a></td>
                                    <td>
                                        <form action="/manual-delete/{{$value->id}}" method="post">
                                            {{csrf_field()}}
                                            {{method_field('DELETE')}}
                                            <button type="submit" class="btn btn-danger">УДАЛИТЬ</button>
                                        </form>
                                    </td>
                                </tr>
                            
                                @endforeach  
                            </tbody>
                        </tablе>
                        <a href="/manual/create" class="btn btn-primary">Создать Поле</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection