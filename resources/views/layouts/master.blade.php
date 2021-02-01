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
      <div class="logo-header flex-row">
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

          <a href="/policy" class="navbar-left navbar-form nav-search mr-md-3 w-50">
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
              <a class="dropdown-toggle profile-pic float-right" data-toggle="dropdown" href="#" aria-expanded="false" data-toggle="dropdown" aria-haspopup="true">
                <span>{{ Auth::user()->name }}</span>
              </a>
                <small class="d-flex flex-column w-50 float-right">({{ Auth::user()->role->name }})</small>
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
      <div class="sidebar-wrapper" id="sidebar-wrapper">
          <ul class="nav">
              @if (auth()->check())
                  @if (auth()->user()->isAdmin())
                      <li class="{{ 'dashboard' == request()->path() ? 'active' : '' }}">
                          <a href="{{ route('auction.index') }}">
                              <i class="now-ui-icons tech_tv"></i>
                              <p>Аукцион</p>
                          </a>
                      </li>
                      <li class="{{'dashboard' == request()->path() ? 'active' : ''}}"> 
                          <a href="{{ route('egknservice.index') }}"> 
                              <i class="now-ui-icons tech_tv"></i> 
                              <p>Поступившие заявки</p> 
                          </a> 
                      </li>
                    <li class="{{ 'process' == request()->path() ? 'active' : '' }}">
                        <a href="{{ route('processes.index') }}">
                            <i class="now-ui-icons media-2_sound-wave"></i>
                            <p>Процессы | {{ $processesCount }}</p>
                        </a>
                    </li>
                    <li class="{{ 'roles2' == request()->path() ? 'active' : '' }}">
                        <a href="{{ route('role.index') }}">
                            <i class="now-ui-icons users_circle-08"></i>
                            <p>Роли | {{ $rolesCount }}</p>
                        </a>
                    </li>
                    <li class="{{ 'cityManagements' == request()->path() ? 'active' : '' }}">
                        <a href="{{ route('city.index') }}">
                            <i class="now-ui-icons business_bank"></i>
                            <p>Организации | {{ $cityManagementCount }}</p>
                        </a>
                    </li>
                    <li class="{{ 'role-register' == request()->path() ? 'active' : '' }}">
                        <a href="{{ route('user-role.register') }}">
                            <i class="now-ui-icons users_single-02"></i>
                            <p>Пользователи | {{ $usersCount }}</p>
                        </a>
                    </li>
                    <li class="{{ 'dictionary' == request()->path() ? 'active' : '' }}">
                        <a href="{{ route('dictionary') }}">
                            <i class="now-ui-icons users_single-02"></i>
                            <p>Справочник | {{ $dictionariesCount }}</p>
                        </a>
                    </li>
                    <li class="{{ 'logs' == request()->path() ? 'active' : '' }}">
                        <a href="{{ route('logs') }}">
                            <i class="now-ui-icons users_single-02"></i>
                            <p>Логи сервиса</p>
                        </a>
                    </li>
                @endif
                
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
        @yield('content')
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
