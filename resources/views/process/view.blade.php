@extends('layouts.master')

@section('title')
   Роли
@endsection

@section('content')
<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Процесс {{$process->name}}</h4>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <ul class="list-group" id="list">
                            <li class="list-group-item">Название процесса: {{$process->name}}</li>
                            <li class="list-group-item">Длительность обработки заявки: {{$process->deadline}}</li>
                            <li class="list-group-item">Дэдлайн процесса: {{$process->deadline_until}}</li>
                            <li class="list-group-item">Шаблон одобрения: {{$process->accepted_template->name}}</li>
                            <li class="list-group-item">Шаблон отказа: {{$process->rejected_template->name}}</li>
                            <li class="list-group-item"><div class="dropdown">
                                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Поля данного процесса
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            @foreach(json_decode($process->fields) as $field)
                                                                <p class="dropdown-item">{{$field}}</p>
                                                            @endforeach
                                                            </div>
                                                        </div>
                            </li>
                            <li class="list-group-item"><div class="dropdown">
                                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Маршруты данного процесса
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            @foreach($process->routes as $route)
                                                                <p class="dropdown-item">{{$route->name}}</p>
                                                            @endforeach
                                                            </div>
                                                        </div>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection

                                