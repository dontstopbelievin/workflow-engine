-<!--

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
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        @yield('title')
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- CSS Files -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="../assets/demo/demo.css" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" />
    <style>
      body{
         padding: 0 !important;
      }
    </style>
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="sidebar-blue">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">
        <a href="/dashboard" class="d-flex justify-content-center simple-text logo-normal">
          Электронные услуги
        </a>
      </div>
      <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
        @if(auth()->check())
            @if (auth()->user()->isAdmin())
          <!-- <li class="{{'dashboard' == request()->path() ? 'active' : ''}}">
              <a href="{{ route('dashboard.index') }}">
                <i class="now-ui-icons tech_tv"></i>
                <p>Приборная Панель</p>
              </a>
          </li> -->
          <li class="{{'dashboard' == request()->path() ? 'active' : ''}}">
              <a href="{{ route('auction.index') }}">
                  <i class="now-ui-icons tech_tv"></i>
                  <p>Аукцион</p>
              </a>
          </li>
          <li class="{{'process' == request()->path() ? 'active' : ''}}">
            <a href="{{ route('processes.index') }}">
              <i class="now-ui-icons media-2_sound-wave"></i>
              <p>Процессы | {{$processesCount}}</p>
            </a>
          </li>
          <li class="{{'roles2' == request()->path() ? 'active' : ''}}">
            <a href="{{ route('role.index') }}">
              <i class="now-ui-icons users_circle-08"></i>
              <p>Роли | {{$rolesCount}}</p>
            </a>
          </li>
          <li class="{{'cityManagements' == request()->path() ? 'active' : ''}}">
            <a href="{{ route('city.index') }}">
                <i class="now-ui-icons business_bank"></i>
                <p>Организации | {{$cityManagementCount}}</p>
            </a>
          </li>
          <!-- <li class="{{'templates' == request()->path() ? 'active' : ''}}">
            <a href="{{ route('template.index') }}">
              <i class="now-ui-icons education_agenda-bookmark"></i>
              <p>Шаблоны | {{$templatesCount}}</p>
            </a>
          </li> -->
          <li class="{{'role-registerw' == request()->path() ? 'active' : ''}}">
            <a href="{{ route('user-role.register') }}">
              <i class="now-ui-icons users_single-02"></i>
              <p>Пользователи | {{$usersCount}}</p>
            </a>
          </li>
          <li class="{{'dictionaries' == request()->path() ? 'active' : ''}}">
            <a href="{{ route('dictionary') }}">
              <i class="now-ui-icons users_single-02"></i>
              <p>Справочник | {{$dictionariesCount}}</p>
            </a>
          </li>
            @endif
        @endif
          <li class="{{'applications' == request()->path() ? 'active' : ''}}">
            <a href="{{ route('applications.service') }}">
              <i class="now-ui-icons design_bullet-list-67"></i>
              <p>Услуги </p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel" id="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
        <div class="container-fluid">
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <form>
              {{--<div class="input-group no-border">--}}
                {{--<input type="text" value="" class="form-control" placeholder="Поиск...">--}}
                {{--<div class="input-group-append">--}}
                  {{--<div class="input-group-text">--}}
                    {{--<i class="now-ui-icons ui-1_zoom-bold"></i>--}}
                  {{--</div>--}}
                {{--</div>--}}
              {{--</div>--}}
            </form>
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} {{Auth::user()->role->name ?? ''}}
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
              </div>
            </nav>
            <!-- End Navbar -->


      @yield('content')

      </div>
<!--   Core JS Files   -->


    @yield('scripts')
    <script src="../assets/js/core/jquery.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!-- Chart JS -->
    <script src="../assets/js/plugins/chartjs.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="../assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script>
    <!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
    <script src="../assets/demo/demo.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
        integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA=="
        crossorigin="anonymous"></script>
      </body>

      </html>        