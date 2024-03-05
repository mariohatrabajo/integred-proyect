<div class="loader-bg">
  <div class="loader-track">
    <div class="loader-fill"></div>
  </div>
</div>
<!-- Pre-loader-->
<!-- Sidebar Menu -->
<nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header">
      <a href="#" class="b-brand text-primary">
        <img src="{{ asset('images/logo.svg') }}" />
        <span class="badge bg-light-success rounded-pill ms-2 theme-version"></span>
      </a>
    </div>
    <div class="navbar-content">
      <ul class="pc-navbar">
        <li class="pc-item pc-caption">
          <label>{{ trans('integrated.navi_bar.navigation') }}</label>
          <i class="ti ti-dashboard"></i>
        </li>
        <li class="pc-item pc-hasmenu">
        <li class="pc-item">
          <!-- Enlace a la ruta 'home'. Si la ruta actual es 'home', se agrega la clase 'active'. -->
          <a href="{{ route('home') }}" class="pc-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}">
            <span class="pc-micon">
              <svg class="pc-icon">
                <use xlink:href="#custom-status-up"></use>
              </svg>
            </span>
            <span class="pc-mtext">{{ trans('integrated.navi_bar.dashboard') }}</span>
          </a>
        </li>
        </li>


        @auth
        @if(auth()->user()->roles->contains('id', 1) || auth()->user()->roles->contains('id', 2))
        <li class="pc-item pc-caption">
          <label>{{ trans('integrated.navi_bar.tables') }}</label>
          <i class="ti ti-chart-arcs"></i>
        </li>
        <li class="pc-item">
          <!-- Enlace a la ruta 'profesor'. Si la ruta actual es 'profesor', se agrega la clase 'active'. -->
          <a href="{{ route('profesor') }}" class="pc-link {{ Route::currentRouteName() == 'profesor' ? 'active' : '' }}">
            <span class="pc-micon">
              <svg class="pc-icon">
                <use xlink:href="#custom-user-square"></use>
              </svg>
            </span>
            <span class="pc-mtext">{{ trans('integrated.navi_bar.teacher') }}</span>
          </a>
        </li>
        <li class="pc-item">
          <!-- Enlace a la ruta 'formaciones'. Si la ruta actual es 'formaciones', se agrega la clase 'active'. -->
          <a href="{{ route('formaciones') }}" class="pc-link {{ Route::currentRouteName() == 'formaciones' ? 'active' : '' }}">
            <span class="pc-micon">
              <svg class="pc-icon">
                <use xlink:href="#custom-shopping-bag"></use>
              </svg>
            </span>
            <span class="pc-mtext">{{ trans('integrated.navi_bar.formation') }}</span>
          </a>
        </li>
        <li class="pc-item">
          <!-- Enlace a la ruta 'modulos'. Si la ruta actual es 'modulos', se agrega la clase 'active'. -->
          <a href="{{ route('modulos') }}" class="pc-link {{ Route::currentRouteName() == 'modulos' ? 'active' : '' }}">
            <span class="pc-micon">
              <svg class="pc-icon">
                <use xlink:href="#custom-sort-outline"></use>
              </svg>
            </span>
            <span class="pc-mtext">{{ trans('integrated.navi_bar.modules') }}</span></a>
        </li>
        <li class="pc-item">
          <!-- Enlace a la ruta 'grupos'. Si la ruta actual es 'grupos', se agrega la clase 'active'. -->
          <a href="{{ route('grupos') }}" class="pc-link {{ Route::currentRouteName() == 'grupos' ? 'active' : '' }}">
            <span class="pc-micon">
              <svg class="pc-icon">
                <use xlink:href="#custom-profile-2user-outline"></use>
              </svg>
            </span>
            <span class="pc-mtext">{{ trans('integrated.navi_bar.groups') }}</span></a>
        </li>
        <li class="pc-item">
          <!-- Enlace a la ruta 'lecciones'. Si la ruta actual es 'lecciones', se agrega la clase 'active'. -->
          <a href="{{ route('lecciones') }}" class="pc-link {{ Route::currentRouteName() == 'lecciones' ? 'active' : '' }}">
            <span class="pc-micon">
              <svg class="pc-icon">
                <use xlink:href="#custom-presentation-chart"></use>
              </svg>
            </span>
            <span class="pc-mtext">{{ trans('integrated.navi_bar.lessons') }}</span></a>
        </li>
        @auth
        @if(auth()->user()->roles->contains('id', 1))
        <li class="pc-item">
          <!-- Enlace a la ruta 'roles'. Si la ruta actual es 'roles', se agrega la clase 'active'. -->
          <a href="{{ route('roles') }}" class="pc-link {{ Route::currentRouteName() == 'roles' ? 'active' : '' }}">
            <span class="pc-micon">
              <svg class="pc-icon">
                <use xlink:href="#custom-shield"></use>
              </svg>
            </span>
            <span class="pc-mtext">{{ trans('integrated.navi_bar.roles') }}</span></a>
        </li>
        @endif
        @endauth
        @endif
        @endauth
      </ul>
    </div>
  </div>
