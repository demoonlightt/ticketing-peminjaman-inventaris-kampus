@extends('layouts.app')

@section('title', 'Admin Dashboard - SIPINJAM')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Administrator</p>
      <h1 class="h3 mb-1">Dashboard & Analytics</h1>
      <p class="text-muted mb-0">Ringkasan menyeluruh operasional dan status inventaris kampus.</p>
    </div>
  </div>
</div>

<!-- 4 Cards -->
<div class="row g-3 mb-4">
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="panel p-3 d-flex align-items-center h-100 border-start border-primary border-4 shadow-sm">
      <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded-circle me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
        <i class="bi bi-box-seam"></i>
      </div>
      <div>
        <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Total Inventaris</h6>
        <h3 class="mb-0">{{ number_format($totalInventory) }}</h3>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="panel p-3 d-flex align-items-center h-100 border-start border-success border-4 shadow-sm">
      <div class="icon-shape bg-success bg-opacity-10 text-success rounded-circle me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
        <i class="bi bi-people"></i>
      </div>
      <div>
        <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Total Mahasiswa</h6>
        <h3 class="mb-0">{{ number_format($totalUser) }}</h3>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="panel p-3 d-flex align-items-center h-100 border-start border-warning border-4 shadow-sm">
      <div class="icon-shape bg-warning bg-opacity-10 text-warning rounded-circle me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
        <i class="bi bi-handbag"></i>
      </div>
      <div>
        <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Peminjaman Aktif</h6>
        <h3 class="mb-0">{{ number_format($activeBorrowings) }}</h3>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="panel p-3 d-flex align-items-center h-100 border-start border-info border-4 shadow-sm">
      <div class="icon-shape bg-info bg-opacity-10 text-info rounded-circle me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
        <i class="bi bi-calendar-check"></i>
      </div>
      <div>
        <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Pengajuan Bulan Ini</h6>
        <h3 class="mb-0">{{ number_format($monthlyRequests) }}</h3>
      </div>
    </div>
  </div>
</div>

<!-- Charts Section -->
<div class="row g-4 mb-4">
  <!-- Peminjaman per Bulan -->
  <div class="col-lg-8">
    <div class="panel h-100 shadow-sm">
      <div class="panel-header border-bottom">
        <h5 class="panel-title mb-0">Tren Peminjaman per Bulan</h5>
      </div>
      <div class="panel-body">
        <canvas id="trendChart" style="max-height: 300px;"></canvas>
      </div>
    </div>
  </div>
  
  <!-- Distribusi Kondisi (Pie Chart) -->
  <div class="col-lg-4">
    <div class="panel h-100 shadow-sm">
      <div class="panel-header border-bottom">
        <h5 class="panel-title mb-0">Kesehatan Aset (Kondisi)</h5>
      </div>
      <div class="panel-body d-flex flex-column justify-content-center align-items-center">
        <canvas id="conditionChart" style="max-height: 250px;"></canvas>
        <div class="mt-3 text-center w-100">
          <span class="badge bg-success me-1">Baik: {{ $conditions['baik'] }}</span>
          <span class="badge bg-warning text-dark me-1">Perlu Perawatan: {{ $conditions['rusak_ringan'] }}</span>
          <span class="badge bg-danger">Rusak Berat: {{ $conditions['rusak_berat'] }}</span>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <!-- Tingkat Utilisasi -->
  <div class="col-12">
    <div class="panel shadow-sm">
      <div class="panel-header border-bottom">
        <h5 class="panel-title mb-0">Tingkat Utilisasi Inventaris Tertinggi</h5>
        <small class="text-muted">Rasio antara jumlah barang yang sedang dipinjam dibandingkan total stok yang ada.</small>
      </div>
      <div class="panel-body">
        <canvas id="utilizationChart" style="max-height: 350px;"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- Tambahkan Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // 1. Tren Peminjaman per Bulan (Line/Bar)
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
      type: 'line',
      data: {
        labels: @json($trends['labels']),
        datasets: [{
          label: 'Total Peminjaman',
          data: @json($trends['data']),
          borderColor: '#0d6efd',
          backgroundColor: 'rgba(13, 110, 253, 0.1)',
          borderWidth: 2,
          fill: true,
          tension: 0.4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: { beginAtZero: true }
        }
      }
    });

    // 2. Distribusi Kondisi (Doughnut/Pie)
    const conditionCtx = document.getElementById('conditionChart').getContext('2d');
    new Chart(conditionCtx, {
      type: 'doughnut',
      data: {
        labels: ['Baik', 'Perlu Perawatan', 'Rusak Berat'],
        datasets: [{
          data: [
            @json($conditions['baik']),
            @json($conditions['rusak_ringan']),
            @json($conditions['rusak_berat'])
          ],
          backgroundColor: ['#198754', '#ffc107', '#dc3545'],
          hoverOffset: 4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '65%',
        plugins: {
          legend: {
            position: 'bottom'
          }
        }
      }
    });

    // 3. Tingkat Utilisasi (Bar Chart)
    const utilCtx = document.getElementById('utilizationChart').getContext('2d');
    new Chart(utilCtx, {
      type: 'bar',
      data: {
        labels: @json($utilization['labels']),
        datasets: [{
          label: 'Utilisasi (%)',
          data: @json($utilization['data']),
          backgroundColor: [
            'rgba(13, 110, 253, 0.8)', // Primary
            'rgba(25, 135, 84, 0.8)',  // Success
            'rgba(255, 193, 7, 0.8)',  // Warning
            'rgba(13, 202, 240, 0.8)', // Info
            'rgba(108, 117, 125, 0.8)' // Secondary
          ],
          borderRadius: 4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        indexAxis: 'y', // Membuat bar chart menjadi horizontal
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: function(context) {
                return context.raw + '% Utilisasi';
              }
            }
          }
        },
        scales: {
          x: {
            beginAtZero: true,
            max: 100,
            ticks: {
              callback: function(value) {
                return value + '%';
              }
            }
          }
        }
      }
    });
  });
</script>
@endsection
