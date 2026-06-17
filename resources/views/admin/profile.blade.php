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

<div class="row">
  <div class="col-xl-4 col-lg-5 mb-4 mb-lg-0">
    <div class="panel shadow-sm text-center p-4">
      <div class="position-relative d-inline-block mb-3">
        <img src="{{ asset('assets/images/avatar/avatar.jpg') }}" alt="Profile" class="rounded-circle img-thumbnail border-danger" style="width: 120px; height: 120px; object-fit: cover; border-width: 3px;">
        <button class="btn btn-sm btn-danger position-absolute bottom-0 end-0 rounded-circle" style="width: 32px; height: 32px; padding: 0;"><i class="bi bi-pencil"></i></button>
      </div>
      <h5 class="mb-1">Super Admin</h5>
      <p class="text-muted mb-3">admin@kampus.ac.id</p>
      <span class="badge bg-danger px-3 py-2">Hak Akses: Administrator</span>
    </div>
  </div>

  <div class="col-xl-8 col-lg-7">
    <div class="panel shadow-sm">
      <div class="panel-header border-bottom">
        <h5 class="panel-title mb-0">Informasi Pribadi</h5>
      </div>
      <div class="panel-body">
        <form>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Nama Lengkap</label>
              <input type="text" class="form-control" value="Super Admin" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Email Sistem</label>
              <input type="email" class="form-control" value="admin@kampus.ac.id" disabled>
              <small class="text-muted">Email admin bersifat paten.</small>
            </div>
          </div>
          <button type="submit" class="btn btn-danger">Simpan Perubahan</button>
        </form>
      </div>
    </div>

    <div class="panel shadow-sm mt-4 border-top border-warning border-4">
      <div class="panel-header border-bottom">
        <h5 class="panel-title mb-0">Keamanan Akun Super</h5>
      </div>
      <div class="panel-body">
        <form>
          <div class="mb-3">
            <label class="form-label">Password Lama</label>
            <input type="password" class="form-control" required>
          </div>
          <div class="row mb-4">
            <div class="col-md-6">
              <label class="form-label">Password Baru</label>
              <input type="password" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Konfirmasi Password Baru</label>
              <input type="password" class="form-control" required>
            </div>
          </div>
          <button type="submit" class="btn btn-warning">Ganti Password Utama</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
