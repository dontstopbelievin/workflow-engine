@extends('layouts.master')

@section('title')
    Process Creation
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Создание процесса</h4>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="/process/create" method="POST">
                                @csrf
                                @empty($process)
                                <div class="form-group">
                                        <label for="role_name">Наименование</label>
                                        <input type="text" class="form-control" name="name" placeholder="Введите наименование проекта">
                                        <label for="duration">Срок(количество дней)</label>
                                        <input type="number" min="0" class="form-control" name="deadline" placeholder="Введите срок">
                                        <label for="accept_template">Шаблон одобрения:</label>
                                        <select class="form-control" id="accept_template" name="accepted_template">
                                            @foreach($accepted as $accepted_template)
                                                <option>{{$accepted_template->name}}</option>
                                            @endforeach
                                        </select>
                                        <label for="reject_template">Шаблон отказа:</label>
                                        <select class="form-control" id="reject_template" name="rejected_template">
                                            @foreach($rejected as $rejected_template)
                                                <option>{{$rejected_template->name}}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <button type="submit" class="btn btn-basic">Отправить</button>
                                @endempty
                            </form>
                            @empty($choosenFields)
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
                                            <form action="/process/fields" method="GET">
                                                <div class="modal-body">
                                                    @isset($fields)
                                                        @foreach ($fields as $field)
                                                            <div class="checkbox">
                                                                <label><input type="checkbox" name="fields[]" value="{{$field->field_name}}">{{$field->field_name}}</label>
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
                            @isset($choosenFields)
                                <form action="/process/save-fields" method="POST">
                                    @csrf
                                    @foreach($choosenFields as $choosenField)
                                        
                                        <label for="{{$choosenField.'_field'}}">{{$choosenField}}</label>
                                        <input type="text" class="form-control" name="{{$choosenField.'_field'}}">
                                        
                                    @endforeach
                                    <button type="submit" class="btn btn-basic">Выбрать</button>
                                </form>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection