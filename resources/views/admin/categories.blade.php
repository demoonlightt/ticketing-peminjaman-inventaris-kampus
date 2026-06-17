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

<div class="row">
  <div class="col-md-8">
    <div class="panel shadow-sm">
      <div class="panel-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="ps-4">Kode Kategori</th>
                <th>Nama Kategori</th>
                <th>Total Barang</th>
                <th class="pe-4 text-end">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="ps-4 fw-semibold text-muted">ELK</td>
                <td>Elektronik</td>
                <td><span class="badge bg-secondary">45 item</span></td>
                <td class="pe-4 text-end">
                  <button class="btn btn-sm btn-light"><i class="bi bi-pencil"></i></button>
                  <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                </td>
              </tr>
              <tr>
                <td class="ps-4 fw-semibold text-muted">FOT</td>
                <td>Fotografi</td>
                <td><span class="badge bg-secondary">12 item</span></td>
                <td class="pe-4 text-end">
                  <button class="btn btn-sm btn-light"><i class="bi bi-pencil"></i></button>
                  <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                </td>
              </tr>
              <tr>
                <td class="ps-4 fw-semibold text-muted">AUD</td>
                <td>Audio</td>
                <td><span class="badge bg-secondary">20 item</span></td>
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
  </div>
</div>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Kategori</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label class="form-label">Kode Kategori (Maks 3 Huruf)</label>
            <input type="text" class="form-control text-uppercase" maxlength="3" placeholder="Contoh: ELK" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Nama Kategori</label>
            <input type="text" class="form-control" placeholder="Contoh: Elektronik" required>
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
