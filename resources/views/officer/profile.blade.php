@extends('layouts.app')

@section('title', 'Profil Petugas - SIPINJAM')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-person" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Akun</p>
      <h1 class="h3 mb-1">Profil Petugas</h1>
      <p class="text-muted mb-0">Kelola akun operasional dan pengaturan akses Anda.</p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xl-4 col-lg-5 mb-4 mb-lg-0">
    <div class="panel shadow-sm text-center p-4">
      <div class="position-relative d-inline-block mb-3">
        <img src="{{ asset('assets/images/avatar/avatar.jpg') }}" alt="Profile" class="rounded-circle img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
        <button class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle" style="width: 32px; height: 32px; padding: 0;"><i class="bi bi-pencil"></i></button>
      </div>
      <h5 class="mb-1">Petugas Inventaris</h5>
      <p class="text-muted mb-3">petugas@kampus.ac.id</p>
      <span class="badge bg-primary px-3 py-2">Hak Akses: Operator</span>
    </div>
  </div>

  <div class="col-xl-8 col-lg-7">
    <div class="panel shadow-sm">
      <div class="panel-header border-bottom">
        <h5 class="panel-title mb-0">Data Petugas</h5>
      </div>
      <div class="panel-body">
        <form>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Nama Lengkap</label>
              <input type="text" class="form-control" value="Petugas Inventaris" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">ID Pegawai</label>
              <input type="text" class="form-control" value="PEG-998877" disabled>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-md-6">
              <label class="form-label">Email Operasional</label>
              <input type="email" class="form-control" value="petugas@kampus.ac.id" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Nomor HP</label>
              <input type="text" class="form-control" value="085566778899" required>
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Simpan Profil</button>
        </form>
      </div>
    </div>

    <div class="panel shadow-sm mt-4 border-top border-warning border-4">
      <div class="panel-header border-bottom">
        <h5 class="panel-title mb-0">Keamanan Akun</h5>
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
          <button type="submit" class="btn btn-warning">Perbarui Password</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
