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
    border-bottom: solid;
}
.navbar-nav .active{
    background-color: green;
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
        <ul class="navbar-nav nav_left_form" style="margin-left: 20px;">
            <li class="nav-item">
                <a href="{{url('docs')}}" class="navbar-left navbar-form nav-search {{request()->segment(1) == 'docs' ? 'active' : ''}}">
                Документы</a>
            </li>
            <li class="nav-item">
                <a href="{{url('admin/process')}}" class="navbar-left navbar-form nav-search {{(request()->segment(1) == 'process') || (request()->segment(1) == 'admin') ? 'active' : ''}}">
                Администрирование</a>
            </li>
        </ul>
        <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
            @guest
            <li class="nav-item">
              <a href="{{ route('login') }}">Авторизация</a>
            </li>
            @else
            <li class="nav-item dropdown">
              <a class="dropdown-toggle profile-pic float-right" data-toggle="dropdown" href="#" aria-expanded="false" data-toggle="dropdown" aria-haspopup="true" style="line-height: 100%;margin-top: 10px;">
                <span style="color:white!important">{{ Auth::user()->name }}</span><br>
                <small>
                    @if(strlen(Auth::user()->role->name) > 60)
                        ({{substr(Auth::user()->role->name, 0, 60)}})
                    @else
                        ({{Auth::user()->role->name}})
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