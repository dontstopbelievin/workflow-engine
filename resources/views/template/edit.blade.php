@extends('layouts.app')

@section('title')
   Измененить шаблона
@endsection

@section('content')

<div class="main-panel">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1>Измение Шаблона {{$template->name}}</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ url('admin/template/update', ['template' => $template]) }}" method="POST">
                                {{ csrf_field( )}}
                                {{ method_field('PUT') }}
                                <div class="form-group">
                                    <label>Наименование Шаблона</label>
                                    <input type="text" name="name" value="{{ $template->name}}" class="form-control">
                                </div>
                                <label for="templateName">Выберите шаблон</label>
                                <div class="custom-file mt-1 col-md-12" id="templateName">
                                    <input type="file" class="custom-file-input" id="customFile" name="file_input">
                                    <label class="custom-file-label" for="customFile">Выберите Файл</label>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Обновить</button>
                                    <a href="admin/template" class="btn btn-danger">Отмена</a>
                                    <a href="{{ url('admin/template_field/create', ['id' => $template]) }}" class="btn btn-outline-success">Добавление поле шаблонов</a>
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