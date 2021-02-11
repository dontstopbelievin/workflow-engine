@extends('layouts.app')

@section('title')
    Создание Шаблона
@endsection

@section('content')
    <div class="row">
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
                            <form action="/templates/create" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="fieldName">Название Маршрута</label>
                                    <input type="text" class="form-control" name="name" id="fieldName">
                                    <label for="accept_template">Выберите участника:</label>
                                    <select class="form-control" name="partcipant" id="participant">
                                    @foreach ($participants as $participant)
                                        <option value="{{$participant->name}}">{{$participant->name}}</option>
                                    @endforeach
                                    </select>
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