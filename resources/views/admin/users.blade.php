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
  <div class="mt-3 mt-md-0 d-flex gap-2">
    <input type="text" class="form-control" placeholder="Cari Nama/NIM..." style="max-width: 250px;">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class="bi bi-plus-lg"></i> Tambah User</button>
  </div>
</div>

<div class="panel shadow-sm">
  <div class="panel-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th class="ps-4">NIM</th>
            <th>Nama Lengkap</th>
            <th>Email</th>
            <th>Status</th>
            <th class="pe-4 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="ps-4 fw-semibold text-muted">12345601</td>
            <td>Budi Santoso</td>
            <td>budi@kampus.ac.id</td>
            <td><span class="badge bg-success">Aktif</span></td>
            <td class="pe-4 text-end">
              <div class="dropdown">
                <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">Aksi</button>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                  <li><a class="dropdown-item text-warning" href="#"><i class="bi bi-key me-2"></i> Reset Password</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-slash-circle me-2"></i> Suspend Akun</a></li>
                </ul>
              </div>
            </td>
          </tr>
          <tr>
            <td class="ps-4 fw-semibold text-muted">12345602</td>
            <td>Siti Aminah</td>
            <td>siti@kampus.ac.id</td>
            <td><span class="badge bg-success">Aktif</span></td>
            <td class="pe-4 text-end">
              <div class="dropdown">
                <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">Aksi</button>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                  <li><a class="dropdown-item text-warning" href="#"><i class="bi bi-key me-2"></i> Reset Password</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-slash-circle me-2"></i> Suspend Akun</a></li>
                </ul>
              </div>
            </td>
          </tr>
          <tr>
            <td class="ps-4 fw-semibold text-muted">12345699</td>
            <td>Reza Rahadian</td>
            <td>reza@kampus.ac.id</td>
            <td><span class="badge bg-danger">Banned</span></td>
            <td class="pe-4 text-end">
              <div class="dropdown">
                <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">Aksi</button>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item text-success" href="#"><i class="bi bi-check-circle me-2"></i> Pulihkan Akun</a></li>
                </ul>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Mahasiswa Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">NIM</label>
            <input type="text" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email Kampus</label>
            <input type="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password Default</label>
            <input type="text" class="form-control" value="mahasiswa123" readonly>
            <small class="text-muted">User dapat mengganti password setelah login.</small>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Simpan</button>
      </div>
    </div>
  </div>
</div>
@endsection
