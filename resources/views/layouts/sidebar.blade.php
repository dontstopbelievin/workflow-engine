<div class="sidebar" style="margin-top: 40px;">
  <div class="scrollbar-inner sidebar-wrapper" style="padding-top: 0px;">
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