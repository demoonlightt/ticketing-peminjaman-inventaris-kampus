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
  <div class="mt-3 mt-md-0 d-flex gap-2">
    <form action="{{ route('admin.officers') }}" method="GET" class="d-flex gap-2">
      <input type="text" name="search" class="form-control" placeholder="Cari Nama/NIP..." value="{{ request('search') }}" style="max-width: 250px;">
      <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
    </form>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addOfficerModal"><i class="bi bi-plus-lg"></i> Tambah Petugas</button>
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

<div class="panel shadow-sm">
  <div class="panel-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th class="ps-4">ID Pegawai</th>
            <th>Nama Lengkap</th>
            <th>Email</th>
            <th>Divisi / Bagian</th>
            <th>Status</th>
            <th class="pe-4 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($officers as $o)
            <tr>
              <td class="ps-4 fw-semibold text-muted">{{ $o->officerProfile->employee_number ?? '-' }}</td>
              <td class="fw-semibold">{{ $o->name }}</td>
              <td>{{ $o->email }}</td>
              <td><span class="badge bg-primary">{{ $o->officerProfile->division ?? 'Operator' }}</span></td>
              <td>
                @if($o->status === 'active')
                  <span class="badge bg-success">Aktif</span>
                @else
                  <span class="badge bg-danger">Suspended</span>
                @endif
              </td>
              <td class="pe-4 text-end">
                <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#editOfficerModal-{{ $o->id }}"><i class="bi bi-pencil"></i> Edit</button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center py-4 text-muted">Tidak ada petugas terdaftar.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah Petugas -->
<div class="modal fade" id="addOfficerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Petugas Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.officers.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="add_name" class="form-label">Nama Lengkap</label>
            <input type="text" name="name" id="add_name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="add_employee_number" class="form-label">ID Pegawai / NIP</label>
            <input type="text" name="employee_number" id="add_employee_number" class="form-control" placeholder="PEG-XXXXXX" required>
          </div>
          <div class="mb-3">
            <label for="add_email" class="form-label">Email</label>
            <input type="email" name="email" id="add_email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="add_division" class="form-label">Divisi / Bagian</label>
            <input type="text" name="division" id="add_division" class="form-control" placeholder="Operator Inventaris" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password Sementara</label>
            <input type="text" class="form-control text-muted" value="petugas123" readonly>
            <small class="text-muted">Petugas dapat memperbarui password setelah melakukan login.</small>
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

@foreach($officers as $o)
  <!-- Modal Edit Petugas #{{ $o->id }} -->
  <div class="modal fade" id="editOfficerModal-{{ $o->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Data Petugas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form action="{{ route('admin.officers.update', $o->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-body">
            <div class="mb-3">
              <label for="edit_name-{{ $o->id }}" class="form-label">Nama Lengkap</label>
              <input type="text" name="name" id="edit_name-{{ $o->id }}" class="form-control" value="{{ $o->name }}" required>
            </div>
            <div class="mb-3">
              <label for="edit_employee_number-{{ $o->id }}" class="form-label">ID Pegawai / NIP</label>
              <input type="text" name="employee_number" id="edit_employee_number-{{ $o->id }}" class="form-control" value="{{ $o->officerProfile->employee_number ?? '' }}" required>
            </div>
            <div class="mb-3">
              <label for="edit_email-{{ $o->id }}" class="form-label">Email</label>
              <input type="email" name="email" id="edit_email-{{ $o->id }}" class="form-control" value="{{ $o->email }}" required>
            </div>
            <div class="mb-3">
              <label for="edit_division-{{ $o->id }}" class="form-label">Divisi / Bagian</label>
              <input type="text" name="division" id="edit_division-{{ $o->id }}" class="form-control" value="{{ $o->officerProfile->division ?? '' }}" required>
            </div>
            <div class="mb-3">
              <label for="edit_status-{{ $o->id }}" class="form-label">Status Akun</label>
              <select name="status" id="edit_status-{{ $o->id }}" class="form-select" required>
                <option value="active" {{ $o->status === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="suspended" {{ $o->status === 'suspended' ? 'selected' : '' }}>Suspended</option>
              </select>
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
