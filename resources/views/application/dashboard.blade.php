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
					<h4 class="page-title">Все услуги</h4>
          @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
          @endif
					<div class="card">
						<!-- <div class="card-header">
			        <div class="card-title">Table</div>
			      </div> -->
						<div class="card-body">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>#</th>
										<th>НАИМЕНОВАНИЕ УСЛУГИ</th>
										<th>ДЕЙСТВИЯ</th>
									</tr>
								</thead>
								<tbody>
                  @foreach($processes as $process)
                    <tr class="p-3 mb-5 rounded">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$process->name}}</td>
                        @if($process->name == 'Выдача выписки об учетной записи договора о долевом участии в жилищном строительства')
                          <td class="text-center align-middle border">
                              <button class="btn btn-simple-primary px-0 py-0" style=" background-color: transparent;font-size:30px;" onclick="window.location='http://qazreestr.kz:8180/rddu/private/cabinet.jsp'">
                                  <i class="la la-arrow-circle-o-right"></i>
                              </button>
                          </td>
                        @else
                          <td class="text-center align-middle border">
                              <button class="btn btn-simple-primary px-0 py-0" style=" background-color: transparent;font-size:30px;" onclick="window.location='{{route('applications.index', ['process' => $process])}}'">
                                  <i class="la la-arrow-circle-o-right"></i>
                              </button>
                          </td>
                        @endif
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
