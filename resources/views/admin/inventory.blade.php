@extends('layouts.app')

@section('title', 'Kelola Inventaris - SIPINJAM')

@section('content')
<div class="page-heading d-flex justify-content-between align-items-center flex-wrap">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-box" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Master Data</p>
      <h1 class="h3 mb-1">Kelola Inventaris</h1>
      <p class="text-muted mb-0">Basis data master seluruh aset barang kampus.</p>
    </div>
  </div>
  <form action="{{ route('admin.inventory') }}" method="GET" class="mt-3 mt-md-0 d-flex gap-2">
    <input type="text" name="search" class="form-control" placeholder="Cari barang/kode..." value="{{ request('search') }}" style="max-width: 200px;">
    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addInventoryModal"><i class="bi bi-plus-lg"></i> Tambah Barang</button>
  </form>
</div>


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
            <th class="ps-4">Kode</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th class="text-center">Total Stok</th>
            <th class="text-center">Tersedia</th>
            <th>Lokasi</th>
            <th>Kondisi</th>
            <th class="pe-4 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($inventories as $inv)
            <tr>
              <td class="ps-4 fw-semibold text-muted">{{ $inv->code }}</td>
              <td>
                <div class="d-flex align-items-center">
                  @if($inv->image)
                    <img src="{{ asset('storage/' . $inv->image) }}" alt="{{ $inv->name }}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                  @else
                    <div class="bg-light rounded p-2 me-2" style="width: 40px; height: 40px; display:flex; align-items:center; justify-content:center;">
                      <i class="bi bi-box text-primary"></i>
                    </div>
                  @endif
                  <span class="fw-semibold">{{ $inv->name }}</span>
                </div>
              </td>
              <td>{{ $inv->category->name }}</td>
              <td class="text-center">{{ $inv->total_stock }}</td>
              <td class="text-center">
                <span class="badge bg-success">{{ $inv->available_stock }}</span>
              </td>
              <td>{{ $inv->location }}</td>
              <td>
                @if($inv->condition === 'baik')
                  <span class="badge bg-success bg-opacity-10 text-success border border-success">Baik</span>
                @elseif($inv->condition === 'rusak_ringan')
                  <span class="badge bg-warning bg-opacity-10 text-warning border border-warning text-dark">Rusak Ringan</span>
                @elseif($inv->condition === 'rusak_berat')
                  <span class="badge bg-danger bg-opacity-10 text-danger border border-danger">Rusak Berat</span>
                @endif
              </td>
              <td class="pe-4 text-end">
                <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#editInventoryModal-{{ $inv->id }}"><i class="bi bi-pencil"></i></button>
                <form action="{{ route('admin.inventory.destroy', $inv->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center py-4 text-muted">Belum ada barang terdaftar.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah Inventaris -->
<div class="modal fade" id="addInventoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Inventaris</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.inventory.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="add_name" class="form-label">Nama Barang</label>
              <input type="text" name="name" id="add_name" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="add_category" class="form-label">Kategori</label>
              <select name="category_id" id="add_category" class="form-select" required>
                <option value="">Pilih Kategori...</option>
                @foreach($categories as $cat)
                  <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="add_code" class="form-label">Kode Inventaris (Unique)</label>
              <input type="text" name="code" id="add_code" class="form-control" placeholder="Contoh: INV-ELK-001" required>
            </div>
            <div class="col-md-6">
              <label for="add_location" class="form-label">Lokasi Penyimpanan</label>
              <input type="text" name="location" id="add_location" class="form-control" placeholder="Gedung D, Lab Komputer" required>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-4">
              <label for="add_stock" class="form-label">Jumlah Stok Awal</label>
              <input type="number" name="total_stock" id="add_stock" class="form-control" min="1" required>
            </div>
            <div class="col-md-4">
              <label for="add_condition" class="form-label">Kondisi Fisik</label>
              <select name="condition" id="add_condition" class="form-select" required>
                <option value="baik">Baik</option>
                <option value="rusak_ringan">Rusak Ringan</option>
                <option value="rusak_berat">Rusak Berat</option>
              </select>
            </div>
            <div class="col-md-4">
              <label for="add_image" class="form-label">Foto Barang</label>
              <input type="file" name="image" id="add_image" class="form-control" accept="image/*">
            </div>
          </div>
          <div class="mb-3">
            <label for="add_desc" class="form-label">Deskripsi & Spesifikasi</label>
            <textarea name="description" id="add_desc" class="form-control" rows="3" placeholder="Tulis rincian spesifikasi barang..."></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Data</button>
        </div>
      </form>
    </div>
  </div>
</div>

@foreach($inventories as $inv)
  <!-- Modal Edit Inventaris #{{ $inv->id }} -->
  <div class="modal fade" id="editInventoryModal-{{ $inv->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Data Inventaris: {{ $inv->name }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form action="{{ route('admin.inventory.update', $inv->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="modal-body">
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="edit_name-{{ $inv->id }}" class="form-label">Nama Barang</label>
                <input type="text" name="name" id="edit_name-{{ $inv->id }}" class="form-control" value="{{ $inv->name }}" required>
              </div>
              <div class="col-md-6">
                <label for="edit_category-{{ $inv->id }}" class="form-label">Kategori</label>
                <select name="category_id" id="edit_category-{{ $inv->id }}" class="form-select" required>
                  @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $inv->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="edit_code-{{ $inv->id }}" class="form-label">Kode Inventaris</label>
                <input type="text" name="code" id="edit_code-{{ $inv->id }}" class="form-control" value="{{ $inv->code }}" required>
              </div>
              <div class="col-md-6">
                <label for="edit_location-{{ $inv->id }}" class="form-label">Lokasi Penyimpanan</label>
                <input type="text" name="location" id="edit_location-{{ $inv->id }}" class="form-control" value="{{ $inv->location }}" required>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-4">
                <label for="edit_stock-{{ $inv->id }}" class="form-label">Total Stok</label>
                <input type="number" name="total_stock" id="edit_stock-{{ $inv->id }}" class="form-control" value="{{ $inv->total_stock }}" min="0" required>
              </div>
              <div class="col-md-4">
                <label for="edit_condition-{{ $inv->id }}" class="form-label">Kondisi Fisik</label>
                <select name="condition" id="edit_condition-{{ $inv->id }}" class="form-select" required>
                  <option value="baik" {{ $inv->condition === 'baik' ? 'selected' : '' }}>Baik</option>
                  <option value="rusak_ringan" {{ $inv->condition === 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                  <option value="rusak_berat" {{ $inv->condition === 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                </select>
              </div>
              <div class="col-md-4">
                <label for="edit_image-{{ $inv->id }}" class="form-label">Foto Barang (Ganti)</label>
                <input type="file" name="image" id="edit_image-{{ $inv->id }}" class="form-control" accept="image/*">
              </div>
            </div>
            <div class="mb-3">
              <label for="edit_desc-{{ $inv->id }}" class="form-label">Deskripsi & Spesifikasi</label>
              <textarea name="description" id="edit_desc-{{ $inv->id }}" class="form-control" rows="3">{{ $inv->description }}</textarea>
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
