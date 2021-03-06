@extends('layouts.app')

@section('title')
    Услуги
@endsection
<style type="text/css">
  .table td{
    font-size: 16px!important;
  }
</style>
@section('content')
    <div class="main-panel">
      <div class="content">
        <div class="container-fluid">
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col-md-2">
                  @if (Auth::user()->role->name === 'Заявитель')
                    <a href="{{ url('docs/create', ['process' => $process]) }}" class="btn btn-primary" style="margin-bottom: 10px">Создать Заявку</a>
                    <form action="{{ url('docs/search')}}" method="POST" style="margin-bottom: 10px">
                        @csrf
                        <input type="hidden" name="processId" value="{{$process->id}}">
                        <button class="btn btn-primary" type="submit">Обновить</button>
                    </form>
                  @endif
                </div>
                <div class="col-md-8">
                  <h4 class="page-title text-center">
                    {{strtoupper($process->name)}}
                  </h4>
                </div>
              </div>
              @if(session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
              @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                      <thead>
                          <tr>
                              <th style="width:7%;">№</th>
                              <th style="width:20%;">ИМЯ ЗАЯВИТЕЛЯ</th>
                              <th style="width:60%;">СТАТУС ЗАЯВКИ</th>
                              <th style="width:13%;">ДЕЙСТВИЯ</th>
                          </tr>
                      </thead>
                      <tbody>
                      @foreach($arrayApps as $app)
                          <tr>
                              <td>{{$loop->iteration}}</td>
                              <td>{{$app->user_name ?? '' }}</td>
                              <td>{{$app->last_status ?? ''}}</td>
                              <td>
                                <button class="rounded-circle bg-white" onclick="window.location='{{url('docs/view', ['process_id' => $process["id"] , 'application_id' => $app->id])}}'">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                    </svg>
                                </button>
                              </td>
                          </tr>
                      @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
@endsection