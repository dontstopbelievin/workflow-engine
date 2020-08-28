

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
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Просмотр заявки</h4>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
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

                    </div>
                </div>
                @isset($records)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Ход Согласования</h3>
                        </div>
                        <div class="panel-body" id="items">
                            <ul class="list-group">
                                @foreach($records as $record)
                                    <li class="list-group-item ourItem">{{$record->name}} | {{$record->updated_at}}
                                    </li>

                                @endforeach
                            </ul>
                        </div>
                    </div>

                @endisset
                @if($canApprove)
                    @if($toCitizen)
                        <form action="{{ route('applications.toCitizen', ['application_id' => $application->id]) }}" method="post">
                            @csrf
                            <input type="hidden" name="process_id" value = {{$process->id}}>
                            <button class="btn btn-basic" type="submit">Отправить заявителю</button>
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

                        <form action="{{ route('applications.approve', ['application_id' => $application->id]) }}" method="post">
                            @csrf
                            <input type="hidden" name="process_id" value = {{$process->id}}>
                            <button class="btn btn-basic" type="submit">Отправить на согласование</button>
                        </form>
                    @endif
                    @endif
            </div>
        </div>
    </div>
</div>

{{csrf_field()}}

</body>
</html>
