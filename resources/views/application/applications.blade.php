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
                              <th style="width:43%;">НАЗВАНИЕ ГОС УСЛУГИ</th>
                              <th style="width:10%;" class="text-center">ПОДАНА</th>
                              <th style="width:10%;" class="text-center">СРОК</th>
                              <th style="width:10%;text-align:center;">ПЕРЕЙТИ</th>
                          </tr>
                      </thead>
                      <tbody>
                      @if(empty($apps))
                        <tr><td colspan="5" style="text-align: center;">Упссс тут пусто...</td></tr>
                      @else
                        @foreach($apps as $app)
                            <tr><?php
                              $date=date_create($app->created_at);
                              $date2=date_create($app->deadline_date);
                              if($date->diff($date2)->days == 0) {$opac = 0;}
                              else {$opac = 1 - $date2->diff(date_create(date("Y-m-d")))->days / $date->diff($date2)->days;}
                              $deadline_color = '#1abf29';
                              if($opac > 0.4 && $opac < 0.7){
                                $deadline_color = '#ff6';
                              }
                              if($opac > 0.7){
                                $deadline_color = '#f33';
                              }
                            ?>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$app->sur_name ?? '' }} {{$app->first_name ?? '' }} {{$app->middle_name ?? '' }}</td>
                                <td>{{$app->process_name ?? ''}}</td>
                                <td class="text-center"><?php
                                  echo date_format($date,"d/m/Y");
                                  echo "<br/>";
                                  echo date_format($date,"H:i:s");?>
                                </td>
                                <td class="text-center" style="background: <?php echo $deadline_color;?>">
                                  <?php
                                  echo date_format($date2,"d/m/Y");
                                  echo "<br/>";
                                  echo date_format($date2,"H:i:s");?>
                                </td>
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
