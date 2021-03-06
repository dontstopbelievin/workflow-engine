@extends('layouts.app')

@if($process->need_map)
    <link rel="stylesheet" href="https://js.arcgis.com/4.18/esri/css/main.css">
    <style type="text/css">
    #viewDiv{
        padding: 0;
        margin: 0;
        min-height: 400px!important;
        height: 100%!important;
        width: 100%;
    }
    .esri-search{
        width: 400px!important;
    }
    .esri-popup__main-container{
        resize: horizontal;
        max-height: 666px!important;
        overflow: scroll;
    }
    .esri-view-width-less-than-medium .esri-popup__main-container,
    .esri-view-width-xlarge .esri-popup__main-container,
    .esri-view-width-large .esri-popup__main-container,
    .esri-view-width-medium .esri-popup__main-container,
    .esri-view-height-less-than-medium .esri-popup__main-container{
        height: 300px;
        width: 466px;
    }
    .esri-popup__content{
        margin: 0px 0px 0px 10px!important;
        overflow: visible!important;
    }
    .esri-popup__footer{
        display:none!important;
    }
    .attrName {
        font-weight: bold;
    }
    </style>
@endif
<style type="text/css">
    .card-body{
        font-size: 16px!important;
    }
    .table td,th{
        font-size: 16px!important;
    }
    #templateFieldsId label{
        font-size: 16px!important;
    }
