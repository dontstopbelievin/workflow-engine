@extends('layouts.app')

@section('title')
    Входящие
@endsection

@section('content')
    <div class="main-panel">
      <div class="content">
        <div class="container-fluid">
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col-md-3">
                </div>
                <div class="col-md-6">
                  <h4 class="page-title text-center">
                    Заявки по услугам
                  </h4>
                </div>
              </div>
              @if (session('status'))
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
                              <th style="width:20%;">Имя заявителя</th>
                              <th style="width:50%;">Процесс</th>
                              <th style="width:13%;">Дата</th>
                              <th style="width:10%;">Действия</th>
                          </tr>
                      </thead>
                      <tbody>
                      @foreach($apps as $app)
                          <tr>
                              <td>{{$loop->iteration}}</td>
                              <td>{{$app->user_name ?? '' }}</td>
                              <td>{{$app->process_name ?? ''}}</td>
                              <td>{{$app->updated_at ?? ''}}</td>
                              <td>
                                <button class="rounded-circle bg-white" onclick="window.location='{{url('docs/services/'.request()->segment(3).'/view', ['process_id' => $app->process_id, 'application_id' => $app->application_id])}}'">
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
