@extends('layouts.app')

@section('title', 'Sedang Dipinjam - SIPINJAM')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-handbag" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Peminjaman</p>
      <h1 class="h3 mb-1">Daftar Barang Dipinjam</h1>
      <p class="text-muted mb-0">Kelola penyerahan barang dan daftar inventaris yang saat ini sedang dipinjam mahasiswa.</p>
    </div>
  </div>
</div>


<div class="panel">
  <div class="panel-header">
    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab" aria-controls="approved" aria-selected="true">Menunggu Diserahkan</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="borrowed-tab" data-bs-toggle="tab" data-bs-target="#borrowed" type="button" role="tab" aria-controls="borrowed" aria-selected="false">Sedang Dipinjam</button>
      </li>
    </ul>
  </div>
  <div class="panel-body p-0">
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="approved" role="tabpanel" aria-labelledby="approved-tab">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="ps-4">No. Tiket</th>
                <th>Mahasiswa</th>
                <th>Inventaris</th>
                <th>Tgl Ambil (Rencana)</th>
                <th class="pe-4 text-end">Aksi Penyerahan</th>
              </tr>
            </thead>
            <tbody>
              @php
                $approvedRequests = $requests->where('status', 'approved');
              @endphp
              @forelse($approvedRequests as $req)
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
                  <td class="pe-4 text-end">
                    <form action="{{ route('officer.requests.handover', $req->id) }}" method="POST" class="d-inline-flex align-items-center gap-2">
                      @csrf
                      <input type="text" name="notes" placeholder="Catatan kondisi (opsional)" class="form-control form-control-sm" style="max-width: 200px;">
                      <button type="submit" class="btn btn-sm btn-primary text-nowrap"><i class="bi bi-box-arrow-up-right"></i> Serahkan Barang</button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center py-4 text-muted">Tidak ada pengajuan menunggu penyerahan barang.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      <div class="tab-pane fade" id="borrowed" role="tabpanel" aria-labelledby="borrowed-tab">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="ps-4">No. Tiket</th>
                <th>Mahasiswa</th>
                <th>Inventaris</th>
                <th>Batas Kembali</th>
                <th>Catatan Penyerahan</th>
                <th class="pe-4">Status</th>
              </tr>
            </thead>
            <tbody>
              @php
                $borrowedRequests = $requests->where('status', 'borrowed');
              @endphp
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
                  <td>{{ \Carbon\Carbon::parse($req->return_date)->format('d M Y') }}</td>
                  <td>{{ $req->handover->notes ?? '-' }}</td>
                  <td class="pe-4">
                    @if(strtotime($req->return_date) < strtotime(date('Y-m-d')))
                      <span class="badge bg-danger">Terlambat</span>
                    @else
                      <span class="badge bg-info text-dark">Aktif</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center py-4 text-muted">Tidak ada barang yang sedang dipinjam saat ini.</td>
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
