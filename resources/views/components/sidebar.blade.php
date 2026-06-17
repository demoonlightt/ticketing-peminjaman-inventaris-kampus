<aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
  <div class="sidebar-header">
    <a class="brand-mark" href="#" aria-label="SIPINJAM dashboard">
      <span class="brand-icon"><i class="bi bi-box-seam" aria-hidden="true"></i></span>
      <span class="brand-copy">
        <span class="brand-title">SIPINJAM</span>
        <span class="brand-subtitle">Inventaris Kampus</span>
      </span>
    </a>
  </div>

  <nav class="sidebar-nav">
    @if(request()->is('admin/*') || request()->is('admin'))
      <!-- ADMIN MENU -->
      <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
        <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
        <span class="nav-text">Dashboard</span>
      </a>

      <div class="nav-section-title mt-3 mb-1 px-3 text-muted small fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">MASTER DATA</div>
      <a class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}" href="{{ route('admin.users') }}">
        <span class="nav-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
        <span class="nav-text">User</span>
      </a>
      <a class="nav-link {{ request()->routeIs('admin.officers') ? 'active' : '' }}" href="{{ route('admin.officers') }}">
        <span class="nav-icon"><i class="bi bi-person-badge" aria-hidden="true"></i></span>
        <span class="nav-text">Petugas</span>
      </a>
      <a class="nav-link {{ request()->routeIs('admin.categories') ? 'active' : '' }}" href="{{ route('admin.categories') }}">
        <span class="nav-icon"><i class="bi bi-tags" aria-hidden="true"></i></span>
        <span class="nav-text">Kategori Inventaris</span>
      </a>
      <a class="nav-link {{ request()->routeIs('admin.inventory') ? 'active' : '' }}" href="{{ route('admin.inventory') }}">
        <span class="nav-icon"><i class="bi bi-box" aria-hidden="true"></i></span>
        <span class="nav-text">Inventaris</span>
      </a>

      <div class="nav-section-title mt-3 mb-1 px-3 text-muted small fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">PEMINJAMAN</div>
      <a class="nav-link {{ request()->routeIs('admin.requests') ? 'active' : '' }}" href="{{ route('admin.requests') }}">
        <span class="nav-icon"><i class="bi bi-inbox" aria-hidden="true"></i></span>
        <span class="nav-text">Semua Pengajuan</span>
      </a>

      <div class="nav-section-title mt-3 mb-1 px-3 text-muted small fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">LAPORAN</div>
      <a class="nav-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}" href="{{ route('admin.reports') }}">
        <span class="nav-icon"><i class="bi bi-file-earmark-pdf" aria-hidden="true"></i></span>
        <span class="nav-text">Peminjaman & Pengembalian</span>
      </a>

      <div class="nav-section-title mt-3 mb-1 px-3 text-muted small fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">ANALYTICS</div>
      <a class="nav-link {{ request()->routeIs('admin.statistics') ? 'active' : '' }}" href="{{ route('admin.statistics') }}">
        <span class="nav-icon"><i class="bi bi-bar-chart" aria-hidden="true"></i></span>
        <span class="nav-text">Statistik</span>
      </a>

      <div class="nav-section-title mt-3 mb-1 px-3 text-muted small fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">AKUN</div>
      <a class="nav-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}" href="{{ route('admin.profile') }}">
        <span class="nav-icon"><i class="bi bi-person" aria-hidden="true"></i></span>
        <span class="nav-text">Profil</span>
      </a>
      <a class="nav-link" href="{{ route('login') }}">
        <span class="nav-icon"><i class="bi bi-box-arrow-right text-danger" aria-hidden="true"></i></span>
        <span class="nav-text text-danger">Logout</span>
      </a>

    @elseif(request()->is('officer/*') || request()->is('officer'))
      <!-- PETUGAS MENU -->
      <a class="nav-link {{ request()->routeIs('officer.dashboard') ? 'active' : '' }}" href="{{ route('officer.dashboard') }}">
        <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
        <span class="nav-text">Dashboard</span>
      </a>

      <div class="nav-section-title mt-3 mb-1 px-3 text-muted small fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">INVENTARIS</div>
      <a class="nav-link {{ request()->routeIs('officer.inventory') ? 'active' : '' }}" href="{{ route('officer.inventory') }}">
        <span class="nav-icon"><i class="bi bi-box" aria-hidden="true"></i></span>
        <span class="nav-text">Daftar Inventaris</span>
      </a>

      <div class="nav-section-title mt-3 mb-1 px-3 text-muted small fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">PEMINJAMAN</div>
      <a class="nav-link {{ request()->routeIs('officer.incoming_requests') ? 'active' : '' }}" href="{{ route('officer.incoming_requests') }}">
        <span class="nav-icon"><i class="bi bi-inbox" aria-hidden="true"></i></span>
        <span class="nav-text">Pengajuan Masuk</span>
      </a>
      <a class="nav-link {{ request()->routeIs('officer.borrowed') ? 'active' : '' }}" href="{{ route('officer.borrowed') }}">
        <span class="nav-icon"><i class="bi bi-handbag" aria-hidden="true"></i></span>
        <span class="nav-text">Sedang Dipinjam</span>
      </a>
      <a class="nav-link {{ request()->routeIs('officer.returns') ? 'active' : '' }}" href="{{ route('officer.returns') }}">
        <span class="nav-icon"><i class="bi bi-arrow-return-left" aria-hidden="true"></i></span>
        <span class="nav-text">Pengembalian</span>
      </a>

      <div class="nav-section-title mt-3 mb-1 px-3 text-muted small fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">LAPORAN</div>
      <a class="nav-link {{ request()->routeIs('officer.reports') ? 'active' : '' }}" href="{{ route('officer.reports') }}">
        <span class="nav-icon"><i class="bi bi-file-earmark-pdf" aria-hidden="true"></i></span>
        <span class="nav-text">Laporan Peminjaman</span>
      </a>

      <div class="nav-section-title mt-3 mb-1 px-3 text-muted small fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">AKUN</div>
      <a class="nav-link {{ request()->routeIs('officer.profile') ? 'active' : '' }}" href="{{ route('officer.profile') }}">
        <span class="nav-icon"><i class="bi bi-person" aria-hidden="true"></i></span>
        <span class="nav-text">Profil</span>
      </a>
      <a class="nav-link" href="{{ route('login') }}">
        <span class="nav-icon"><i class="bi bi-box-arrow-right text-danger" aria-hidden="true"></i></span>
        <span class="nav-text text-danger">Logout</span>
      </a>

    @else
      <!-- MAHASISWA MENU -->
      <a class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}" href="{{ route('student.dashboard') }}">
        <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
        <span class="nav-text">Dashboard</span>
      </a>

      <div class="nav-section-title mt-3 mb-1 px-3 text-muted small fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">INVENTARIS</div>
      <a class="nav-link {{ request()->routeIs('student.inventory') ? 'active' : '' }}" href="{{ route('student.inventory') }}">
        <span class="nav-icon"><i class="bi bi-box" aria-hidden="true"></i></span>
        <span class="nav-text">Daftar Inventaris</span>
      </a>

      <div class="nav-section-title mt-3 mb-1 px-3 text-muted small fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">PEMINJAMAN</div>
      <a class="nav-link {{ request()->routeIs('student.borrow') ? 'active' : '' }}" href="{{ route('student.borrow') }}">
        <span class="nav-icon"><i class="bi bi-pencil-square" aria-hidden="true"></i></span>
        <span class="nav-text">Ajukan Peminjaman</span>
      </a>
      <a class="nav-link {{ request()->routeIs('student.my_borrowings') ? 'active' : '' }}" href="{{ route('student.my_borrowings') }}">
        <span class="nav-icon"><i class="bi bi-bag-check" aria-hidden="true"></i></span>
        <span class="nav-text">Peminjaman Saya</span>
      </a>
      <a class="nav-link {{ request()->routeIs('student.history') ? 'active' : '' }}" href="{{ route('student.history') }}">
        <span class="nav-icon"><i class="bi bi-clock-history" aria-hidden="true"></i></span>
        <span class="nav-text">Riwayat Peminjaman</span>
      </a>

      <div class="nav-section-title mt-3 mb-1 px-3 text-muted small fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">PENGEMBALIAN</div>
      <a class="nav-link {{ request()->routeIs('student.returns') ? 'active' : '' }}" href="{{ route('student.returns') }}">
        <span class="nav-icon"><i class="bi bi-arrow-return-left" aria-hidden="true"></i></span>
        <span class="nav-text">Ajukan Pengembalian</span>
      </a>

      <div class="nav-section-title mt-3 mb-1 px-3 text-muted small fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">DOKUMEN</div>
      <a class="nav-link {{ request()->routeIs('student.download_pdf') ? 'active' : '' }}" href="{{ route('student.download_pdf') }}">
        <span class="nav-icon"><i class="bi bi-file-earmark-arrow-down" aria-hidden="true"></i></span>
        <span class="nav-text">Download PDF</span>
      </a>

      <div class="nav-section-title mt-3 mb-1 px-3 text-muted small fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">AKUN</div>
      <a class="nav-link {{ request()->routeIs('student.profile') ? 'active' : '' }}" href="{{ route('student.profile') }}">
        <span class="nav-icon"><i class="bi bi-person" aria-hidden="true"></i></span>
        <span class="nav-text">Profil</span>
      </a>
      <a class="nav-link" href="{{ route('login') }}">
        <span class="nav-icon"><i class="bi bi-box-arrow-right text-danger" aria-hidden="true"></i></span>
        <span class="nav-text text-danger">Logout</span>
      </a>
    @endif
  </nav>

  <div class="sidebar-user">
    <img class="avatar-img avatar-md sidebar-user-avatar" src="{{ asset('assets/images/avatar/avatar.jpg') }}" alt="User">
    <strong>
      @if(request()->is('admin/*') || request()->is('admin')) Admin
      @elseif(request()->is('officer/*') || request()->is('officer')) Petugas
      @else Mahasiswa
      @endif
    </strong>
    <small>Online</small>
  </div>
</aside>
