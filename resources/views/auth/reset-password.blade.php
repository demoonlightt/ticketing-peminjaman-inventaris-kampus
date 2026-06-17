@extends('layouts.auth')

@section('title', 'Reset Password - SIPINJAM')

@section('content')
<div class="card shadow-sm border-0 rounded-3">
  <div class="card-body p-4 p-md-5">
    <div class="text-center mb-4">
      <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
        <i class="bi bi-shield-lock fs-2"></i>
      </div>
      <h3 class="fw-bold mb-1">Reset Password</h3>
      <p class="text-muted">Masukkan password baru Anda di bawah ini.</p>
    </div>

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

    <form action="{{ route('password.update') }}" method="POST">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">

      <div class="mb-3">
        <label for="email" class="form-label">Email Kampus</label>
        <input type="email" name="email" class="form-control" id="email" value="{{ $email ?? old('email') }}" required readonly>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password Baru</label>
        <input type="password" name="password" class="form-control" id="password" placeholder="••••••••" required>
      </div>

      <div class="mb-4">
        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="••••••••" required>
      </div>

      <div class="d-grid gap-2 mb-3">
        <button type="submit" class="btn btn-primary py-2">Reset Password</button>
      </div>
    </form>
  </div>
</div>
@endsection
