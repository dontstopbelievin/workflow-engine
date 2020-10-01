

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajax Project </title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" />
</head>
<body style="background-color: #ebecf1;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title text-center" style="margin-bottom: 20px; margin-top: 20px;">Просмотр заявки</h2>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="tab">
                            <button class="tablinks" onclick="openTab(event, 'applicationInfo')">Информация о заявителе</button>
                            <button class="tablinks" onclick="openTab(event, 'specialistFields')">Поля заполненные специалистами</button>
                            <button class="tablinks" onclick="openTab(event, 'comments')">Комментарии</button>
                            <button class="tablinks" onclick="openTab(event, 'logs')">Ход согласования</button>
                            <button class="tablinks" onclick="openTab(event, 'revisionReasonTab')">Причина отправки на доработку</button>
                            <button class="tablinks" onclick="openTab(event, 'rejectReasonTab')">Причина отказа</button>
                        </div>
                        <div id="applicationInfo" class="tabcontent">
                            <!-- <h4 class="text-center">Информация о заявителе</h4> -->
                            <ul class="list-group" id="list">
                                <li class="list-group-item">Название услуги: {{$process->name}}</li>
                                @isset($application->name)
                                    <li class="list-group-item">Наименование заявителя: {{$application->name}}</li>
                                @endisset
                                @isset($application->surname)
                                    <li class="list-group-item">Фамилия заявителя: {{$application->surname ?? ''}}</li>
                                @endisset
                                @isset($application->email)
                                    <li class="list-group-item">Электронный адрес заявителя: {{$application->email ?? ''}}</li>
                                @endisset
                                @isset($application->address)
                                    <li class="list-group-item">Адрес: {{$application->address ?? ''}}</li>
                                @endisset
                                @isset($application->cadastral_number)
                                    <li class="list-group-item">Кадастровый номер: {{$application->cadastral_number ?? ''}}</li>
                                @endisset
                            </ul>
                        </div>
                        
                        <div id="specialistFields" class="tabcontent">
                            <!-- <h4 class="text-center">Поля заполненные специалистами</h4> -->
                            @isset($templateTableFields)
                                <ul class="list-group" id="list">
                                @foreach($templateTableFields as $key=>$value)
                                    <li class="list-group-item">{{$key}}: {{$value}}</li>
                                    @endforeach
                                </ul>
                                @endisset
                        </div>
                        
                        <div id="logs" class="tabcontent">
                            <table class="table" style="background: white;">
                                <h4 class="text-center" style="margin-top:50px;">Ход согласования</h4>
                                <thead>
                                    <tr>
                                        <th>Статус</th>
                                        <th>Участник</th>
                                        <th>Время</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @isset($records)
                                    @foreach($records as $record)
                                        <tr>
                                            <td>{{$record["name"]}}</td>
                                            <td>{{$record["role"]}}</td>
                                            <td>{{$record["created_at"]}}</td>
                                        </tr>
                                    @endforeach
                                @endisset
                                </tbody>
                            </table>
                        </div>
                        <div id="comments" class="tabcontent">
                            <table class="table" style="background: white;">
                                <thead>
                                    <tr>
                                        <th>Роль</th>
                                        <th>Комментарий</th>
                                        <th>Время</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @isset($comments)
                                    @foreach ($comments as $comment)
                                        <tr>
                                            <td>{{$comment["role"]}}</td>
                                            <td>{{$comment["comment"]}}</td>
                                            <td>{{$comment["created_at"]}}</td>
                                        </tr>
                                    @endforeach
                                @endisset
                                </tbody>
                            </table>
                        </div>

                        <div id="revisionReasonTab" class="tabcontent">
                            @isset($application->revision_reason)
                                <div class="panel panel-default">
                                    <div class="panel-body" id="items">
                                        <ul class="list-group">
                                            <p>{{$application->revision_reason}}</p>
                                        </ul>
                                    </div>
                                </div>
                            @endisset
                        </div>

                        <div id="rejectReasonTab" class="tabcontent">
                            @isset($application->reject_reason)
                                <div class="panel panel-default">
                                    <div class="panel-body" id="items">
                                        <ul class="list-group">
                                            <p>{{$application->reject_reason}}</p>
                                        </ul>
                                    </div>
                                </div>
                            @endisset
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
                                            <input type="hidden" id="processId" name="process_id" value = {{$process->id}}>
                                            <input type="hidden" id="applicationId" name="application_id" value = {{$application->id}}>
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
                                            <input type="hidden" id="applicationId" name="application_id" value = {{$application->id}}>
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
                                                        <option value="{{$role}}">{{$role}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <input type="hidden" id="processId" name="process_id" value = {{$process->id}}>
                                            <input type="hidden" id="applicationId" name="application_id" value = {{$application->id}}>
                                            <button class="btn btn-info" data-dismiss="modal" id="revisionButton">Отправить</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="sendToSubRouteId" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title  text-center">Форма отправки в другую организацию</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="form-group row">
                                                <label for="subOrgComments" class="col-md-4 col-form-label text-md-right">{{ __("Введите комментарий (не обязательно)") }}</label>
                                                <div class="col-md-6">
                                                    <input type="text" id="subOrgComments" class="form-control" name="sendToAnotherOrganization" autofocus>
                                                </div>
                                            </div>
                                            <input type="hidden" id="processId" name="process_id" value = {{$process->id}}>
                                            <input type="hidden" id="applicationId" name="application_id" value = {{$application->id}}>
                                            <button class="btn btn-info" data-dismiss="modal" id="sendToSubOrgButton">Отправить</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="items">
                            @if($canApprove)
                                    @isset($templateFields)
                                        <h4 class="card-title text-center" style="margin-top:50px;">Поля Шаблона</h4>
                                        <form id = "templateFieldsId" method="POST">
                                            @foreach($templateFields as $item)
                                                <div class="form-group row">
                                                    <label for="{{$item->name}}" class="col-md-4 col-form-label text-md-right">{{ __($item->label_name) }}</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control"  name="{{$item->name}}" required autocomplete="{{$item->name}}" autofocus>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </form>
                                    @endisset
                                @if($toCitizen)
                                    <form action="{{ route('applications.toCitizen', ['application_id' => $application->id]) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="process_id" value = {{$process->id}}>
                                        <div style="text-align: center">
                                            <button class="btn btn-danger" style="margin-bottom: 30px;" type="submit">Отправить заявителю</button>
                                        </div>
                                    </form>
                                @elseif($backToMainOrg)
                                    <form action="{{ route('applications.backToMainOrg', ['application_id' => $application->id]) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="process_id" value = {{$process->id}}>
                                        <button class="btn btn-warning" style="margin-bottom: 70px;" type="submit">Отправить обратно в организацию</button>
                                    </form>
                                @else
                                    @if(isset($sendToSubRoute["name"]))
                                        <form action="{{ route('applications.sendToSubRoute', ['application_id' => $application->id]) }}" method="post">
                                            @csrf
                                            <input type="hidden" name="process_id" value = {{$process->id}}>
                                            <button class="btn btn-warning" type="button" data-toggle="modal" data-target="#sendToSubRouteId">Отправить в {{$sendToSubRoute["name"]}}</button>
                                        </form>
                                    @endif
                                    <div style="text-align:center; margin-top: 100px; margin-bottom:70px;">
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">Мотивированный отказ</button>
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal2">Отправить на доработку</button>
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal3">Согласовать</button>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>  
                </div>      
            </div>
        </div>
    </div>
    <div class="my-2 text-center">
        <a href="{{ route('applications.index', ['process' => $process]) }}" class="btn btn-info btn-lg my-5">Назад</a>
    </div>
    
{{csrf_field()}}

<style>
    .tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
    }

    /* Style the buttons that are used to open the tab content */
    .tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
    background-color: #ddd;
    }

    /* Create an active/current tablink class */
    .tab button.active {
    background-color: #ccc;
    }

    /* Style the tab content */
    .tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
    }
