@extends('layouts.master')

@section('title')
    Услуги
@endsection

@section('content')
    

    <div class="main-panel">
  		<div class="content">
  			<div class="container-fluid">
  				<h4 class="page-title">Все заявки по услуге "{{$process->name}}" </h4>
          @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
          @endif
          @if (Auth::user()->role->name === 'Заявитель')
            <a href="{{ route('applications.create', ['process' => $process]) }}" class="btn btn-info mb-3">Создать Заявку</a>
            <form action="{{ route('applications.search')}}" method="POST">
                @csrf
                <input type="hidden" name="processId" value="{{$process->id}}">
                <button type="submit">Обновить</button>
            </form>
          @endif
          <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                      <thead>
                          <tr>
                              <th style="width:7%;">№</th>
                              <th style="width:20%;">Имя заявителя</th>
                              <th style="width:60%;">Статус заявки</th>
                              <th style="width:13%;">Действия</th>
                          </tr>
                      </thead>
                      <tbody>
                      @foreach($arrayApps as $app)
                          <tr>
                              <td>{{$loop->iteration}}</td>
                              <td>{{$app["name"] ?? '' }}</td>
                              @if($app["status"] === 'Отправлено заявителю на согласование')
                                  <td>Отправлено заявителю</td>
                              @else
                                  <td>{{$app["status"] ?? ''}}</td>
                              @endif
                                  <td>
                                  <button class="rounded-circle bg-white" onclick="window.location='{{route('applications.view', ['process_id' => $process["id"] , 'application_id' => $app["id"]])}}'">
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

<!-- @section('scripts')
<script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <script src="../assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script>
  <script src="../assets/demo/demo.js"></script>
@endsection -->
