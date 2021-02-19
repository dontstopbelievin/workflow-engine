<div class="sidebar" style="margin-top: 60px;">
  <div class="scrollbar-inner sidebar-wrapper" style="padding-top: 0px;">
    @if(request()->segment(1) == 'applications' || request()->segment(1) == 'services' ||
      request()->segment(1) == 'user' || request()->segment(1) == 'password'
      || request()->segment(1) == 'policy')
      <ul class="nav">
        <li class="nav-item text-center">
          <button class="btn btn-primary" onclick="location.href='{{url('services')}}';">
            <i class="fa fa-plus"></i>
            <span style="margin-left: 5px;">Создать документ</span>
          </button>
          <br><hr>
        </li>
        <li class="nav-item {{request()->segment(1) == 'services' ? 'active' : ''}}">
          <a href="{{ url('services') }}">
              <i class="la la-sign-out"></i>
              <p>Входящие</p>
          </a>
        </li>
        <li class="nav-item {{request()->segment(1) == 'services' ? 'active' : ''}}">
          <a href="{{ url('services') }}">
              <i class="la la-sign-in"></i>
              <p>Исходящие</p>
          </a>
        </li>
        <li class="nav-item {{request()->segment(1) == 'services' ? 'active' : ''}}">
          <a href="{{ url('services') }}">
              <i class="fa fa-book"></i>
              <p>Мои документы</p>
          </a>
        </li>
        <li class="nav-item {{request()->segment(1) == 'services' ? 'active' : ''}}">
          <a href="{{ url('services') }}">
              <i class="fa fa-file-text"></i>
              <p>Черновики</p>
          </a>
        </li>
        <li class="nav-item {{request()->segment(1) == 'services' ? 'active' : ''}}">
          <a href="{{ url('services') }}">
              <i class="fa fa-archive"></i>
              <p>Архив документов</p>
          </a>
        </li>
      </ul>
    @else
      <ul class="nav">
          <li class="nav-item {{request()->is('auction') ? 'active' : ''}}">
            <a href="{{ url('auction') }}">
                <i class="la la-legal"></i>
                <p>Аукцион</p>
            </a>
          </li>
          <li class="nav-item {{request()->is('egknservice') ? 'active' : ''}}">
            <a href="{{ url('egknservice') }}">
                <i class="la la-archive"></i>
                <p>Поступившие заявки</p>
            </a>
          </li>
          <li class="nav-item {{(request()->is('process') ? 'active' : request()->segment(1) == 'processes') ? 'active' : (request()->segment(1) == 'processes-edit' ? 'active' : (request()->segment(1) == 'template_field/create' ? 'active' : ''))}}">
            <a href="{{ url('process') }}">
                <i class="la la-gears"></i>
                <p>Процессы</p>
                <span class="badge badge-count">{{ $processesCount }}</span>
            </a>
          </li>
          <li class="nav-item {{request()->is('role') ? 'active' : (request()->segment(1) == 'role-edit' ? 'active' : '')}}">
            <a href="{{ url('role') }}">
                <i class="la la-user"></i>
                <p>Роли</p>
                <span class="badge badge-count">{{ $rolesCount }}</span>
            </a>
          </li>
          <li class="nav-item {{request()->is('city/index') ? 'active' : ''}}">
            <a href="{{ url('city/index') }}">
                <i class="la la-building"></i>
                <p>Организации</p>
                <span class="badge badge-count">{{ $cityManagementCount }}</span>
            </a>
          </li>
          <li class="nav-item {{request()->is('user_role/register') ? 'active' : (request()->segment(1) == 'user-edit' ? 'active' : '')}}">
            <a href="{{ url('user_role/register') }}">
                <i class="la la-users"></i>
                <p>Пользователи</p>
                <span class="badge badge-count">{{ $usersCount }}</span>
            </a>
          </li>
          <li class="nav-item {{request()->segment(1) == 'dictionary' ? 'active' : ''}}">
            <a href="{{ url('dictionary') }}">
                <i class="la la-book"></i>
                <p>Справочник</p>
                <span class="badge badge-count">{{ $dictionariesCount }}</span>
            </a>
          </li>
          <li class="nav-item {{request()->is('process/logs') ? 'active' : ''}}">
            <a href="{{ url('process/logs') }}">
                <i class="la la-comment"></i>
                <p>Логи сервиса</p>
            </a>
          </li>
          <li class="nav-item {{request()->segment(1) == 'services' ? 'active' : (request()->segment(1) == 'index' ? 'active' : (request()->segment(1) == 'applications-create' ? 'active' : ''))}}">
            <a href="{{ url('services') }}">
                <i class="la la-list"></i>
                <p>Все услуги</p>
            </a>
          </li>
      </ul>
    </div>
    @endif
  </div>
</div>
