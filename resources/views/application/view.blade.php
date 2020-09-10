

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
                    <h4 class="card-title text-center" style="margin-bottom: 20px; margin-top: 20px;">Просмотр заявки</h4>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
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
                    </ul>
                    @isset($templateTableFields)
                        @foreach($templateTableFields as $key=>$value)
                            <div class="form-group row">
                                <label for="{{$value}}" class="col-md-4 col-form-label text-md-right">{{$key}}</label>
                                <div class="col-md-6">
                                    <p>{{$value}}</p>
                                </div>
                            </div>
                            @endforeach
                        @endisset

                    <hr>
                    <div style="margin-top:50px;">
                        <table class="table" name="accepted_table">
                            <h4 class="text-center">Комментарии</h4>
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
                            </tablе>
                            <table class="table" name="reject_table">
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
                    <hr>

                @isset($application->revision_reason)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Причина возврата на доработку</h3>
                        </div>
                        <div class="panel-body" id="items">
                            <ul class="list-group">
                                <p>{{$application->revision_reason}}</p>
                            </ul>
                        </div>
                    </div>

                @endisset
                @isset($application->reject_reason)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">Причина отказа</h3>
                            </div>
                            <div class="panel-body" id="items">
                                <ul class="list-group">
                                    <p>{{$application->reject_reason}}</p>
                                </ul>
                            </div>
                        </div>
                @endisset

                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title text-center">Форма Мотивированного отказа</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    {{--<input type="text" id="rejectReason" name="reject_reason" placeholder="Введите причину отказа">--}}
                                    <div class="form-group row">
                                        <label for="reject_reason" class="col-md-4 col-form-label text-md-right">{{ __("Введите причину отказа") }}</label>
                                        <div class="col-md-6">
                                            <input type="text" id="rejectReason" class="form-control" name="reject_reason"  autocomplete="reject_reason" autofocus>
                                        </div>
                                    </div>
                                    <input type="hidden" id="processId" name="process_id" value = {{$process->id}}>
                                    <input type="hidden" id="applicationId" name="application_id" value = {{$application->id}}>
                                    <button class="btn btn-info" style="float:center" id="rejectButton">Отправить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModal3" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title  text-center">Добавление комментариев</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    {{--<input type="text" id="comments" name="comments" placeholder="Введите комментарии">--}}
                                    <div class="form-group row">
                                        <label for="comments" class="col-md-4 col-form-label text-md-right">{{ __("Введите комментарии") }}</label>
                                        <div class="col-md-6">
                                            <input type="text" id="comments" class="form-control" name="comments"  autocomplete="comments" autofocus>
                                        </div>
                                    </div>
                                    <input type="hidden" id="processId" name="process_id" value = {{$process->id}}>
                                    <input type="hidden" id="applicationId" name="application_id" value = {{$application->id}}>
                                    <button class="btn btn-info" id="commentButton">Отправить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModal2" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title  text-center">Форма отправки на доработку</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    {{--<input type="text" id="revisionReason" name="revision_reason" placeholder="Введите причину отправки на доработку">--}}
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
                                    <button class="btn btn-info" id="revisionButton">Отправить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                            <button class="btn btn-basic" type="submit">Отправить обратно в организацию</button>
                        </form>
                    @else
                        @if(isset($sendToSubRoute["name"]))
                            <form action="{{ route('applications.sendToSubRoute', ['application_id' => $application->id]) }}" method="post">
                                @csrf
                                <input type="hidden" name="process_id" value = {{$process->id}}>
                                <button class="btn btn-basic" type="submit">Отправить в {{$sendToSubRoute["name"]}}</button>
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

        $('#rejectButton').click(function(event) {
            var rejectReason = $('#rejectReason').val();
            var processId = $('#processId').val();
            var applicationId = $('#applicationId').val();
            console.log(rejectReason, processId, applicationId)
            $.post('/applications/reject', {'rejectReason':rejectReason,'processId':processId,'applicationId':applicationId, '_token':$('input[name=_token]').val()}, function(data){
                var modal =  $('#myModal');
                // console.log(data);
                modal.style.display = 'none';
                $('#items').load(location.href + ' #items');
            });
        });
        $('#revisionButton').click(function(event) {
            var revisionReason = $('#revisionReason').val();
            var roleToRevise = $( "#roleToRevise option:selected" ).text();
            var processId = $('#processId').val();
            var applicationId = $('#applicationId').val();
            console.log(rejectReason, processId, applicationId)
            $.post('/applications/revision', {'revisionReason':revisionReason,'processId':processId,'applicationId':applicationId,'roleToRevise':roleToRevise, '_token':$('input[name=_token]').val()}, function(data){
                var modal =  $('#myModal2');
                // console.log(data);
                modal.style.display = 'none';
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
            // console.log(values);
            var processId = $('#processId').val();
            var applicationId = $('#applicationId').val();
            console.log(comments, processId, applicationId)
            $.post('/applications/approve', {'comments':comments,'fieldValues':values,'process_id':processId,'applicationId':applicationId, '_token':$('input[name=_token]').val()}, function(data){
                var modal =  $('#myModal3');
                modal.style.display = 'none';
                $('#items').load(location.href + ' #items');
            });
        });

    });
</script>

</body>
</html>
