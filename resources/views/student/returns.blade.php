@extends('layouts.app')

@section('title', 'Ajukan Pengembalian - SIPINJAM')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-arrow-return-left" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Mahasiswa</p>
      <h1 class="h3 mb-1">Ajukan Pengembalian</h1>
      <p class="text-muted mb-0">Beri tahu petugas bahwa Anda akan mengembalikan barang hari ini.</p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="panel shadow-sm">
      <div class="panel-header border-bottom">
        <h5 class="panel-title mb-0">Barang yang Harus Dikembalikan</h5>
      </div>
      <div class="panel-body">
        <div class="d-flex border p-3 rounded mb-3 align-items-center">
          <div class="bg-light p-3 rounded me-3 text-primary">
            <i class="bi bi-camera fs-3"></i>
          </div>
          <div class="flex-grow-1">
            <h6 class="mb-1">Tripod Kamera Takara</h6>
            <p class="text-muted small mb-0">No. Tiket: #REQ-0992</p>
            <p class="text-muted small mb-0">Batas Kembali: 15 Jun 2026</p>
          </div>
          <div>
            <span class="badge bg-danger mb-2 d-block">Terlambat 2 Hari</span>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#returnModal">Kembalikan</button>
          </div>
        </div>

        <div class="d-flex border p-3 rounded align-items-center">
          <div class="bg-light p-3 rounded me-3 text-primary">
            <i class="bi bi-laptop fs-3"></i>
          </div>
          <div class="flex-grow-1">
            <h6 class="mb-1">Macbook Pro M1 2020</h6>
            <p class="text-muted small mb-0">No. Tiket: #REQ-1010</p>
            <p class="text-muted small mb-0">Batas Kembali: 25 Jun 2026</p>
          </div>
          <div>
            <span class="badge bg-success bg-opacity-10 text-success border border-success mb-2 d-block">Waktu Tersisa: 8 Hari</span>
            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#returnModal">Kembalikan Cepat</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Ajukan Kembali -->
<div class="modal fade" id="returnModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi Pengembalian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Apakah Anda yakin akan menyerahkan barang ini ke petugas inventaris sekarang?</p>
        <div class="mb-3">
          <label class="form-label">Catatan Kondisi Barang (Opsional)</label>
          <textarea class="form-control" rows="2" placeholder="Cth: Barang aman, tidak ada cacat..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Kirim Notifikasi ke Petugas</button>
      </div>
    </div>
  </div>
</div>
@endsection
