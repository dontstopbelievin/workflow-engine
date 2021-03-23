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
            <a href="{{ url('admin/process') }}" class="btn btn-info" style="margin-right: 10px;">Назад</a>
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
              <form action="{{ url('admin/process/update', ['process' => $process]) }}" method="POST">
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
                <form action="{{ url('admin/process/add_organization', ['process' => $process]) }}" method="POST">
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
                <table border="1" cellpadding="5">
                  <tr>
                    <td>Название таблицы</td><td>Согласование/Мотив. отказ</td>
                    <td>Прикрепленный шаблон</td>
                    <td>Специалист</td><td>Очередность</td><td>Действие</td>
                  </tr>
                  @if(count($templates) > 0)
                    @foreach($templates as $template)
                      <tr>
                        <td>{{$template->table_name}}</td>
                        <td>
                          @if($template->accept_template == 1)
                            Согласование
                          @else
                            Мотивированный отказ
                          @endif
                        </td>
                        <td>{{$template->doc->name}}</td>
                        <td>
                          @if(mb_strlen($template->role->name, 'utf-8') > 50)
                            <div href="#" data-toggle="tooltip" title="{{$template->role->name}}">
                              {{mb_substr($template->role->name, 0, 50, 'utf-8')}}...
                            </div>
                          @else
                              {{$template->role->name}}
                          @endif
                        </td>
                        <td>{{$template->order}}</td>
                        <td>
                          <a href="{{ url('admin/template_field/create', [$template]) }}" class="btn btn-outline-danger btn-xs">Добавить поля</a>
                          <form action="{{ url('admin/template/delete', [$template->id]) }}" method="post">
                            {{csrf_field()}}
                            <button type="submit" class="btn btn-outline-danger btn-xs" style="margin:3px;">Удалить</button>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  @else
                  <tr><td colspan="6">Упссс тут пусто...</td></tr>
                  @endif
                </table>
              </div>
              <hr/>
              <div class="col-md-6">
                <div class="card-title" style="margin-top: 10px;">Создать шаблон</div>
                <form action="{{ url('admin/template/store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="process_id" value="{{$process->id}}">
                    <div class="form-group">
                        <label for="fieldName">Название таблицы шаблона</label>
                        <input type="text" class="form-control" name="table_name" id="fieldName">
                    </div>
                    <div class="form-group">
                        <label for="sh_order">Очередность</label>
                        <input type="number" class="form-control" name="order" id="sh_order">
                    </div>
                    <div class="form-group">
                      <label for="template_state">Выберите тип</label>
                      <select name="template_state" class="form-control">
                        <option selected="true" disabled="disabled">Выберите тип</option>
                        <option value="1">Согласование</option>
                        <option value="0">Мотивированный отказ</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="role_id">Выберите специалиста</label>
                      <select name="role_id" class="form-control">
                        <option selected="true" disabled="disabled">Выберите специалиста</option>
                        @foreach($process_roles_2 as $item)
                          <option value={{$item->role_id}}>{{$item->name}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                        <label for="template_doc_id">Выберите документ шаблона:</label>
                        <select name="template_doc_id" id="docTemplate" class="form-control">
                          <option selected="true" disabled="disabled">Выберите документ</option>
                          @foreach($templateDocs as $doc)
                            <option value="{{$doc->id}}">
                                {{$doc->name}}
                            </option>
                          @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="to_citizen">Показать заявителю</label>
                      <select name="to_citizen" class="form-control">
                        <option selected value="1">Да</option>
                        <option value="0">Нет</option>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-primary" style="margin-left: 10px;">Создать</button>
                </form>
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
                            <form action="{{ url('admin/process/add_role', ['process' => $process]) }}" method="POST">
                              @csrf
                              <div style="margin-bottom: 10px;text-align: center;">
                                <button type="submit" class="btn btn-success">Добавить</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                              </div>
                              <div class="form-group" style="padding: 0px">
                                <label>Очередность:</label>
                                <input type="number" name="order">
                              </div>
                              <div class="tab">
                                <button class="tablinks4 active" onclick="openTab4(event, 'roles_tab')">Роли</button>
                                <button class="tablinks4" onclick="openTab4(event, 'services_tab')">Сервисы</button>
                              </div>
                            <div id="services_tab" class="tabcontent4" style="display: none;">
                            @isset($services)
                              @foreach($services as $service)
                                <div class="pb-0">
                                  <label class="form-check-label py-0">
                                    <input type="checkbox" name="services[]" value="{{$service->id}}" class="form-check-input">
                                    <span class="form-check-sign">{{$service->label}}</span>
                                  </label>
                                </div>
                              @endforeach
                            @endisset
                            </div>
                            <div id="roles_tab" class="tabcontent4">
                            @isset($roles)
                              @foreach ($roles as $role)
                                  <div class="pb-0">
                                    <label class="form-check-label py-0">
                                      <input type="checkbox" name="roles[]" value="{{$role->id}}" class="form-check-input" id="participant{{$role->id}}">
                                      <span class="form-check-sign">{{$role->name}}</span>
                                    </label>
                                    <div id="dropdown{{$role->id}}" class="form-check" style="display:none;">
                                      <div class="dropdown-permission">
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
                                      if(document.getElementById("dropdown{{$role->id}}").style.display == "none"){
                                        document.getElementById("dropdown{{$role->id}}").style.display = "block";
                                      }else{
                                        document.getElementById("dropdown{{$role->id}}").style.display = "none";
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
                            </div>
                            <div style="text-align: center;">
                              <button type="submit" class="btn btn-success">Добавить</button>
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
                          <form action="{{ url('admin/process/add_sub_role', ['process' => $process]) }}" method="POST">
                            @csrf
                            <div style="margin-bottom: 10px;text-align: center;">
                              <button type="submit" class="btn btn-success">Выбрать</button>
                              <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                            </div>
                            <div class="form-group" style="padding: 0px;">
                              <label>Очередность:</label>
                              <input type="number" name="order">
                            </div>
                            <div class="form-group" style="padding: 0px;">
                              <label>Parent:</label>
                              <input type="text" name="parent_role_name" id="parent_role_name" value="" disabled="">
                              <input type="hidden" name="parent_role_id" id="parent_role_id" value="">
                            </div>
                            <div class="tab">
                                <button class="tablinks5 active" onclick="openTab5(event, 'roles_tab2')">Роли</button>
                                <button class="tablinks5" onclick="openTab5(event, 'services_tab2')">Сервисы</button>
                              </div>
                            <div id="services_tab2" class="tabcontent5" style="display: none;">
                            @isset($services)
                              @foreach($services as $service)
                                <div class="pb-0">
                                  <label class="form-check-label py-0">
                                    <input type="checkbox" name="services[]" value="{{$service->id}}" class="form-check-input">
                                    <span class="form-check-sign">{{$service->label}}</span>
                                  </label>
                                </div>
                              @endforeach
                            @endisset
                            </div>
                          <div id="roles_tab2" class="tabcontent5">
                          @isset($roles)
                              @foreach($roles as $role)
                                  <div class="pb-0">
                                    <label class="form-check-label py-0">
                                      <input type="checkbox" name="roles[]" value="{{$role->id}}" class="form-check-input" id="s_participant{{$role->id}}">
                                      <span class="form-check-sign">{{$role->name}}</span>
                                    </label>
                                    <div id="s_dropdown{{$role->id}}" class="form-check" style="display:none;">
                                      <div class="dropdown-permission">
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
                                      if(document.getElementById("s_dropdown{{$role->id}}").style.display == "none"){
                                        document.getElementById("s_dropdown{{$role->id}}").style.display = "block";
                                      }else{
                                        document.getElementById("s_dropdown{{$role->id}}").style.display = "none";
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
                          </div>
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
                        <form action="{{ url('admin/process/create_process_table', ['process' => $process]) }}" method="POST">
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
    function openTab4(evt, tabName) {
      evt.preventDefault();
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent4");
      for (i = 0; i < tabcontent.length; i++) {
          tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks4");
      for (i = 0; i < tablinks.length; i++) {
          tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(tabName).style.display = "block";
      evt.currentTarget.className += " active";
    }
    function openTab5(evt, tabName) {
      evt.preventDefault();
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent5");
      for (i = 0; i < tabcontent.length; i++) {
          tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks5");
      for (i = 0; i < tablinks.length; i++) {
          tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(tabName).style.display = "block";
      evt.currentTarget.className += " active";
    }

    $(document).ready(function() {
        $('.AddButton').click(function(event) {
            $('#parent_role_id').val($(this).attr('data-id'));
            $('#parent_role_name').val($(this).attr('data-name'));
          });
      });
  </script>
@append