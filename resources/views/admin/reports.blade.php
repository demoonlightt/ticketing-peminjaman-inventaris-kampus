@extends('layouts.app')

@section('title', 'Laporan & Export - SIPINJAM')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-file-earmark-pdf" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Administrator</p>
      <h1 class="h3 mb-1">Laporan & Dokumen</h1>
      <p class="text-muted mb-0">Unduh laporan operasional, statistik, dan rekap data inventaris.</p>
    </div>
  </div>
</div>

<div class="row g-4">
  <!-- Semua Laporan -->
  <div class="col-md-4">
    <div class="panel h-100 border-top border-primary border-4 shadow-sm">
      <div class="panel-body text-center p-4">
        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 72px; height: 72px;">
          <i class="bi bi-journal-check fs-2"></i>
        </div>
        <h5 class="mb-2">Semua Laporan</h5>
        <p class="text-muted small mb-4">Export komprehensif riwayat peminjaman dan pengembalian.</p>
        <button class="btn btn-outline-primary w-100"><i class="bi bi-download me-2"></i>Export Laporan (PDF)</button>
      </div>
    </div>
  </div>

  <!-- Statistik -->
  <div class="col-md-4">
    <div class="panel h-100 border-top border-info border-4 shadow-sm">
      <div class="panel-body text-center p-4">
        <div class="bg-info bg-opacity-10 text-info rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 72px; height: 72px;">
          <i class="bi bi-bar-chart fs-2"></i>
        </div>
        <h5 class="mb-2">Laporan Statistik</h5>
        <p class="text-muted small mb-4">Export grafik utilisasi, tren peminjaman, dan kondisi aset.</p>
        <button class="btn btn-outline-info w-100"><i class="bi bi-download me-2"></i>Export Statistik (PDF)</button>
      </div>
    </div>
  </div>

  <!-- Data Inventaris -->
  <div class="col-md-4">
    <div class="panel h-100 border-top border-success border-4 shadow-sm">
      <div class="panel-body text-center p-4">
        <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 72px; height: 72px;">
          <i class="bi bi-box-seam fs-2"></i>
        </div>
        <h5 class="mb-2">Data Inventaris</h5>
        <p class="text-muted small mb-4">Export daftar seluruh inventaris beserta status stok terbaru.</p>
        <button class="btn btn-outline-success w-100"><i class="bi bi-download me-2"></i>Export Inventaris (PDF)</button>
      </div>
    </div>
  </div>
</div>
@endsection
