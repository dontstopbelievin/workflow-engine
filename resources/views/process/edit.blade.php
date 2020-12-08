@extends('layouts.master')

@section('title')
   Редактирование процесса
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <h2 class="card-title font-weight-bold text-center">Изменение Процесса: {{$process->name}}</h2>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                   @elseif (session('failure'))
                        <div class="alert alert-warning" role="alert">
                            {{ session('failure') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-9">
                        <form action="{{ route('processes.update', ['process' => $process]) }}" method="POST">
                                @csrf
                                {{ method_field('PUT') }}
                                <div class="form-group">
                                    <label>Наиманование Процесса</label>
                                    <input type="text" name="name" value="{{ $process->name}}" class="form-control">
                                </div>
                                <div class="form-group-row">
                                    <label>Срок(количество дней)</label>
                                    <input type="text" name="deadline" value="{{ $process->deadline}}" class="form-control">
                                </div>
                                <div class="form-group-row">
                                    <button button type="submit" class="btn btn-info btn-lg">Обновить</button>
                                    <a href="{{ route('processes.index') }}" class="btn btn-outline-danger btn-lg">Отмена</a>
                                </div>
                            </form>
                            <hr>
                            <button type="button" class="btn btn-light btn-lg my-3" data-toggle="modal" data-target="#myModal">Выбрать Поля</button>
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
                            <div class="modal fade" id="routeModal" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Список Ролей</h4>
                                        </div>
                                        <form action="{{ route('processes.addRole', ['process' => $process]) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                @isset($roles)
                                                    @foreach ($roles as $role)
                                                        <div class="checkbox">
                                                            <label><input type="checkbox" name="roles[]" value="{{$role->id}}">{{$role->name}}</label>
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
                                                    <label>Выберите Орагнизацию дополнительного маршрута</label>
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
                            @isset($tableColumns)
                            <h4 class="font-weight-bold text-left">Поля процесса:</h4>
                                @foreach($tableColumns as $column)
                                <ul class="list-group text-center">
                                    <li class="list-group-item w-50 text-center">{{$column}}</li>
                                </ul>                                                    
                                @endforeach
                            @endisset

                            <h3 class="font-weight-bold text-center">Создание маршрутов</h3>
                            @isset($organizations)
                            <div class="my-4">
                                <form action="{{ route('processes.addOrganization', ['process' => $process]) }}" method="POST">
                                    @csrf
                                    <div class="form-group-row">
                                        <label for="mainOrganization">Выберите Орагнизацию основного маршрута</label>
                                        <select name="mainOrganization" class="form-control" id="mainOrganization">
                                            <option selected="true" disabled="disabled">Выберите Ниже</option>
                                            @foreach($organizations as $organization)
                                                <option>{{$organization->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-info btn-lg my-2">Выбрать</button>
                                </form>
                            </div>
                            @endisset
                            <button type="button" class="btn btn-light btn-lg my-3" data-toggle="modal" data-target="#routeModal">Выбрать Участников</button>
                            @isset($roles)

                                <div class="my-4">
                                    <form action="{{ route('processes.addRole', ['process' => $process]) }}" method="POST">
                                    @csrf
                                        <div class="form-group-row">
                                            <label>Выберите участников процесса</label>
                                            <select name="role" class="form-control form-control-lg">
                                                <option selected="true" disabled="disabled">Выберите Ниже</option>
                                                @foreach($roles as $role)
                                                    <option>{{$role->name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-info btn-lg my-2">Выбрать</button>
                                    </form>
                                </div>
                            @endisset
                            <hr>
                            @isset($process->routes)
                                <div>
                                    <div>
                                        <h4 class="font-weight-bold">Маршрут Процесса | {{ $nameMainOrg ?? ''}} </h4>
                                    </div>
                                    <div class="border border-light" id="items">
                                        @if(isset($sAllRoles))
                                        <ul class="list-group"> 
                                            @foreach($sAllRoles as $key=>$role)
                                                <li class="list-group-item my-auto ourItem" data-toggle="modal" data-target="#myModal2">{{$key}}
                                                    <input type="hidden" id="roleName" value = {{$key}}>
                                                    <input type="hidden" id="processId" value = {{$process->id}}>
                                                    <ul class="list-group">            
                                                    @if (is_array($role))
                                                        @foreach($role as $skey => $sval)
                                                        <li class="list-group-item">  
                                                            {{$sval}}
                                                        </li>
                                                        @endforeach
                                                    @endif
                                                    </ul>
                                                </li>
                                            @endforeach
                                        @else 
                                            @foreach($process->routes as $route)
                                                <ul class="list-group">
                                                    <li class="list-group-item ourItem" data-toggle="modal" data-target="#myModal2">{{$route->name}}
                                                        <input type="hidden" id="roleName" value = {{$route->name}}>
                                                        <input type="hidden" id="processId" value = {{$process->id}}>
                                                    </li>
                                                </ul>    
                                            @endforeach
                                        @endif
                                        </ul>
                                    </div>
                                </div>
                            @endisset

                            <hr>
                            <h3 class="font-weight-bold text-center">Создание Шаблонов</h3>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <h5 class="font-weight-bold">Шаблон одобрения</h5>
                                        @empty($accepted)
                                        <form action="{{ route('template.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="template_state" value="accepted">
                                            <input type="hidden" name="processId" value="{{$process->id}}">
                                            <div class="form-group-row">
                                                <label for="fieldName">Название шаблона</label>
                                                <input type="text" class="form-control" name="name" id="fieldName">
                                            </div>
                                            <button type="submit" class="btn btn-info my-2">Создать</button>
                                        </form>
                                        @endempty
                                        @isset($accepted)
                                            <p><u>{{$accepted->name}}</u></p>
                                        @endisset
                                    </div>
                                    <div class="col-xs-6">
                                        <h5>Шаблон отказа</h5>
                                        @empty($rejected)
                                        <form action="{{ route('template.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="template_state" value="rejected">
                                            <input type="hidden" name="processId" value="{{$process->id}}">
                                            <div class="form-group-row">
                                                <label for="fieldName">Название шаблона</label>
                                                <input type="text" class="form-control" name="name" id="fieldName">
                                            </div>
                                            <button type="submit" class="btn btn-info my-2">Создать</button>
                                        </form>
                                        @endempty
                                        @isset($rejected)
                                             <p><u>{{$rejected->name}}</u></p>
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
