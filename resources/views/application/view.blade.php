@extends('layouts.master')

@section('title')
   Роли
@endsection

@section('content')
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
                    <form action="{{ route('applications.toCitizen', ['application' => $application]) }}" method="post">
                        @csrf
                        <input type="hidden" name="process_id" value = {{$application->id}}>
                        <button class="btn btn-basic" type="submit">Отправить заявителю</button>
                    </form>
                    @elseif($backToMainOrg)
                    <form action="{{ route('applications.backToMainOrg', ['application' => $application]) }}" method="post">
                        @csrf
                        <input type="hidden" name="process_id" value = {{$application->id}}>
                        <button class="btn btn-basic" type="submit">Отправить обратно в организацию</button>
                    </form>
                    @else 
                        @if(isset($sendToSubRoute["name"]))
                        <form action="{{ route('applications.sendToSubRoute', ['application' => $application]) }}" method="post">
                        @csrf
                        <input type="hidden" name="process_id" value = {{$application->id}}>
                        <button class="btn btn-basic" type="submit">Отправить в {{$sendToSubRoute["name"]}}</button>
                        </form>
                        @endif
                        <form action="{{ route('applications.approve', ['application' => $application]) }}" method="post">
                        @csrf
                        <input type="hidden" name="process_id" value = {{$application->id}}>
                        <button class="btn btn-basic" type="submit">Отправить на согласование</button>
                        </form>
                    </form>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection

