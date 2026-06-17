<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Bukti Peminjaman #REQ-{{ str_pad($borrowRequest->id, 4, '0', STR_PAD_LEFT) }}</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    body { font-family: 'Inter', sans-serif; background-color: #fff; color: #333; }
    .receipt-header { border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 30px; }
    .logo-text { font-size: 24px; font-weight: bold; color: #000; }
    .ticket-badge { background-color: #000; color: #fff; padding: 5px 15px; font-weight: bold; font-size: 14px; }
    .info-table th { width: 30%; font-weight: 600; color: #555; }
    .info-table td { width: 70%; }
    .signature-area { margin-top: 50px; }
    @media print {
      .no-print { display: none !important; }
      body { padding: 0; margin: 0; }
    }
  </style>
</head>
<body class="p-5" onload="window.print()">

  <div class="container bg-white border p-5 shadow-sm rounded" style="max-width: 800px;">
    
    <div class="no-print d-flex justify-content-between mb-4">
      <a href="{{ route('student.download_pdf') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
      <button onclick="window.print()" class="btn btn-primary">Cetak Bukti</button>
    </div>

    <div class="receipt-header d-flex justify-content-between align-items-center">
      <div>
        <div class="logo-text">SIPINJAM</div>
        <div class="text-muted small">Sistem Informasi Peminjaman Inventaris Kampus</div>
      </div>
      <div>
        <span class="ticket-badge">TIKET: #REQ-{{ str_pad($borrowRequest->id, 4, '0', STR_PAD_LEFT) }}</span>
      </div>
    </div>

    <div class="row mb-4">
      <div class="col-6">
        <h6 class="text-uppercase fw-bold text-muted small">Detail Peminjam</h6>
        <p class="mb-0"><strong>Nama:</strong> {{ $borrowRequest->student->name }}</p>
        <p class="mb-0"><strong>NIM:</strong> {{ $borrowRequest->student->mahasiswaProfile->nim }}</p>
        <p class="mb-0"><strong>Prodi:</strong> {{ $borrowRequest->student->mahasiswaProfile->prodi }}</p>
        <p class="mb-0"><strong>Fakultas:</strong> {{ $borrowRequest->student->mahasiswaProfile->fakultas }}</p>
      </div>
      <div class="col-6 text-end">
        <h6 class="text-uppercase fw-bold text-muted small">Waktu Transaksi</h6>
        <p class="mb-0"><strong>Tgl Pengajuan:</strong> {{ \Carbon\Carbon::parse($borrowRequest->request_date)->format('d M Y') }}</p>
        <p class="mb-0"><strong>Tgl Pinjam:</strong> {{ \Carbon\Carbon::parse($borrowRequest->borrow_date)->format('d M Y') }}</p>
        <p class="mb-0"><strong>Batas Kembali:</strong> {{ \Carbon\Carbon::parse($borrowRequest->return_date)->format('d M Y') }}</p>
        <p class="mb-0"><strong>Status:</strong> <span class="text-uppercase fw-bold text-primary">{{ $borrowRequest->status }}</span></p>
      </div>
    </div>

    <div class="mb-4">
      <h6 class="text-uppercase fw-bold text-muted small">Keperluan Peminjaman</h6>
      <p class="border p-3 rounded bg-light">{{ $borrowRequest->purpose }}</p>
    </div>

    <div class="mb-5">
      <h6 class="text-uppercase fw-bold text-muted small">Daftar Barang yang Dipinjam</h6>
      <table class="table table-bordered align-middle">
        <thead class="table-dark">
          <tr>
            <th style="width: 10%" class="text-center">No</th>
            <th style="width: 25%">Kode Barang</th>
            <th style="width: 50%">Nama Barang</th>
            <th style="width: 15%" class="text-center">Jumlah</th>
          </tr>
        </thead>
        <tbody>
          @foreach($borrowRequest->items as $index => $item)
            <tr>
              <td class="text-center">{{ $index + 1 }}</td>
              <td><code>{{ $item->inventory->code }}</code></td>
              <td>{{ $item->inventory->name }}</td>
              <td class="text-center">{{ $item->quantity }} unit</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="row signature-area text-center">
      <div class="col-6">
        <p class="mb-5">Petugas Inventaris</p>
        <strong>{{ $borrowRequest->approvedBy ? $borrowRequest->approvedBy->name : '........................' }}</strong>
        <p class="text-muted small mb-0">{{ $borrowRequest->approvedBy && $borrowRequest->approvedBy->officerProfile ? $borrowRequest->approvedBy->officerProfile->division : 'Petugas Perlengkapan' }}</p>
      </div>
      <div class="col-6">
        <p class="mb-5">Peminjam (Mahasiswa)</p>
        <strong>{{ $borrowRequest->student->name }}</strong>
        <p class="text-muted small mb-0">NIM: {{ $borrowRequest->student->mahasiswaProfile->nim }}</p>
      </div>
    </div>

    <div class="mt-5 pt-3 border-top text-center text-muted small">
      Dokumen ini merupakan bukti resmi peminjaman inventaris kampus SIPINJAM.<br>
      Dicetak secara otomatis pada {{ date('d M Y H:i') }}.
    </div>

  </div>

</body>
</html>
