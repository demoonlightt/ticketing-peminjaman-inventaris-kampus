@extends('layouts.app')

@section('title', 'Verifikasi Pengajuan - SIPINJAM')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-inbox" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Peminjaman</p>
      <h1 class="h3 mb-1">Pengajuan Masuk</h1>
      <p class="text-muted mb-0">Verifikasi permintaan peminjaman inventaris dari mahasiswa.</p>
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

<div class="panel">
  <div class="panel-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th class="ps-4">No. Tiket</th>
            <th>Mahasiswa</th>
            <th>Inventaris</th>
            <th>Durasi Pinjam</th>
            <th>Surat/Dokumen</th>
            <th class="pe-4 text-end">Aksi Verifikasi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($requests as $req)
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
                {{ \Carbon\Carbon::parse($req->borrow_date)->format('d M') }} - {{ \Carbon\Carbon::parse($req->return_date)->format('d M Y') }}
              </td>
              <td>
                @if($req->attachment)
                  <a href="{{ asset('storage/' . $req->attachment) }}" target="_blank" class="btn btn-sm btn-light text-primary"><i class="bi bi-file-earmark"></i> Lihat Dokumen</a>
                @else
                  <span class="text-muted small">Tidak ada lampiran</span>
                @endif
              </td>
              <td class="pe-4 text-end">
                <form action="{{ route('officer.requests.approve', $req->id) }}" method="POST" style="display:inline;">
                  @csrf
                  <button type="submit" class="btn btn-sm btn-success me-1"><i class="bi bi-check-lg"></i> Setujui</button>
                </form>
                <form action="{{ route('officer.requests.reject', $req->id) }}" method="POST" style="display:inline;">
                  @csrf
                  <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-x-lg"></i> Tolak</button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center py-4 text-muted">Tidak ada pengajuan peminjaman baru saat ini.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
