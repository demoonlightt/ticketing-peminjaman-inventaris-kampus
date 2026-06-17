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
  <div class="mt-3 mt-md-0 d-flex gap-2">
    <input type="text" class="form-control" placeholder="Cari nama/kode barang..." style="max-width: 250px;">
    <button class="btn btn-primary"><i class="bi bi-search"></i></button>
  </div>
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
            <th class="text-center">Rusak</th>
            <th class="pe-4 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="ps-4 fw-semibold text-muted">INV-ELK-001</td>
            <td>
              <h6 class="mb-0">Proyektor Epson EB-X05</h6>
            </td>
            <td>Elektronik</td>
            <td class="text-center">10</td>
            <td class="text-center"><span class="badge bg-warning text-dark">8</span></td>
            <td class="text-center"><span class="badge bg-success">2</span></td>
            <td class="text-center"><span class="badge bg-danger">0</span></td>
            <td class="pe-4 text-end">
              <button class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i> Detail</button>
            </td>
          </tr>
          <tr>
            <td class="ps-4 fw-semibold text-muted">INV-FOT-002</td>
            <td>
              <h6 class="mb-0">Kamera DSLR Canon EOS</h6>
            </td>
            <td>Fotografi</td>
            <td class="text-center">5</td>
            <td class="text-center"><span class="badge bg-warning text-dark">5</span></td>
            <td class="text-center"><span class="badge bg-danger">0</span></td>
            <td class="text-center"><span class="badge bg-danger">0</span></td>
            <td class="pe-4 text-end">
              <button class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i> Detail</button>
            </td>
          </tr>
          <tr>
            <td class="ps-4 fw-semibold text-muted">INV-AUD-005</td>
            <td>
              <h6 class="mb-0">Microphone Wireless Shure</h6>
            </td>
            <td>Audio</td>
            <td class="text-center">15</td>
            <td class="text-center"><span class="badge bg-warning text-dark">2</span></td>
            <td class="text-center"><span class="badge bg-success">11</span></td>
            <td class="text-center"><span class="badge bg-danger">2</span></td>
            <td class="pe-4 text-end">
              <button class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i> Detail</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
