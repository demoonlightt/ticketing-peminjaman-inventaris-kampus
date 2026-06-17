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

<div class="row g-4">
  <div class="col-12">
    <div class="panel shadow-sm">
      <div class="panel-header">
        <h5 class="panel-title mb-0">Penerimaan Pengembalian Barang</h5>
      </div>
      <div class="panel-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="ps-4">No. Tiket</th>
                <th>Mahasiswa</th>
                <th>Inventaris</th>
                <th>Batas Kembali</th>
                <th class="pe-4 text-end">Aksi Konfirmasi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($borrowedRequests as $req)
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
                  <td>
                    {{ \Carbon\Carbon::parse($req->return_date)->format('d M Y') }}
                    @if(strtotime($req->return_date) < strtotime(date('Y-m-d')))
                      <span class="badge bg-danger ms-1">Terlambat</span>
                    @endif
                  </td>
                  <td class="pe-4 text-end">
                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#returnModal-{{ $req->id }}">
                      <i class="bi bi-box-arrow-in-down"></i> Terima Barang
                    </button>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center py-4 text-muted">Tidak ada barang yang sedang dipinjam saat ini.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="col-12">
    <div class="panel shadow-sm">
      <div class="panel-header">
        <h5 class="panel-title mb-0">Riwayat Pengembalian & Denda</h5>
      </div>
      <div class="panel-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="ps-4">No. Tiket</th>
                <th>Mahasiswa</th>
                <th>Inventaris</th>
                <th>Tgl Kembali</th>
                <th>Kondisi Cek</th>
                <th>Detail Denda</th>
                <th class="pe-4 text-end">Aksi Denda</th>
              </tr>
            </thead>
            <tbody>
              @forelse($returnedRequests as $req)
                <tr>
                  <td class="ps-4 fw-semibold text-muted">#REQ-{{ str_pad($req->id, 4, '0', STR_PAD_LEFT) }}</td>
                  <td>
                    <h6 class="mb-0">{{ $req->student->name }}</h6>
                    <small class="text-muted">NIM: {{ $req->student->mahasiswaProfile->nim }}</small>
                  </td>
                  <td>
                    @foreach($req->items as $item)
                      {{ $item->inventory->name }} ({{ $item->quantity }}x)<br>
                    @endforeach
                  </td>
                  <td>{{ \Carbon\Carbon::parse($req->returnRecord->return_date)->format('d M Y') }}</td>
                  <td>
                    @if($req->returnRecord->item_condition === 'baik')
                      <span class="badge bg-success">Baik</span>
                    @elseif($req->returnRecord->item_condition === 'rusak_ringan')
                      <span class="badge bg-warning text-dark">Rusak Ringan</span>
                    @elseif($req->returnRecord->item_condition === 'rusak_berat')
                      <span class="badge bg-danger">Rusak Berat</span>
                    @endif
                  </td>
                  <td>
                    @if($req->returnRecord->fine)
                      <div class="small">
                        <strong>Rp {{ number_format($req->returnRecord->fine->amount, 0, ',', '.') }}</strong><br>
                        <span class="text-muted text-wrap d-block" style="max-width: 250px;">{{ $req->returnRecord->fine->reason }}</span>
                      </div>
                    @else
                      <span class="text-muted small">-</span>
                    @endif
                  </td>
                  <td class="pe-4 text-end">
                    @if($req->returnRecord->fine)
                      @if($req->returnRecord->fine->paid_status === 'unpaid')
                        <form action="{{ route('officer.fines.pay', $req->returnRecord->fine->id) }}" method="POST" style="display:inline;">
                          @csrf
                          <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-cash-coin"></i> Bayar Denda</button>
                        </form>
                      @else
                        <span class="badge bg-success px-3 py-2"><i class="bi bi-check-circle me-1"></i> Lunas</span>
                      @endif
                    @else
                      <span class="text-muted small">-</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center py-4 text-muted">Belum ada riwayat pengembalian barang.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@foreach($borrowedRequests as $req)
  <!-- Modal Konfirmasi for Request #{{ $req->id }} -->
  <div class="modal fade" id="returnModal-{{ $req->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Terima Pengembalian #REQ-{{ str_pad($req->id, 4, '0', STR_PAD_LEFT) }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('officer.requests.return', $req->id) }}" method="POST">
          @csrf
          <div class="modal-body">
            <div class="mb-3">
              <label for="return_date-{{ $req->id }}" class="form-label">Tanggal Pengembalian</label>
              <input type="date" name="return_date" id="return_date-{{ $req->id }}" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="mb-3">
              <label for="item_condition-{{ $req->id }}" class="form-label">Kondisi Barang Saat Diterima</label>
              <select name="item_condition" id="item_condition-{{ $req->id }}" class="form-select" required>
                <option value="baik">Baik / Normal</option>
                <option value="rusak_ringan">Rusak Ringan (Denda Rp 50.000)</option>
                <option value="rusak_berat">Rusak Berat (Denda Rp 150.000)</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="notes-{{ $req->id }}" class="form-label">Catatan Pemeriksaan (Opsional)</label>
              <textarea name="notes" id="notes-{{ $req->id }}" class="form-control" rows="3" placeholder="Tulis catatan kondisi fisik barang secara detail..."></textarea>
            </div>
            <div class="alert alert-warning small mb-0">
              <i class="bi bi-info-circle me-1"></i> Sistem akan secara otomatis menghitung denda keterlambatan sebesar <strong>Rp 5.000 per hari</strong> apabila tanggal pengembalian melewati batas waktu.
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Konfirmasi & Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endforeach
@endsection
