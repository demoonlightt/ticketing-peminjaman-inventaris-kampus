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

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

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
          @forelse($requests as $req)
            <tr>
              <td class="ps-4 fw-semibold text-primary">#REQ-{{ str_pad($req->id, 4, '0', STR_PAD_LEFT) }}</td>
              <td>
                @foreach($req->items as $item)
                  {{ $item->inventory->name }} ({{ $item->quantity }}x)<br>
                @endforeach
              </td>
              <td>{{ \Carbon\Carbon::parse($req->borrow_date)->format('d M Y') }}</td>
              <td>{{ \Carbon\Carbon::parse($req->return_date)->format('d M Y') }}</td>
              <td>
                @if($req->status === 'pending')
                  <span class="badge bg-warning text-dark">Menunggu Persetujuan</span>
                @elseif($req->status === 'approved')
                  <span class="badge bg-info text-dark">Disetujui (Siap Diambil)</span>
                @elseif($req->status === 'borrowed')
                  <span class="badge bg-primary">Sedang Dipinjam</span>
                @elseif($req->status === 'returned')
                  <span class="badge bg-success">Dikembalikan</span>
                @elseif($req->status === 'rejected')
                  <span class="badge bg-danger">Ditolak</span>
                @endif
              </td>
              <td class="pe-4 text-end">
                @php
                  $progress = 25;
                  $color = 'warning';
                  if ($req->status === 'approved') { $progress = 50; $color = 'info'; }
                  elseif ($req->status === 'borrowed') { $progress = 75; $color = 'primary'; }
                  elseif ($req->status === 'returned' || $req->status === 'rejected') { $progress = 100; $color = $req->status === 'returned' ? 'success' : 'danger'; }
                @endphp
                <div class="progress" style="height: 10px; width: 120px; display: inline-block;">
                  <div class="progress-bar bg-{{ $color }}" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center py-4 text-muted">Tidak ada peminjaman aktif saat ini.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
