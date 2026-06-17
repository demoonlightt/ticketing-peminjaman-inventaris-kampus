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
      </div>
      <h5 class="mb-1">{{ $user->name }}</h5>
      <p class="text-muted mb-3">{{ $user->email }}</p>
      <div class="d-flex justify-content-center gap-2">
        @if($user->status === 'active')
          <span class="badge bg-success bg-opacity-10 text-success border border-success">Akun Aktif</span>
        @else
          <span class="badge bg-danger bg-opacity-10 text-danger border border-danger">Ditangguhkan</span>
        @endif

        @php
          $unpaidFinesCount = \App\Models\Fine::whereHas('returnRecord.borrowRequest', function($q) {
              $q->where('student_id', Auth::id());
          })->where('paid_status', 'unpaid')->count();
        @endphp
        @if($unpaidFinesCount > 0)
          <span class="badge bg-danger bg-opacity-10 text-danger border border-danger">Ada Tanggungan Denda</span>
        @else
          <span class="badge bg-primary bg-opacity-10 text-primary border border-primary">Bebas Tanggungan</span>
        @endif
      </div>
    </div>
  </div>

  <div class="col-xl-8 col-lg-7">
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

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
        <h5 class="panel-title mb-0">Informasi Dasar & Keamanan</h5>
      </div>
      <div class="panel-body">
        <form action="{{ route('student.profile.update') }}" method="POST">
          @csrf
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="name" class="form-label">Nama Lengkap</label>
              <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="col-md-6">
              <label for="nim" class="form-label">NIM</label>
              <input type="text" id="nim" class="form-control" value="{{ $user->mahasiswaProfile->nim }}" disabled>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="email" class="form-label">Email Kampus</label>
              <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="col-md-6">
              <label for="angkatan" class="form-label">Angkatan</label>
              <input type="number" name="angkatan" id="angkatan" class="form-control" value="{{ old('angkatan', $user->mahasiswaProfile->angkatan) }}" required>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="fakultas" class="form-label">Fakultas</label>
              <input type="text" name="fakultas" id="fakultas" class="form-control" value="{{ old('fakultas', $user->mahasiswaProfile->fakultas) }}" required>
            </div>
            <div class="col-md-6">
              <label for="prodi" class="form-label">Program Studi</label>
              <input type="text" name="prodi" id="prodi" class="form-control" value="{{ old('prodi', $user->mahasiswaProfile->prodi) }}" required>
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
