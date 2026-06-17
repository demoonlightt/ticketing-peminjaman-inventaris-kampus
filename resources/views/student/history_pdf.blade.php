<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Peminjaman - {{ $student->name }}</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    body { font-family: 'Inter', sans-serif; background-color: #fff; color: #333; }
    .receipt-header { border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 30px; }
    .logo-text { font-size: 24px; font-weight: bold; color: #000; }
    .ticket-badge { background-color: #000; color: #fff; padding: 5px 15px; font-weight: bold; font-size: 14px; }
    .signature-area { margin-top: 50px; }
    @media print {
      .no-print { display: none !important; }
      body { padding: 0; margin: 0; }
    }
  </style>
</head>
<body class="p-5" onload="window.print()">

  <div class="container bg-white border p-5 shadow-sm rounded" style="max-width: 900px;">
    
    <div class="no-print d-flex justify-content-between mb-4">
      <a href="{{ route('student.download_pdf') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
      <button onclick="window.print()" class="btn btn-primary">Cetak Riwayat</button>
    </div>

    <div class="receipt-header d-flex justify-content-between align-items-center">
      <div>
        <div class="logo-text">SIPINJAM</div>
        <div class="text-muted small">Sistem Informasi Peminjaman Inventaris Kampus</div>
      </div>
      <div class="text-end">
        <h5 class="mb-0 fw-bold">LAPORAN RIWAYAT PEMINJAMAN</h5>
        <span class="text-muted small">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</span>
      </div>
    </div>

    <div class="row mb-4">
      <div class="col-12">
        <h6 class="text-uppercase fw-bold text-muted small">Identitas Mahasiswa</h6>
        <table class="table table-sm table-borderless" style="max-width: 500px;">
          <tr>
            <td style="width: 25%"><strong>Nama</strong></td>
            <td>: {{ $student->name }}</td>
          </tr>
          <tr>
            <td><strong>NIM</strong></td>
            <td>: {{ $student->mahasiswaProfile->nim }}</td>
          </tr>
          <tr>
            <td><strong>Prodi</strong></td>
            <td>: {{ $student->mahasiswaProfile->prodi }}</td>
          </tr>
          <tr>
            <td><strong>Fakultas</strong></td>
            <td>: {{ $student->mahasiswaProfile->fakultas }}</td>
          </tr>
        </table>
      </div>
    </div>

    <div class="mb-5">
      <h6 class="text-uppercase fw-bold text-muted small">Rekapitulasi Transaksi Peminjaman</h6>
      <table class="table table-bordered align-middle">
        <thead class="table-dark">
          <tr>
            <th style="width: 5%" class="text-center">No</th>
            <th style="width: 15%">No. Tiket</th>
            <th style="width: 30%">Daftar Barang</th>
            <th style="width: 15%">Tgl Pinjam</th>
            <th style="width: 15%">Tgl Kembali</th>
            <th style="width: 10%">Status</th>
            <th style="width: 10%">Denda</th>
          </tr>
        </thead>
        <tbody>
          @forelse($borrowings as $index => $req)
            <tr>
              <td class="text-center">{{ $index + 1 }}</td>
              <td><code>#REQ-{{ str_pad($req->id, 4, '0', STR_PAD_LEFT) }}</code></td>
              <td>
                @foreach($req->items as $item)
                  {{ $item->inventory->name }} ({{ $item->quantity }}x)<br>
                @endforeach
              </td>
              <td>{{ \Carbon\Carbon::parse($req->borrow_date)->format('d M Y') }}</td>
              <td>{{ \Carbon\Carbon::parse($req->return_date)->format('d M Y') }}</td>
              <td class="text-center text-capitalize">
                <span class="badge {{ $req->status === 'returned' ? 'bg-success' : ($req->status === 'rejected' ? 'bg-danger' : 'bg-warning text-dark') }}">
                  {{ $req->status }}
                </span>
              </td>
              <td class="text-end">
                @if($req->returnRecord && $req->returnRecord->fine)
                  Rp {{ number_format($req->returnRecord->fine->amount, 0, ',', '.') }}
                @else
                  -
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center py-4 text-muted">Tidak ada transaksi peminjaman pada periode ini.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="row signature-area text-center justify-content-end">
      <div class="col-4">
        <p class="mb-0">Yogyakarta, {{ date('d M Y') }}</p>
        <p class="mb-5">Mahasiswa Bersangkutan,</p>
        <strong>{{ $student->name }}</strong>
        <p class="text-muted small mb-0">NIM: {{ $student->mahasiswaProfile->nim }}</p>
      </div>
    </div>

    <div class="mt-5 pt-3 border-top text-center text-muted small">
      Laporan riwayat peminjaman SIPINJAM. Dicetak secara otomatis pada {{ date('d M Y H:i') }}.
    </div>

  </div>

</body>
</html>
