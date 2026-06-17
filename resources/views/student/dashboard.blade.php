@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa - SIPINJAM')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Mahasiswa</p>
      <h1 class="h3 mb-1">Dashboard</h1>
      <p class="text-muted mb-0">Ringkasan aktivitas peminjaman inventaris Anda.</p>
    </div>
  </div>
</div>

<div class="row g-3 mb-4">
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="panel p-3 d-flex align-items-center h-100">
      <div class="icon-shape bg-primary text-white rounded-circle me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
        <i class="bi bi-file-earmark-text"></i>
      </div>
      <div>
        <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Total Pengajuan</h6>
        <h3 class="mb-0">{{ $totalRequestsCount }}</h3>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="panel p-3 d-flex align-items-center h-100">
      <div class="icon-shape bg-success text-white rounded-circle me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
        <i class="bi bi-bag-check"></i>
      </div>
      <div>
        <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Peminjaman Aktif</h6>
        <h3 class="mb-0">{{ $activeBorrowingsCount }}</h3>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="panel p-3 d-flex align-items-center h-100">
      <div class="icon-shape bg-warning text-dark rounded-circle me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
        <i class="bi bi-hourglass-split"></i>
      </div>
      <div>
        <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Menunggu Persetujuan</h6>
        <h3 class="mb-0">{{ $pendingRequestsCount }}</h3>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="panel p-3 d-flex align-items-center h-100">
      <div class="icon-shape bg-danger text-white rounded-circle me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
        <i class="bi bi-exclamation-triangle"></i>
      </div>
      <div>
        <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Terlambat</h6>
        <h3 class="mb-0">{{ $lateRequestsCount }}</h3>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="panel">
      <div class="panel-header d-flex justify-content-between align-items-center">
        <h5 class="panel-title mb-0">Riwayat Pengajuan Terbaru</h5>
        <a href="{{ route('student.my_borrowings') }}" class="btn btn-sm btn-outline-primary">Lihat Peminjaman Saya</a>
      </div>
      <div class="panel-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="ps-4">No. Tiket</th>
                <th>Nama Inventaris</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($activeBorrowings as $req)
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
                      <span class="badge bg-warning text-dark">Pending</span>
                    @elseif($req->status === 'approved')
                      <span class="badge bg-info text-dark">Approved</span>
                    @elseif($req->status === 'borrowed')
                      <span class="badge bg-success">Borrowed</span>
                    @elseif($req->status === 'returned')
                      <span class="badge bg-secondary">Returned</span>
                    @elseif($req->status === 'rejected')
                      <span class="badge bg-danger">Rejected</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center py-4 text-muted">Belum ada pengajuan peminjaman aktif.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
