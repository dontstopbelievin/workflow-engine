<style type="text/css">
    .nav-item a,p{
        font-size: 16px!important;
    }
</style>
<div class="sidebar" style="margin-top: 60px;">
  <div class="scrollbar-inner sidebar-wrapper" style="padding-top: 0px;">
    @if(request()->segment(1) == 'applications' || request()->segment(1) == 'docs' ||
      request()->segment(1) == 'user' || request()->segment(1) == 'password'
      || request()->segment(1) == 'policy' || request()->segment(1) == '')
      <ul class="nav">
      @if ((Auth::user()->role->name == 'Заявитель'))
        <li class="nav-item text-center">
          <button class="btn btn-primary" onclick="location.href='{{url('docs')}}';">
            <i class="fa fa-plus"></i>
            <span style="margin-left: 5px;">Подать заявку</span>
          </button>
          <br><hr>
        </li>
      @else
        <li class="nav-item {{request()->segment(3) == 'incoming' ? 'active' : ''}}">
          <a href="{{ url('docs/services/incoming') }}">
              <i class="la la-sign-out"></i>
              <p>Входящие</p>
              <span class="badge badge-count">{{ $counter_incoming }}</span>
          </a>
        </li>
        <li class="nav-item {{request()->segment(3) == 'outgoing' ? 'active' : ''}}">
          <a href="{{ url('docs/services/outgoing') }}">
              <i class="la la-sign-in"></i>
              <p>Исходящие</p>
              <span class="badge badge-count">{{ $counter_outgoing }}</span>
          </a>
        </li>
      @endif
      @if ((Auth::user()->role->name == 'Заявитель'))
        <li class="nav-item {{request()->segment(3) == 'mydocs' ? 'active' : ''}}">
          <a href="{{ url('docs/services/mydocs') }}">
              <i class="fa fa-book"></i>
              <p>Мои документы</p>
              <span class="badge badge-count">{{ $counter_my_docs }}</span>
          </a>
        </li>
        {{-- <li class="nav-item {{request()->segment(3) == 'drafts' ? 'active' : ''}}">
          <a href="{{ url('docs/services/drafts') }}">
              <i class="fa fa-file-text"></i>
              <p>Черновики</p>
          </a>
        </li> --}}
      @else
        <li class="nav-item {{request()->segment(3) == 'archive' ? 'active' : ''}}">
          <a href="{{ url('docs/services/archive') }}">
              <i class="fa fa-archive"></i>
              <p>Архив документов</p>
              <span class="badge badge-count">{{ $counter_archive }}</span>
          </a>
        </li>
      @endif
      </ul>
    @else
      <ul class="nav">
          <li class="nav-item {{request()->is('admin/auction') ? 'active' : ''}}">
            <a href="{{ url('admin/auction') }}">
                <i class="la la-legal"></i>
                <p>Аукцион</p>
            </a>
          </li>
          <li class="nav-item {{request()->is('admin/egknservice') ? 'active' : ''}}">
            <a href="{{ url('admin/egknservice') }}">
                <i class="la la-archive"></i>
                <p>Поступившие заявки</p>
            </a>
          </li>
          <li class="nav-item {{request()->segment(2) == 'process' || request()->segment(2) == 'template_field' ? 'active' : ''}}">
            <a href="{{ url('admin/process') }}">
                <i class="la la-gears"></i>
                <p>Процессы</p>
                <span class="badge badge-count">{{ $processesCount }}</span>
            </a>
          </li>
          <li class="nav-item {{request()->segment(2) == 'role' ? 'active' : ''}}">
            <a href="{{ url('admin/role') }}">
                <i class="la la-user"></i>
                <p>Роли</p>
                <span class="badge badge-count">{{ $rolesCount }}</span>
            </a>
          </li>
          <li class="nav-item {{request()->is('admin/city/index') ? 'active' : ''}}">
            <a href="{{ url('admin/city/index') }}">
                <i class="la la-building"></i>
                <p>Организации</p>
                <span class="badge badge-count">{{ $cityManagementCount }}</span>
            </a>
          </li>
          <li class="nav-item {{request()->segment(2) == 'user_role' ? 'active' : ''}}">
            <a href="{{ url('admin/user_role/register') }}">
                <i class="la la-users"></i>
                <p>Пользователи</p>
                <span class="badge badge-count">{{ $usersCount }}</span>
            </a>
          </li>
          <li class="nav-item {{request()->is('admin/dictionary') ? 'active' : ''}}">
            <a href="{{ url('admin/dictionary') }}">
                <i class="la la-book"></i>
                <p>Справочник</p>
                <span class="badge badge-count">{{ $dictionariesCount }}</span>
            </a>
          </li>
          <li class="nav-item {{request()->is('admin/logs') ? 'active' : ''}}">
            <a href="{{ url('admin/logs') }}">
                <i class="la la-comment"></i>
                <p>Логи сервиса</p>
            </a>
          </li>
          @if(Auth::user()->usertype == 'super_admin')
          <li class="nav-item {{request()->is('admin/super_admin') ? 'active' : ''}}">
            <a href="{{ url('admin/super_admin') }}">
                <i class="la la-github-alt"></i>
                <p>Супер Админ</p>
            </a>
          </li>
          @endif
      </ul>
    </div>
    @endif
  </div>
</div>
