@extends('layouts.master')

@section('title')
   Справочник
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Справочник</h4>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- <table class="table">
                            <thead>
                                <th>№</th>
                                <th>Название поля</th>
                                <th>Дата создания</th>
                                <th><button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Изменить"><i class="fa fa-edit"></i></button></th>
                                <th> <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Удалить"><i class="fa fa-trash"></i></button></th>
                            </thead>
                            <tbody>
                                @foreach($fieldValue as $value)
                                <tr>
                                    <td>{{$value->id}}</td>
                                    <td>{{$value->name}}</td>
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
                        </tablе> -->
                        <table class="table">
                            <thead>
                                <th>Название поля</th>
                            </thead>
                            <tbody>
                                @foreach($columns as $column)
                                <tr>
                                    <td>{{$column}}</td>
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
@endsection

@section('scripts')
@endsection