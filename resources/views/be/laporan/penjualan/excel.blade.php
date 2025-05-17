<table>
    <thead>
        <tr>
            <th colspan="7" style="text-align: center; font-size: 16px;"><strong>LAPORAN PENJUALAN</strong></th>
        </tr>
        <tr>
            <td colspan="7" style="text-align: center;">
                Periode: {{ $from }} s.d. {{ $to }}
            </td>
        </tr>
        <tr></tr>
        <tr style="background-color: #f0f0f0; font-weight: bold;">
            <th>No</th>
            <th>Tanggal</th>
            <th>Kode Transaksi</th>
            <th>Nama Pelanggan</th>
            <th>Status</th>
            <th>Produk / Keterangan</th>
            <th class="text-right">Total Bayar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($penjualans as $index => $penjualan)
        {{-- Baris Utama --}}
        <tr style="font-weight: bold;">
            <td>{{ $index + 1 }}</td>
            <td>{{ \Carbon\Carbon::parse($penjualan->tgl_penjualan)->translatedFormat('d F Y') }}</td>
            <td>{{ $penjualan->kode_transaksi }}</td>
            <td>{{ $penjualan->pelanggan->nama_pelanggan }}</td>
            <td>{{ $penjualan->status_order }}</td>
            <td>{{ $penjualan->keterangan_status }}</td>
            <td class="text-right">Rp{{ number_format($penjualan->total_bayar, 0, ',', '.') }}</td>
        </tr>

        {{-- Baris Detail Produk --}}
        <tr style="background-color: #eaeaea;">
            <td></td>
            <td colspan="6"><strong>Detail Produk:</strong></td>
        </tr>
        <tr style="background-color: #ddd;">
            <td></td>
            <td colspan="2"><strong>Nama Produk</strong></td>
            <td><strong>Harga</strong></td>
            <td><strong>Jumlah</strong></td>
            <td colspan="2"><strong>Subtotal</strong></td>
        </tr>
        @foreach($penjualan->detailPenjualan as $detail)
        <tr>
            <td></td>
            <td colspan="2">{{ $detail->obat->nama_obat }}</td>
            <td>Rp{{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
            <td>{{ $detail->jumlah_beli }}</td>
            <td colspan="2">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
        @endforeach

        {{-- Total Keseluruhan --}}
        <tr style="font-weight: bold;">
            <td colspan="6" style="text-align: right;">Total Seluruh Penjualan</td>
            <td class="text-right">Rp{{ number_format($totalSeluruhPenjualan, 0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>
