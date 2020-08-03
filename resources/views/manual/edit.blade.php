@extends('layouts.master')

@section('title')
   Изменение названия поля
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1>Изменение Поля: {{$fieldValue->name}}</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="/manual-update/{{$fieldValue->id}}" method="POST">
                                {{ csrf_field( )}}
                                {{ method_field('PUT') }}
                                <div class="form-group">
                                    <label>Название поля</label>
                                    <input type="text" name="name" value="{{ $fieldValue->name}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Обновить</button>
                                    <a href="/manual" class="btn btn-danger">Отмена</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection