@extends('layouts.app')

@section('title', 'Konfirmasi Pengembalian - SIPINJAM')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-arrow-return-left" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Peminjaman</p>
      <h1 class="h3 mb-1">Konfirmasi Pengembalian</h1>
      <p class="text-muted mb-0">Terima dan cek kondisi barang yang dikembalikan oleh mahasiswa.</p>
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
            <th>Tgl Kembali</th>
            <th class="pe-4 text-end">Aksi Konfirmasi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="ps-4 fw-semibold text-primary">#REQ-0950</td>
            <td>
              <h6 class="mb-0">Rina Gunawan</h6>
              <small class="text-muted">NIM: 12345688</small>
            </td>
            <td>Gimbal Stabilizer DJI</td>
            <td>Hari Ini (17 Jun 2026)</td>
            <td class="pe-4 text-end">
              <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#returnModal"><i class="bi bi-box-arrow-in-down"></i> Terima Barang</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="returnModalLabel">Konfirmasi Penerimaan Barang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label class="form-label">Kondisi Barang Saat Diterima</label>
            <select class="form-select" required>
              <option value="baik">Baik / Normal</option>
              <option value="rusak_ringan">Rusak Ringan</option>
              <option value="rusak_berat">Rusak Berat</option>
              <option value="hilang">Hilang</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Catatan Petugas (Opsional)</label>
            <textarea class="form-control" rows="3" placeholder="Tambahkan catatan jika ada masalah..."></textarea>
          </div>
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="checkDenda">
            <label class="form-check-label text-danger" for="checkDenda">Kenakan Denda Keterlambatan/Kerusakan</label>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Selesaikan Pengembalian</button>
      </div>
    </div>
  </div>
</div>
@endsection
