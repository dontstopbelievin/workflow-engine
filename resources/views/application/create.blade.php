@extends('layouts.master')

@section('title')
    Создание Заявки
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
            <h4 class="page-title">Создание заявки "{{$process->name}}"</h4>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="card">
              <form action="{{ route('applications.store') }}" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                  @csrf
                  @foreach($arrayToFront as $item)
                      <label>{{$item["labelName"]}}</label>
                      @if($item["inputName"] === 'file')
                        <div class="form-group">
                          <input type="file" name={{$item["name"]}} multiple><br><br>
                        </div>
                      @elseif($item["inputName"] === 'text')
                        <div class="form-group">
                          <input type="text" name={{$item["name"]}} id={{$item["name"]}} class="form-control">
                        </div>
                      @elseif($item["inputName"] === 'url')
                      <div class="form-group">
                        <input type="text" name={{$item["name"]}} id={{$item["name"]}} class="form-control" >
                      </div>
                      @elseif($item["inputName"] === 'image')
                      <div class="">
                        <input type="file" name={{$item["name"]}} id={{$item["name"]}} class="form-control">
                      </div>
                      @else
                      <div class="form-group">
                        <select name="{{$item["name"]}}" id="{{$item["name"]}}" class="form-control" data-dropup-auto="false">
                            <option selected disabled>Выберите Ниже</option>
                            @foreach($item["inputName"] as $key=>$val)
                                <option>{{$val}}</option>
                            @endforeach
                        </select>
                      </div>
                      @endif
                  @endforeach
                </div>
                <div class="card-action">
                  <input type="hidden" name="process_id" value = {{$process->id}}>
                  <button type="submit" class="btn btn-primary">Создать</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
@endsection

@section('scripts')
@endsection
