@extends('layouts.app')

@section('title', 'Kategori Inventaris - SIPINJAM')

@section('content')
<div class="page-heading d-flex justify-content-between align-items-center flex-wrap">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-tags" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Master Data</p>
      <h1 class="h3 mb-1">Kategori Inventaris</h1>
      <p class="text-muted mb-0">Kelola kategori untuk mengklasifikasikan barang inventaris.</p>
    </div>
  </div>
  <button class="btn btn-primary mt-3 mt-md-0" data-bs-toggle="modal" data-bs-target="#addCategoryModal"><i class="bi bi-plus-lg"></i> Tambah Kategori</button>
</div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif
@if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif
@if($errors->any())
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul class="mb-0">
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<div class="row g-4">
  <div class="col-md-8">
    <div class="panel shadow-sm">
      <div class="panel-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="ps-4">ID</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Total Barang</th>
                <th class="pe-4 text-end">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($categories as $cat)
                <tr>
                  <td class="ps-4 fw-semibold text-muted">#{{ $cat->id }}</td>
                  <td class="fw-semibold">{{ $cat->name }}</td>
                  <td class="text-muted">{{ $cat->description ?? '-' }}</td>
                  <td><span class="badge bg-secondary">{{ $cat->inventories_count }} item</span></td>
                  <td class="pe-4 text-end">
                    <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#editCategoryModal-{{ $cat->id }}"><i class="bi bi-pencil"></i></button>
                    <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center py-4 text-muted">Belum ada kategori terdaftar.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Kategori Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="add_name" class="form-label">Nama Kategori</label>
            <input type="text" name="name" id="add_name" class="form-control" placeholder="Contoh: Elektronik" required>
          </div>
          <div class="mb-3">
            <label for="add_description" class="form-label">Deskripsi</label>
            <textarea name="description" id="add_description" class="form-control" rows="3" placeholder="Deskripsi singkat kategori..."></textarea>
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

@foreach($categories as $cat)
  <!-- Modal Edit Kategori #{{ $cat->id }} -->
  <div class="modal fade" id="editCategoryModal-{{ $cat->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Kategori</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form action="{{ route('admin.categories.update', $cat->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-body">
            <div class="mb-3">
              <label for="edit_name-{{ $cat->id }}" class="form-label">Nama Kategori</label>
              <input type="text" name="name" id="edit_name-{{ $cat->id }}" class="form-control" value="{{ $cat->name }}" required>
            </div>
            <div class="mb-3">
              <label for="edit_description-{{ $cat->id }}" class="form-label">Deskripsi</label>
              <textarea name="description" id="edit_description-{{ $cat->id }}" class="form-control" rows="3">{{ $cat->description }}</textarea>
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
