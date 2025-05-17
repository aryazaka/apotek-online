<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Pembelian</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #000; }
    h2, h4 { text-align: center; margin: 0; padding: 0; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; page-break-inside: auto; }
    th, td { border: 1px solid #000; padding: 6px; vertical-align: top; }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }
    .no-border { border: none !important; }
    .detail-wrapper { page-break-inside: avoid; margin-bottom: 10px; }
    .subtable { width: 100%; border-collapse: collapse; margin-top: 5px; }
    .subtable th, .subtable td {
      font-size: 11px;
      border: 1px solid #999;
      padding: 4px;
    }
    .header-table th {
      background-color: #eee;
    }
  </style>
</head>
<body>

  <h2>LAPORAN PEMBELIAN</h2>
  <h4>
    Periode:
    @if($from == 'Semua Data')
        Semua Data
    @else
        {{ $from }} s.d. {{ $to }}
    @endif
  </h4>

  <table>
    <thead class="header-table">
      <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>No Nota</th>
        <th>Distributor</th>
        <th class="text-right">Total Bayar</th>
      </tr>
    </thead>
    <tbody>
      @foreach($pembelians as $index => $pembelian)
      <tr>
        <td class="text-center">{{ $index + 1 }}</td>
        <td>{{ \Carbon\Carbon::parse($pembelian->tgl_pembelian)->translatedFormat('d F Y') }}</td>
        <td>{{ $pembelian->nonota }}</td>
        <td>{{ $pembelian->distributor->nama_distributor ?? '-' }}</td>
        <td class="text-right">Rp{{ number_format($pembelian->total_bayar, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <td colspan="5">
          <div class="detail-wrapper">
            <strong>Detail Obat:</strong>
            <table class="subtable">
              <thead>
                <tr>
                  <th>Nama Obat</th>
                  <th class="text-right">Harga Beli</th>
                  <th class="text-center">Jumlah Beli</th>
                  <th class="text-right">Subtotal</th>
                </tr>
              </thead>
              <tbody>
                @foreach($pembelian->detailPembelian as $detail)
                <tr>
                  <td>{{ $detail->obat->nama_obat ?? '-' }}</td>
                  <td class="text-right">Rp{{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                  <td class="text-center">{{ $detail->jumlah_beli }}</td>
                  <td class="text-right">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </td>
      </tr>
      @endforeach

      <tr>
        <td colspan="4" class="text-right"><strong>Total Seluruh Pembelian</strong></td>
        <td class="text-right"><strong>Rp{{ number_format($totalSeluruhPembelians, 0, ',', '.') }}</strong></td>
      </tr>
    </tbody>
  </table>

</body>
</html>
