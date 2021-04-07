<style type="text/css">
.navbar a{
    color:white!important;
}
.dropdown-menu a{
    color:black!important;
}
.nav_left_form a{
    padding: 5px;
    margin: 5px;
}
.navbar-nav .active{
    background-color: #004798;
}
.nav_left_form li{
    padding: 20px;
}
.nav_left_form li:hover{
    background-color: #0057A8;
}
.nav_left_form a:hover{
    text-decoration: none!important;
}
</style>
<nav class="navbar navbar-header navbar-expand-lg fixed-top" style="background: #0067B8!important; height: 60px;box-shadow: 0 2px 1px -1px #999; color:white!important;padding-left: 0px;">
    <div class="container-fluid" style="padding-left: 0px;">
        <div class="navbar-header">
            <div>
                <a href="{{ url('docs') }}" class="logo" style="padding-right: 5px; text-decoration: none!important;">
                    <img style="height: 35px;" src="{{url('/images/astana-logo.png')}}">
                </a>
                <a href="{{ url('docs') }}" class="logo">
                    <img style="height: 13px;" src="{{url('/images/logo.png')}}">
                </a>
            </div>
        </div>
        @if(Auth::check())
            <ul class="navbar-nav nav_left_form" style="margin-left: 20px;">
                <li class="nav-item {{request()->segment(1) == 'docs' ? 'active' : ''}}">
                    <a href="{{url('docs')}}" class="navbar-left navbar-form nav-search">
                    <b>ДОКУМЕНТЫ</b></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="navbar-left navbar-form nav-search">
                    <b>ОТЧЕТЫ</b></a>
                </li>
                <li class="nav-item {{(request()->segment(1) == 'process') || (request()->segment(1) == 'admin') ? 'active' : ''}}">
                    <a href="{{url('admin/process')}}" class="navbar-left navbar-form nav-search">
                    <b>АДМИНИСТРИРОВАНИЕ</b></a>
                </li>
            </ul>
        @endif
        <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
            @guest
            <li class="nav-item">
              <a href="{{ route('login') }}">АВТОРИЗАЦИЯ</a>
            </li>
            @else
            <li class="nav-item dropdown">
              <a class="dropdown-toggle profile-pic float-right" data-toggle="dropdown" href="#" aria-expanded="false" data-toggle="dropdown" aria-haspopup="true" style="line-height: 100%;margin-top: 10px;">
                <span style="color:white!important">{{ Auth::user()->name }}</span><br>
                <small>
                    @if(mb_strlen(Auth::user()->role->name, 'UTF-8') > 25)
                        <span data-toggle="tooltip" title="{{Auth::user()->role->name}}" style="color:white!important;">
                              ({{mb_substr(Auth::user()->role->name, 0, 25, 'utf-8')}}...)
                        </span>
                    @else
                        ({{ Auth::user()->role->name }})
                    @endif
                </small>
              </a>
              <ul class="dropdown-menu dropdown-user">
                <li><a class="dropdown-item" href="{{ url('user/personal_area') }}">Мои данные</a></li>
                <li><a class="dropdown-item" href="{{ url('user/edit', ['user' => Auth::user()]) }}">Редактировать данные</a></li>
                <li><a class="dropdown-item" href="{{url('password/reset')}}">Cменить пароль</a></li>
                <li><a class="dropdown-item" href="{{url('policy')}}">
                    Правила информационной без...</a></li>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item"href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
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
