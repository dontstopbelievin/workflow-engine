<style type="text/css">
.navbar a{
    color:white!important;
}
.dropdown-menu a{
    color:black!important;
}
</style>
<nav class="navbar navbar-header navbar-expand-lg fixed-top" style="background: #0067B8!important; height: 60px;box-shadow: 0 2px 1px -1px #999; color:white!important;">
    <div class="container-fluid">
        <div class="navbar-header">
            <div>
                <a href="{{ route('applications.service') }}" class="logo" style="font-weight: bold;">
                    <img style="height: 20px;" src="{{url('/images/logo.png')}}">
                </a>
            </div>
        </div>
        <ul class="nav navbar-nav" style="margin-left: 20px;">
            <li>
                <a href="/policy" class="navbar-left navbar-form nav-search mr-md-3 w-50">
                Документы</a>
            </li>
            <li>
                <a href="/policy" class="navbar-left navbar-form nav-search mr-md-3 w-50">
                Контрагенты</a>
            </li>
            <li>
                <a href="/policy" class="navbar-left navbar-form nav-search mr-md-3 w-50">
                Правила информационной безопасности</a>
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
                <small>({{ Auth::user()->role->name }})</small>
              </a>
              <ul class="dropdown-menu dropdown-user">
                <li> <a class="dropdown-item" href="{{ route('user.personalArea') }}">Мои данные</a> </li>
                <li> <a class="dropdown-item" href="{{ route('user.edit', ['user' => Auth::user()]) }}">Редактировать данные</a> </li>
                <li> <a class="dropdown-item" href="/password/reset">Cменить пароль</a> </li>
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