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
<div class="alert alert-primary d-flex align-items-center shadow-sm border-0 mb-4" role="alert">
  <i class="bi bi-info-circle-fill fs-4 me-3"></i>
  <div>
    Halaman ini difokuskan untuk pelaporan metrik detail. Untuk melihat visualisasi grafik secara cepat, silakan kunjungi <a href="{{ route('admin.dashboard') }}" class="fw-bold alert-link">Dashboard Utama</a>.
  </div>
</div>

<!-- Fine Summary Cards -->
<div class="row g-4 mb-4">
  <div class="col-md-4">
    <div class="panel shadow-sm border-start border-primary border-4">
      <div class="panel-body d-flex align-items-center justify-content-between p-4">
        <div>
          <p class="text-muted small mb-1">Total Akumulasi Denda</p>
          <h3 class="mb-0">Rp {{ number_format($totalFines, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3">
          <i class="bi bi-cash-stack fs-4"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="panel shadow-sm border-start border-success border-4">
      <div class="panel-body d-flex align-items-center justify-content-between p-4">
        <div>
          <p class="text-muted small mb-1">Denda Terbayar</p>
          <h3 class="mb-0 text-success">Rp {{ number_format($paidFines, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-success bg-opacity-10 text-success rounded-circle p-3">
          <i class="bi bi-check-circle-fill fs-4"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="panel shadow-sm border-start border-danger border-4">
      <div class="panel-body d-flex align-items-center justify-content-between p-4">
        <div>
          <p class="text-muted small mb-1">Belum Terbayar</p>
          <h3 class="mb-0 text-danger">Rp {{ number_format($unpaidFines, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-danger bg-opacity-10 text-danger rounded-circle p-3">
          <i class="bi bi-exclamation-triangle-fill fs-4"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <!-- Top Students -->
  <div class="col-md-6">
    <div class="panel shadow-sm h-100">
      <div class="panel-header border-bottom p-3">
        <h5 class="panel-title mb-0">Top 5 Mahasiswa Peminjam Teraktif</h5>
      </div>
      <div class="panel-body p-0">
        <ul class="list-group list-group-flush">
          @forelse($topStudents as $index => $student)
            <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-4">
              <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">{{ $index + 1 }}</div>
                <div>
                  <h6 class="mb-0">{{ $student->name }}</h6>
                  <small class="text-muted">{{ $student->mahasiswaProfile->prodi ?? 'Mahasiswa' }}</small>
                </div>
              </div>
              <span class="badge bg-primary rounded-pill">{{ $student->borrow_requests_count }} Transaksi</span>
            </li>
          @empty
            <li class="list-group-item text-center py-4 text-muted">Belum ada transaksi peminjaman.</li>
          @endforelse
        </ul>
      </div>
    </div>
  </div>

  <!-- Officer Performance -->
  <div class="col-md-6">
    <div class="panel shadow-sm h-100">
      <div class="panel-header border-bottom p-3">
        <h5 class="panel-title mb-0">Kinerja Petugas (Bulan Ini)</h5>
      </div>
      <div class="panel-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="ps-4">Nama Petugas</th>
                <th class="text-center">Penyerahan Barang</th>
                <th class="text-center">Penerimaan Kembali</th>
              </tr>
            </thead>
            <tbody>
              @forelse($officersPerformance as $officer)
                <tr>
                  <td class="ps-4 fw-semibold">{{ $officer->name }}</td>
                  <td class="text-center"><span class="text-success fw-bold">{{ $officer->handovers_count }}</span></td>
                  <td class="text-center"><span class="text-primary fw-bold">{{ $officer->returns_count }}</span></td>
                </tr>
              @empty
                <tr>
                  <td colspan="3" class="text-center py-4 text-muted">Belum ada aktivitas petugas bulan ini.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
