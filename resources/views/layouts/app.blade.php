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
  <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
