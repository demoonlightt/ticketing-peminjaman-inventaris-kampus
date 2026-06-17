@extends('layouts.app')

@section('title', 'SIPINJAM - Ajukan Peminjaman')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-pencil-square" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Mahasiswa</p>
      <h1 class="h3 mb-1">Ajukan Peminjaman</h1>
      <p class="text-muted mb-0">Isi formulir di bawah ini untuk mengajukan peminjaman inventaris.</p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-8 mx-auto">
    <div class="panel">
      <div class="panel-header">
        <h5 class="panel-title mb-0">Formulir Peminjaman</h5>
      </div>
      <div class="panel-body">
        <form action="#" method="POST">
          <div class="mb-3">
            <label for="inventoryItem" class="form-label">Pilih Barang</label>
            <select class="form-select" id="inventoryItem" required>
              <option value="" selected disabled>-- Pilih Barang --</option>
              <option value="1">Proyektor Epson EB-X05</option>
              <option value="2">Kamera DSLR Canon EOS 3000D</option>
              <option value="3">Microphone Wireless Shure</option>
              <option value="4">Kabel HDMI 10 Meter</option>
            </select>
          </div>
          
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="borrowDate" class="form-label">Tanggal Pinjam</label>
              <input type="date" class="form-control" id="borrowDate" required>
            </div>
            <div class="col-md-6">
              <label for="returnDate" class="form-label">Tanggal Kembali</label>
              <input type="date" class="form-control" id="returnDate" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="purpose" class="form-label">Keperluan</label>
            <textarea class="form-control" id="purpose" rows="3" placeholder="Jelaskan keperluan peminjaman barang ini..." required></textarea>
          </div>

          <div class="mb-4">
            <label for="attachment" class="form-label">Surat Pengajuan (Opsional)</label>
            <input class="form-control" type="file" id="attachment" accept=".pdf,.jpg,.png">
            <div class="form-text">Unggah surat pengantar dari dosen jika diperlukan (Maks 2MB).</div>
          </div>

          <div class="d-flex justify-content-end">
            <button type="reset" class="btn btn-light me-2">Batal</button>
            <button type="submit" class="btn btn-primary"><i class="bi bi-send me-1"></i> Ajukan Sekarang</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
