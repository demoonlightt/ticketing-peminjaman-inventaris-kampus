@extends('layouts.app')

@section('title', 'Statistik Analitik - SIPINJAM')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-bar-chart" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Analytics</p>
      <h1 class="h3 mb-1">Statistik Mendalam</h1>
      <p class="text-muted mb-0">Analisis kinerja sistem dan penggunaan aset dalam periode tertentu.</p>
    </div>
  </div>
</div>

<!-- Notice -->
<div class="alert alert-primary d-flex align-items-center shadow-sm border-0" role="alert">
  <i class="bi bi-info-circle-fill fs-4 me-3"></i>
  <div>
    Halaman ini difokuskan untuk pelaporan metrik detail. Untuk melihat visualisasi grafik secara cepat, silakan kunjungi <a href="{{ route('admin.dashboard') }}" class="fw-bold alert-link">Dashboard Utama</a>.
  </div>
</div>

<div class="row g-4 mt-1">
  <div class="col-md-6">
    <div class="panel shadow-sm h-100">
      <div class="panel-header border-bottom">
        <h5 class="panel-title mb-0">Top 5 Mahasiswa Peminjam Teraktif</h5>
      </div>
      <div class="panel-body p-0">
        <ul class="list-group list-group-flush">
          <li class="list-group-item d-flex justify-content-between align-items-center py-3">
            <div class="d-flex align-items-center">
              <div class="bg-primary bg-opacity-10 text-primary rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">1</div>
              <div>
                <h6 class="mb-0">Andi Wijaya</h6>
                <small class="text-muted">Ilmu Komputer</small>
              </div>
            </div>
            <span class="badge bg-primary rounded-pill">24 Transaksi</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center py-3">
            <div class="d-flex align-items-center">
              <div class="bg-primary bg-opacity-10 text-primary rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">2</div>
              <div>
                <h6 class="mb-0">Siti Aminah</h6>
                <small class="text-muted">Desain Komunikasi Visual</small>
              </div>
            </div>
            <span class="badge bg-primary rounded-pill">18 Transaksi</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center py-3">
            <div class="d-flex align-items-center">
              <div class="bg-primary bg-opacity-10 text-primary rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">3</div>
              <div>
                <h6 class="mb-0">Budi Santoso</h6>
                <small class="text-muted">Teknik Elektro</small>
              </div>
            </div>
            <span class="badge bg-primary rounded-pill">15 Transaksi</span>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="panel shadow-sm h-100">
      <div class="panel-header border-bottom">
        <h5 class="panel-title mb-0">Kinerja Petugas (Bulan Ini)</h5>
      </div>
      <div class="panel-body p-0">
        <div class="table-responsive">
          <table class="table table-borderless align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="ps-4">Nama Petugas</th>
                <th class="text-center">Verifikasi</th>
                <th class="text-center">Pengembalian</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="ps-4 fw-semibold">Ahmad Petugas</td>
                <td class="text-center"><span class="text-success fw-bold">145</span></td>
                <td class="text-center"><span class="text-primary fw-bold">130</span></td>
              </tr>
              <tr>
                <td class="ps-4 fw-semibold">Rina Gunawan</td>
                <td class="text-center"><span class="text-success fw-bold">112</span></td>
                <td class="text-center"><span class="text-primary fw-bold">98</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
