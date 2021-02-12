@extends('layouts.app')

@section('title')
    Создание процесса
@endsection

@section('content')
<div class="main-panel">
  <div class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h4 class="page-title text-center">Логи сервиса</h4>
          @if (session('status'))
              <div class="alert alert-success" role="alert">
                  {{ session('status') }}
              </div>
          @endif
        </div>
        <div class="card-body">
          <div class="">
              @for($i = sizeof($logsArr)-1; $i >= 0; $i-- )
                <p>{{sizeof($logsArr) - $i }}. {{$logsArr[$i]}}</p>
              @endfor
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection