@extends('layouts.master')

@section('title')
   Изменение процесса
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Изменение Процесса: {{$process->name}}</h2>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                        <form action="{{ route('processes.update', ['process' => $process]) }}" method="POST">
                                {{ csrf_field( )}}
                                {{ method_field('PUT') }}
                                <div class="form-group">
                                    <label>Наиманование Процесса</label>
                                    <input type="text" name="name" value="{{ $process->name}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Срок(количество дней)</label>
                                    <input type="text" name="deadline" value="{{ $process->deadline}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Изменить шаблон одобрения</label>
                                    <select name="accepted_template" class="form-control">
                                        
                                        <option selected="$process->accepted_template->name">{{$process->accepted_template->name}}</option>
                                        @foreach($accepted as $accepted_template)
                                            <option>{{$accepted_template->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Изменить шаблон отказа</label>
                                    <select name="rejected_template" class="form-control">
                                        <option selected="$process->rejected_template">{{$process->rejected_template->name}}</option>
                                        @foreach($rejected as $rejected_template)
                                            <option>{{$rejected_template->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Обновить</button>
                                    <a href="{{ route('processes.index') }}" class="btn btn-danger">Отмена</a>
                                </div>
                            </form>
                            @empty($arrayJson)
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Выбрать Поля</button>
                            
                            <div class="container"> 
                                <!-- Modal -->
                                <div class="modal fade" id="myModal" role="dialog">
                                    <div class="modal-dialog">
                                    <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Список Полей</h4>
                                            </div>
                                            <form action="{{ route('processes.savefields', ['process' => $process]) }}" method="POST">
                                            @csrf
                                                <div class="modal-body">
                                                    @isset($columns)
                                                        @foreach ($columns as $column)
                                                            <div class="checkbox">
                                                                <label><input type="checkbox" name="fields[]" value="{{$column}}">{{$column}}</label>
                                                            </div>
                                                        @endforeach   
                                                    @endisset
                                                </div>
                                                <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Выбрать</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                                                </div>      
                                            </form>
                                        </div>                                          
                                    </div>
                                </div>     
                            </div>  
                            @endempty
                            <h5>Поля процесса:</h5>
                            @isset($process->fields)
                                @foreach(json_decode($process->fields) as $choosenField)                        
                                <h6>{{$choosenField}}</h6>                                
                                @endforeach
                            @endisset
                            <h2>Создание маршрутов</h2>
                            @isset($roles)
                                <form action="{{ route('processes.addrole', ['process' => $process]) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Выбрать участников процесса</label>
                                    <select name="role" class="form-control">
                                        @foreach($roles as $role)
                                            <option>{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">Выбрать</button>
                                </form>
                            @endisset
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