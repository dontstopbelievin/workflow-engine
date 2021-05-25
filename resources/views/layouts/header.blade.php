<style type="text/css">
    .navbar a {
        color: white !important;
    }

    .dropdown-menu a {
        color: black !important;
    }

    .nav_left_form a {
        padding: 5px;
        margin: 5px;
    }

    .navbar-nav .active {
        background-color: #1a9f29;
    }

    .nav_left_form li {
        padding: 20px;
    }

    .nav_left_form li:hover {
        cursor: pointer;
        background-color: #1a9f29;
    }

    .nav-auth {
        padding: 20px;
    }

    .nav-auth2 {
        padding: 10px;
    }

    .nav-auth2:hover {
        cursor: pointer;
        background-color: #1a9f29;
    }

    .nav-auth:hover {
        cursor: pointer;
        background-color: #1a9f29;
    }
    .btn-primary{
        background-color: #0a8323!important;
        border-color: #0a8323!important;
    }
    .btn-primary:hover{
        background-color: #1a9f29!important;
        border-color: #0a8323!important;
    }
</style>
<nav class="navbar navbar-header navbar-expand-lg fixed-top"
    style="background: #0a8323!important; height: 60px;box-shadow: 0 2px 1px -1px #999; color:white!important;padding-left: 0px;">
    <div class="container-fluid" style="padding-left: 0px;">
        <div class="navbar-header">
            <div>
                <a href="{{ url('docs') }}" class="logo" style="padding-right: 5px; text-decoration: none!important;">
                    <img style="height: 35px;" src="{{ url('/images/astana-logo.png') }}">
                </a>
                <a href="{{ url('docs') }}" class="logo">
                    <img style="height: 13px;" src="{{ url('/images/logo.png') }}">
                </a>
            </div>
        </div>
        @if (Auth::check())
            <ul class="navbar-nav nav_left_form" style="margin-left: 20px;">
                <li onclick="window.location='{{ url('docs') }}'"
                    class="nav-item {{ request()->segment(1) == 'docs' ? 'active' : '' }}">
                    <b>ДОКУМЕНТЫ</b>
                </li>
                {{-- <li class="nav-item">
                    <b>ОТЧЕТЫ</b>
                </li> --}}
                @if (Auth::check() && Auth::user()->role->name === 'Admin')
                    <li onclick="window.location='{{ url('admin/process') }}'"
                        class="nav-item {{ request()->segment(2) == 'process' ? 'active' : '' }}">
                        <b>АДМИНИСТРИРОВАНИЕ</b>
                    </li>
                    <li onclick="window.location='{{ url('admin/report') }}'"
                        class="nav-item {{ request()->segment(2) == 'report' ? 'active' : '' }}">
                        <b>ОТЧЕТ</b>
                    </li>
                @endif
            </ul>
        @endif
        <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
            @guest
                <li class="nav-item nav-auth" onclick="window.location='{{ route('login') }}'">
                    <b>АВТОРИЗАЦИЯ</b>
                </li>
            @else
                <li class="nav-item dropdown nav-auth2" data-toggle="dropdown">
                    <span style="color:white!important"><b>{{ Auth::user()->sur_name }}
                            {{ Auth::user()->first_name }}</b></span><br>
                    <small>
                        @if (mb_strlen(Auth::user()->role->name, 'UTF-8') > 25)
                            <span data-toggle="tooltip" title="{{ Auth::user()->role->name }}"
                                style="color:white!important;">
                                <b>({{ mb_substr(Auth::user()->role->name, 0, 25, 'utf-8') }}...)</b>
                            </span>
                        @else
                            <b>({{ Auth::user()->role->name }})</b>
                        @endif
                    </small>

                    <ul class="dropdown-menu dropdown-user">
                        <li class="dropdown-item" onclick="window.location='{{ url('user/personal_area') }}'">Мои данные
                        </li>
                        <li class="dropdown-item"
                            onclick="window.location='{{ url('user/edit', ['user' => Auth::user()]) }}'">Редактировать
                            данные</li>
                        <li class="dropdown-item" onclick="window.location='{{ url('password/reset') }}'">Cменить пароль
                        </li>
                        <li class="dropdown-item" onclick="window.location='{{ url('policy') }}'">Правила информационной
                            без...</li>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                            <i class="fa fa-power-off"></i>
                            {{ __('Выйти') }}
                        </a>
                        <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </ul>
                </li>
            @endguest
        </ul>
    </div>
</nav>
