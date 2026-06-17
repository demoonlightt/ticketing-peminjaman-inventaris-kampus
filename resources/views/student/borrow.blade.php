@extends('layouts.app')

@section('title', 'SIPINJAM - Ajukan Peminjaman')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-pencil-square" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Mahasiswa</p>
      <h1 class="h3 mb-1">Ajukan Peminjaman</h1>
      <p class="text-muted mb-0">Isi formulir di bawah ini untuk mengajukan peminjaman inventaris.</p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-8 mx-auto">
    <div class="panel">
      <div class="panel-header">
        <h5 class="panel-title mb-0">Formulir Peminjaman</h5>
      </div>
      <div class="panel-body">
        @if($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <form action="{{ route('student.borrow.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row mb-3">
            <div class="col-md-8">
              <label for="inventory_id" class="form-label">Pilih Barang</label>
              <select name="inventory_id" class="form-select" id="inventory_id" required>
                <option value="" disabled {{ is_null($selectedInventoryId) ? 'selected' : '' }}>-- Pilih Barang --</option>
                @foreach($inventories as $item)
                  <option value="{{ $item->id }}" {{ $selectedInventoryId == $item->id ? 'selected' : '' }}>
                    {{ $item->name }} (Tersedia: {{ $item->available_stock }})
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label for="quantity" class="form-label">Jumlah</label>
              <input type="number" name="quantity" class="form-control" id="quantity" value="{{ old('quantity', 1) }}" min="1" required>
            </div>
          </div>
          
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="borrow_date" class="form-label">Tanggal Pinjam</label>
              <input type="date" name="borrow_date" class="form-control" id="borrow_date" value="{{ old('borrow_date', date('Y-m-d')) }}" required>
            </div>
            <div class="col-md-6">
              <label for="return_date" class="form-label">Tanggal Kembali</label>
              <input type="date" name="return_date" class="form-control" id="return_date" value="{{ old('return_date', date('Y-m-d', strtotime('+3 days'))) }}" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="purpose" class="form-label">Keperluan</label>
            <textarea name="purpose" class="form-control" id="purpose" rows="3" placeholder="Jelaskan keperluan peminjaman barang ini..." required>{{ old('purpose') }}</textarea>
          </div>

          <div class="mb-4">
            <label for="attachment" class="form-label">Surat Pengajuan (Opsional)</label>
            <input name="attachment" class="form-control" type="file" id="attachment" accept=".pdf,.jpg,.png">
            <div class="form-text">Unggah surat pengantar dari dosen jika diperlukan (Maks 2MB).</div>
          </div>

          <div class="d-flex justify-content-end">
            <button type="reset" class="btn btn-light me-2">Batal</button>
            <button type="submit" class="btn btn-primary"><i class="bi bi-send me-1"></i> Ajukan Sekarang</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
