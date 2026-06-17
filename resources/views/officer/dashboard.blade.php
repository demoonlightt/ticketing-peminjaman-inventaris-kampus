@extends('layouts.app')

@section('title', 'Dashboard Petugas - SIPINJAM')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Petugas Inventaris</p>
      <h1 class="h3 mb-1">Dashboard</h1>
      <p class="text-muted mb-0">Ringkasan aktivitas dan tugas harian inventaris kampus.</p>
    </div>
  </div>
</div>

<div class="row g-3 mb-4">
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="panel p-3 d-flex align-items-center h-100 border-start border-warning border-4">
      <div class="icon-shape bg-warning bg-opacity-10 text-warning rounded-circle me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
        <i class="bi bi-inbox"></i>
      </div>
      <div>
        <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Pending Approval</h6>
        <h3 class="mb-0">{{ $incomingRequests }}</h3>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="panel p-3 d-flex align-items-center h-100 border-start border-primary border-4">
      <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded-circle me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
        <i class="bi bi-handbag"></i>
      </div>
      <div>
        <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Barang Dipinjam</h6>
        <h3 class="mb-0">{{ $activeBorrowings }}</h3>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="panel p-3 d-flex align-items-center h-100 border-start border-info border-4">
      <div class="icon-shape bg-info bg-opacity-10 text-info rounded-circle me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
        <i class="bi bi-arrow-return-left"></i>
      </div>
      <div>
        <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Pengembalian Hari Ini</h6>
        <h3 class="mb-0">{{ $returnsToday }}</h3>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="panel p-3 d-flex align-items-center h-100 border-start border-danger border-4">
      <div class="icon-shape bg-danger bg-opacity-10 text-danger rounded-circle me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
        <i class="bi bi-exclamation-triangle"></i>
      </div>
      <div>
        <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Terlambat</h6>
        <h3 class="mb-0">{{ $lateCount }}</h3>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <div class="panel">
      <div class="panel-header d-flex justify-content-between align-items-center">
        <h5 class="panel-title mb-0">Aktivitas Pengajuan Terbaru</h5>
        <a href="{{ route('officer.incoming_requests') }}" class="btn btn-sm btn-outline-primary">Lihat Semua Pengajuan</a>
      </div>
      <div class="panel-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="ps-4">No. Tiket</th>
                <th>Mahasiswa</th>
                <th>Nama Inventaris</th>
                <th>Tgl Pengajuan</th>
                <th>Status</th>
                <th class="pe-4 text-end">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($recentRequests as $req)
                <tr>
                  <td class="ps-4 fw-semibold text-primary">#REQ-{{ str_pad($req->id, 4, '0', STR_PAD_LEFT) }}</td>
                  <td>{{ $req->student->name }}</td>
                  <td>
                    @foreach($req->items as $item)
                      {{ $item->inventory->name }} ({{ $item->quantity }}x)<br>
                    @endforeach
                  </td>
                  <td>{{ \Carbon\Carbon::parse($req->request_date)->format('d M Y') }}</td>
                  <td>
                    @if($req->status === 'pending')
                      <span class="badge bg-warning text-dark">Pending</span>
                    @elseif($req->status === 'approved')
                      <span class="badge bg-info text-dark">Approved</span>
                    @elseif($req->status === 'borrowed')
                      <span class="badge bg-primary">Borrowed</span>
                    @elseif($req->status === 'returned')
                      <span class="badge bg-success">Returned</span>
                    @elseif($req->status === 'rejected')
                      <span class="badge bg-danger">Rejected</span>
                    @endif
                  </td>
                  <td class="pe-4 text-end">
                    @if($req->status === 'pending')
                      <form action="{{ route('officer.requests.approve', $req->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success"><i class="bi bi-check-lg"></i> Setujui</button>
                      </form>
                      <form action="{{ route('officer.requests.reject', $req->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-x-lg"></i> Tolak</button>
                      </form>
                    @elseif($req->status === 'approved')
                      <a href="{{ route('officer.borrowed') }}" class="btn btn-sm btn-primary">Serah Terima</a>
                    @elseif($req->status === 'borrowed')
                      <a href="{{ route('officer.returns') }}" class="btn btn-sm btn-outline-primary">Catat Kembali</a>
                    @else
                      <span class="text-muted small">-</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center py-4 text-muted">Belum ada riwayat aktivitas peminjaman.</td>
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
