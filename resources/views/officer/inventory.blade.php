@extends('layouts.app')

@section('title', 'Daftar Inventaris - SIPINJAM')

@section('content')
<div class="page-heading d-flex justify-content-between align-items-center flex-wrap">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-box" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Petugas Inventaris</p>
      <h1 class="h3 mb-1">Daftar Inventaris</h1>
      <p class="text-muted mb-0">Pantau ketersediaan stok fisik barang dan status peminjaman.</p>
    </div>
  </div>
  <form action="{{ route('officer.inventory') }}" method="GET" class="mt-3 mt-md-0 d-flex gap-2">
    <input type="text" name="search" class="form-control" placeholder="Cari nama/kode barang..." value="{{ request('search') }}" style="max-width: 250px;">
    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
  </form>
</div>

<div class="panel shadow-sm">
  <div class="panel-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th class="ps-4">Kode</th>
            <th>Barang</th>
            <th>Kategori</th>
            <th class="text-center">Total Stok</th>
            <th class="text-center">Dipinjam</th>
            <th class="text-center">Tersedia</th>
            <th class="text-center">Kondisi</th>
            <th class="pe-4 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($inventories as $inv)
            <tr>
              <td class="ps-4 fw-semibold text-muted">{{ $inv->code }}</td>
              <td>
                <h6 class="mb-0">{{ $inv->name }}</h6>
              </td>
              <td>{{ $inv->category->name }}</td>
              <td class="text-center">{{ $inv->total_stock }}</td>
              <td class="text-center">
                <span class="badge bg-warning text-dark">{{ $inv->total_stock - $inv->available_stock }}</span>
              </td>
              <td class="text-center">
                <span class="badge bg-success">{{ $inv->available_stock }}</span>
              </td>
              <td class="text-center">
                @if($inv->condition === 'baik')
                  <span class="badge bg-success bg-opacity-10 text-success border border-success">Baik</span>
                @elseif($inv->condition === 'rusak_ringan')
                  <span class="badge bg-warning bg-opacity-10 text-warning border border-warning text-dark">Rusak Ringan</span>
                @elseif($inv->condition === 'rusak_berat')
                  <span class="badge bg-danger bg-opacity-10 text-danger border border-danger">Rusak Berat</span>
                @endif
              </td>
              <td class="pe-4 text-end">
                <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#descModal-{{ $inv->id }}"><i class="bi bi-eye"></i> Detail</button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center py-4 text-muted">Tidak ada data inventaris ditemukan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@foreach($inventories as $inv)
  <!-- Detail Modal -->
  <div class="modal fade" id="descModal-{{ $inv->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail Barang: {{ $inv->name }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p><strong>Kode Barang:</strong> <code>{{ $inv->code }}</code></p>
          <p><strong>Lokasi Penyimpanan:</strong> <span class="badge bg-secondary">{{ $inv->location }}</span></p>
          <p><strong>Deskripsi:</strong></p>
          <p class="text-muted mb-0">{{ $inv->description ?? 'Tidak ada deskripsi.' }}</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
@endforeach
@endsection
