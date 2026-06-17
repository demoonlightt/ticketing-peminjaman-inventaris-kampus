@extends('layouts.app')

@section('title', 'Katalog Inventaris - SIPINJAM')

@section('content')
<div class="page-heading d-flex justify-content-between align-items-center flex-wrap">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-box" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Mahasiswa</p>
      <h1 class="h3 mb-1">Daftar Inventaris</h1>
      <p class="text-muted mb-0">Cari dan jelajahi barang yang tersedia untuk dipinjam.</p>
    </div>
  </div>
  <div class="mt-3 mt-md-0 d-flex gap-2">
    <input type="text" class="form-control" placeholder="Cari barang..." style="max-width: 250px;">
    <select class="form-select" style="max-width: 150px;">
      <option value="">Semua Kategori</option>
      <option value="elektronik">Elektronik</option>
      <option value="fotografi">Fotografi</option>
      <option value="atk">ATK</option>
    </select>
  </div>
</div>

<div class="row g-4">
  <!-- Item 1 -->
  <div class="col-sm-6 col-md-4 col-xl-3">
    <div class="card h-100 shadow-sm border-0">
      <div class="bg-light p-4 text-center rounded-top d-flex align-items-center justify-content-center" style="height: 180px;">
        <i class="bi bi-camera fs-1 text-primary"></i>
      </div>
      <div class="card-body">
        <span class="badge bg-primary bg-opacity-10 text-primary mb-2">Fotografi</span>
        <h5 class="card-title text-truncate">Kamera DSLR Canon EOS 3000D</h5>
        <p class="card-text text-muted small mb-3">Kamera DSLR entry-level untuk kebutuhan dokumentasi kegiatan.</p>
        <div class="d-flex justify-content-between align-items-center">
          <span class="fw-semibold text-success"><i class="bi bi-check-circle me-1"></i> Tersedia (5)</span>
          <a href="{{ route('student.borrow') }}" class="btn btn-sm btn-outline-primary">Pinjam</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Item 2 -->
  <div class="col-sm-6 col-md-4 col-xl-3">
    <div class="card h-100 shadow-sm border-0">
      <div class="bg-light p-4 text-center rounded-top d-flex align-items-center justify-content-center" style="height: 180px;">
        <i class="bi bi-projector fs-1 text-primary"></i>
      </div>
      <div class="card-body">
        <span class="badge bg-primary bg-opacity-10 text-primary mb-2">Elektronik</span>
        <h5 class="card-title text-truncate">Proyektor Epson EB-X05</h5>
        <p class="card-text text-muted small mb-3">Proyektor standar untuk presentasi di ruang kelas atau seminar.</p>
        <div class="d-flex justify-content-between align-items-center">
          <span class="fw-semibold text-danger"><i class="bi bi-x-circle me-1"></i> Habis (0)</span>
          <button class="btn btn-sm btn-outline-secondary" disabled>Pinjam</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Item 3 -->
  <div class="col-sm-6 col-md-4 col-xl-3">
    <div class="card h-100 shadow-sm border-0">
      <div class="bg-light p-4 text-center rounded-top d-flex align-items-center justify-content-center" style="height: 180px;">
        <i class="bi bi-mic fs-1 text-primary"></i>
      </div>
      <div class="card-body">
        <span class="badge bg-primary bg-opacity-10 text-primary mb-2">Elektronik</span>
        <h5 class="card-title text-truncate">Microphone Wireless Shure</h5>
        <p class="card-text text-muted small mb-3">Mic nirkabel untuk acara outdoor maupun indoor.</p>
        <div class="d-flex justify-content-between align-items-center">
          <span class="fw-semibold text-success"><i class="bi bi-check-circle me-1"></i> Tersedia (2)</span>
          <a href="{{ route('student.borrow') }}" class="btn btn-sm btn-outline-primary">Pinjam</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Item 4 -->
  <div class="col-sm-6 col-md-4 col-xl-3">
    <div class="card h-100 shadow-sm border-0">
      <div class="bg-light p-4 text-center rounded-top d-flex align-items-center justify-content-center" style="height: 180px;">
        <i class="bi bi-camera-reels fs-1 text-primary"></i>
      </div>
      <div class="card-body">
        <span class="badge bg-primary bg-opacity-10 text-primary mb-2">Fotografi</span>
        <h5 class="card-title text-truncate">Tripod Kamera Takara</h5>
        <p class="card-text text-muted small mb-3">Tripod portabel untuk stabilisasi video dan foto.</p>
        <div class="d-flex justify-content-between align-items-center">
          <span class="fw-semibold text-success"><i class="bi bi-check-circle me-1"></i> Tersedia (8)</span>
          <a href="{{ route('student.borrow') }}" class="btn btn-sm btn-outline-primary">Pinjam</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
