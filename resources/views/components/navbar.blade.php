<nav class="navbar admin-navbar navbar-expand bg-white">
  <div class="container-fluid px-3 px-lg-4">
    <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-controls="adminSidebar" aria-expanded="true" aria-label="Toggle sidebar">
      <span></span>
      <span></span>
      <span></span>
    </button>

    <form class="d-none d-md-flex ms-3 flex-grow-1" role="search">
      <input class="form-control search-input" type="search" placeholder="Cari..." aria-label="Search">
    </form>

    <div class="navbar-actions ms-auto">
      <button class="icon-button theme-toggle" type="button" data-theme-toggle aria-label="Switch color theme" title="Switch color theme">
        <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
      </button>
      <div class="dropdown">
        <button class="icon-button" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Notifications">
          <span class="notification-dot"></span>
          <i class="bi bi-bell" aria-hidden="true"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-end notification-menu">
          <div class="dropdown-header fw-bold text-body">Notifikasi</div>
          <a class="dropdown-item" href="#">
            <span class="notification-title">Notifikasi sistem</span>
            <span class="notification-time">Baru saja</span>
          </a>
        </div>
      </div>

      <div class="dropdown">
        <button class="profile-button dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <img class="avatar-img avatar-sm" src="{{ asset('assets/images/avatar/avatar.jpg') }}" alt="User">
          <span class="profile-name d-none d-sm-inline">
            @if(request()->is('admin/*') || request()->is('admin'))
              Admin
            @elseif(request()->is('officer/*') || request()->is('officer'))
              Petugas
            @else
              Mahasiswa
            @endif
          </span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item" href="
              @if(request()->is('admin/*') || request()->is('admin')) {{ route('admin.profile') }}
              @elseif(request()->is('officer/*') || request()->is('officer')) {{ route('officer.profile') }}
              @else {{ route('student.profile') }}
              @endif
            ">Profil</a>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="#">Keluar</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>
