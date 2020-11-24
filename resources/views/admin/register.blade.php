  @extends('layouts.master')

@section('title')
    Зарегистрированные пользователи
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
            <li class="nav-item ">
              <a href="{{ route('auction.index') }}">
                <i class="la la-table"></i>
                <p>Аукцион</p>
              </a>
            </li>
            <li class="nav-item ">
              <a href="{{ route('processes.index') }}">
                <i class="la la-keyboard-o"></i>
                <p>Процессы</p>
                <span class="badge badge-count">{{ $processesCount }}</span>
              </a>
            </li>
            <li class="nav-item ">
              <a href="{{ route('role.index') }}">
                <i class="la la-th"></i>
                <p>Роли</p>
                <span class="badge badge-count">{{ $rolesCount }}</span>
              </a>
            </li>
            <li class="nav-item ">
              <a href="{{ route('city.index') }}">
                <i class="la la-bell"></i>
                <p>Организации</p>
                <span class="badge badge-count">{{ $cityManagementCount }}</span>
              </a>
            </li>
            <li class="nav-item active">
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
            <li class="nav-item ">
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
						<h4 class="page-title">Зарегистрированные пользователи</h4>
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
                      <th style="width: 7%">№</th>
                      <th style="width: 20%">ИМЯ</th>
                      <th style="width: 15%">ТЕЛЕФОН</th>
                      <th style="width: 15%">ПОЧТА</th>
                      <th style="width: 30%">РОЛЬ</th>
                      <th style="width: 12%">ДЕЙСТВИЯ</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->phone}}</td>
                            <td>{{$user->email}}</td>
                            @if ($user->role)
                            <td>{{$user->role->name}}</td>
                            @else
                            <td>-</td>
                            @endif
                            <td>
                              <div class="row">
                                <button class="btn btn-link btn-simple-primary" data-original-title="Изменить" onclick="window.location='{{route('user-role.edit', ['user' => $user])}}'">
                                  <i class="la la-edit"></i>
                                </button>
                                <form action="{{ route('user-role.delete', ['user' => $user]) }}" method="post">
                                    {{csrf_field()}}
                                    {{method_field('DELETE')}}
                                    <button type="submit" class="btn btn-link btn-danger" data-original-title="Удалить">
                                      <i class="la la-times"></i>
                                    </button>
                                </form>
                              </div>
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
