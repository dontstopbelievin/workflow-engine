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
                            <li class="list-group-item">Наименование заявителя: {{$application->name ?? ''}}</li>
                            <li class="list-group-item">Фамилия заявителя: {{$application->surname ?? ''}}</li>
                            <li class="list-group-item">Электронный адрес заявителя: {{$application->email ?? ''}}</li>
                            <li class="list-group-item">Адрес: {{$application->adress ?? ''}}</li>
                        </ul>

                    </div>
                </div>
                @if($canApprove)
                    @if($toCitizen)
                    <form action="{{ route('applications.tocitizen', ['application' => $application]) }}" method="post">
                        @csrf
                        <input type="hidden" name="process_id" value = {{$application->id}}>
                        <button class="btn btn-basic" type="submit">Отправить заявителю</button>
                    </form>
                    @else 
                    <form action="{{ route('applications.approve', ['application' => $application]) }}" method="post">
                        @csrf
                        <input type="hidden" name="process_id" value = {{$application->id}}>
                        <button class="btn btn-basic" type="submit">Отправить на согласование</button>
                    </form>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection

                                