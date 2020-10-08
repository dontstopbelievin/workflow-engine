@extends('layouts.master')

@section('title')
  Просмотр Процесса
@endsection

@section('content')
<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Процесс {{$process->name}}</h3>
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
                            @if($process->rejected_template)
                            <li class="list-group-item">Шаблон отказа: {{$process->rejected_template->name}}</li>
                            @endif

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Поля процесса {{$process->name}}</h3>
                                </div>
                                <div class="panel-body" id="items">
                                    <ul class="list-group">
                                        @foreach($tableColumns as $column)
                                            <li class="list-group-item ourItem">{{$column}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Маршруты процесса {{$process->name}}</h3>
                                </div>
                                <div class="panel-body" id="items">
                                    <ul class="list-group">
                                        @if(isset($sAllRoles))
                                            @foreach($sAllRoles as $key=>$role)
                                                <li class="list-group-item ourItem">{{$key}}
                                                    <ul>                           
                                                        @if (is_array($role))
                                                            @foreach($role as $skey => $sval)
                                                                <li>  
                                                                    {{$sval}}
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                </li>
                                            @endforeach
                                        @else
                                            @foreach($process->routes as $route)
                                                <li class="list-group-item ourItem">{{$route->name}}</li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection

