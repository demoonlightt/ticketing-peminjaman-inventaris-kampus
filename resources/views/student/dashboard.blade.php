@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa - SIPINJAM')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Mahasiswa</p>
      <h1 class="h3 mb-1">Dashboard</h1>
      <p class="text-muted mb-0">Ringkasan aktivitas peminjaman inventaris Anda.</p>
    </div>
  </div>
</div>

<div class="row g-3 mb-4">
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="panel p-3 d-flex align-items-center h-100">
      <div class="icon-shape bg-primary text-white rounded-circle me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
        <i class="bi bi-file-earmark-text"></i>
      </div>
      <div>
        <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Total Pengajuan</h6>
        <h3 class="mb-0">12</h3>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="panel p-3 d-flex align-items-center h-100">
      <div class="icon-shape bg-success text-white rounded-circle me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
        <i class="bi bi-bag-check"></i>
      </div>
      <div>
        <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Peminjaman Aktif</h6>
        <h3 class="mb-0">2</h3>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="panel p-3 d-flex align-items-center h-100">
      <div class="icon-shape bg-warning text-dark rounded-circle me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
        <i class="bi bi-hourglass-split"></i>
      </div>
      <div>
        <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Menunggu Persetujuan</h6>
        <h3 class="mb-0">1</h3>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="panel p-3 d-flex align-items-center h-100">
      <div class="icon-shape bg-danger text-white rounded-circle me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
        <i class="bi bi-exclamation-triangle"></i>
      </div>
      <div>
        <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Terlambat</h6>
        <h3 class="mb-0">0</h3>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="panel">
      <div class="panel-header d-flex justify-content-between align-items-center">
        <h5 class="panel-title mb-0">Riwayat Pengajuan</h5>
        <a href="{{ route('student.history') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
      </div>
      <div class="panel-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="ps-4">No. Tiket</th>
                <th>Nama Inventaris</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="ps-4 fw-semibold text-primary">#REQ-1004</td>
                <td>Proyektor Epson EB-X05</td>
                <td>20 Jun 2026</td>
                <td>21 Jun 2026</td>
                <td><span class="badge bg-warning text-dark">Pending</span></td>
              </tr>
              <tr>
                <td class="ps-4 fw-semibold text-primary">#REQ-1003</td>
                <td>Kamera DSLR Canon EOS</td>
                <td>16 Jun 2026</td>
                <td>18 Jun 2026</td>
                <td><span class="badge bg-success">Borrowed</span></td>
              </tr>
              <tr>
                <td class="ps-4 fw-semibold text-primary">#REQ-0992</td>
                <td>Tripod Kamera Takara</td>
                <td>10 Jun 2026</td>
                <td>12 Jun 2026</td>
                <td><span class="badge bg-secondary">Returned</span></td>
              </tr>
              <tr>
                <td class="ps-4 fw-semibold text-primary">#REQ-0951</td>
                <td>Microphone Wireless Shure</td>
                <td>01 Jun 2026</td>
                <td>02 Jun 2026</td>
                <td><span class="badge bg-secondary">Returned</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
