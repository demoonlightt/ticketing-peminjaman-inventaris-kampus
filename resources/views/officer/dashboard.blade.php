@extends('layouts.app')

@section('title', 'Dashboard Petugas - SIPINJAM')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Petugas Inventaris</p>
      <h1 class="h3 mb-1">Dashboard</h1>
      <p class="text-muted mb-0">Ringkasan aktivitas dan tugas harian inventaris kampus.</p>
    </div>
  </div>
</div>

<div class="row g-3 mb-4">
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="panel p-3 d-flex align-items-center h-100 border-start border-warning border-4">
      <div class="icon-shape bg-warning bg-opacity-10 text-warning rounded-circle me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
        <i class="bi bi-inbox"></i>
      </div>
      <div>
        <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Pending Approval</h6>
        <h3 class="mb-0">8</h3>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="panel p-3 d-flex align-items-center h-100 border-start border-primary border-4">
      <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded-circle me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
        <i class="bi bi-handbag"></i>
      </div>
      <div>
        <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Barang Dipinjam</h6>
        <h3 class="mb-0">45</h3>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="panel p-3 d-flex align-items-center h-100 border-start border-info border-4">
      <div class="icon-shape bg-info bg-opacity-10 text-info rounded-circle me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
        <i class="bi bi-arrow-return-left"></i>
      </div>
      <div>
        <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Pengembalian Hari Ini</h6>
        <h3 class="mb-0">12</h3>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="panel p-3 d-flex align-items-center h-100 border-start border-danger border-4">
      <div class="icon-shape bg-danger bg-opacity-10 text-danger rounded-circle me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
        <i class="bi bi-exclamation-triangle"></i>
      </div>
      <div>
        <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Terlambat</h6>
        <h3 class="mb-0">3</h3>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="panel">
      <div class="panel-header d-flex justify-content-between align-items-center">
        <h5 class="panel-title mb-0">Daftar Pengajuan Terbaru</h5>
        <a href="{{ route('officer.incoming_requests') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
      </div>
      <div class="panel-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="ps-4">No. Tiket</th>
                <th>Mahasiswa</th>
                <th>Nama Inventaris</th>
                <th>Tgl Pengajuan</th>
                <th>Status</th>
                <th class="pe-4 text-end">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="ps-4 fw-semibold text-primary">#REQ-1004</td>
                <td>Budi Santoso</td>
                <td>Proyektor Epson EB-X05</td>
                <td>18 Jun 2026</td>
                <td><span class="badge bg-warning text-dark">Pending</span></td>
                <td class="pe-4 text-end">
                  <button class="btn btn-sm btn-success"><i class="bi bi-check-lg"></i> Setujui</button>
                </td>
              </tr>
              <tr>
                <td class="ps-4 fw-semibold text-primary">#REQ-1005</td>
                <td>Siti Aminah</td>
                <td>Kamera DSLR Canon EOS</td>
                <td>18 Jun 2026</td>
                <td><span class="badge bg-warning text-dark">Pending</span></td>
                <td class="pe-4 text-end">
                  <button class="btn btn-sm btn-success"><i class="bi bi-check-lg"></i> Setujui</button>
                </td>
              </tr>
              <tr>
                <td class="ps-4 fw-semibold text-primary">#REQ-1003</td>
                <td>Andi Wijaya</td>
                <td>Tripod Kamera Takara</td>
                <td>17 Jun 2026</td>
                <td><span class="badge bg-primary">Approved</span></td>
                <td class="pe-4 text-end">
                  <button class="btn btn-sm btn-outline-primary">Serahkan Barang</button>
                </td>
              </tr>
              <tr>
                <td class="ps-4 fw-semibold text-primary">#REQ-0992</td>
                <td>Dewi Lestari</td>
                <td>Microphone Wireless Shure</td>
                <td>15 Jun 2026</td>
                <td><span class="badge bg-info text-dark">Borrowed</span></td>
                <td class="pe-4 text-end">
                  <button class="btn btn-sm btn-outline-secondary" disabled>Menunggu Kembali</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