</nav>
<!-- Sidebar Menu end -->
<!-- Header Topbar start -->
<header class="pc-header">
  <div class="header-wrapper">
    <div class="me-auto pc-mob-drp">
      <ul class="list-unstyled">
        <li class="pc-h-item pc-sidebar-collapse">
          <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
            <i class="ti ti-menu-2"></i>
          </a>
        </li>

        <!-- Aqui va la barra de busqueda global -->
        @auth
        @livewire('busqueda-general')
        @endauth

        <li class="pc-h-item pc-sidebar-popup">
          <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
            <i class="ti ti-menu-2"></i>
          </a>
        </li>
        <!-- </li>&nbsp;&nbsp;
        <li class="pc-h-item">
          <span class="pc-mtext"><a href="{{route('login')}}">Login</a></span>&nbsp;|&nbsp;
          <span class="pc-mtext"><a href="{{route('logout')}}">Logout</a></span>&nbsp;|&nbsp;
          <span class="pc-mtext"><a href="{{route('register')}}">Register</a></span>
        </li> -->
      </ul>
    </div>
    <div class="ms-auto">
      <ul class="list-unstyled">
        <!-- If the user NOT loggin, show the buttons -->
        @guest
        <li class="dropdown pc-h-item">
          <a href="{{route('login')}}">
            <button type="button" class="btn btn-info">Login</button>
          </a>
        </li>
        <li class="dropdown pc-h-item">
          &nbsp;&nbsp;&nbsp;
        </li>
        <li class="dropdown pc-h-item">
          <a href="{{route('register')}}">
            <button type="button" class="btn btn-info">Register</button>
          </a>
        </li>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        @endguest
        <li class="dropdown pc-h-item">
          <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
            <svg class="pc-icon">
              <use xlink:href="#custom-sun-1"></use>
            </svg>
          </a>
          <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
            <a href="#!" class="dropdown-item" onclick="layout_change('dark')">
              <svg class="pc-icon">
                <use xlink:href="#custom-moon"></use>
              </svg>
              <span>Dark</span>
            </a>
            <a href="#!" class="dropdown-item" onclick="layout_change('light')">
              <svg class="pc-icon">
                <use xlink:href="#custom-sun-1"></use>
              </svg>
              <span>Light</span>
            </a>
            <a href="#!" class="dropdown-item" onclick="layout_change_default()">
              <svg class="pc-icon">
                <use xlink:href="#custom-setting-2"></use>
              </svg>
              <span>Default</span>
            </a>
          </div>
        </li>
        @auth
        @if(auth()->user()->roles->contains('id', 1) || auth()->user()->roles->contains('id', 2))
        <li class="dropdown pc-h-item header-user-profile">
          <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
            <img src="{{ asset('images/user/avatar-2.jpg') }}" alt="user-image" class="user-avtar" />
          </a>
          <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
            <div class="dropdown-header d-flex align-items-center justify-content-between">
              <h5 class="m-0">Profile</h5>
            </div>
            <div class="dropdown-body">
              <div class="profile-notification-scroll position-relative" style="max-height: calc(100vh - 225px)">
                <div class="d-flex mb-1">
                  <div class="flex-shrink-0">
                    <img src="{{ asset('images/user/avatar-2.jpg') }}" alt="user-image" class="user-avtar wid-35" />
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <?php
                    $nombre;
                    $email;
                    $user = Illuminate\Support\Facades\Auth::user();
                    if ($user != null) {
                      $nombre = auth()->user()->name;
                      $email = auth()->user()->email;
                    } else {
                      $nombre = 'User';
                      $email = 'You are not registered';
                    }
                    ?>
                    <h6 class="mb-1">
                      <?php echo $nombre ?>
                    </h6>
                    <span>
                      <?php echo $email ?>
                    </span>
                  </div>
                </div>
                <hr class="border-secondary border-opacity-50" />
                <div class="card">
                  <div class="card-body py-3">
                    <div class="d-flex align-items-center justify-content-between">
                      <h5 class="mb-0 d-inline-flex align-items-center"><svg class="pc-icon text-muted me-2">
                          <use xlink:href="#custom-notification-outline"></use>
                        </svg>Notification</h5>
                      <div class="form-check form-switch form-check-reverse m-0">
                        <input class="form-check-input f-18" type="checkbox" role="switch" />
                      </div>
                    </div>
                  </div>
                </div>
                <p class="text-span">Manage</p>
                <a href="{{ route('profile') }}" class="dropdown-item {{ Route::currentRouteName() == 'profile' ? 'active' : '' }}">
                  <span>
                    <svg class="pc-icon text-muted me-2">
                      <use xlink:href="#custom-user"></use>
                    </svg>
                    <span>My Account</span>
                  </span>
                </a>
                <a href="{{ route('settings') }}" class="dropdown-item {{ Route::currentRouteName() == 'settings' ? 'active' : '' }}">
                  <span>
                    <svg class="pc-icon text-muted me-2">
                      <use xlink:href="#custom-setting-2"></use>
                    </svg>
                    <span>Settings</span>
                  </span>
                </a>
                <a href="{{ route('chgpasswd') }}" class="dropdown-item {{ Route::currentRouteName() == 'chgpasswd' ? 'active' : '' }}">
                  <span>
                    <svg class="pc-icon text-muted me-2">
                      <use xlink:href="#custom-security-safe"></use>
                    </svg>
                    <span>Change Password</span>
                  </span>
                </a>
                <hr class="border-secondary border-opacity-50" />
                <div class="d-grid mb-3">
                  <a class="btn btn-primary" href="{{ route('logout') }}">
                    <svg class="pc-icon me-2">
                      <use xlink:href="#custom-logout-1-outline"></use>
                    </svg>Logout
                  </a>
                </div>
              </div>
            </div>
          </div>
    </div>
    </li>
    @endif
    @endauth
    </ul>
  </div>
  </div>
</header>
</div>