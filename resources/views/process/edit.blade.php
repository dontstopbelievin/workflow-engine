@extends('layouts.master')

@section('title')
   Редактирование процесса
@endsection

@section('content')


<div class="main-panel">
  <div class="content">
    <div class="container-fluid">
      <h4 class="page-title">Изменение Процесса: {{$process->name}}</h4>
      @if (session('status'))
          <div class="alert alert-success" role="alert">
              {{ session('status') }}
          </div>
      @endif
      <div class="card">
        <div class="card-body">
          <div class="col-md-12">
            <form action="{{ route('processes.update', ['process' => $process]) }}" method="POST">
              {{ csrf_field( )}}
              {{ method_field('PUT') }}
              <div class="form-group">
                <label>Наименование Процесса</label>
                <input type="text" name="name" value="{{ $process->name}}" class="form-control">
              </div>
              <div class="form-group">
                <label>Срок(количество дней)</label>
                <input type="text" name="deadline" value="{{ $process->deadline}}" class="form-control">
              </div>
              <div class="form-group-row">
                  <button button type="submit" class="btn btn-primary mx-2">Обновить</button>
                  <a href="{{ route('processes.index') }}" class="btn btn-outline-danger">Отмена</a>
              </div>
            </form>
            <hr>

                    <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <span class="modal-title">Список Полей</span>
                        </div>
                        <form action="{{ route('processes.createProcessTable', ['process' => $process]) }}" method="POST">
                        @csrf
                            <div class="modal-body">
                                @isset($columns)
                                    @foreach ($columns as $column)
                                      <div class="form-check" style="padding:0px;">
                												<label class="form-check-label">
                													<input class="form-check-input" type="checkbox" name="fields[]" value="{{$column["name"]}}">
                													<span class="form-check-sign">{{$column["labelName"]}}</span>
                												</label>
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
                                    <div class="form-check" style="padding:0px;">
                                      <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{$role->id}}">
                                        <span class="form-check-sign">{{$role->name}}</span>
                                      </label>
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
                                    <select name="supportOrganization" id="subOrg" class="subOrg" data-dropup-auto="false">
                                        @foreach($organizations as $organization)
                                            <option>{{$organization->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    @isset($columns)
                                        @foreach ($roles as $role)
                                            <div class="checkbox">
                                                <label class="form-check-label"><input class="get_value" type="checkbox" name="subRoles[]" value="{{$role->name}}">
                                                  <span class="form-check-sign">{{$role->name}}</span>
                                                </label>
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
            <button type="button" class="btn btn-outline-info mx-2" data-toggle="modal" data-target="#myModal">Выбрать Поля</button>
            @isset($tableColumns)
              <div class="card-header">
                <div class="card-title">Поля процесса:</div>
              </div>

                @foreach($tableColumns as $column)
                <ul class="list-group text-center mx-2">
                    <li class="list-group-item w-50 text-center">{{$column}}</li>
                </ul>
                @endforeach
            @endisset
            <hr>
            <div class="card-header">
              <div class="card-title"><h5>Создание маршрутов</h5></div>
            </div>
            @isset($organizations)
            <div class="my-4">
                <form action="{{ route('processes.addOrganization', ['process' => $process]) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="mainOrganization">Выберите Оргaнизацию основного маршрута</label>
                        <select name="mainOrganization" class="form-control" id="mainOrganization" data-dropup-auto="false">
                            <option selected="true" disabled="disabled">Выберите Ниже</option>
                            @foreach($organizations as $organization)
                                <option>{{$organization->name}} </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mx-2">Выбрать</button>
                </form>
            </div>
            @endisset
            <button type="button" class="btn btn-outline-info mx-2" data-toggle="modal" data-target="#routeModal">Выбрать Участников</button>
            <!-- @isset($roles)
              <div class="my-4">
                  <form action="{{ route('processes.addRole', ['process' => $process]) }}" method="POST">
                  @csrf
                      <div class="form-group">
                          <label>Выберите участников процесса</label>
                          <select name="role" class="form-control">
                              <option selected="true" disabled="disabled">Выберите Ниже</option>
                              @foreach($roles as $role)
                                  <option>{{$role->name}} </option>
                              @endforeach
                          </select>
                      </div>
                      <button type="submit" class="btn btn-outline-info mx-2">Выбрать</button>
                  </form>
              </div>
            @endisset -->
            @isset($process->routes)
                <div>
                    <div class="card-header">
                      <div class="card-title"><h5>Маршрут Процесса | {{ $nameMainOrg ?? ''}}</h5></div>
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
            <div class="card-title"><h5>Создание Шаблонов</h5></div>
            <hr>

              <div class="row">

                  <form action="{{ route('process.addDocTemplates') }}" method="POST">
                      @csrf
                      <div class="form-group">

                          <input type="hidden" name="processId" value = {{$process->id}}>
                          <label for="docTemplate">Выберите Документ Шаблона</label>
                          <select name="docTemplateId" id="docTemplate" class="form-control">
                              @foreach($templateDocs as $doc)
                                  <option value="{{$doc->id}}">
                                      {{$doc->name}}
                                  </option>
                              @endforeach
                          </select>
                      </div>
                      <button type="submit" class="btn btn-primary">Прикрепить</button>
                  </form>
              </div>
            <div class="row">


                <div class="col-md-6">
                    @empty($accepted)
                    <form action="{{ route('template.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="template_state" value="accepted">
                        <input type="hidden" name="processId" value="{{$process->id}}">
                        <div class="form-group">
                            <label for="fieldName">Название шаблона</label>
                            <input type="text" class="form-control" name="name" id="fieldName">
                        </div>
                        <button type="submit" class="btn btn-primary">Создать</button>
                    </form>
                    @endempty
                    @isset($accepted)
                        <p><u>{{$accepted->name}}</u></p>
                    @endisset
                </div>
                <div class="col-md-6">
                  <div class="card-title">Шаблон отказa</div>
                    @empty($rejected)
                    <form action="{{ route('template.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="template_state" value="rejected">
                        <input type="hidden" name="processId" value="{{$process->id}}">

                        <div class="form-group">
                            <label for="fieldName">Название шаблона</label>
                            <input type="text" class="form-control" name="name" id="fieldName">
                        </div>
                        <button type="submit" class="btn btn-primary">Создать</button>
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

{{csrf_field()}}
<script
    src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    crossorigin="anonymous"></script>
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script> -->
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
