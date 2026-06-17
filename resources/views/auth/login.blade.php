@extends('layouts.auth')

@section('title', 'Login - SIPINJAM')

@section('content')
<div class="card shadow-sm border-0 rounded-3">
  <div class="card-body p-4 p-md-5">
    <div class="text-center mb-4">
      <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
        <i class="bi bi-box-seam fs-2"></i>
      </div>
      <h3 class="fw-bold mb-1">Selamat Datang!</h3>
      <p class="text-muted">Login ke SIPINJAM (Sistem Informasi Peminjaman Inventaris Kampus)</p>
    </div>

    <form action="{{ route('student.dashboard') }}" method="GET">
      <div class="mb-3">
        <label for="email" class="form-label">Email Kampus</label>
        <input type="email" class="form-control" id="email" placeholder="mahasiswa@kampus.ac.id" required>
      </div>
      
      <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center">
          <label for="password" class="form-label">Password</label>
          <a href="#" class="text-decoration-none small">Lupa password?</a>
        </div>
        <input type="password" class="form-control" id="password" placeholder="••••••••" required>
      </div>

      <div class="mb-4 form-check">
        <input type="checkbox" class="form-check-input" id="remember">
        <label class="form-check-label" for="remember">Ingat saya</label>
      </div>

      <div class="d-grid gap-2 mb-3">
        <button type="submit" class="btn btn-primary py-2">Log In</button>
      </div>
    </form>

    <div class="d-flex align-items-center my-4">
      <hr class="flex-grow-1">
      <span class="px-3 text-muted small">ATAU</span>
      <hr class="flex-grow-1">
    </div>

    <div class="d-grid gap-2 mb-4">
      <a href="{{ route('student.dashboard') }}" class="btn btn-outline-dark py-2 d-flex align-items-center justify-content-center">
        <i class="bi bi-google text-danger me-2"></i> Login dengan Google
      </a>
    </div>

    <p class="text-center text-muted mb-0">Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">Daftar sekarang</a></p>
  </div>
</div>
@endsection
