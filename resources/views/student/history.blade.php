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
          @forelse($requests as $req)
            <tr>
              <td class="ps-4 fw-semibold text-muted">#REQ-{{ str_pad($req->id, 4, '0', STR_PAD_LEFT) }}</td>
              <td>
                @if($req->items->count() > 0)
                  @php $firstItem = $req->items->first()->inventory; @endphp
                  <div class="d-flex align-items-center">
                    <div class="bg-light rounded p-2 me-3">
                      @php
                        $icon = 'bi-box';
                        if(str_contains(strtolower($firstItem->name), 'kamera')) $icon = 'bi-camera';
                        elseif(str_contains(strtolower($firstItem->name), 'proyektor')) $icon = 'bi-projector';
                        elseif(str_contains(strtolower($firstItem->name), 'laptop') || str_contains(strtolower($firstItem->name), 'macbook')) $icon = 'bi-laptop';
                        elseif(str_contains(strtolower($firstItem->name), 'mikrofon') || str_contains(strtolower($firstItem->name), 'mic')) $icon = 'bi-mic';
                        elseif(str_contains(strtolower($firstItem->name), 'speaker')) $icon = 'bi-volume-up';
                        elseif(str_contains(strtolower($firstItem->name), 'printer')) $icon = 'bi-printer';
                        elseif(str_contains(strtolower($firstItem->name), 'mikroskop')) $icon = 'bi-microscope';
                      @endphp
                      <i class="bi {{ $icon }} text-primary"></i>
                    </div>
                    <div>
                      <h6 class="mb-0">
                        @if($req->items->count() > 1)
                          {{ $firstItem->name }} (dan {{ $req->items->count() - 1 }} barang lainnya)
                        @else
                          {{ $firstItem->name }} ({{ $req->items->first()->quantity }}x)
                        @endif
                      </h6>
                      <small class="text-muted">Kategori: {{ $firstItem->category->name }}</small>
                    </div>
                  </div>
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
              <td>{{ \Carbon\Carbon::parse($req->borrow_date)->format('d M Y') }}</td>
              <td>{{ \Carbon\Carbon::parse($req->return_date)->format('d M Y') }}</td>
              <td>
                @if($req->status === 'rejected')
                  <span class="badge bg-danger">Ditolak</span>
                @elseif($req->returnRecord)
                  @if($req->returnRecord->item_condition === 'baik')
                    <span class="badge bg-success bg-opacity-10 text-success border border-success">Baik</span>
                  @elseif($req->returnRecord->item_condition === 'rusak_ringan')
                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning">Rusak Ringan</span>
                  @elseif($req->returnRecord->item_condition === 'rusak_berat')
                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger">Rusak Berat</span>
                  @endif

                  @if($req->returnRecord->fine)
                    <div class="mt-1 small">
                      <span class="text-danger fw-semibold">Denda: Rp {{ number_format($req->returnRecord->fine->amount, 0, ',', '.') }}</span>
                      @if($req->returnRecord->fine->paid_status === 'paid')
                        <span class="badge bg-success p-1 ms-1" style="font-size: 0.65rem;">Lunas</span>
                      @else
                        <span class="badge bg-danger p-1 ms-1" style="font-size: 0.65rem;">Belum Lunas</span>
                      @endif
                    </div>
                  @endif
                @else
                  <span class="badge bg-secondary">Selesai</span>
                @endif
              </td>
              <td class="text-center text-warning">
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
              </td>
              <td class="pe-4 text-end">
                <button class="btn btn-sm btn-outline-secondary" disabled>Sudah Dinilai</button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center py-4 text-muted">Belum ada riwayat peminjaman.</td>
            </tr>
          @endforelse
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
