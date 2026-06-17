@extends('layouts.app')

@section('title', 'Dokumen - SIPINJAM')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-file-earmark-arrow-down" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Mahasiswa</p>
      <h1 class="h3 mb-1">Download Dokumen PDF</h1>
      <p class="text-muted mb-0">Unduh bukti peminjaman dan riwayat transaksi Anda.</p>
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-md-6">
    <div class="panel h-100">
      <div class="panel-body text-center p-5">
        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
          <i class="bi bi-receipt fs-1"></i>
        </div>
        <h4 class="mb-2">Bukti Peminjaman Aktif</h4>
        <p class="text-muted mb-4">Cetak bukti untuk peminjaman yang sedang berlangsung (Approved/Borrowed).</p>
        
        <form action="#" method="GET" class="text-start">
          <div class="mb-3">
            <label for="borrow_id" class="form-label">Pilih Tiket Peminjaman</label>
            <select class="form-select" id="borrow_id" required>
              <option value="" selected disabled>-- Pilih Tiket Aktif --</option>
              <option value="1">#REQ-1003 - Kamera DSLR Canon EOS</option>
              <option value="2">#REQ-1004 - Proyektor Epson EB-X05</option>
            </select>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary"><i class="bi bi-download me-2"></i>Export Bukti (PDF)</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="panel h-100">
      <div class="panel-body text-center p-5">
        <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
          <i class="bi bi-clock-history fs-1"></i>
        </div>
        <h4 class="mb-2">Riwayat Peminjaman Pribadi</h4>
        <p class="text-muted mb-4">Cetak rekapitulasi seluruh riwayat peminjaman inventaris Anda.</p>
        
        <form action="#" method="GET" class="text-start">
          <div class="row mb-3">
            <div class="col-6">
              <label for="start_date" class="form-label">Dari Tanggal</label>
              <input type="date" class="form-control" id="start_date" required>
            </div>
            <div class="col-6">
              <label for="end_date" class="form-label">Sampai Tanggal</label>
              <input type="date" class="form-control" id="end_date" required>
            </div>
          </div>
          <div class="d-grid mt-4 pt-1">
            <button type="submit" class="btn btn-success"><i class="bi bi-file-earmark-pdf me-2"></i>Export Riwayat (PDF)</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
