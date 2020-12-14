@extends('layouts.master')

@section('title')
   Изменение Роли
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
                            <a href="{{ route('user.personalArea') }}">
                                <span class="link-collapse">Личный Кабинет</span>
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
      <li class="nav-item active">
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
			<h4 class="page-title">Изменение Роли {{$role->name}}</h4>
			<div class="card">
        <form action="{{ route('role.update', ['role' => $role]) }}" method="POST">
            {{ csrf_field( )}}
            {{ method_field('PUT') }}
            <div class="card-body">
    					<div class="form-group">
                <label>Наиманование роли</label>
                <input type="text" name="name" value="{{ $role->name}}" class="form-control">
    					</div>
    					<div class="form-group">
                <select name="city_management_id" class="form-control">
                    @isset($role->cityManagement->id)
                        <option value="{{$role->cityManagement->id}}" selected>{{$role->cityManagement->name}}</option>
                    @endisset
                    @foreach($cityManagements as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
    					</div>
    				</div>
    				<div class="card-action">
              <button type="submit" class="btn btn-success">Обновить</button>
              <a href="{{ route('role.index') }}" class="btn btn-danger">Отмена</a>
    				</div>
        </form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
@endsection
