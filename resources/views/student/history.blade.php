@extends('layouts.app')

@section('title', 'Riwayat & Rating - SIPINJAM')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-clock-history" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Mahasiswa</p>
      <h1 class="h3 mb-1">Riwayat Peminjaman</h1>
      <p class="text-muted mb-0">Daftar inventaris yang telah selesai dipinjam. Anda dapat memberikan rating untuk pelayanan dan kondisi barang.</p>
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
            <th>Inventaris</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Kondisi Saat Kembali</th>
            <th class="text-center">Rating</th>
            <th class="pe-4 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="ps-4 fw-semibold text-muted">#REQ-0992</td>
            <td>
              <div class="d-flex align-items-center">
                <div class="bg-light rounded p-2 me-3">
                  <i class="bi bi-camera text-primary"></i>
                </div>
                <div>
                  <h6 class="mb-0">Tripod Kamera Takara</h6>
                  <small class="text-muted">Kategori: Fotografi</small>
                </div>
              </div>
            </td>
            <td>10 Jun 2026</td>
            <td>12 Jun 2026</td>
            <td><span class="badge bg-success bg-opacity-10 text-success border border-success">Baik</span></td>
            <td class="text-center text-warning">
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-half"></i>
            </td>
            <td class="pe-4 text-end">
              <button class="btn btn-sm btn-outline-secondary" disabled>Sudah Dinilai</button>
            </td>
          </tr>
          <tr>
            <td class="ps-4 fw-semibold text-muted">#REQ-0951</td>
            <td>
              <div class="d-flex align-items-center">
                <div class="bg-light rounded p-2 me-3">
                  <i class="bi bi-mic text-primary"></i>
                </div>
                <div>
                  <h6 class="mb-0">Microphone Wireless Shure</h6>
                  <small class="text-muted">Kategori: Audio</small>
                </div>
              </div>
            </td>
            <td>01 Jun 2026</td>
            <td>02 Jun 2026</td>
            <td><span class="badge bg-success bg-opacity-10 text-success border border-success">Baik</span></td>
            <td class="text-center text-muted">
              Belum dinilai
            </td>
            <td class="pe-4 text-end">
              <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#ratingModal">Beri Rating</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Rating -->
<div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ratingModalLabel">Beri Rating Pelayanan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center py-4">
        <h6 class="mb-3">Seberapa puas Anda dengan kondisi barang dan layanan kami?</h6>
        <div class="fs-1 text-warning mb-4" style="cursor: pointer;">
          <i class="bi bi-star"></i>
          <i class="bi bi-star"></i>
          <i class="bi bi-star"></i>
          <i class="bi bi-star"></i>
          <i class="bi bi-star"></i>
        </div>
        <div class="text-start">
          <label for="reviewText" class="form-label">Ulasan (Opsional)</label>
          <textarea class="form-control" id="reviewText" rows="3" placeholder="Tulis pengalaman Anda menggunakan inventaris ini..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Kirim Rating</button>
      </div>
    </div>
  </div>
</div>
@endsection
