@extends('layouts.app')

@section('title', 'Peminjaman Saya - SIPINJAM')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-bag-check" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Mahasiswa</p>
      <h1 class="h3 mb-1">Peminjaman Saya</h1>
      <p class="text-muted mb-0">Lacak status pengajuan yang sedang diproses atau barang yang sedang Anda pinjam.</p>
    </div>
  </div>
</div>

<div class="panel shadow-sm">
  <div class="panel-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th class="ps-4">No. Tiket</th>
            <th>Nama Barang</th>
            <th>Tgl Pinjam</th>
            <th>Batas Kembali</th>
            <th>Status</th>
            <th class="pe-4 text-end">Progress</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="ps-4 fw-semibold text-primary">#REQ-1004</td>
            <td>Proyektor Epson EB-X05</td>
            <td>20 Jun 2026</td>
            <td>21 Jun 2026</td>
            <td><span class="badge bg-warning text-dark">Menunggu Persetujuan</span></td>
            <td class="pe-4 text-end">
              <div class="progress" style="height: 10px; width: 100px; display: inline-block;">
                <div class="progress-bar bg-warning" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </td>
          </tr>
          <tr>
            <td class="ps-4 fw-semibold text-primary">#REQ-1003</td>
            <td>Kamera DSLR Canon EOS</td>
            <td>16 Jun 2026</td>
            <td>18 Jun 2026</td>
            <td><span class="badge bg-info text-dark">Disetujui (Ambil Barang)</span></td>
            <td class="pe-4 text-end">
              <div class="progress" style="height: 10px; width: 100px; display: inline-block;">
                <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </td>
          </tr>
          <tr>
            <td class="ps-4 fw-semibold text-primary">#REQ-0992</td>
            <td>Tripod Kamera Takara</td>
            <td>10 Jun 2026</td>
            <td>15 Jun 2026</td>
            <td><span class="badge bg-primary">Sedang Dipinjam</span></td>
            <td class="pe-4 text-end">
              <div class="progress" style="height: 10px; width: 100px; display: inline-block;">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
