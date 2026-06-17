@extends('layouts.app')

@section('title', 'Katalog Inventaris - SIPINJAM')

@section('content')
<div class="page-heading d-flex justify-content-between align-items-center flex-wrap">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-box" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Mahasiswa</p>
      <h1 class="h3 mb-1">Daftar Inventaris</h1>
      <p class="text-muted mb-0">Cari dan jelajahi barang yang tersedia untuk dipinjam.</p>
    </div>
  </div>
  <div class="mt-3 mt-md-0">
    <form action="{{ route('student.inventory') }}" method="GET" class="d-flex gap-2">
      <input type="text" name="search" class="form-control" placeholder="Cari barang..." value="{{ $search }}" style="max-width: 250px;">
      <select name="category_id" class="form-select" onchange="this.form.submit()" style="max-width: 170px;">
        <option value="">Semua Kategori</option>
        @foreach($categories as $cat)
          <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
      </select>
      <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
    </form>
  </div>
</div>

<div class="row g-4">
  @forelse($inventories as $item)
    <div class="col-sm-6 col-md-4 col-xl-3">
      <div class="card h-100 shadow-sm border-0">
        <div class="bg-light p-4 text-center rounded-top d-flex align-items-center justify-content-center" style="height: 180px;">
          @if($item->image)
            <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid rounded-top h-100 object-fit-cover" alt="{{ $item->name }}">
          @else
            @php
              $icon = 'bi-box';
              if(str_contains(strtolower($item->name), 'kamera')) $icon = 'bi-camera';
              elseif(str_contains(strtolower($item->name), 'proyektor')) $icon = 'bi-projector';
              elseif(str_contains(strtolower($item->name), 'laptop') || str_contains(strtolower($item->name), 'macbook')) $icon = 'bi-laptop';
              elseif(str_contains(strtolower($item->name), 'mikrofon') || str_contains(strtolower($item->name), 'mic')) $icon = 'bi-mic';
              elseif(str_contains(strtolower($item->name), 'speaker')) $icon = 'bi-volume-up';
              elseif(str_contains(strtolower($item->name), 'printer')) $icon = 'bi-printer';
              elseif(str_contains(strtolower($item->name), 'mikroskop')) $icon = 'bi-microscope';
            @endphp
            <i class="bi {{ $icon }} fs-1 text-primary"></i>
          @endif
        </div>
        <div class="card-body d-flex flex-column">
          <span class="badge bg-primary bg-opacity-10 text-primary mb-2 align-self-start">{{ $item->category->name }}</span>
          <h5 class="card-title text-truncate" title="{{ $item->name }}">{{ $item->name }}</h5>
          <p class="card-text text-muted small mb-3 flex-grow-1">{{ Str::limit($item->description, 70) }}</p>
          <div class="d-flex justify-content-between align-items-center mt-auto">
            @if($item->available_stock > 0)
              <span class="fw-semibold text-success"><i class="bi bi-check-circle me-1"></i> Tersedia ({{ $item->available_stock }})</span>
              <a href="{{ route('student.borrow', ['inventory_id' => $item->id]) }}" class="btn btn-sm btn-outline-primary">Pinjam</a>
            @else
              <span class="fw-semibold text-danger"><i class="bi bi-x-circle me-1"></i> Habis (0)</span>
              <button class="btn btn-sm btn-outline-secondary" disabled>Pinjam</button>
            @endif
          </div>
        </div>
      </div>
    </div>
  @empty
    <div class="col-12 text-center py-5">
      <i class="bi bi-box fs-1 text-muted"></i>
      <p class="text-muted mt-2">Tidak ada barang inventaris yang sesuai dengan pencarian atau filter Anda.</p>
    </div>
  @endforelse
</div>
@endsection
