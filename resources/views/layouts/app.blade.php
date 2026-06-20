<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="SIPINJAM - Sistem Informasi Peminjaman Inventaris Kampus">
  <title>@yield('title', 'SIPINJAM')</title>

  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>
  <div class="admin-shell">
    <div class="sidebar-backdrop" data-sidebar-close></div>

    <x-sidebar />

    <div class="admin-main">
      <x-navbar />

      <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif
          @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('error') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          @yield('content')
        </div>
      </main>

      <x-footer />
    </div>
  </div>

  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
  @auth
    <script>
      window.adminHMDUser = {
        name: "{{ Auth::user()->name }}",
        workspace: "{{ Auth::user()->role === 'admin' ? 'Administrator' : (Auth::user()->role === 'officer' ? 'Petugas' : 'Mahasiswa') }}",
        avatar: "{{ (Auth::user()->avatar || Auth::user()->provider === 'google') ? Auth::user()->avatar : '' }}"
      };
    </script>
  @endauth
  @if(config('app.env') === 'local')
    <!-- Floating Quick Role Switcher (Local Env Only) -->
    <div class="position-fixed bottom-0 end-0 m-3 z-3 d-none d-md-block">
      <div class="dropdown">
        <button class="btn btn-dark shadow-lg border border-warning d-flex align-items-center gap-2 px-3 py-2" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 30px; font-size: 14px;">
          <i class="bi bi-cpu text-warning"></i>
          <span class="fw-semibold text-white">Dev Switcher</span>
          <span class="badge bg-warning text-dark text-uppercase" style="font-size: 10px;">{{ Auth::check() ? Auth::user()->role : 'Guest' }}</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end p-2 shadow-lg border border-light-subtle" style="min-width: 220px; border-radius: 12px;">
          <li class="dropdown-header text-muted text-uppercase fw-bold pb-1 mb-2 border-bottom" style="font-size: 11px;">Pilih Akses Mode</li>
          <li>
            <a class="dropdown-item d-flex align-items-center gap-2 py-2 rounded-2 {{ Auth::check() && Auth::user()->isAdmin() ? 'active bg-danger text-white' : '' }}" href="{{ route('dev.switch-role', 'admin') }}">
              <i class="bi bi-shield-lock text-danger"></i> Administrator
            </a>
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center gap-2 py-2 rounded-2 {{ Auth::check() && Auth::user()->isOfficer() ? 'active bg-primary text-white' : '' }}" href="{{ route('dev.switch-role', 'officer') }}">
              <i class="bi bi-person-badge text-primary"></i> Officer (Petugas)
            </a>
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center gap-2 py-2 rounded-2 {{ Auth::check() && Auth::user()->isStudent() ? 'active bg-success text-white' : '' }}" href="{{ route('dev.switch-role', 'student') }}">
              <i class="bi bi-mortarboard text-success"></i> Mahasiswa
            </a>
          </li>
        </ul>
      </div>
    </div>
  @endif

  <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