</style>
<script
    src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"></script>
<script>

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
            var processId = $('#processId').val();
            var applicationId = $('#applicationId').val();
            console.log(rejectReason, processId, applicationId)
            $.post('/applications/reject', {'rejectReason':rejectReason,'processId':processId,'applicationId':applicationId, '_token':$('input[name=_token]').val()}, function(data){

                $('#items').load(location.href + ' #items');
            });
        });
        $('#revisionButton').click(function(event) {
            let revisionReason = $('#revisionReason').val();
            var roleToRevise = $( "#roleToRevise option:selected" ).text();
            var processId = $('#processId').val();
            var applicationId = $('#applicationId').val();
            $.post('/applications/revision', {'revisionReason':revisionReason,'processId':processId,'applicationId':applicationId,'roleToRevise':roleToRevise, '_token':$('input[name=_token]').val()}, function(data){
                $('#items').load(location.href + ' #items');
            });
        });
        $('#commentButton').click(function(event) {
            var comments = $('#comments').val();
            var inputs = $('#templateFieldsId :input');
            var values = {};
            inputs.each(function() {
                values[this.name] = $(this).val();
            });
            var processId = $('#processId').val();
            var applicationId = $('#applicationId').val();
            $.post('/applications/approve', {'comments':comments,'fieldValues':values,'process_id':processId,'applicationId':applicationId, '_token':$('input[name=_token]').val()}, function(data){
                $('#items').load(location.href + ' #items');
            });
        });
        $('#sendToSubOrgButton').click(function(event) {
            var comments = $('#subOrgComments').val();
            var inputs = $('#templateFieldsId :input');
            var values = {};
            inputs.each(function() {
                values[this.name] = $(this).val();
            });
            var processId = $('#processId').val();
            var applicationId = $('#applicationId').val();
            console.log(comments, processId, applicationId)
            $.post('/applications/sendToSubRoute', {'comments':comments,'fieldValues':values,'processId':processId,'applicationId':applicationId, '_token':$('input[name=_token]').val()}, function(data){

                $('#items').load(location.href + ' #items');
            });
        });

    });
</script>

</body>
</html>
