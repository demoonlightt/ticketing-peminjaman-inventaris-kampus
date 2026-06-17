@extends('layouts.app')

@section('title', 'Profil Saya - SIPINJAM')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-person" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Akun</p>
      <h1 class="h3 mb-1">Profil Saya</h1>
      <p class="text-muted mb-0">Kelola informasi data diri dan keamanan akun Anda.</p>
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
      <h5 class="mb-1">Mahasiswa</h5>
      <p class="text-muted mb-3">mahasiswa@kampus.ac.id</p>
      <div class="d-flex justify-content-center gap-2">
        <span class="badge bg-success bg-opacity-10 text-success border border-success">Akun Aktif</span>
        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary">Bebas Tanggungan</span>
      </div>
    </div>
  </div>

  <div class="col-xl-8 col-lg-7">
    <div class="panel shadow-sm">
      <div class="panel-header border-bottom">
        <h5 class="panel-title mb-0">Informasi Dasar</h5>
      </div>
      <div class="panel-body">
        <form>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Nama Lengkap</label>
              <input type="text" class="form-control" value="Mahasiswa" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">NIM</label>
              <input type="text" class="form-control" value="1234567890" disabled>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Email Kampus</label>
              <input type="email" class="form-control" value="mahasiswa@kampus.ac.id" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Nomor HP / WhatsApp</label>
              <input type="text" class="form-control" value="081234567890" required>
            </div>
          </div>
          <div class="mb-4">
            <label class="form-label">Fakultas / Program Studi</label>
            <input type="text" class="form-control" value="Fakultas Ilmu Komputer / Teknik Informatika" required>
          </div>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
      </div>
    </div>

    <div class="panel shadow-sm mt-4">
      <div class="panel-header border-bottom">
        <h5 class="panel-title mb-0">Ganti Password</h5>
      </div>
      <div class="panel-body">
        <form>
          <div class="mb-3">
            <label class="form-label">Password Saat Ini</label>
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
