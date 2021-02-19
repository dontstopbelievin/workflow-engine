@extends('layouts.app')

@section('title')
    Создание Шаблона
@endsection

@section('content')

    <div class="main-panel">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Создайте шаблон</h4>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ url('template/store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="fieldName">Название шаблона</label>
                                    <input type="text" class="form-control" name="name" id="fieldName">
                                    <label for="accept_template">Выберите тип шаблона:</label>
                                    <select class="form-control" name="template_state" id="accept_template">
                                        <option value="accepted">Шаблон одобрения</option>
                                        <option value="declined">Шаблон отказа</option>
                                    </select>
                                    <label for="templateName">Выберите шаблон</label>
                                    <div class="custom-file mt-1 col-md-12" id="templateName">
                                        <input type="file" class="custom-file-input" id="customFile" name="file_input">
                                        <label class="custom-file-label" for="customFile">Выберите Файл</label>
                                    </div>

                                </div>
                                <button type="submit" class="btn btn-success">Отправить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection