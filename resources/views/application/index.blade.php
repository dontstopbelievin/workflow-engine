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
                <a href="{{ route('applications.create', ['process' => $process]) }}" class="btn btn-info">Создать Заявку</a><br><br>
            @endif
  					<div class="card">
  						<!-- <div class="card-header">
  			        <div class="card-title">Table</div>
  			      </div> -->
  						<div class="card-body">
  							<table class="table table-hover">
  								<thead>
  									<tr>
                      <th>№</th>
                      <th>Имя заявителя</th>
                      <th>Статус заявки</th>
                      <th>Действия</th>
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
                                <td class="text-left align-middle border">{{$app["status"] ?? ''}}</td>
                            @endif
                                <td class="text-center align-middle border">
                                <button class="btn btn-simple-primary px-0 py-0" style=" background-color: transparent;font-size:30px;" onclick="window.location='{{route('applications.view', ['process_id' => $process["id"] , 'application_id' => $app["id"]])}}'">
                                  <i class="la la-arrow-circle-o-right"></i>
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
