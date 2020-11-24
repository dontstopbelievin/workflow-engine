@extends('layouts.master')

@section('title')
    Услуги
@endsection

@section('content')
      <div class="sidebar">
        <div class="scrollbar-inner sidebar-wrapper">
          <ul class="nav">
            <li class="nav-item">
              <a class="" role="button" data-toggle="collapse" href="#settings" aria-expanded="false">
                <i class="la la-navicon"></i>
                <p>Настройки</p>
              </a>
            </li>
            <div class="collapse" id="settings">
              <ul class="nav">
                <li class="nav-item">
                  <a href="#">
                    <span class="link-collapse">My Profile</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#">
                    <span class="link-collapse">Edit Profile</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#">
                    <span class="link-collapse">Settings</span>
                  </a>
                </li>
              </ul>
            </div>
            <li class="nav-item">
              <a href="{{ route('auction.index') }}">
                <i class="la la-table"></i>
                <p>Аукцион</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('processes.index') }}">
                <i class="la la-keyboard-o"></i>
                <p>Процессы</p>
                <span class="badge badge-count">{{ $processesCount }}</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('role.index') }}">
                <i class="la la-th"></i>
                <p>Роли</p>
                <span class="badge badge-count">{{ $rolesCount }}</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('city.index') }}">
                <i class="la la-bell"></i>
                <p>Организации</p>
                <span class="badge badge-count">{{ $cityManagementCount }}</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('user-role.register') }}">
                <i class="la la-font"></i>
                <p>Пользователи</p>
                <span class="badge badge-count">{{ $usersCount }}</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('dictionary') }}">
                <i class="la la-fonticons"></i>
                <p>Справочник</p>
                <span class="badge badge-count">{{ $dictionariesCount }}</span>
              </a>
            </li>
            <li class="nav-item active">
              <a href="{{ route('applications.service') }}">
                <i class="la la-dashboard"></i>
                <p>Все услуги</p>
              </a>
            </li>
          </ul>
        </div>
      </div>

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
