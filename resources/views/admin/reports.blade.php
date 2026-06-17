@extends('layouts.app')

@section('title', 'Laporan & Export - SIPINJAM')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-file-earmark-bar-graph" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Administrator</p>
      <h1 class="h3 mb-1">Laporan & Rekap Transaksi</h1>
      <p class="text-muted mb-0">Filter, analisis, dan cetak riwayat peminjaman/pengembalian inventaris.</p>
    </div>
  </div>
</div>

<div class="panel shadow-sm mb-4">
  <div class="panel-body">
    <form action="{{ route('admin.reports') }}" method="GET" class="row g-3">
      <div class="col-md-3">
        <label for="start_date" class="form-label small fw-semibold">Tanggal Mulai</label>
        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate }}">
      </div>
      <div class="col-md-3">
        <label for="end_date" class="form-label small fw-semibold">Tanggal Selesai</label>
        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate }}">
      </div>
      <div class="col-md-3">
        <label for="status" class="form-label small fw-semibold">Status Transaksi</label>
        <select name="status" id="status" class="form-select">
          <option value="">Semua Status</option>
          <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
          <option value="approved" {{ $status === 'approved' ? 'selected' : '' }}>Approved</option>
          <option value="borrowed" {{ $status === 'borrowed' ? 'selected' : '' }}>Borrowed</option>
          <option value="returned" {{ $status === 'returned' ? 'selected' : '' }}>Returned</option>
          <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
      </div>
      <div class="col-md-3 d-flex align-items-end gap-2">
        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-filter me-1"></i> Filter</button>
        @if(count($reports) > 0)
          <button type="button" onclick="printReport()" class="btn btn-success w-100"><i class="bi bi-printer me-1"></i> Cetak</button>
        @endif
      </div>
    </form>
  </div>
</div>

<div class="panel shadow-sm" id="reportTablePanel">
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
            <th class="pe-4 text-end">Denda</th>
          </tr>
        </thead>
        <tbody>
          @forelse($reports as $req)
            <tr>
              <td class="ps-4 fw-semibold text-primary">#{{ $req->ticket_number }}</td>
              <td>
                <strong>{{ $req->student->name }}</strong><br>
                <small class="text-muted">{{ $req->student->mahasiswaProfile->nim ?? '-' }}</small>
              </td>
              <td>
                @foreach($req->items as $item)
                  {{ $item->inventory->name ?? 'Barang Terhapus' }} ({{ $item->quantity }})<br>
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
              <td class="pe-4 text-end fw-semibold">
                @if($req->returnRecord && $req->returnRecord->fine)
                  <span class="{{ $req->returnRecord->fine->paid_status === 'paid' ? 'text-success' : 'text-danger' }}">
                    Rp {{ number_format($req->returnRecord->fine->amount, 0, ',', '.') }}
                    <small class="d-block text-muted">({{ $req->returnRecord->fine->paid_status }})</small>
                  </span>
                @else
                  -
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center py-4 text-muted">Tidak ada transaksi ditemukan untuk filter ini.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  function printReport() {
    const printContent = document.getElementById('reportTablePanel').innerHTML;
    const originalContent = document.body.innerHTML;

    document.body.innerHTML = `
      <div style="padding: 40px; font-family: 'Inter', sans-serif;">
        <h2 style="margin-bottom: 5px;">SIPINJAM - Laporan Rekapitulasi Peminjaman</h2>
        <p style="color: #666; margin-top: 0; margin-bottom: 5px;">Tanggal Laporan: {{ date('d M Y') }}</p>
        <p style="color: #666; margin-top: 0; margin-bottom: 30px;">
          Periode: {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d M Y') : 'Awal' }} s/d {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d M Y') : 'Akhir' }}
        </p>
        ${printContent}
      </div>
    `;

    window.print();
    document.body.innerHTML = originalContent;
    window.location.reload();
  }
</script>
@endsection
