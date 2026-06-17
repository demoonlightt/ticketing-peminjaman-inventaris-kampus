@extends('layouts.app')

@section('title', 'Semua Pengajuan - SIPINJAM')

@section('content')
<div class="page-heading d-flex justify-content-between align-items-center flex-wrap">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-inbox" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Peminjaman</p>
      <h1 class="h3 mb-1">Semua Pengajuan</h1>
      <p class="text-muted mb-0">Tampilan master seluruh riwayat transaksi peminjaman di kampus.</p>
    </div>
  </div>
  <form action="{{ route('admin.requests') }}" method="GET" class="mt-3 mt-md-0 d-flex gap-2">
    <select name="status" class="form-select" style="max-width: 150px;">
      <option value="">Semua Status</option>
      <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
      <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
      <option value="borrowed" {{ request('status') === 'borrowed' ? 'selected' : '' }}>Borrowed</option>
      <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>Returned</option>
      <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
    </select>
    <input type="month" name="month" class="form-control" style="max-width: 150px;" value="{{ request('month') }}">
    <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-funnel"></i> Filter</button>
  </form>
</div>

<div class="panel shadow-sm">
  <div class="panel-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th class="ps-4">No. Tiket</th>
            <th>Mahasiswa</th>
            <th>Barang Dipinjam</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Kembali</th>
            <th>Status</th>
            <th class="pe-4 text-end">Log Petugas</th>
          </tr>
        </thead>
        <tbody>
          @forelse($requests as $req)
            <tr>
              <td class="ps-4 fw-semibold text-primary">#{{ $req->ticket_number }}</td>
              <td>
                <strong>{{ $req->student->name }}</strong><br>
                <small class="text-muted">{{ $req->student->email }}</small>
              </td>
              <td>
                @foreach($req->items as $item)
                  <span class="badge bg-light text-dark border">{{ $item->inventory->name ?? 'Barang Terhapus' }} ({{ $item->quantity }})</span>
                @endforeach
              </td>
              <td>{{ $req->borrow_date ? \Carbon\Carbon::parse($req->borrow_date)->format('d M Y') : '-' }}</td>
              <td>{{ $req->expected_return_date ? \Carbon\Carbon::parse($req->expected_return_date)->format('d M Y') : '-' }}</td>
              <td>
                @if($req->status === 'pending')
                  <span class="badge bg-warning text-dark">Pending</span>
                @elseif($req->status === 'approved')
                  <span class="badge bg-primary">Approved</span>
                @elseif($req->status === 'borrowed')
                  <span class="badge bg-info text-dark">Borrowed</span>
                @elseif($req->status === 'returned')
                  <span class="badge bg-success">Returned</span>
                @elseif($req->status === 'rejected')
                  <span class="badge bg-danger">Rejected</span>
                @endif
              </td>
              <td class="pe-4 text-end text-muted small">
                @if($req->status === 'approved' && $req->approvedBy)
                  <span class="text-primary">Disetujui: {{ $req->approvedBy->name }}</span>
                @elseif($req->status === 'rejected' && $req->approvedBy)
                  <span class="text-danger">Ditolak: {{ $req->approvedBy->name }}</span>
                @elseif($req->status === 'borrowed' && $req->handover)
                  <span class="text-info">Diserahkan: {{ $req->handover->officer->name ?? 'Petugas' }}</span>
                @elseif($req->status === 'returned' && $req->returnRecord)
                  <span class="text-success">Dikembalikan: {{ $req->returnRecord->officer->name ?? 'Petugas' }}</span>
                @else
                  -
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center py-4 text-muted">Tidak ada data transaksi peminjaman ditemukan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
