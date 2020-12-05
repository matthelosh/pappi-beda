<header class="c-header c-header-light c-header-fixed c-header-with-subheader">
        <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
          <svg class="c-icon c-icon-lg">
            <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-menu') }}"></use>
          </svg>
        </button><a class="c-header-brand d-lg-none" href="#">
          {{-- <svg width="118" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset('img/pappi-beda.svg') }}"></use>
          </svg></a> --}}
          <img src="{{ asset('img/pappi-beda.svg') }}" height="46" alt="">
        <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
          <svg class="c-icon c-icon-lg">
            <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-menu') }}"></use>
          </svg>
        </button>
        <ul class="c-header-nav d-md-down-none">
          <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="/#">{{ Auth::user()->nama }}</a></li>
          {{--<li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="#">Users</a></li>
          <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="#">Settings</a></li> --}}
        </ul>
        <ul class="c-header-nav ml-auto mr-4">
          {{-- <li class="c-header-nav-item d-md-down-none mx-2"><a class="c-header-nav-link" href="#">
              <svg class="c-icon">
                <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-bell') }}"></use>
              </svg></a></li>
          <li class="c-header-nav-item d-md-down-none mx-2"><a class="c-header-nav-link" href="#">
              <svg class="c-icon">
                <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-list-rich') }}"></use>
              </svg></a></li> --}}
          <li class="c-header-nav-item d-md-down-none mx-2"><a class="c-header-nav-link" href="#" title="Ganti Periode">
              <svg class="c-icon">
                <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-equalizer') }}"></use>
              </svg></a></li>
          <li class="c-header-nav-item dropdown"><a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" title="{{ Auth::user()->nama }}">
              <div class="c-avatar"><img class="c-avatar-img" src="{{ asset('/img/users/'.Auth::user()->nip.'.jpg') }}" alt="user@email.com" onerror="this.onerror=null;this.src='/coreui/assets/img/avatars/6.jpg'"></div>
            </a>
            <div class="dropdown-menu dropdown-menu-right pt-0">
              {{-- <div class="dropdown-header bg-light py-2"><strong>Account</strong></div><a class="dropdown-item" href="#"> --}}
                {{-- <svg class="c-icon mr-2">
                  <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-bell') }}"></use>
                </svg> Updates<span class="badge badge-info ml-auto">42</span></a><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-envelope-open') }}"></use>
                </svg> Messages<span class="badge badge-success ml-auto">42</span></a><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-task') }}"></use>
                </svg> Tasks<span class="badge badge-danger ml-auto">42</span></a><a class="dropdown-item" href="#"> --}}
                {{-- <svg class="c-icon mr-2">
                  <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-comment-square') }}"></use>
                </svg> Comments<span class="badge badge-warning ml-auto">42</span></a> --}}
              <div class="dropdown-header bg-light py-2"><strong>Atur</strong></div><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-user') }}"></use>
                </svg> Profil</a>
                {{-- <a class="dropdown-item" href="#"> --}}

                {{-- <svg class="c-icon mr-2">
                  <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-settings') }}"></use>
                </svg> Settings</a><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-credit-card') }}"></use>
                </svg> Payments<span class="badge badge-secondary ml-auto">42</span></a><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-file') }}"></use>
                </svg> Projects<span class="badge badge-primary ml-auto">42</span> --}}
                {{-- </a> --}}
              <div class="dropdown-divider"></div>
              {{-- <a class="dropdown-item" href="#"> --}}
                {{-- <svg class="c-icon mr-2">
                  <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-lock-locked') }}"></use>
                </svg> Lock Account</a> --}}
                <button class="dropdown-item btn-logout" onclick="logout()" class="text-danger" >
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-account-logout') }}"></use>
                </svg> Keluar</button>
            </div>
          </li>
        </ul>
        {{-- <div class="c-subheader px-3">
          <!-- Breadcrumb-->
          <ol class="breadcrumb border-0 m-0">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
            <!-- Breadcrumb Menu-->
          </ol>
        </div> --}}
      </header>