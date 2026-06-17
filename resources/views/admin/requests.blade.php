@extends('layouts.app')

@section('title', 'Semua Pengajuan - SIPINJAM')

@section('content')
<div class="page-heading d-flex justify-content-between align-items-center flex-wrap">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-inbox" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Peminjaman</p>
      <h1 class="h3 mb-1">Semua Pengajuan</h1>
      <p class="text-muted mb-0">Tampilan master seluruh riwayat transaksi peminjaman di kampus.</p>
    </div>
  </div>
  <div class="mt-3 mt-md-0 d-flex gap-2">
    <select class="form-select" style="max-width: 150px;">
      <option value="">Semua Status</option>
      <option value="pending">Pending</option>
      <option value="approved">Approved</option>
      <option value="borrowed">Borrowed</option>
      <option value="returned">Returned</option>
      <option value="rejected">Rejected</option>
    </select>
    <input type="month" class="form-control" style="max-width: 150px;">
    <button class="btn btn-outline-secondary"><i class="bi bi-funnel"></i> Filter</button>
  </div>
</div>

<div class="panel shadow-sm">
  <div class="panel-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th class="ps-4">No. Tiket</th>
            <th>Mahasiswa</th>
            <th>Barang Dipinjam</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Kembali</th>
            <th>Status</th>
            <th class="pe-4 text-end">Log Petugas</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="ps-4 fw-semibold text-primary">#REQ-1004</td>
            <td>Budi Santoso</td>
            <td>Proyektor Epson EB-X05</td>
            <td>20 Jun 2026</td>
            <td>21 Jun 2026</td>
            <td><span class="badge bg-warning text-dark">Pending</span></td>
            <td class="pe-4 text-end text-muted small">-</td>
          </tr>
          <tr>
            <td class="ps-4 fw-semibold text-primary">#REQ-1003</td>
            <td>Siti Aminah</td>
            <td>Kamera DSLR Canon EOS</td>
            <td>16 Jun 2026</td>
            <td>18 Jun 2026</td>
            <td><span class="badge bg-primary">Approved</span></td>
            <td class="pe-4 text-end text-muted small">Ahmad (15 Jun, 09:00)</td>
          </tr>
          <tr>
            <td class="ps-4 fw-semibold text-primary">#REQ-0992</td>
            <td>Dewi Lestari</td>
            <td>Tripod Kamera Takara</td>
            <td>10 Jun 2026</td>
            <td>15 Jun 2026</td>
            <td><span class="badge bg-info text-dark">Borrowed</span></td>
            <td class="pe-4 text-end text-muted small">Ahmad (10 Jun, 14:30)</td>
          </tr>
          <tr>
            <td class="ps-4 fw-semibold text-primary">#REQ-0951</td>
            <td>Andi Wijaya</td>
            <td>Microphone Wireless Shure</td>
            <td>01 Jun 2026</td>
            <td>02 Jun 2026</td>
            <td><span class="badge bg-success">Returned</span></td>
            <td class="pe-4 text-end text-muted small">Rina (02 Jun, 16:15)</td>
          </tr>
          <tr>
            <td class="ps-4 fw-semibold text-primary">#REQ-0940</td>
            <td>Farhan Maulana</td>
            <td>Kabel Roll 15M</td>
            <td>28 May 2026</td>
            <td>28 May 2026</td>
            <td><span class="badge bg-danger">Rejected</span></td>
            <td class="pe-4 text-end text-muted small">Ahmad (27 May, 10:00)</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
