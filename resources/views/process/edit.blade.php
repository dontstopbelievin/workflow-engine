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
            <a href="{{ route('processes.index') }}" class="btn btn-outline-danger" style="margin-bottom: 20px;">Назад</a>
            <h5>О процессе:</h5>
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
                  <button button type="submit" class="btn btn-primary mx-2">Изменить</button>
              </div>
            </form>
            <hr style="height:1px;border-width:0; background-color:black;">

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
                                <button type="submit" class="btn btn-success">Создать</button>
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
                                <!-- @isset($roles)
                                    @foreach ($roles as $role)
                                    <div class="form-check" style="padding:0px;">
                                      <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{$role->id}}">
                                        <span class="form-check-sign">{{$role->name}}</span>
                                      </label>
                                    </div>
                                    @endforeach
                                @endisset -->
                                @isset($roles)
                                  @foreach ($roles as $role)
                                      <div class="pb-0">
                                        <label class="form-check-label py-0">
                                          <input type="checkbox" name="roles[]" value="{{$role->id}}" class="form-check-input" id="participant{{$role->id}}">
                                          <span class="form-check-sign">{{$role->name}}</span>
                                        </label>
                                        <div id="dropdown" class="form-check">
                                          <div class="dropdown-permission{{$role->id}}" id="dropdown-permission{{$role->id}}" style="display:none;">
                                            <label class="form-check-label">
                                               <input type="checkbox" name="reject[]" id="reject{{$role->id}}" value="{{$role->id}}" class="mr-2">
                                               <span class="form-check-sign">Отказать</span>
                                            </label>
                                            <label class="form-check-label">
                                               <input type="checkbox" name="revision[]" id="revision{{$role->id}}" value="{{$role->id}}" class="mr-2">
                                               <span class="form-check-sign">Отправить на доработку</span>
                                            </label>
                                          </div>
                                        </div>
                                      </div>
                                      <script>
                                        $("#participant{{$role->id}}").click(function(){
                                          if(document.getElementById("dropdown-permission{{$role->id}}").style.display == "none"){
                                            document.getElementById("dropdown-permission{{$role->id}}").style.display = "block";
                                          }else{
                                            document.getElementById("dropdown-permission{{$role->id}}").style.display = "none";
                                            document.getElementById("revision{{$role->id}}").checked = false;
                                            document.getElementById("reject{{$role->id}}").checked = false;
                                          }
                                        });
                                      </script>
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
                            <h4 class="modal-title">Добавить подмаршрут к <div id="modHeader"></div></h4>
                        </div>
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Выберите Организацию дополнительного маршрута</label>
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
            <h5>Создать таблицу:</h5>
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
            <hr style="height:1px;border-width:0; background-color:black;">
            <h5>Создание маршрута:</h5>
            <h6>Организация - {{ $nameMainOrg ?? ''}}</h6>
            @isset($organizations)
              <form action="{{ route('processes.addOrganization', ['process' => $process]) }}" method="POST">
                  @csrf
                  <div class="form-group">
                      <label for="mainOrganization">Выберите Оргaнизацию основного маршрута</label>
                      <select name="mainOrganization" class="form-control" id="mainOrganization" data-dropup-auto="false">
                          <option selected="true" disabled="disabled">Выберите организацию</option>
                          @foreach($organizations as $organization)
                              <option value={{$organization->id}}>{{$organization->name}} </option>
                          @endforeach
                      </select>
                  </div>
                  <button type="submit" class="btn btn-primary mx-2">Выбрать</button>
              </form>
            @endisset
            @isset($process->routes)
              <div style="margin-top: 10px;">
                  <button type="button" class="btn btn-outline-info mx-2" data-toggle="modal" data-target="#routeModal">Выбрать Участников</button>
                  <div class="border border-light" id="items" style="margin-top: 10px;">
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

            <hr style="height:1px;border-width:0; background-color:black;">
            <div class="card-title"><h5>Создание шаблонов:</h5></div>
              <div>
                <div>
                  <b>Прикрепленный шаблон:</b>
                  @foreach($templateDocs as $template)
                    @if($template->id == $process->template_doc_id)
                       {{$template->name}}
                      @break
                    @endif
                  @endforeach
                </div>
                <form action="{{ route('process.addDocTemplates') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="processId" value = {{$process->id}}>
                        <label for="docTemplate">Выберите другой документ шаблона:</label>
                        <select name="docTemplateId" id="docTemplate" class="form-control">
                            @foreach($templateDocs as $doc)
                              @if($process->template_doc_id == $doc->id)
                                <option selected value="{{$doc->id}}">
                                    {{$doc->name}}
                                </option>
                              @else
                                <option value="{{$doc->id}}">
                                    {{$doc->name}}
                                </option>
                              @endif
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Прикрепить</button>
                </form>
              </div>
            <div>
              <div class="card-title" style="margin-top: 10px;">Шаблон одобрения</div>
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
                  <p>
                    <u>{{$accepted->name}}</u>
                    <a href="{{ route('templatefield.create', [$accepted]) }}" class="btn btn-outline-danger btn-xs">Редактировать</a>
                  </p>
              @endisset
              <div class="card-title" style="margin-top: 10px;">Шаблон отказa</div>
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
                   <p>
                      <u>{{$rejected->name}}</u>
                      <a href="{{ route('templatefield.create', [$rejected]) }}" class="btn btn-outline-danger btn-xs">Редактировать</a>
                   </p>
              @endisset
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
            $('#modHeader').text(text);
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
            var roleToAdd = $('#modHeader').text();
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
