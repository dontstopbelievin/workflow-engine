@extends('layouts.app')

@section('title')
    Входящие
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
            <div class="card-body">
                @if (session('status'))
                  <div class="alert alert-success" role="alert">
                      {{ session('status') }}
                  </div>
                @endif
                <div class="table-responsive">
                    <table class="table">
                      <thead>
                          <tr>
                              <th style="width:7%;">№</th>
                              <th style="width:20%;">ИМЯ ЗАЯВИТЕЛЯ</th>
                              <th style="width:50%;">ГОСУДАРСТВЕННАЯ УСЛУГА</th>
                              <th style="width:13%;">ДАТА</th>
                              <th style="width:10%;text-align:center;">ПЕРЕЙТИ</th>
                          </tr>
                      </thead>
                      <tbody>
                      @if(empty($apps))
                        <tr><td colspan="5" style="text-align: center;">Упссс тут пусто...</td></tr>
                      @else
                        @foreach($apps as $app)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$app->sur_name ?? '' }} {{$app->first_name ?? '' }} {{$app->middle_name ?? '' }}</td>
                                <td>{{$app->process_name ?? ''}}</td>
                                <td>{{$app->updated_at ?? ''}}</td>
                                <td style="text-align:center;">
                                  <a href="{{url('docs/services/'.request()->segment(3).'/view', ['process_id' => $app->process_id, 'application_id' => $app->application_id])}}">
                                    <i class="fa fa-eye fa-2x" aria-hidden="true"></i>
                                  </a>
                                </td>
                            </tr>
                        @endforeach
                      @endif
                      </tbody>
                    </table>
                  </div>
                  @include('layouts.user_policies')
                </div>
              </div>
            </div>
          </div>
        </div>
@endsection
