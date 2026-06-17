@extends('layouts.app')

@section('title', 'Ajukan Pengembalian - SIPINJAM')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-arrow-return-left" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Mahasiswa</p>
      <h1 class="h3 mb-1">Ajukan Pengembalian</h1>
      <p class="text-muted mb-0">Beri tahu petugas bahwa Anda akan mengembalikan barang hari ini.</p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="panel shadow-sm">
      <div class="panel-header border-bottom">
        <h5 class="panel-title mb-0">Barang yang Harus Dikembalikan</h5>
      </div>
      <div class="panel-body">
        @forelse($requests as $req)
          @foreach($req->items as $item)
            <div class="d-flex border p-3 rounded mb-3 align-items-center">
              <div class="bg-light p-3 rounded me-3 text-primary">
                @php
                  $icon = 'bi-box';
                  if(str_contains(strtolower($item->inventory->name), 'kamera')) $icon = 'bi-camera';
                  elseif(str_contains(strtolower($item->inventory->name), 'proyektor')) $icon = 'bi-projector';
                  elseif(str_contains(strtolower($item->inventory->name), 'laptop') || str_contains(strtolower($item->inventory->name), 'macbook')) $icon = 'bi-laptop';
                  elseif(str_contains(strtolower($item->inventory->name), 'mikrofon') || str_contains(strtolower($item->inventory->name), 'mic')) $icon = 'bi-mic';
                  elseif(str_contains(strtolower($item->inventory->name), 'speaker')) $icon = 'bi-volume-up';
                  elseif(str_contains(strtolower($item->inventory->name), 'printer')) $icon = 'bi-printer';
                  elseif(str_contains(strtolower($item->inventory->name), 'mikroskop')) $icon = 'bi-microscope';
                @endphp
                <i class="bi {{ $icon }} fs-3"></i>
              </div>
              <div class="flex-grow-1">
                <h6 class="mb-1">{{ $item->inventory->name }} ({{ $item->quantity }}x)</h6>
                <p class="text-muted small mb-0">No. Tiket: #REQ-{{ str_pad($req->id, 4, '0', STR_PAD_LEFT) }}</p>
                <p class="text-muted small mb-0">Batas Kembali: {{ \Carbon\Carbon::parse($req->return_date)->format('d M Y') }}</p>
              </div>
              <div>
                @php
                  $today = strtotime(date('Y-m-d'));
                  $dueDate = strtotime($req->return_date);
                  $diff = $dueDate - $today;
                  $days = round($diff / (60 * 60 * 24));
                @endphp
                @if($days < 0)
                  <span class="badge bg-danger mb-2 d-block">Terlambat {{ abs($days) }} Hari</span>
                @elseif($days == 0)
                  <span class="badge bg-warning text-dark mb-2 d-block">Batas Kembali Hari Ini</span>
                @else
                  <span class="badge bg-success bg-opacity-10 text-success border border-success mb-2 d-block">Sisa {{ $days }} Hari</span>
                @endif
                <button class="btn btn-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#returnModal">Petunjuk</button>
              </div>
            </div>
          @endforeach
        @empty
          <div class="text-center py-4 text-muted">
            <i class="bi bi-check-circle fs-1 text-success d-block mb-2"></i>
            Semua barang pinjaman Anda telah dikembalikan!
          </div>
        @endforelse
      </div>
    </div>
  </div>
</div>

<!-- Modal Petunjuk Pengembalian -->
<div class="modal fade" id="returnModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-primary text-white border-0">
        <h5 class="modal-title"><i class="bi bi-info-circle-fill me-2"></i>Petunjuk Pengembalian</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <p class="mb-3">Untuk mengembalikan barang yang Anda pinjam, silakan ikuti langkah berikut:</p>
        <ol class="ps-3 mb-4">
          <li class="mb-2">Bawa barang inventaris fisik yang ingin dikembalikan beserta seluruh kelengkapannya (kabel, tas, adaptor, dll.).</li>
          <li class="mb-2">Temui petugas <strong>Hendra Setiawan</strong> di <strong>Bagian Perlengkapan & Inventaris</strong>.</li>
          <li class="mb-2">Petugas akan memeriksa kondisi fisik barang dan melakukan pencatatan pengembalian secara resmi di sistem.</li>
          <li>Apabila pengembalian terlambat atau terdapat kerusakan fisik, denda akan dihitung secara otomatis oleh sistem.</li>
        </ol>
        <div class="alert alert-info d-flex align-items-center mb-0" role="alert">
          <i class="bi bi-info-circle-fill fs-4 me-3"></i>
          <div>
            Status peminjaman Anda akan berubah menjadi <strong>"Returned"</strong> setelah dikonfirmasi oleh petugas.
          </div>
        </div>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-primary px-4" data-bs-dismiss="modal">Mengerti</button>
      </div>
    </div>
  </div>
</div>
@endsection
