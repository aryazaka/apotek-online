<table>
  <thead>
    <tr>
      <th colspan="9" style="text-align: center; font-size: 16px;"><strong>LAPORAN PENJUALAN</strong></th>
    </tr>
    <tr>
      <td colspan="9" style="text-align: center;">
        Periode:
        @if($from == 'Semua Data')
          Semua Data
        @else
          {{ $from }} s.d. {{ $to }}
        @endif
      </td>
    </tr>
    <tr style="background-color: #f0f0f0; font-weight: bold;">
      <th>No</th>
      <th>Tanggal</th>
      <th>Kode Transaksi</th>
      <th>Nama Pelanggan</th>
      <th>Status</th>
      <th>Keterangan</th>
      <th>Ongkir</th>
      <th>Biaya App</th>
      <th>Total Bayar</th>
    </tr>
  </thead>
  <tbody>
    @foreach($penjualans as $index => $penjualan)
    {{-- Baris Utama --}}
    <tr>
      <td>{{ $index + 1 }}</td>
      <td>{{ \Carbon\Carbon::parse($penjualan->tgl_penjualan)->translatedFormat('d F Y') }}</td>
      <td>{{ $penjualan->kode_transaksi }}</td>
      <td>{{ $penjualan->pelanggan->nama_pelanggan }}</td>
      <td>{{ ucfirst($penjualan->status_order) }}</td>
      <td>{{ $penjualan->keterangan_status }}</td>
      <td>Rp{{ number_format($penjualan->ongkos_kirim, 0, ',', '.') }}</td>
      <td>Rp{{ number_format($penjualan->biaya_app, 0, ',', '.') }}</td>
      <td>Rp{{ number_format($penjualan->total_bayar, 0, ',', '.') }}</td>
    </tr>

    {{-- Baris Detail Produk --}}
    <tr style="background-color: #eaeaea;">
      <td></td>
      <td colspan="8"><strong>Detail Produk:</strong></td>
    </tr>
    <tr style="background-color: #ddd;">
      <td></td>
      <td colspan="4"><strong>Nama Produk</strong></td>
      <td><strong>Jumlah</strong></td>
      <td><strong>Harga</strong></td>
      <td colspan="2"><strong>Subtotal</strong></td>
    </tr>
    @foreach($penjualan->detailPenjualan as $detail)
    <tr>
      <td></td>
      <td colspan="4">{{ $detail->obat->nama_obat }}</td>
      <td>{{ $detail->jumlah_beli }}</td>
      <td>Rp{{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
      <td colspan="2">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
    </tr>
    @endforeach

    {{-- Informasi Pengiriman --}}
    @if($penjualan->pengiriman)
    @php
      $pelanggan = $penjualan->pelanggan;
      $alamatLengkap = '-';
      if ($pelanggan) {
          for ($i = 1; $i <= 3; $i++) {
              $alamat = $pelanggan->{"alamat$i"};
              if ($alamat) {
                  $alamatLengkap = $alamat . ', ' .
                  $pelanggan->{"kota$i"} . ', ' .
                  $pelanggan->{"propinsi$i"} . ', ' .
                  $pelanggan->{"kodepos$i"};
                  break;
              }
          }
      }
    @endphp
    <tr style="background-color: #eaeaea;">
      <td></td>
      <td colspan="8"><strong>Informasi Pengiriman:</strong></td>
    </tr>
    <tr>
      <td></td>
      <td colspan="2">Alamat Tujuan</td>
      <td colspan="6">{{ $alamatLengkap }}</td>
    </tr>
    <tr>
      <td></td>
      <td colspan="2">Nama Kurir</td>
      <td colspan="6">{{ $penjualan->pengiriman->nama_kurir ?? '-' }}</td>
    </tr>
    <tr>
      <td></td>
      <td colspan="2">No. Telp Kurir</td>
      <td colspan="6">{{ $penjualan->pengiriman->telpon_kurir ?? '-' }}</td>
    </tr>
    @endif

    @endforeach

    {{-- Total Keseluruhan --}}
    <tr style="font-weight: bold;">
      <td colspan="8" style="text-align: right;">Total Seluruh Penjualan</td>
      <td style="text-align: right;">Rp{{ number_format($totalSeluruhPenjualan, 0, ',', '.') }}</td>
    </tr>
  </tbody>
</table>
