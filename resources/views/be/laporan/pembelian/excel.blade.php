<table>
    <thead>
        <tr>
            <th colspan="7" style="text-align: center; font-size: 16px;"><strong>LAPORAN PEMBELIAN</strong></th>
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
            <th>No Nota</th>
            <th>Distributor</th>
            <th class="text-right">Total Bayar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pembelians as $index => $pembelian)
        {{-- Baris Utama --}}
        <tr style="font-weight: bold;">
            <td>{{ $index + 1 }}</td>
            <td>{{ \Carbon\Carbon::parse($pembelian->tgl_pembelian)->translatedFormat('d F Y') }}</td>
            <td>{{ $pembelian->nonota }}</td>
            <td>{{ $pembelian->distributor->nama_distributor ?? '-' }}</td>
            <td class="text-right">Rp{{ number_format($pembelian->total_bayar, 0, ',', '.') }}</td>
        </tr>

        {{-- Baris Detail Produk --}}
        <tr style="background-color: #eaeaea;">
            <td></td>
            <td colspan="6"><strong>Detail Obat:</strong></td>
        </tr>
        <tr style="background-color: #ddd;">
            <td></td>
            <td colspan="2"><strong>Nama Obat</strong></td>
            <td><strong>Harga Beli</strong></td>
            <td><strong>Jumlah Beli</strong></td>
            <td colspan="2"><strong>Subtotal</strong></td>
        </tr>
        @foreach($pembelian->detailPembelian as $detail)
        <tr>
            <td></td>
            <td colspan="2">{{ $detail->obat->nama_obat ?? '-' }}</td>
            <td>Rp{{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
            <td>{{ $detail->jumlah_beli }}</td>
            <td colspan="2">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
        @endforeach

        {{-- Total Keseluruhan --}}
        <tr style="font-weight: bold;">
            <td colspan="6" style="text-align: right;">Total Seluruh Pembelian</td>
            <td class="text-right">Rp{{ number_format($totalSeluruhPembelians, 0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>
