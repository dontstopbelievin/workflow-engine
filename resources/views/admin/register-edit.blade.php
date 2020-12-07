@extends('layouts.master')

@section('title')
    Изменение данных пользователя
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
						<h4 class="page-title">Изменение данных пользователя</h4>
						<div class="card">
              <form action="{{ route('user-role.update', ['user' => $user]) }}" method="POST">
                {{ csrf_field( )}}
                {{ method_field('PUT') }}
  							<div class="card-body">
  								<div class="form-group">
  									<label for="lotNumber">Имя пользователя</label>
                    <input type="text" name="username" value="{{ $user->name}}" class="form-control">
  								</div>
  								<div class="form-group">
  									<label for="lotNumber">Присвоить роль</label>
                    <select name="role_id" class="form-control" data-dropup-auto="false">
                        @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </select>
  								</div>
  							</div>
  							<div class="card-action">
                  <button type="submit" class="btn btn-success">Обновить</button>
                  <a href="{{ route('user-role.register') }}" class="btn btn-danger">Отмена</a>
  							</div>
              </form>
						</div>
					</div>
				</div>
			</div>

@endsection
