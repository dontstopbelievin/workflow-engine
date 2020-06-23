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
                                <div class="form-group">
                                    @isset($process)
                                    <label for="role_name">Наименование</label>
                                    <input type="text" class="form-control" name="name" value={{$process->name}}>
                                    <label for="duration">Срок(количество дней)</label>
                                    <input type="number" min="0" class="form-control" name="deadline" value={{$process->deadline}}>
                                    <label for="fields">Состав полей</label>
                                    @endisset
                                    @empty($process)
                                    <label for="role_name">Наименование</label>
                                    <input type="text" class="form-control" name="name" placeholder="Введите наименование проекта">
                                    <label for="duration">Срок(количество дней)</label>
                                    <input type="number" min="0" class="form-control" name="deadline" placeholder="Введите срок">
                                    @endempty
                                </div>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </form>
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
                                                    <form action="/process/fields" method="POST">
                                                        <div class="modal-body">
                                                            @isset($fields)
                                                            @csrf
                                                            @foreach ($fields as $field)
                                                            <div class="checkbox">
                                                                <label><input type="checkbox" value="{{$field->field_name}}">{{$field->field_name}}</label>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection