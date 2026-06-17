@extends('layouts.auth')

@section('title', 'Lupa Password - SIPINJAM')

@section('content')
<div class="card shadow-sm border-0 rounded-3">
  <div class="card-body p-4 p-md-5">
    <div class="text-center mb-4">
      <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
        <i class="bi bi-key fs-2"></i>
      </div>
      <h3 class="fw-bold mb-1">Lupa Password?</h3>
      <p class="text-muted">Masukkan email Anda untuk menerima link reset password.</p>
    </div>

    @if(session('status'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

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

    <form action="{{ route('password.email') }}" method="POST">
      @csrf
      <div class="mb-4">
        <label for="email" class="form-label">Email Kampus</label>
        <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" placeholder="mahasiswa@kampus.ac.id" required>
      </div>

      <div class="d-grid gap-2 mb-3">
        <button type="submit" class="btn btn-primary py-2">Kirim Link Reset</button>
      </div>
    </form>

    <p class="text-center text-muted mb-0">Kembali ke <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Sign In</a></p>
  </div>
</div>
@endsection
