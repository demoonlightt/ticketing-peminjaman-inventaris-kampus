@extends('layouts.app')

@section('title', 'Laporan - SIPINJAM')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-file-earmark-pdf" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Laporan</p>
      <h1 class="h3 mb-1">Laporan Transaksi</h1>
      <p class="text-muted mb-0">Kelola dan export data laporan peminjaman serta pengembalian inventaris.</p>
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-md-6">
    <div class="panel h-100 border-top border-primary border-4">
      <div class="panel-body text-center p-5">
        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
          <i class="bi bi-journal-arrow-up fs-1"></i>
        </div>
        <h4 class="mb-2">Laporan Peminjaman</h4>
        <p class="text-muted mb-4">Export data seluruh barang yang dipinjam dalam rentang waktu tertentu.</p>
        
        <form action="#" method="GET" class="text-start">
          <div class="row mb-3">
            <div class="col-6">
              <label class="form-label">Dari Tanggal</label>
              <input type="date" class="form-control" required>
            </div>
            <div class="col-6">
              <label class="form-label">Sampai Tanggal</label>
              <input type="date" class="form-control" required>
            </div>
          </div>
          <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary"><i class="bi bi-download me-2"></i>Export PDF</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="panel h-100 border-top border-success border-4">
      <div class="panel-body text-center p-5">
        <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
          <i class="bi bi-journal-arrow-down fs-1"></i>
        </div>
        <h4 class="mb-2">Laporan Pengembalian</h4>
        <p class="text-muted mb-4">Export data seluruh barang yang telah dikembalikan beserta status kondisinya.</p>
        
        <form action="#" method="GET" class="text-start">
          <div class="row mb-3">
            <div class="col-6">
              <label class="form-label">Dari Tanggal</label>
              <input type="date" class="form-control" required>
            </div>
            <div class="col-6">
              <label class="form-label">Sampai Tanggal</label>
              <input type="date" class="form-control" required>
            </div>
          </div>
          <div class="d-grid mt-4">
            <button type="submit" class="btn btn-success"><i class="bi bi-download me-2"></i>Export PDF</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
