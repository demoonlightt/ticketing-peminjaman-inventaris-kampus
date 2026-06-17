@extends('layouts.auth')

@section('title', 'Sign Up - SIPINJAM')

@section('content')
<div class="card shadow-sm border-0 rounded-3 my-4">
  <div class="card-body p-4 p-md-5">
    <div class="text-center mb-4">
      <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
        <i class="bi bi-person-plus fs-2"></i>
      </div>
      <h3 class="fw-bold mb-1">Buat Akun Mahasiswa</h3>
      <p class="text-muted">Daftar untuk mulai meminjam inventaris kampus</p>
    </div>

    <div class="d-grid gap-2 mb-4">
      <a href="{{ route('auth.google') }}" class="btn btn-outline-dark py-2 d-flex align-items-center justify-content-center">
        <i class="bi bi-google text-danger me-2"></i> Daftar dengan Google
      </a>
    </div>

    <div class="d-flex align-items-center my-4">
      <hr class="flex-grow-1">
      <span class="px-3 text-muted small">ATAU DENGAN EMAIL</span>
      <hr class="flex-grow-1">
    </div>

    @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label for="name" class="form-label">Nama Lengkap</label>
        <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" placeholder="John Doe" required>
      </div>

      <div class="mb-3">
        <label for="nim" class="form-label">NIM (Nomor Induk Mahasiswa)</label>
        <input type="text" name="nim" class="form-control" id="nim" value="{{ old('nim') }}" placeholder="1234567890" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email Kampus</label>
        <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" placeholder="mahasiswa@kampus.ac.id" required>
      </div>
      
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="password" placeholder="Minimal 8 karakter" required>
      </div>

      <div class="mb-4 form-check">
        <input type="checkbox" class="form-check-input" id="terms" required>
        <label class="form-check-label small text-muted" for="terms">Saya menyetujui syarat & ketentuan peminjaman inventaris</label>
      </div>

      <div class="d-grid gap-2 mb-3">
        <button type="submit" class="btn btn-primary py-2">Sign Up</button>
      </div>
    </form>

    <p class="text-center text-muted mb-0 mt-4">Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Login di sini</a></p>
  </div>
</div>
@endsection
