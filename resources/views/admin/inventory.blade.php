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
  <div class="mt-3 mt-md-0 d-flex gap-2">
    <input type="text" class="form-control" placeholder="Cari..." style="max-width: 200px;">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addInventoryModal"><i class="bi bi-plus-lg"></i> Tambah Barang</button>
  </div>
</div>

<div class="panel shadow-sm">
  <div class="panel-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th class="ps-4">Kode</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th class="text-center">Stok Awal</th>
            <th>Kondisi Tersedia</th>
            <th class="pe-4 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="ps-4 fw-semibold text-muted">INV-ELK-001</td>
            <td>
              <div class="d-flex align-items-center">
                <div class="bg-light rounded p-2 me-2"><i class="bi bi-projector text-primary"></i></div>
                <span>Proyektor Epson EB-X05</span>
              </div>
            </td>
            <td>Elektronik</td>
            <td class="text-center">10</td>
            <td>
              <span class="badge bg-success bg-opacity-10 text-success border border-success">Baik: 8</span>
              <span class="badge bg-warning bg-opacity-10 text-warning border border-warning">Perawatan: 2</span>
            </td>
            <td class="pe-4 text-end">
              <button class="btn btn-sm btn-light"><i class="bi bi-pencil"></i></button>
              <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
            </td>
          </tr>
          <tr>
            <td class="ps-4 fw-semibold text-muted">INV-FOT-002</td>
            <td>
              <div class="d-flex align-items-center">
                <div class="bg-light rounded p-2 me-2"><i class="bi bi-camera text-primary"></i></div>
                <span>Kamera DSLR Canon EOS</span>
              </div>
            </td>
            <td>Fotografi</td>
            <td class="text-center">5</td>
            <td>
              <span class="badge bg-success bg-opacity-10 text-success border border-success">Baik: 5</span>
            </td>
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

<!-- Modal Tambah Inventaris -->
<div class="modal fade" id="addInventoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Inventaris</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Nama Barang</label>
              <input type="text" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Kategori</label>
              <select class="form-select" required>
                <option value="">Pilih Kategori...</option>
                <option value="ELK">Elektronik</option>
                <option value="FOT">Fotografi</option>
                <option value="AUD">Audio</option>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Jumlah Stok Awal</label>
              <input type="number" class="form-control" min="1" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Foto Barang</label>
              <input type="file" class="form-control" accept="image/*">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi & Spesifikasi</label>
            <textarea class="form-control" rows="3" placeholder="Tulis rincian spesifikasi barang..."></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Simpan Data</button>
      </div>
    </div>
  </div>
</div>
@endsection
