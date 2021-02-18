@extends('layouts.app')
@section('content')
    <title>Просмотр Заявки</title>
    <div class="main-panel">
      <div class="content">
        <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-3">
                                <a href="{{ route('applications.index', ['process' => $process]) }}" class="btn btn-info float-left">Назад</a>
                            </div>
                            <div class="col-md-6">
                              <h2 class="card-title text-center" style="margin-bottom: 20px;">Просмотр заявки</h2>
                            </div>
                        </div>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="tab">
                            <button class="tablinks" id="mybutton" onclick="openTab(event, 'applicationInfo')">Информация о заявителе</button>
                            <button class="tablinks" onclick="openTab(event, 'specialistFields')">Поля заполненные специалистами</button>
                            <button class="tablinks" onclick="openTab(event, 'logs')">Ход согласования</button>
                        </div>
                        <div id="applicationInfo" class="tabcontent">
                            <!-- <h4 class="text-center">Информация о заявителе</h4> -->
                            <ul class="list-group" id="list">

                                <li class="list-group-item">Название услуги: {{$process->name}}</li>
                                @isset($aRowNameRows)
                                   @foreach ($aRowNameRows as $aRowNameRow)
                                        @if (array_key_exists($aRowNameRow->name, $applicationArrays))
                                        {{--dd($applicationArrays[$aRowNameRow->name], $aRowNameRow->label_name);--}}
                                            @if($aRowNameRow->label_name == 'Загрузите Файл')
                                                <li class="list-group-item">{{$aRowNameRow->label_name}}: <a href="{{url('storage/' .$application->attachment)}}" target="_blank">Просмотр</a></li>
                                            @else
                                                <li class="list-group-item">{{$aRowNameRow->label_name}}: {{$applicationArrays[$aRowNameRow->name]}}</li>
                                            @endif
                                        @endif
                                   @endforeach
                                @endisset
                                {{--@isset($application->attachment)--}}
                                    {{--<li class="list-group-item">Загруженный документ:  <a href="{{url('storage/' .$application->attachment)}}" target="_blank">Просмотр</a></li>--}}
                                {{--@endisset--}}
                            </ul>
                        </div>

                        <div id="specialistFields" class="tabcontent">
                            <!-- <h4 class="text-center">Поля заполненные специалистами</h4> -->
                            @isset($templateTableFields)
                                <ul class="list-group" id="list">
                                @foreach($templateTableFields as $key=>$value)
                                    @if(substr($value, 0, 16) === 'application-docs')
                                            <li class="list-group-item">{{$key}}: <a href="{{asset('storage/' .$value )}}" target="_blanc">Просмотр</a></li>
                                        @else
                                    <li class="list-group-item">{{$key}}: {{$value}}</li>
                                        @endif
                                    @endforeach
                                </ul>
                              @endisset
                              @isset($application->doc_path)
                                  <li class="list-group-item">Выходной документ:  <a href="{{asset('storage/' .$application->doc_path)}}" target="_blanc">Просмотр</a></li>
                              @endisset
                        </div>

                        <div id="logs" class="tabcontent">
                            <table class="table" style="background: white;width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 30%;">Статус</th>
                                        <th style="width: 30%;">Участник</th>
                                        <th style="width: 30%;">Комментарии</th>
                                        <th style="width: 10%;">Время</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @isset($records)
                                    @foreach($records as $record)
                                        <tr>
                                            <td>{{$record["name"]}}</td>
                                            <td>{{$record["role"]}}</td>
                                            <td>{{$record["comment"]}}</td>
                                            <td>{{Carbon\Carbon::parse($record["created_at"])->format('d-m-Y h:i:s A')}}</td>
                                        </tr>
                                    @endforeach
                                @endisset
                                </tbody>
                            </table>
                        </div>

                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title text-center">Форма Мотивированного отказа</h4>
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
                                                <label for="comments" class="col-md-4 col-form-label text-md-right">{{ __("Введите комментарии") }}</label>
                                                <div class="col-md-6">
                                                    <input type="text" id="comments" class="form-control" name="comments"  autocomplete="comments" autofocus>
                                                </div>
                                            </div>
                                            <input type="hidden" id="processId" name="process_id" value = {{$process->id}}>
                                            <input type="hidden" id="application_id" name="application_id" value = {{$application->id}}>
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
                                                <label for="revisionReason" class="col-md-4 col-form-label text-md-right">{{ __("Введите причину отправки на доработку") }}</label>
                                                <div class="col-md-6">
                                                    <input type="text" id="revisionReason" class="form-control" name="revisionReason"  autocomplete="revisionReason" autofocus>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="roleToRevise" class="col-md-4 col-form-label text-md-right">{{ __('Выберите Специалиста') }}</label>
                                                <select name="roleToRevise" id="roleToRevise" class="form-control">
                                                    <option selected disabled>Выберите Ниже</option>
                                                    @foreach($allRoles as $role)
                                                        <option value="{{$role->id}}">{{$role->name}}</option>
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
                        <div id="items">
                            @if($canApprove)
                                    @if (isset($templateFields) && $application->reject_reason == null)
                                        <h4 class="card-title text-center" style="margin-top:50px;">Поля Шаблона</h4>
                                        <form id = "templateFieldsId" method="POST" enctype="multipart/form-data">
                                            {{--<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">--}}
                                            @foreach($templateFields as $item)
                                                @if(Auth::user()->role->id == $item->can_edit_role_id)
                                                    <div class="form-group row">
                                                        <label for="{{$item->name}}" class="col-md-4 col-form-label text-md-right">{{ __($item->label_name) }}</label>
                                                        @if($item->input_type_id === 1)
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" id="{{$item->name}}"  name="{{$item->name}}" required autocomplete="{{$item->name}}" autofocus>
                                                            </div>
                                                        @elseif($item->input_type_id === 2)
                                                            <div class="col-md-6">
                                                                <input type="file" class="form-control" id="{{$item->name}}"  name="{{$item->name}}" required autocomplete="{{$item->name}}" autofocus>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                            @endforeach
                                        </form>
                                    @endif

                                    <div style="text-align:center; margin-top: 100px; margin-bottom:70px;">
                                      @if($application->reject_reason == null)
                                          @if($toCitizen)
                                              <form action="{{ route('applications.toCitizen', ['application_id' => $application->id]) }}" method="post">
                                                  @csrf
                                                  <input type="hidden" name="process_id" value = {{$process->id}}>
                                                  <input type="hidden" name="application_id" value = {{$application->id}}>
                                                  <input type="hidden" name="answer" value = "1">
                                                  <div class="form-group row">
                                                      <label for="comments" class="col-md-4 col-form-label text-md-right">{{ __("Введите комментарии перед отправкой заявителю") }}</label>
                                                      <div class="col-md-6">
                                                          <input type="text" id="comments" class="form-control" name="comments"  autocomplete="comments" autofocus>
                                                      </div>
                                                  </div>
                                                  <div style="text-align: center">
                                                      <button class="btn btn-success" style="margin-top: 30px;margin-bottom: 30px;" type="submit">Согласовать и отправить заявителю</button>
                                                  </div>
                                              </form>
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
                                          <form action="{{ route('applications.toCitizen', ['application_id' => $application->id]) }}" method="post">
                                              @csrf
                                              <input type="hidden" name="process_id" value = {{$process->id}}>
                                              <input type="hidden" name="application_id" value = {{$application->id}}>
                                              <input type="hidden" name="answer" value = "0">
                                              <div class="form-group row">
                                                  <label for="comments" class="col-md-4 col-form-label text-md-right">{{ __("Введите комментарии перед отправкой заявителю") }}</label>
                                                  <div class="col-md-6">
                                                      <input type="text" id="comments" class="form-control" name="comments"  autocomplete="comments" autofocus>
                                                  </div>
                                              </div>
                                              <div style="text-align: center">
                                                  <button class="btn btn-danger" style="margin-top: 30px;margin-bottom: 30px;" type="submit">Отправить заявителю с отказом</button>
                                              </div>
                                          </form>
                                        @else
                                            <input type="hidden" id="processId" name="process_id" value = {{$process->id}}>
                                            <input type="hidden" id="application_id" name="application_id" value = {{$application->id}}>
                                            <button class="btn btn-danger" data-dismiss="modal" id="approveReject">Согласовать отказ</button>
                                        @endif
                                      @endif
                                    </div>
                                @endif
                            <a href="{{ route('applications.index', ['process' => $process]) }}" class="btn btn-info" style="margin-top: 10px;">Назад</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
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
                console.log(rejectReason, processId, application_id)
                $.post('/applications/reject', {'rejectReason':rejectReason,'motiv_otkaz':motiv_otkaz,'processId':processId,'application_id':application_id, '_token':$('input[name=_token]').val()}, function(data){
                    console.log('reject: '+data);
                    $('#items').load(location.href + ' #items');
                });
            });

            $('#approveReject').click(function(event) {
                var processId = $('#processId').val();
                var application_id = $('#application_id').val();
                console.log(processId, application_id)
                $.post('/applications/approveReject', {'processId':processId,'application_id':application_id, '_token':$('input[name=_token]').val()}, function(data){
                    $('#items').load(location.href + ' #items');
                });
            });

            $('#revisionButton').click(function(event) {
                let revisionReason = $('#revisionReason').val();
                var roleToRevise = $( "#roleToRevise option:selected" ).text();
                var processId = $('#processId').val();
                var application_id = $('#application_id').val();
                $.post('/applications/revision', {'revisionReason':revisionReason,'processId':processId,'application_id':application_id,'roleToRevise':roleToRevise, '_token':$('input[name=_token]').val()}, function(data){
                    $('#items').load(location.href + ' #items');
                });
            });

            $('#commentButton').click(function(event) {
                // event.preventDefault();
                let formData = new FormData();
                let comments = $('#comments').val();
                let inputs = $('#templateFieldsId :input');
                formData.append('comments', comments);
                formData.append('process_id', $('#processId').val())
                formData.append('application_id', $('#application_id').val())
                inputs.each(function() {
                    if ($(this)[0].files === null) {
                        formData.append(this.name, $(this).val());
                    } else {
                        var file = $('input[type=file]')[0].files[0];
                        if(file!==undefined) {
                            formData.append(this.name, file);
                        }
                    }
                });

                formData.append('_token', $('input[name=_token]').val());
                var xhr = new XMLHttpRequest();
                xhr.open("post", "{{route('applications.approve')}}", true);
                xhr.setRequestHeader("Authorization", "Bearer " + "{{csrf_token()}}");
                xhr.onload = function () {
                    location.reload();
                }.bind(this)
                xhr.send(formData);
            });
        });
    </script>
@append
