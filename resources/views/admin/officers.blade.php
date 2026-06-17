@extends('layouts.app')

@section('title', 'Kelola Petugas - SIPINJAM')

@section('content')
<div class="page-heading d-flex justify-content-between align-items-center flex-wrap">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-person-badge" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Master Data</p>
      <h1 class="h3 mb-1">Kelola Petugas</h1>
      <p class="text-muted mb-0">Manajemen staf operasional inventaris kampus.</p>
    </div>
  </div>
  <button class="btn btn-primary mt-3 mt-md-0" data-bs-toggle="modal" data-bs-target="#addOfficerModal"><i class="bi bi-plus-lg"></i> Tambah Petugas</button>
</div>

<div class="panel shadow-sm">
  <div class="panel-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th class="ps-4">ID Pegawai</th>
            <th>Nama Lengkap</th>
            <th>Email</th>
            <th>Hak Akses</th>
            <th class="pe-4 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="ps-4 fw-semibold text-muted">PEG-998877</td>
            <td>Ahmad Petugas</td>
            <td>ahmad@kampus.ac.id</td>
            <td><span class="badge bg-primary">Operator</span></td>
            <td class="pe-4 text-end">
              <button class="btn btn-sm btn-light"><i class="bi bi-pencil"></i></button>
              <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah Petugas -->
<div class="modal fade" id="addOfficerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Petugas Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">ID Pegawai</label>
            <input type="text" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password Sementara</label>
            <input type="text" class="form-control" value="petugas123" readonly>
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