</style>
@section('content')
    <title>Просмотр Заявки</title>
    <div class="main-panel">
      <div class="content">
        <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-3">
                                <a href="{{ url('docs/services/'.request()->segment(3)) }}" class="btn btn-primary float-left">Назад</a>
                            </div>
                        </div>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                    <div class="alert alert-danger" id="error_box" style="display:none;">
                      <!-- errors HERE -->
                    </div>
                    <div class="card-body" id="items">
                        <div class="tab">
                            <button class="tablinks" id="mybutton" onclick="openTab(event, 'applicationInfo')">Заявление</button>
                            <button class="tablinks" onclick="openTab(event, 'specialistFields')">Ответы специалистов</button>
                            <button class="tablinks" onclick="openTab(event, 'logs')">Движение документа</button>
                            @if(Auth::user()->role->name != 'Заявитель' && $canApprove)
                                <button class="tablinks" onclick="openTab(event, 'spec_answ')">Ваш ответ</button>
                            @endif
                        </div>
                        <div id="applicationInfo" class="tabcontent">
                            <!-- <h4 class="text-center">Информация о заявителе</h4> -->
                            <div class="row">
                            <div class="col-md-6">
                                <ul class="list-group" id="list">
                                    <li class="list-group-item"><b>Название услуги:</b> {{$process->name}}</li>
                                    @isset($aRowNameRows)
                                       @foreach ($aRowNameRows as $aRowNameRow)
                                            @if (array_key_exists($aRowNameRow->name, $application_arr))
                                                @if($aRowNameRow->inputName == 'file')
                                                    <li class="list-group-item"><b>{{$aRowNameRow->labelName}}:</b> <a href="{{url('storage/' .$application_arr[$aRowNameRow->name])}}" target="_blank">Просмотр</a></li>
                                                @else
                                                    @if($aRowNameRow->inputName == 'hidden')
                                                        <div id="{{$aRowNameRow->name}}" style="display: none;">{{$application_arr[$aRowNameRow->name]}}</div>
                                                    @else
                                                        <li class="list-group-item"><b>{{$aRowNameRow->labelName}}:</b> {{$application_arr[$aRowNameRow->name]}}</li>
                                                    @endif
                                                @endif
                                            @endif
                                       @endforeach
                                    @endisset
                                </ul>
                            </div>
                            <div class="col-md-6">
                                @if($process->need_map)
                                    <div id="viewDiv" style="height: 0px"></div>
                                @endif
                            </div>
                        </div>
                        </div>

                        <div id="specialistFields" class="tabcontent">
                            <!-- <h4 class="text-center">Поля заполненные специалистами</h4> -->
                            @isset($templateTableFields)
                                @foreach($templateTableFields as $item)
                                @if ((Auth::user()->role->name == 'Заявитель' && $item->to_citizen == 1 &&
                                    $application->status_id == 33) ||
                                    Auth::user()->role->name != 'Заявитель')
                                <div style="padding: 10px;"><b>{{$item->role_name}}</b>("{{$item->name}}"):</div>
                                <ul class="list-group" id="list">
                                    @if(count($item->fields) > 0)
                                        @foreach($item->fields as $key=>$value)
                                            @if(substr($value['value'], 0, 16) === 'application-docs')
                                                <li class="list-group-item">{{$value['label']}}: <a href="{{asset('storage/' .$value['value'] )}}" target="_blanc">Просмотр</a></li>
                                            @else
                                                @if($key == 'pdf_url')
                                                    @if($value['value'] != null)
                                                    <li class="list-group-item">Выходной документ: <a href="{{asset('storage/' .$value['value'] )}}" target="_blanc">Просмотр</a></li>
                                                    @endif
                                                @else
                                                    <li class="list-group-item">{{$value['label']}}: {{$value['value']}}</li>
                                                @endif
                                            @endif
                                        @endforeach
                                    @else
                                        <li class="list-group-item">Данные не введены.</li>
                                    @endif
                                </ul>
                                @endif
                                @endforeach
                            @endisset
                        </div>

                        <div id="logs" class="tabcontent">
                            <table class="table" style="background: white;width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 30%;">Роль</th>
                                        <th style="width: 30%;">Действие</th>
                                        @if((Auth::user()->role->name != 'Заявитель'))
                                            <th style="width: 30%;">Комментарии</th>
                                        @endif
                                        <th style="width: 10%;">Время</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @isset($records)
                                    @foreach($records as $record)
                                        <tr>
                                            <td>
                                            @if(mb_strlen($record["role"], 'UTF-8') > 50)
                                                <span data-toggle="tooltip" title="{{$record['role']}}">
                                                      {{mb_substr($record["role"], 0, 50, 'utf-8')}}...
                                                </span>
                                            @else
                                                {{ $record["role"] }}
                                            @endif
                                            </td>
                                            <td>
                                            @if(mb_strlen($record["name"], 'UTF-8') > 100)
                                                <span data-toggle="tooltip" title="{{$record['name']}}">
                                                      {{mb_substr($record["name"], 0, 100, 'utf-8')}}...
                                                </span>
                                            @else
                                                {{ $record["name"] }}
                                            @endif
                                            </td>
                                            @if((Auth::user()->role->name != 'Заявитель'))
                                                <td>{{$record["comment"]}}</td>
                                            @endif
                                            <td>{{Carbon\Carbon::parse($record["created_at"])->format('d-m-Y h:i:s A')}}</td>
                                        </tr>
                                    @endforeach
                                @endisset
                                </tbody>
                            </table>
                        </div>

                        <div id="spec_answ" class="tabcontent">
                            @if($canApprove)
                                @if (isset($templateFields) && $application->reject_reason == null)
                                    <!-- <div id = "templateFieldsId"> -->
                                    <div class="alert alert-danger" id="error_box" style="display:none;">
                                      <!-- errors HERE -->
                                    </div>
                                    <ul class="list-group" id="templateFieldsId">
                                        @foreach($templateFields as $item)
                                            <!-- <div class="form-group row"> -->
                                            <li class="list-group-item">
                                                <div class="row">
                                                <div class="col-md-3">
                                                <label for="{{$item->name}}" class="col-form-label">{{ __($item->label_name) }}</label>
                                                </div>
                                        @switch($item->input_type_id)
                                            @case(1)
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" id="{{$item->name}}"  name="{{$item->name}}" required autocomplete="{{$item->name}}" autofocus>
                                                </div>
                                                @break
                                            @case(2)
                                                <div class="col-md-6">
                                                    <input type="file" class="form-control" id="{{$item->name}}"  name="{{$item->name}}" required autocomplete="{{$item->name}}" autofocus>
                                                </div>
                                                @break
                                            @case(3)
                                                <div class="col-md-6">
                                                    <select name="{{$item->name}}" id="{{$item->name}}" class="form-control" required>
                                                        <option selected disabled>Выберите {{$item->label_name}}</option>
                                                        @foreach($item->options as $option)
                                                            <option value="{{$option->name_rus}}">{{$option->name_rus}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @break
                                            @case(4)
                                                <div class="col-md-6">
                                                    @if($item->def_values)
                                                        <select id="select_{{$item->id}}" class="form-control">
                                                            <option selected disabled>Выберите {{$item->label_name}}</option>
                                                            @foreach($item->def_values as $val)
                                                                <option value="{{$val->text}}">{{$val->title}}</option>
                                                            @endforeach
                                                        </select>
                                                        @section('scripts')
                                                        <script type="text/javascript">
                                                            $('#select_{{$item->id}}').on('change', function() {
                                                                $('#{{$item->name}}').val(this.value);
                                                            });
                                                        </script>
                                                        @append
                                                    @endif
                                                    <textarea name="{{$item->name}}" rows="3" class="form-control" id="{{$item->name}}" required></textarea>
                                                </div>
                                                @break
                                            @default
                                        @endswitch
                                                <!-- </div> -->
                                                </div>
                                            </li>
                                        @endforeach
                                    <!-- </div> -->
                                    </ul>
                                @endif

                                <div style="margin: 10px 0px;">
                                  @if($application->reject_reason_from_spec_id == null)
                                      @if($toCitizen)
                                              <input type="hidden" id="answer" value ="1">
                                              <input type="hidden" name="process_id" value = {{$process->id}}>
                                              <input type="hidden" name="application_id" value = {{$application->id}}>
                                              <div class="form-group row">
                                                  <label for="comments" class="col-md-4 col-form-label text-md-right">{{ __("Комментарий") }}</label>
                                                  <div class="col-md-6">
                                                      <input type="text" id="lastComments" class="form-control" name="lastComments"  autocomplete="comments" autofocus>
                                                  </div>
                                              </div>
                                            <button class="btn btn-success" data-dismiss="modal" id="toCitizen">Согласовать и отправить заявителю</button>
                                      @else
                                          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal3">Согласовать</button>
                                      @endif
                                      @if($buttons[0] && $buttons[0]->can_motiv_otkaz == 1)
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">Мотивированный отказ</button>
                                      @else
                                        @if($buttons[0] && $buttons[0]->can_reject == 1)
                                          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">Отказ</button>
                                        @endif
                                      @endif
                                      @if($buttons[0] && $buttons[0]->can_send_to_revision == 1)
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal2">Отправить на доработку</button>
                                      @endif
                                  @else
                                    @if($toCitizen)
                                          <input type="hidden" id="answer" value ="0">
                                          <input type="hidden" name="process_id" value = {{$process->id}}>
                                          <input type="hidden" name="application_id" value = {{$application->id}}>
                                          <div class="form-group row">
                                              <label for="comments" class="col-md-4 col-form-label text-md-right">{{ __("Комментарий") }}</label>
                                              <div class="col-md-6">
                                                  <input type="text" id="lastComments" class="form-control" name="lastComments"  autocomplete="comments" autofocus>
                                              </div>
                                          </div>
                                          <div style="text-align: center">
                                            <button class="btn btn-danger" data-dismiss="modal" id="toCitizen">Отправить заявителю с отказом</button>
                                          </div>
                                    @else
                                        <input type="hidden" id="processId" name="process_id" value = {{$process->id}}>
                                        <input type="hidden" id="application_id" name="application_id" value = {{$application->id}}>
                                        @if($rolesToSelect)
                                        <div class="form-group row">
                                            <select name="roleToSelect" id="roleToSelect" class="form-control">
                                                <option selected disabled value="-1">Выберите Ниже</option>
                                                @foreach($rolesToSelect as $role)
                                                    <option value="{{$role['id']}}">{{$role['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif
                                        <button class="btn btn-danger" data-dismiss="modal" id="approveReject">Согласовать отказ</button>
                                    @endif
                                  @endif
                                </div>
                            @endif
                        </div>

                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        @if($buttons && $buttons[0]->can_motiv_otkaz == 1)
                                            <h4 class="modal-title text-center">Форма Мотивированного отказа</h4>
                                        @else
                                            <h4 class="modal-title text-center">Форма отказа</h4>
                                        @endif
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="form-group row">
                                                <label for="reject_reason" class="col-md-4 col-form-label text-md-right">{{ __("Введите причину отказа") }}</label>
                                                <div class="col-md-6">
                                                    <input type="text" id="rejectReason" class="form-control" name="reject_reason"  autocomplete="reject_reason" autofocus>
                                                </div>
                                            </div>
                                            @if($buttons && $buttons[0]->can_motiv_otkaz == 1)
                                              <input type="hidden" id="motiv_otkaz" name="motiv_otkaz" value="1">
                                            @else
                                              <input type="hidden" id="motiv_otkaz" name="motiv_otkaz" value="0">
                                            @endif
                                            <input type="hidden" id="processId" name="process_id" value = {{$process->id}}>
                                            <input type="hidden" id="application_id" name="application_id" value = {{$application->id}}>
                                            @if($rolesToSelect)
                                            <div class="form-group row">
                                                <select name="roleToSelect" id="roleToSelect" class="form-control">
                                                    <option selected disabled value="-1">Выберите Ниже</option>
                                                    @foreach($rolesToSelect as $role)
                                                        <option value="{{$role['id']}}">{{$role['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @endif
                                            <button class="btn btn-info" style="float:center" data-dismiss="modal" id="rejectButton">Отправить</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="myModal3" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title  text-center">Добавление комментариев</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="form-group row">
                                                <label for="comments" class="col-md-4 col-form-label text-md-right">{{ __("Введите комментарий") }}</label>
                                                <div class="col-md-6">
                                                    <input type="text" id="comments" class="form-control" name="comments"  autocomplete="comments" autofocus>
                                                </div>
                                            </div>
                                            <input type="hidden" id="processId" name="process_id" value = {{$process->id}}>
                                            <input type="hidden" id="application_id" name="application_id" value = {{$application->id}}>
                                            @if($rolesToSelect)
                                            <div class="form-group row">
                                                <select name="roleToSelect" id="roleToSelect" class="form-control">
                                                    <option selected disabled value="-1">Выберите Ниже</option>
                                                    @foreach($rolesToSelect as $role)
                                                        <option value="{{$role['id']}}">{{$role['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @endif
                                            <button class="btn btn-info" data-dismiss="modal" id="commentButton">Отправить</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title  text-center">Форма отправки на доработку</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="form-group row">
                                                <label for="revisionReason" class="col-form-label">{{ __("Введите причину отправки на доработку") }}</label>
                                                <input type="text" id="revisionReason" class="form-control" name="revisionReason"  autocomplete="revisionReason" autofocus>
                                            </div>
                                            <div class="form-group row">
                                                <label for="roleToRevise" class="col-form-label">{{ __('Выберите Специалиста') }}</label>
                                                <select name="roleToRevise" id="roleToRevise" class="form-control">
                                                    <option selected disabled>Выберите Ниже</option>
                                                    @foreach($rolesToRevision as $role)
                                                        <option value="{{$role['id']}}">{{$role['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <input type="hidden" id="processId" name="process_id" value = {{$process->id}}>
                                            <input type="hidden" id="application_id" name="application_id" value = {{$application->id}}>
                                            <button class="btn btn-info" data-dismiss="modal" id="revisionButton">Отправить</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="created_modal" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            Ваша заявка успешна подана!<br/>
                                            Срок выполнения заявки <span id="created_deadline"></span> дней.<br/>
                                            <button type="button" class="btn btn-primary float-right" data-dismiss="modal">Закрыть</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- sign ecp -->
                        <div class="form-group" style="display:none;">
                            <label for="inputType">Выберите Тип Вводимого</label>
                            <select id="storageSelect" name="inputType" class="form-control">
                                <option value="PKCS12" selected>PKCS12</option>
                            </select>
                        </div>
                        <div style="display:none;">
                            <textarea class="form-control" id="xmlToSign" readonly placeholder="<xml>...</xml>" rows="3"></textarea>
                        </div>
                        <div style="display:none;">
                            <textarea class="form-control" id="urlToSend" readonly rows="3"></textarea>
                        </div>
                        @if($buttons && $buttons[0] && $buttons[0]->can_ecp_sign == 1)
                          <input type="hidden" id="can_ecp_sign" name="can_ecp_sign" value = "1">
                        @else
                          @if($buttons && $buttons[0] && $buttons[0]->can_ecp_sign == 0)
                            <input type="hidden" id="can_ecp_sign" name="can_ecp_sign" value = "0">
                          @endif
                        @endif
                        <!-- sign ecp -->

                        <div>
                            <a href="{{ url('docs/services/'.request()->segment(3)) }}" class="btn btn-primary float-left" style="margin-top:15px">Назад</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @if($process->need_map)
        @include('application.maps.map_spec')
    @endif
    <script>
        var created_deadline = null;
        let tmp = [];
        location.search
            .substr(1)
            .split("&")
            .forEach(function (item) {
              tmp = item.split("=");
              if (tmp[0] == 'deadline'){
                created_deadline = decodeURIComponent(tmp[1]);
                document.getElementById("created_deadline").innerHTML = created_deadline;
                $('#created_modal').modal('show');
              }
            });

        document.addEventListener("DOMContentLoaded", function(event) {
            document.getElementById("mybutton").click();
        });
        function openTab(evt, tabName) {
        // Declare all variables
            var i, tabcontent, tablinks;

            // Get all elements with class="tabcontent" and hide them
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Get all elements with class="tablinks" and remove the class "active"
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Show the current tab, and add an "active" class to the button that opened the tab
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }
        $(document).ready(function() {
            $(document).on('click', '.ourItem', function(event) {
                var text = $(this).text();
                text = $.trim(text);
                $('#modHeader').val(text);
                console.log(text);
            });

            $('#rejectButton').click(function(event) {
                var rejectReason = $('#rejectReason').val();
                var motiv_otkaz = $('#motiv_otkaz').val();
                var processId = $('#processId').val();
                var application_id = $('#application_id').val();
                var can_ecp_sign = $('#can_ecp_sign').val();
                var roleToSelect = $("#roleToSelect").val();
                var payload = {
                    'rejectReason': rejectReason,
                    'motiv_otkaz': motiv_otkaz,
                    'process_id': processId,
                    'application_id': application_id,
                    '_token': $('input[name=_token]').val()
                };
                if(roleToSelect && roleToSelect != '-1'){
                    payload['roleToSelect'] = roleToSelect;
                }

                if(motiv_otkaz == 1 && can_ecp_sign == 1){
                  $.ajax({
                    method: "POST",
                    url: "/docs/getXML",
                    data: { 'processId':processId,'applicationId':application_id,'_token':$('input[name=_token]').val() }
                  }).then(function(data){
                      document.getElementById("xmlToSign").value = data;
                      document.getElementById("urlToSend").value = "docs/reject";
                      signXmlCall();
                  });
                } else{
                  $.post('/docs/reject', payload)
                    .done( function(data) {
                        console.log(data);
                        $('#error_box').hide('400');
                        $('#items').load(location.href + ' #items');
                     })
                    .fail( function(xhr, textStatus, errorThrown) {
                      var response = JSON.parse(xhr.responseText);
                      var errorString = '';
                      $.each( response.error, function( key, value) {
                          errorString += '<li>' + value + '</li>';
                      });
                      console.log(errorString);
                      document.getElementById("error_box").innerHTML = errorString;
                      $('#error_box').show('400');
                    });
                }

            });

            $('#approveReject').click(function(event) {
                var processId = $('#processId').val();
                var application_id = $('#application_id').val();
                var can_ecp_sign = $('#can_ecp_sign').val();
                var roleToSelect = $("#roleToSelect").val();
                var payload = {
                    'process_id': processId,
                    'application_id': application_id,
                    '_token': $('input[name=_token]').val()
                };
                if(roleToSelect && roleToSelect != '-1'){
                    payload['roleToSelect'] = roleToSelect;
                }

                if(can_ecp_sign == 1){
                  $.ajax({
                    method: "POST",
                    url: "/docs/getXML",
                    data: { 'processId':processId,'applicationId':application_id,'_token':$('input[name=_token]').val() }
                  }).then(function(data){
                      document.getElementById("xmlToSign").value = data;
                      document.getElementById("urlToSend").value = "docs/approveReject";
                      signXmlCall();
                  });
                }else{
                  $.post('/docs/approveReject', payload)
                  .done( function(data) {
                      console.log(data);
                      $('#error_box').hide('400');
                      $('#items').load(location.href + ' #items');
                   })
                  .fail( function(xhr, textStatus, errorThrown) {
                    var response = JSON.parse(xhr.responseText);
                    var errorString = '';
                    $.each( response.error, function( key, value) {
                        errorString += '<li>' + value + '</li>';
                    });
                    console.log(errorString);
                    document.getElementById("error_box").innerHTML = errorString;
                    $('#error_box').show('400');
                  });
                }


            });

            $('#toCitizen').click(function(event) {
                var processId = $('#processId').val();
                var application_id = $('#application_id').val();
                var can_ecp_sign = $('#can_ecp_sign').val();

                if(can_ecp_sign == 1){
                  $.ajax({
                    method: "POST",
                    url: "/docs/getXML",
                    data: { 'processId':processId,'applicationId':application_id,'_token':$('input[name=_token]').val() }
                  }).then(function(data){
                      document.getElementById("xmlToSign").value = data;
                      document.getElementById("urlToSend").value = "docs/toCitizen";
                      signXmlCall();
                  });
                }else{
                  $.post('/docs/toCitizen', {'answer':$('#answer').val(),'process_id':processId,'application_id':application_id, 'comments': $('#lastComments').val(), '_token':$('input[name=_token]').val()})
                  .done( function(data) {
                      console.log(data);
                      $('#error_box').hide('400');
                      $('#items').load(location.href + ' #items');
                   })
                  .fail( function(xhr, textStatus, errorThrown) {
                    var response = JSON.parse(xhr.responseText);
                    var errorString = '';
                    $.each( response.error, function( key, value) {
                        errorString += '<li>' + value + '</li>';
                    });
                    console.log(errorString);
                    document.getElementById("error_box").innerHTML = errorString;
                    $('#error_box').show('400');
                  });
                }



            });

            $('#revisionButton').click(function(event) {
                let revisionReason = $('#revisionReason').val();
                var roleToRevise = $( "#roleToRevise option:selected" ).text();
                var processId = $('#processId').val();
                var application_id = $('#application_id').val();
                $.post('/docs/revision', {'revisionReason':revisionReason,'processId':processId,'application_id':application_id,'roleToRevise':roleToRevise, '_token':$('input[name=_token]').val()})
                .done( function(data) {
                    console.log(data);
                    $('#error_box').hide('400');
                    $('#items').load(location.href + ' #items');
                 })
                .fail( function(xhr, textStatus, errorThrown) {
                  var response = JSON.parse(xhr.responseText);
                  var errorString = '';
                  $.each( response.error, function( key, value) {
                      errorString += '<li>' + value + '</li>';
                  });
                  console.log(errorString);
                  document.getElementById("error_box").innerHTML = errorString;
                  $('#error_box').show('400');
                });
            });

            $('#commentButton').click(function(event) {

                let formData = new FormData();
                var processId = $('#processId').val();
                var application_id = $('#application_id').val();
                var can_ecp_sign = $('#can_ecp_sign').val();
                let comments = $('#comments').val();
                let inputs = $('#templateFieldsId :input');
                var roleToSelect = $("#roleToSelect").val();
                if(roleToSelect && roleToSelect != '-1'){
                    formData.append('roleToSelect', roleToSelect);
                }
                formData.append('process_id', processId);
                formData.append('application_id', application_id);
                formData.append('comments', comments);
                inputs.each(function() {
                    if ('files' in $(this)[0] && $(this)[0].files != null) {
                        var file = $('input[type=file]')[0].files[0];
                        if(file!==undefined) {
                            formData.append(this.name, file);
                        }
                    } else {
                     formData.append(this.name, $(this).val());
                    }
                });
                formData.append('_token', $('input[name=_token]').val());

                if(can_ecp_sign == 1){
                  // get xml and sendXmlCall: processId, applicationId
                  $.ajax({
                    method: "POST",
                    url: "/docs/getXML",
                    data: { 'processId':processId,'applicationId':application_id,'_token':$('input[name=_token]').val() }
                  }).then(function(data){
                      document.getElementById("xmlToSign").value = data;
                      document.getElementById("urlToSend").value = "docs/approve";
                      signXmlCall();
                  });
                }else{
                  var xhr = new XMLHttpRequest();
                  xhr.open("post", "{{url('docs/approve')}}", true);
                  xhr.setRequestHeader("Authorization", "Bearer " + "{{csrf_token()}}");
                  xhr.onload = function () {
                      if(xhr.status == 200){
                          $('#error_box').hide('400');
                          location.reload();
                      }else{
                          console.log(xhr);
                          var errors = JSON.parse(xhr.responseText);
                          var errorString = '';
                          $.each(errors.error, function( key, value) {
                              errorString += '<li>' + value + '</li>';
                          });
                          document.getElementById("error_box").innerHTML = errorString;
                          $('#error_box').show('400');
                      }
                  }.bind(this)
                  xhr.send(formData);
                }
            });
        });
    </script>
@append
