@extends('layouts.app')

@section('title')
    Редактирование процесса
@endsection

@section('content')
<div class="main-panel">
  <div class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h4 class="page-title">
            <a href="{{ route('processes.index') }}" class="btn btn-info" style="margin-right: 10px;">Назад</a>
            Изменение Процесса: {{$process->name}}</h4>
          @if(session('status'))
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
          <div class="col-md-12" style="margin-bottom: 40px;">
            <div class="tab">
              <button class="tablinks3 active" onclick="openTab3(event, 'about_process')">О процессе</button>
              <button class="tablinks3" onclick="openTab3(event, 'organization')">Организация</button>
              <button class="tablinks3" onclick="openTab3(event, 'creat_table')">Создать таблицу</button>
              <button class="tablinks3" onclick="openTab3(event, 'create_roles')">Создание маршрута</button>
              <button class="tablinks3" onclick="openTab3(event, 'create_template')">Создание шаблонов</button>
            </div>
            <div id="about_process" class="tabcontent3">
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
            </div>
            <div id="creat_table" class="tabcontent3" style="display: none;">
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
              <button type="button" class="btn btn-primary mx-2" data-toggle="modal" data-target="#myModal" style="margin-top: 20px;">Выбрать Поля</button>
            </div>
            <div id="organization" class="tabcontent3"  style="display: none;">
              <h6>Организация - {{ $nameMainOrg ?? 'не выбрана'}}</h6>
              @isset($organizations)
                <form action="{{ route('processes.addOrganization', ['process' => $process]) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="mainOrganization">Выберите Оргaнизацию основного маршрута</label>
                        <select name="mainOrganization" class="form-control" id="mainOrganization" data-dropup-auto="false">
                            <option selected="true" disabled="disabled">Выберите организацию</option>
                            @foreach($organizations as $organization)
                                @if($organization->id == $process->main_organization_id)
                                        <option selected value={{$organization->id}}>{{$organization->name}} </option>
                                      @else
                                        <option value={{$organization->id}}>{{$organization->name}} </option>
                                      @endif
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mx-2">Выбрать</button>
                </form>
              @endisset
            </div>
            <div id="create_roles" class="tabcontent3"  style="display: none;">
              @isset($process->routes)
                <div style="margin-top: 10px;">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#routeModal">Выбрать Участников</button>
                    <div class="border border-light" id="items" style="margin-top: 10px;">
                      <table border="1" cellpadding="5" style="text-align: center;">
                          <tr>
                            <td>Роль</td><td>Очередность</td><td></td>
                            @if(isset($process_roles) && count($process_roles)>0)
                              @include('process.process_roles_list', ['process_roles' => $process_roles])
                            @else
                              <tr><td colspan="3">Упссс тут пусто...</td></tr>
                            @endif
                          </tr>
                        </table>
                    </div>
                </div>
              @endisset
            </div>
            <div id="create_template" class="tabcontent3"  style="display: none;">
              <div>
                <div class="card-title">Прикрепленный шаблон:
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
              </div><hr>
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
                <hr>
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
            <div class="modal fade" id="routeModal" role="dialog">
                  <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content">
                          <div class="modal-header">
                              <h4 class="modal-title">Список Ролей</h4>
                          </div>
                          <div class="modal-body">
                            <form action="{{ route('processes.addRole', ['process' => $process]) }}" method="POST">
                              @csrf
                              <div style="margin-bottom: 10px;text-align: center;">
                                <button type="submit" class="btn btn-success">Выбрать</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                              </div>
                              <div class="form-group">
                                <label>Очередность:</label>
                                <input type="number" name="order">
                              </div>
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
                                          <label class="form-check-label">
                                             <input type="checkbox" name="motiv_otkaz[]" id="motiv_otkaz{{$role->id}}" value="{{$role->id}}" class="mr-2">
                                             <span class="form-check-sign">Мотивированный отказ</span>
                                          </label>
                                          <label class="form-check-label">
                                             <input type="checkbox" name="ecp_sign[]" id="ecp_sign{{$role->id}}" value="{{$role->id}}" class="mr-2">
                                             <span class="form-check-sign">Подпись ЭЦП</span>
                                          </label>
                                        </div>
                                      </div>
                                    </div>
                                    @section('scripts')
                                    <script>
                                      $("#participant{{$role->id}}").click(function(){
                                        if(document.getElementById("dropdown-permission{{$role->id}}").style.display == "none"){
                                          document.getElementById("dropdown-permission{{$role->id}}").style.display = "block";
                                        }else{
                                          document.getElementById("dropdown-permission{{$role->id}}").style.display = "none";
                                          document.getElementById("revision{{$role->id}}").checked = false;
                                          document.getElementById("reject{{$role->id}}").checked = false;
                                          document.getElementById("motiv_otkaz{{$role->id}}").checked = false;
                                          document.getElementById("ecp_sign{{$role->id}}").checked = false;
                                        }
                                      });
                                    </script>
                                    @append
                                @endforeach
                            @endisset
                            <div style="text-align: center;">
                              <button type="submit" class="btn btn-success">Выбрать</button>
                              <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                            </div>
                          </form>
                        </div>
                        <div class="modal-footer">
                        </div>
                      </div>
                  </div>
            </div>
            <div class="modal fade" id="myModal2" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Список Ролей</h4>
                        </div>
                        <div class="modal-body">
                          <form action="{{ url('process/add_sub_role', ['process' => $process]) }}" method="POST">
                            @csrf
                            <div style="margin-bottom: 10px;text-align: center;">
                              <button type="submit" class="btn btn-success">Выбрать</button>
                              <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                            </div>
                            <div class="form-group">
                              <label>Очередность:</label>
                              <input type="number" name="order">
                            </div>
                            <div class="form-group">
                              <label>Parent:</label>
                              <input type="text" name="parent_role_name" id="parent_role_name" value="" disabled="">
                              <input type="hidden" name="parent_role_id" id="parent_role_id" value="">
                            </div>
                            @isset($roles)
                              @foreach ($roles as $role)
                                  <div class="pb-0">
                                    <label class="form-check-label py-0">
                                      <input type="checkbox" name="roles[]" value="{{$role->id}}" class="form-check-input" id="s_participant{{$role->id}}">
                                      <span class="form-check-sign">{{$role->name}}</span>
                                    </label>
                                    <div id="dropdown" class="form-check">
                                      <div class="dropdown-permission{{$role->id}}" id="s_dropdown-permission{{$role->id}}" style="display:none;">
                                        <label class="form-check-label">
                                           <input type="checkbox" name="reject[]" id="s_reject{{$role->id}}" value="{{$role->id}}" class="mr-2">
                                           <span class="form-check-sign">Отказать</span>
                                        </label>
                                        <label class="form-check-label">
                                           <input type="checkbox" name="revision[]" id="s_revision{{$role->id}}" value="{{$role->id}}" class="mr-2">
                                           <span class="form-check-sign">Отправить на доработку</span>
                                        </label>
                                        <label class="form-check-label">
                                           <input type="checkbox" name="motiv_otkaz[]" id="s_motiv_otkaz{{$role->id}}" value="{{$role->id}}" class="mr-2">
                                           <span class="form-check-sign">Мотивированный отказ</span>
                                        </label>
                                        <label class="form-check-label">
                                           <input type="checkbox" name="ecp_sign[]" id="s_ecp_sign{{$role->id}}" value="{{$role->id}}" class="mr-2">
                                           <span class="form-check-sign">Подпись ЭЦП</span>
                                        </label>
                                      </div>
                                    </div>
                                  </div>
                                  @section('scripts')
                                  <script>
                                    $("#s_participant{{$role->id}}").click(function(){
                                      if(document.getElementById("s_dropdown-permission{{$role->id}}").style.display == "none"){
                                        document.getElementById("s_dropdown-permission{{$role->id}}").style.display = "block";
                                      }else{
                                        document.getElementById("s_dropdown-permission{{$role->id}}").style.display = "none";
                                        document.getElementById("s_reject{{$role->id}}").checked = false;
                                        document.getElementById("s_revision{{$role->id}}").checked = false;
                                        document.getElementById("s_motiv_otkaz{{$role->id}}").checked = false;
                                        document.getElementById("s_ecp_sign{{$role->id}}").checked = false;
                                      }
                                    });
                                  </script>
                                  @append
                              @endforeach
                          @endisset
                          <div style="text-align: center;">
                            <button type="submit" class="btn btn-success">Выбрать</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                          </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                      </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <span class="modal-title">Список Полей</span>
                      </div>
                      <div class="modal-body">
                        <form action="{{ route('processes.createProcessTable', ['process' => $process]) }}" method="POST">
                          @csrf
                          <div style="text-align: center;">
                            <button type="submit" class="btn btn-success">Создать</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                          </div>
                          @isset($columns)
                                @foreach ($columns as $column)
                                  <div class="form-check" style="padding:0px;">
                                    <label class="form-check-label">
                                      <input class="form-check-input" type="checkbox" name="fields[]" value="{{$column->name}}">
                                      <span class="form-check-sign">{{$column->labelName}}</span>
                                    </label>
                                  </div>
                                @endforeach
                          @endisset
                          <div style="text-align: center;">
                            <button type="submit" class="btn btn-success">Создать</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                          </div>
                        </form>   
                      </div>
                      <div class="modal-footer">
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
<script>
    $(document).ready(function() {
        $('.AddButton').click(function(event) {
            $('#parent_role_id').val($(this).attr('data-id'));
            $('#parent_role_name').val($(this).attr('data-name'));
          });
      });
  </script>
@append