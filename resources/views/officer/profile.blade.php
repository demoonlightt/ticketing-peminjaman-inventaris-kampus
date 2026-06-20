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
        @if($user->avatar)
          <img src="{{ $user->getAvatarUrl() }}" alt="Profile" class="rounded-circle img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
        @else
          <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto text-white fw-bold shadow-sm" style="width: 120px; height: 120px; font-size: 2.5rem; background: linear-gradient(135deg, var(--bs-primary), #6f42c1);">
            {{ $user->getInitials() }}
          </div>
        @endif
      </div>
      <h5 class="mb-1">{{ $user->name }}</h5>
      <p class="text-muted mb-3">{{ $user->email }}</p>
      <span class="badge bg-primary px-3 py-2">Hak Akses: {{ $user->officerProfile->division ?? 'Operator' }}</span>
    </div>
  </div>

  <div class="col-xl-8 col-lg-7">

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

    <div class="panel shadow-sm">
      <div class="panel-header border-bottom">
        <h5 class="panel-title mb-0">Data Diri & Keamanan Akun</h5>
      </div>
      <div class="panel-body">
        <form action="{{ route('officer.profile.update') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label for="avatar" class="form-label">Unggah Foto Profil Baru</label>
            <input type="file" name="avatar" id="avatar" class="form-control" accept="image/*">
            <small class="text-muted">Format: JPG, PNG, GIF (Maks. 2MB). Kosongkan jika tidak ingin diubah.</small>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="name" class="form-label">Nama Lengkap</label>
              <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="col-md-6">
              <label for="employee_number" class="form-label font-semibold">NIP / ID Pegawai</label>
              <input type="text" name="employee_number" id="employee_number" class="form-control" value="{{ old('employee_number', $user->officerProfile->employee_number) }}" required>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="email" class="form-label">Email Operasional</label>
              <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="col-md-6">
              <label for="division" class="form-label">Divisi / Bagian</label>
              <input type="text" name="division" id="division" class="form-control" value="{{ old('division', $user->officerProfile->division) }}" required>
            </div>
          </div>

          <hr class="my-4">

          <h6 class="mb-3 text-primary"><i class="bi bi-shield-lock me-2"></i>Ganti Password (Kosongkan jika tidak ingin diubah)</h6>
          
          <div class="row mb-4">
            <div class="col-md-6">
              <label for="password" class="form-label">Password Baru</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="Minimal 8 karakter">
            </div>
            <div class="col-md-6">
              <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
              <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi password baru">
            </div>
          </div>

          <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
