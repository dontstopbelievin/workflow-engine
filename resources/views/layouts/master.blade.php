<!--

=========================================================
* Now UI Dashboard - v1.5.0
=========================================================

* Product Page: https://www.creative-tim.com/product/now-ui-dashboard
* Copyright 2019 Creative Tim (http://www.creative-tim.com)

* Designed by www.invisionapp.com Coded by www.creative-tim.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

-->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta charset="utf-8">
  <title>Изменение данных пользователя</title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
  <link rel="stylesheet" href="../assets/css/ready.css">
  <link rel="stylesheet" href="../assets/css/demo.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="../assets/js/core/jquery.3.2.1.min.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
  <div class="wrapper">
    <div class="main-header">
      <div class="logo-header">
        <a href="{{ route('applications.service') }}" class="logo">
          Электронные услуги
        </a>
        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <button class="topbar-toggler more"><i class="la la-ellipsis-v"></i></button>
      </div>

      <nav class="navbar navbar-header navbar-expand-lg">
        <div class="container-fluid">

          <a href="/policy" class="navbar-left navbar-form nav-search mr-md-3">
                Правила информационной безопасности
          </a>
          <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
            <!-- Authentication Links -->
            @guest
            <li class="nav-item dropdown">
              <a href="{{ route('login') }}">Авторизация</a>
            </li>

            @else
            <li class="nav-item dropdown">
              <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false" data-toggle="dropdown" aria-haspopup="true">
                <span>{{ Auth::user()->name }}</span>
              </a>
              <ul class="dropdown-menu dropdown-user">
                <li> <a class="dropdown-item" href="{{ route('user.personalArea') }}">Мои данные</a> </li>
                <li> <a class="dropdown-item" href="{{ route('user.edit', ['user' => Auth::user()]) }}">Редактировать данные</a> </li>
                <li> <a class="dropdown-item" href="/password/reset">Cменить пароль</a> </li>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-power-off"></i>
                    {{ __('Выйти') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
              </ul>
                <!-- /.dropdown-user -->
            </li>
              @endguest
          </ul>
        </div>
      </nav>
    </div>
    <div class="sidebar">
      <div class="scrollbar-inner sidebar-wrapper">
          <ul class="nav">
            @if( request()->segment(1) == 'auction' )
                <li class="nav-item active">
            @else
                <li class="nav-item">
            @endif
                  <a href="{{ route('auction.index') }}">
                      <i class="la la-table"></i>
                      <p>Аукцион</p>
                  </a>
              </li>
                  <li class="nav-item">
                      <a href="{{ route('egknservice.index') }}">
                          <i class="la la-table"></i>
                          <p>Поступившие заявки</p>
                      </a>
                  </li>
              @if( request()->segment(1) == 'process' ||  request()->segment(1) == 'processes' ||  request()->segment(1) == 'processes-edit' || request()->segment(1) == 'template-field-create'  )
                  <li class="nav-item active">
              @else
                  <li class="nav-item">
              @endif
                  <a href="{{ route('processes.index') }}">
                      <i class="la la-keyboard-o"></i>
                      <p>Процессы</p>
                      <span class="badge badge-count">{{ $processesCount }}</span>
                  </a>
              </li>
              @if( request()->segment(1) == 'roles' || request()->segment(1) == 'role-edit' )
                  <li class="nav-item active">
              @else
                  <li class="nav-item">
              @endif
                  <a href="{{ route('role.index') }}">
                      <i class="la la-th"></i>
                      <p>Роли</p>
                      <span class="badge badge-count">{{ $rolesCount }}</span>
                  </a>
              </li>
              @if( request()->segment(1) == 'cities'  )
                  <li class="nav-item active">
              @else
                  <li class="nav-item">
              @endif
                  <a href="{{ route('city.index') }}">
                      <i class="la la-bell"></i>
                      <p>Организации</p>
                      <span class="badge badge-count">{{ $cityManagementCount }}</span>
                  </a>
              </li>
              @if( request()->segment(1) == 'role-register' || request()->segment(1) == 'user-edit'  )
                  <li class="nav-item active">
              @else
                  <li class="nav-item">
              @endif
                  <a href="{{ route('user-role.register') }}">
                      <i class="la la-font"></i>
                      <p>Пользователи</p>
                      <span class="badge badge-count">{{ $usersCount }}</span>
                  </a>
              </li>
              @if( request()->segment(1) == 'dictionary')
                  <li class="nav-item active">
              @else
                  <li class="nav-item">
              @endif
                  <a href="{{ route('dictionary') }}">
                      <i class="la la-fonticons"></i>
                      <p>Справочник</p>
                      <span class="badge badge-count">{{ $dictionariesCount }}</span>
                  </a>
              </li>
              @if( request()->segment(1) == 'logs' )
                  <li class="nav-item active">
              @else
                  <li class="nav-item">
              @endif
                  <a href="{{ route('logs') }}">
                      <i class="la la-fonticons"></i>
                      <p>Логи сервиса</p>
                  </a>
              </li>
              @if( request()->segment(1) == 'services' || request()->segment(1) == 'index' || request()->segment(1) == 'applications-create')
                  <li class="nav-item active">
              @else
                  <li class="nav-item">
              @endif
                  <a href="{{ route('applications.service') }}">
                      <i class="la la-dashboard"></i>
                      <p>Все услуги</p>
                  </a>
              </li>
          </ul>
      </div>
    </div>
        @yield('content')
      </div>
  </div>
  @yield('scripts')
  <script src="../assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <!-- <script src="../assets/js/core/bootstrap.min.js"></script> -->
  <script src="../assets/js/plugin/chartist/chartist.min.js"></script>
  <script src="../assets/js/plugin/chartist/plugin/chartist-plugin-tooltip.min.js"></script>
  <script src="../assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
  <script src="../assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>
  <script src="../assets/js/plugin/jquery-mapael/jquery.mapael.min.js"></script>
  <script src="../assets/js/plugin/jquery-mapael/maps/world_countries.min.js"></script>
  <script src="../assets/js/plugin/chart-circle/circles.min.js"></script>
  <script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
  <script src="../assets/demo/demo.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
</body>

</html>
