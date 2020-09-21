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
                                            <form action="{{ route('processes.createProcessTable', ['process' => $process]) }}" method="POST">
                                            @csrf
                                                <div class="modal-body">
                                                    @isset($columns)
                                                        @foreach ($columns as $column)
                                                            <div class="checkbox">
                                                                <label><input type="checkbox" name="fields[]" value="{{$column["name"]}}">{{$column["labelName"]}}</label>

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
                                <div class="modal fade" id="myModal2" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Добавить Подмаршрут к <input type="text" id="modHeader"></h4>
                                            </div>
                                                @csrf

                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Выбрать Орагнизацию дополнительного маршрута</label>
                                                        <select name="supportOrganization" id="subOrg" class="subOrg">
                                                            @foreach($organizations as $organization)
                                                                <option>{{$organization->name}} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        @isset($columns)
                                                            @foreach ($roles as $role)
                                                                <div class="checkbox">
                                                                    <label><input class="get_value" type="checkbox" name="subRoles[]" value="{{$role->name}}">{{$role->name}}</label>
                                                                </div>
                                                            @endforeach
                                                        @endisset
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button  type="submit" id="AddButton" class="btn btn-success">Добавить Подмаршрут</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            @endempty
                            <h5>Поля процесса:</h5>
                            @isset($tableColumns)
                                @foreach($tableColumns as $column)
                                <ul>
                                    <li>{{$column}}</li>
                                </ul>                                                    
                                @endforeach
                            @endisset

                            <h2>Создание маршрутов</h2>
                            @isset($organizations)
                                <form action="{{ route('processes.addOrganization', ['process' => $process]) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="mainOrganization">Выбрать Орагнизацию основного маршрута</label>
                                        <select name="mainOrganization" class="form-control" id="mainOrganization">
                                            @foreach($organizations as $organization)
                                                <option>{{$organization->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success">Выбрать</button>
                                </form>
                            @endisset
                            @isset($roles)
                                <form action="{{ route('processes.addRole', ['process' => $process]) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Выбрать участников процесса</label>
                                    <select name="role" class="form-control">
                                        @foreach($roles as $role)
                                            <option>{{$role->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">Выбрать</button>
                                </form>
                            @endisset

                            @isset($process->routes)
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Список маршрутов | {{ $nameMainOrg ?? ''}} <a href="#" id="addNew" class="pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i></a></h3>
                                    </div>

                                    <div class="panel-body" id="items">
                                        <ul class="list-group">
                                        @if(isset($sAllRoles))

                                            @foreach($sAllRoles as $key=>$role)
                                                <li class="list-group-item ourItem" data-toggle="modal" data-target="#myModal2">{{$key}}
                                                    <input type="hidden" id="roleName" value = {{$key}}>
                                                    <input type="hidden" id="processId" value = {{$process->id}}>
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
                                                <li class="list-group-item ourItem" data-toggle="modal" data-target="#myModal2">{{$route->name}}
                                                    <input type="hidden" id="roleName" value = {{$route->name}}>
                                                    <input type="hidden" id="processId" value = {{$process->id}}>
                                                    <ul>

                                                        <li></li>
                                                    </ul>
                                                </li>
                                            @endforeach
                                        @endif
                                        </ul>
                                    </div>
                                </div>
                            @endisset
                            <h4>Создание Шаблонов</h4>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Шаблон одобрения</h5>
                                        <form action="{{ route('template.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="template_state" value="accepted">
                                            <input type="hidden" name="processId" value="{{$process->id}}">
                                            <div class="form-group">
                                                <label for="fieldName">Название шаблона</label>
                                                <input type="text" class="form-control" name="name" id="fieldName">
                                            </div>
                                            <button type="submit" class="btn btn-success">Создать</button>
                                        </form>
                                        @isset($accepted)
                                                Шаблон одобрения: {{$accepted->name}}
                                        @endisset
                                        <h5>Шаблон отказа</h5>
                                        <form action="{{ route('template.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="template_state" value="rejected">
                                            <input type="hidden" name="processId" value="{{$process->id}}">
                                            <div class="form-group">
                                                <label for="fieldName">Название шаблона</label>
                                                <input type="text" class="form-control" name="name" id="fieldName">
                                            </div>
                                            <button type="submit" class="btn btn-success">Создать</button>
                                        </form>
                                        @isset($rejected)
                                            Шаблон отказа: {{$rejected->name}}
                                        @endisset
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
{{csrf_field()}}
<script
    src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"></script>
<script>

    $(document).ready(function() {

        $(document).on('click', '.ourItem', function(event) {
            var text = $(this).text();
            text = $.trim(text);
            $('#modHeader').val(text);
            console.log(text);
        });
        $(document).on('change', '#mainOrganization', function(event) {
            var hidden = [];
            hidden = $('#hidden').val();
            console.log(hidden);

            for (let i =0; i < hidden.length; i ++)
            console.log(json_decode(hidden[i]));
            var organization = $(this).val();
            alert(organization);
            if (input === 'select') {
                document.getElementById('hidden_div').style.display = "block";
            } else {
                document.getElementById('hidden_div').style.display = "none";
            }
        });

        $('#AddButton').click(function(event) {
            var roleToAdd = $('#modHeader').val();
            var subRoles = [];
            var processId = $('#processId').val();
            var subOrg;
            var subOrg = $('#subOrg option:selected').val();
            $('.get_value').each(function(){
                if($(this).is(":checked"))
                {
                    subRoles.push($(this).val());
                }
            });
            console.log(roleToAdd)
            $.post('/add-sub-roles', {'roleToAdd':roleToAdd,'subRoles':subRoles,'processId':processId, 'subOrg':subOrg,  '_token':$('input[name=_token]').val()}, function(data){
                var modal =  $('#myModal2');
                // console.log(data);
                modal.style.display = 'none';
                $('#items').load(location.href + ' #items');
            });
        });

    });
</script>

@endsection

@section('scripts')
@endsection
