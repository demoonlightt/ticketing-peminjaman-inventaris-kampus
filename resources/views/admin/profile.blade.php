@extends('layouts.app')

@section('title', 'Profil Admin - SIPINJAM')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-person" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Akun</p>
      <h1 class="h3 mb-1">Profil Administrator</h1>
      <p class="text-muted mb-0">Kelola pengaturan akun tertinggi Anda.</p>
    </div>
  </div>
</div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@if($errors->any())
  <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
    <ul class="mb-0">
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<div class="row">
  <div class="col-xl-4 col-lg-5 mb-4 mb-lg-0">
    <div class="panel shadow-sm text-center p-4">
      <div class="position-relative d-inline-block mb-3">
        <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 120px; height: 120px;">
          <i class="bi bi-shield-lock fs-1"></i>
        </div>
      </div>
      <h5 class="mb-1">{{ $user->name }}</h5>
      <p class="text-muted mb-3">{{ $user->email }}</p>
      <span class="badge bg-danger px-3 py-2">Hak Akses: Administrator</span>
    </div>
  </div>

  <div class="col-xl-8 col-lg-7">
    <div class="panel shadow-sm">
      <div class="panel-header border-bottom p-3">
        <h5 class="panel-title mb-0">Informasi Pribadi & Keamanan</h5>
      </div>
      <div class="panel-body p-4">
        <form action="{{ route('admin.profile.update') }}" method="POST">
          @csrf
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="name" class="form-label">Nama Lengkap</label>
              <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
            </div>
            <div class="col-md-6">
              <label for="email" class="form-label">Email Sistem</label>
              <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
            </div>
          </div>

          <hr class="my-4">

          <h6 class="mb-3 text-warning"><i class="bi bi-key me-1"></i> Ganti Password Utama</h6>
          <div class="row mb-4">
            <div class="col-md-6">
              <label for="password" class="form-label">Password Baru</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
            </div>
            <div class="col-md-6">
              <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
              <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi password baru">
            </div>
          </div>
          <button type="submit" class="btn btn-danger"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
