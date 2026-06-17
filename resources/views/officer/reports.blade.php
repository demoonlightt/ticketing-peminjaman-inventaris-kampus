@extends('layouts.app')

@section('title', 'Laporan - SIPINJAM')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-file-earmark-pdf" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Laporan</p>
      <h1 class="h3 mb-1">Laporan Transaksi</h1>
      <p class="text-muted mb-0">Kelola dan export data laporan peminjaman serta pengembalian inventaris.</p>
    </div>
  </div>
</div>

<div class="panel shadow-sm mb-4">
  <div class="panel-header border-bottom">
    <h5 class="panel-title mb-0"><i class="bi bi-funnel me-2"></i>Filter Laporan</h5>
  </div>
  <div class="panel-body">
    <form action="{{ route('officer.reports') }}" method="GET">
      <div class="row g-3 align-items-end">
        <div class="col-md-4">
          <label for="start_date" class="form-label font-semibold">Dari Tanggal</label>
          <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate ?? date('Y-m-01') }}">
        </div>
        <div class="col-md-4">
          <label for="end_date" class="form-label font-semibold">Sampai Tanggal</label>
          <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate ?? date('Y-m-d') }}">
        </div>
        <div class="col-md-4 d-flex gap-2">
          <button type="submit" class="btn btn-primary flex-grow-1"><i class="bi bi-filter me-1"></i> Filter Data</button>
          <button type="button" onclick="printReport()" class="btn btn-success"><i class="bi bi-printer me-1"></i> Cetak</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="panel shadow-sm" id="reportTablePanel">
  <div class="panel-header border-bottom d-flex justify-content-between align-items-center">
    <h5 class="panel-title mb-0">Hasil Laporan Transaksi</h5>
    <span class="text-muted small">Periode: {{ \Carbon\Carbon::parse($startDate ?? date('Y-m-01'))->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($endDate ?? date('Y-m-d'))->format('d M Y') }}</span>
  </div>
  <div class="panel-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0" id="reportTable">
        <thead class="table-light">
          <tr>
            <th class="ps-4">No. Tiket</th>
            <th>Mahasiswa</th>
            <th>Inventaris</th>
            <th>Tgl Pinjam</th>
            <th>Batas Kembali</th>
            <th>Status</th>
            <th>Tgl Kembali</th>
            <th>Kondisi</th>
            <th class="pe-4 text-end">Denda</th>
          </tr>
        </thead>
        <tbody>
          @forelse($reports as $req)
            <tr>
              <td class="ps-4 fw-semibold text-primary">#REQ-{{ str_pad($req->id, 4, '0', STR_PAD_LEFT) }}</td>
              <td>
                <h6 class="mb-0">{{ $req->student->name }}</h6>
                <small class="text-muted">NIM: {{ $req->student->mahasiswaProfile->nim }}</small>
              </td>
              <td>
                @foreach($req->items as $item)
                  {{ $item->inventory->name }} ({{ $item->quantity }}x)<br>
                @endforeach
              </td>
              <td>{{ \Carbon\Carbon::parse($req->borrow_date)->format('d M Y') }}</td>
              <td>{{ \Carbon\Carbon::parse($req->return_date)->format('d M Y') }}</td>
              <td>
                <span class="badge {{ $req->status === 'returned' ? 'bg-success' : 'bg-primary' }}">
                  {{ $req->status }}
                </span>
              </td>
              <td>
                {{ $req->returnRecord ? \Carbon\Carbon::parse($req->returnRecord->return_date)->format('d M Y') : '-' }}
              </td>
              <td>
                @if($req->returnRecord)
                  @if($req->returnRecord->item_condition === 'baik')
                    <span class="badge bg-success bg-opacity-10 text-success border border-success">Baik</span>
                  @elseif($req->returnRecord->item_condition === 'rusak_ringan')
                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning">Rusak Ringan</span>
                  @elseif($req->returnRecord->item_condition === 'rusak_berat')
                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger">Rusak Berat</span>
                  @endif
                @else
                  -
                @endif
              </td>
              <td class="pe-4 text-end">
                @if($req->returnRecord && $req->returnRecord->fine)
                  <span class="text-danger fw-semibold">Rp {{ number_format($req->returnRecord->fine->amount, 0, ',', '.') }}</span>
                  @if($req->returnRecord->fine->paid_status === 'paid')
                    <br><span class="badge bg-success" style="font-size: 0.65rem;">Lunas</span>
                  @else
                    <br><span class="badge bg-danger" style="font-size: 0.65rem;">Belum Lunas</span>
                  @endif
                @else
                  -
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9" class="text-center py-5 text-muted">Tidak ada data transaksi peminjaman pada rentang tanggal tersebut.</td>
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
    
    // Create print window layout
    document.body.innerHTML = `
      <div style="padding: 40px; font-family: 'Inter', sans-serif;">
        <h2 style="margin-bottom: 5px;">SIPINJAM - Laporan Transaksi Peminjaman</h2>
        <p style="color: #666; margin-top: 0; margin-bottom: 30px;">Sistem Informasi Peminjaman Inventaris Kampus</p>
        ${printContent}
      </div>
    `;
    
    window.print();
    document.body.innerHTML = originalContent;
    window.location.reload(); // Reload to restore JS event listeners
  }
</script>
@endsection
