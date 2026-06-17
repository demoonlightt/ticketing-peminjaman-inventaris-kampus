@extends('layouts.app')

@section('title', 'Kelola User/Mahasiswa - SIPINJAM')

@section('content')
<div class="page-heading d-flex justify-content-between align-items-center flex-wrap">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Master Data</p>
      <h1 class="h3 mb-1">Kelola Mahasiswa</h1>
      <p class="text-muted mb-0">Daftar pengguna (mahasiswa) yang terdaftar di aplikasi.</p>
    </div>
  </div>
  <form action="{{ route('admin.users') }}" method="GET" class="mt-3 mt-md-0 d-flex gap-2">
    <input type="text" name="search" class="form-control" placeholder="Cari Nama/NIM..." value="{{ request('search') }}" style="max-width: 250px;">
    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class="bi bi-plus-lg"></i> Tambah Mahasiswa</button>
  </form>
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
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<div class="panel shadow-sm">
  <div class="panel-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th class="ps-4">NIM</th>
            <th>Nama Lengkap</th>
            <th>Email</th>
            <th>Program Studi / Fakultas</th>
            <th>Status</th>
            <th class="pe-4 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $u)
            <tr>
              <td class="ps-4 fw-semibold text-muted">{{ $u->mahasiswaProfile->nim ?? '-' }}</td>
              <td>{{ $u->name }}</td>
              <td>{{ $u->email }}</td>
              <td>
                {{ $u->mahasiswaProfile->prodi ?? '-' }}<br>
                <small class="text-muted">{{ $u->mahasiswaProfile->fakultas ?? '-' }} ({{ $u->mahasiswaProfile->angkatan ?? '-' }})</small>
              </td>
              <td>
                @if($u->status === 'active')
                  <span class="badge bg-success">Aktif</span>
                @else
                  <span class="badge bg-danger">Suspended</span>
                @endif
              </td>
              <td class="pe-4 text-end">
                <div class="dropdown">
                  <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">Aksi</button>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $u->id }}"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                    <li>
                      <form action="{{ route('admin.users.reset-password', $u->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="dropdown-item text-warning" onclick="return confirm('Apakah Anda yakin ingin me-reset password mahasiswa ini?')"><i class="bi bi-key me-2"></i> Reset Password</button>
                      </form>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                      <form action="{{ route('admin.users.toggle-status', $u->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @if($u->status === 'active')
                          <button type="submit" class="dropdown-item text-danger"><i class="bi bi-slash-circle me-2"></i> Suspend Akun</button>
                        @else
                          <button type="submit" class="dropdown-item text-success"><i class="bi bi-check-circle me-2"></i> Aktifkan Akun</button>
                        @endif
                      </form>
                    </li>
                  </ul>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center py-4 text-muted">Tidak ada data mahasiswa ditemukan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Mahasiswa Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="add_name" class="form-label">Nama Lengkap</label>
            <input type="text" name="name" id="add_name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="add_nim" class="form-label">NIM</label>
            <input type="text" name="nim" id="add_nim" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="add_email" class="form-label">Email Kampus</label>
            <input type="email" name="email" id="add_email" class="form-control" required>
          </div>
          <div class="row mb-3">
            <div class="col-6">
              <label for="add_prodi" class="form-label">Prodi</label>
              <input type="text" name="prodi" id="add_prodi" class="form-control" placeholder="Teknik Informatika" required>
            </div>
            <div class="col-6">
              <label for="add_fakultas" class="form-label">Fakultas</label>
              <input type="text" name="fakultas" id="add_fakultas" class="form-control" placeholder="Fakultas Teknik" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="add_angkatan" class="form-label">Angkatan</label>
            <input type="number" name="angkatan" id="add_angkatan" class="form-control" placeholder="2024" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password Default</label>
            <input type="text" class="form-control text-muted" value="mahasiswa123" readonly>
            <small class="text-muted">Mahasiswa dapat merubah password ini secara mandiri di halaman profil.</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

@foreach($users as $u)
  <!-- Modal Edit User #{{ $u->id }} -->
  <div class="modal fade" id="editUserModal-{{ $u->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Data Mahasiswa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form action="{{ route('admin.users.update', $u->id) }}" method="POST">
          @csrf
          <div class="modal-body">
            <div class="mb-3">
              <label for="edit_name-{{ $u->id }}" class="form-label">Nama Lengkap</label>
              <input type="text" name="name" id="edit_name-{{ $u->id }}" class="form-control" value="{{ $u->name }}" required>
            </div>
            <div class="mb-3">
              <label for="edit_nim-{{ $u->id }}" class="form-label">NIM</label>
              <input type="text" name="nim" id="edit_nim-{{ $u->id }}" class="form-control" value="{{ $u->mahasiswaProfile->nim ?? '' }}" required>
            </div>
            <div class="mb-3">
              <label for="edit_email-{{ $u->id }}" class="form-label">Email Kampus</label>
              <input type="email" name="email" id="edit_email-{{ $u->id }}" class="form-control" value="{{ $u->email }}" required>
            </div>
            <div class="row mb-3">
              <div class="col-6">
                <label for="edit_prodi-{{ $u->id }}" class="form-label">Prodi</label>
                <input type="text" name="prodi" id="edit_prodi-{{ $u->id }}" class="form-control" value="{{ $u->mahasiswaProfile->prodi ?? '' }}" required>
              </div>
              <div class="col-6">
                <label for="edit_fakultas-{{ $u->id }}" class="form-label">Fakultas</label>
                <input type="text" name="fakultas" id="edit_fakultas-{{ $u->id }}" class="form-control" value="{{ $u->mahasiswaProfile->fakultas ?? '' }}" required>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-6">
                <label for="edit_angkatan-{{ $u->id }}" class="form-label">Angkatan</label>
                <input type="number" name="angkatan" id="edit_angkatan-{{ $u->id }}" class="form-control" value="{{ $u->mahasiswaProfile->angkatan ?? '' }}" required>
              </div>
              <div class="col-6">
                <label for="edit_status-{{ $u->id }}" class="form-label">Status Akun</label>
                <select name="status" id="edit_status-{{ $u->id }}" class="form-select" required>
                  <option value="active" {{ $u->status === 'active' ? 'selected' : '' }}>Aktif</option>
                  <option value="suspended" {{ $u->status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endforeach
@endsection
