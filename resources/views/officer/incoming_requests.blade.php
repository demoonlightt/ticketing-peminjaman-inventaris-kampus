@extends('layouts.app')

@section('title', 'Verifikasi Pengajuan - SIPINJAM')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-inbox" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Peminjaman</p>
      <h1 class="h3 mb-1">Pengajuan Masuk</h1>
      <p class="text-muted mb-0">Verifikasi permintaan peminjaman inventaris dari mahasiswa.</p>
    </div>
  </div>
</div>

<div class="panel">
  <div class="panel-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th class="ps-4">No. Tiket</th>
            <th>Mahasiswa</th>
            <th>Inventaris</th>
            <th>Durasi Pinjam</th>
            <th>Surat/Dokumen</th>
            <th class="pe-4 text-end">Aksi Verifikasi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="ps-4 fw-semibold text-primary">#REQ-1004</td>
            <td>
              <h6 class="mb-0">Budi Santoso</h6>
              <small class="text-muted">NIM: 12345601</small>
            </td>
            <td>Proyektor Epson EB-X05</td>
            <td>18 Jun - 19 Jun 2026</td>
            <td><a href="#" class="btn btn-sm btn-light text-primary"><i class="bi bi-file-earmark-pdf"></i> Lihat Surat</a></td>
            <td class="pe-4 text-end">
              <button class="btn btn-sm btn-success me-1"><i class="bi bi-check-lg"></i> Setujui</button>
              <button class="btn btn-sm btn-danger"><i class="bi bi-x-lg"></i> Tolak</button>
            </td>
          </tr>
          <tr>
            <td class="ps-4 fw-semibold text-primary">#REQ-1005</td>
            <td>
              <h6 class="mb-0">Siti Aminah</h6>
              <small class="text-muted">NIM: 12345602</small>
            </td>
            <td>Kamera DSLR Canon EOS</td>
            <td>18 Jun - 20 Jun 2026</td>
            <td><span class="text-muted small">Tidak ada lampiran</span></td>
            <td class="pe-4 text-end">
              <button class="btn btn-sm btn-success me-1"><i class="bi bi-check-lg"></i> Setujui</button>
              <button class="btn btn-sm btn-danger"><i class="bi bi-x-lg"></i> Tolak</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
