@extends('layouts.app')

@section('title', 'Sedang Dipinjam - SIPINJAM')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-handbag" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Peminjaman</p>
      <h1 class="h3 mb-1">Daftar Barang Dipinjam</h1>
      <p class="text-muted mb-0">Kelola penyerahan barang dan daftar inventaris yang saat ini sedang dipinjam mahasiswa.</p>
    </div>
  </div>
</div>

<div class="panel">
  <div class="panel-header">
    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab" aria-controls="approved" aria-selected="true">Menunggu Diserahkan</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="borrowed-tab" data-bs-toggle="tab" data-bs-target="#borrowed" type="button" role="tab" aria-controls="borrowed" aria-selected="false">Sedang Dipinjam</button>
      </li>
    </ul>
  </div>
  <div class="panel-body p-0">
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="approved" role="tabpanel" aria-labelledby="approved-tab">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="ps-4">No. Tiket</th>
                <th>Mahasiswa</th>
                <th>Inventaris</th>
                <th>Tgl Ambil</th>
                <th class="pe-4 text-end">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="ps-4 fw-semibold text-primary">#REQ-1003</td>
                <td>Andi Wijaya</td>
                <td>Tripod Kamera Takara</td>
                <td>17 Jun 2026</td>
                <td class="pe-4 text-end">
                  <button class="btn btn-sm btn-primary"><i class="bi bi-box-arrow-up-right"></i> Serahkan Barang</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="tab-pane fade" id="borrowed" role="tabpanel" aria-labelledby="borrowed-tab">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="ps-4">No. Tiket</th>
                <th>Mahasiswa</th>
                <th>Inventaris</th>
                <th>Batas Kembali</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="ps-4 fw-semibold text-primary">#REQ-0992</td>
                <td>Dewi Lestari</td>
                <td>Microphone Wireless Shure</td>
                <td>16 Jun 2026</td>
                <td><span class="badge bg-danger">Terlambat</span></td>
              </tr>
              <tr>
                <td class="ps-4 fw-semibold text-primary">#REQ-1000</td>
                <td>Farhan Maulana</td>
                <td>Kabel Roll 15M</td>
                <td>19 Jun 2026</td>
                <td><span class="badge bg-info text-dark">Active</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
