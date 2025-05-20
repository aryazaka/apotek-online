<div class="card shadow-sm border-0">
  <div class="card-body">
    <label for="statusFilter" class="form-label text-muted fw-semibold">Filter Status:</label>
    <select id="statusFilter" class="form-select border-0 shadow-sm" style="width: 300px;">
      <option value="">Semua</option>
      <option value="Belum Diambil">Belum Diambil</option>
      <option value="Sudah Diambil">Sudah Diambil</option>
    </select>
  </div>
</div>

<div class="table-responsive px-4">
<table class="table table-bordered align-middle shadow-sm">
    <thead class="table-dark text-center">
        <tr>
            <th>No</th>
            <th>Kode Transaksi</th>
            <th>Tanggal Pembelian</th>
            <th>Pelanggan</th>
            <th>Obat Dibeli</th>
            <th>Alamat</th>
            <th>Total Bayar</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($penjualans as $idx => $penjualan)
        <tr class="text-center">
            <td>{{ $idx + 1 }}</td>
            <td>{{ $penjualan->kode_transaksi }}</td>
            <td>{{ date('d M Y', strtotime($penjualan->tgl_penjualan)) }}</td>
            <td>{{ $penjualan->pelanggan->nama_pelanggan }}</td>
            <td>
                <ul class="mb-0">
                    @foreach($penjualan->detailPenjualan as $idx => $detail)
                    <li>{{ $detail->obat->nama_obat }} ({{ $detail->jumlah_beli }})</li>
                    @endforeach
                </ul>
            </td>
            <td>{{ $alamatPenjualans[$idx] }}</td>
            <td>Rp {{ number_format($penjualan->total_bayar, 0, ',', '.') }}</td>
            <td>
                @if($penjualan->pengiriman)
                <span class="badge bg-info status-text text-white">Sudah Diambil oleh {{ $penjualan->pengiriman->nama_kurir }}</span>
                @else
                <span class="badge bg-warning text-dark status-text">Belum Diambil</span>
                @endif
            </td>
            <td>
                @if(!$penjualan->pengiriman)
                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalPengiriman{{ $penjualan->id }}">
                    Ambil
                </button>
                @endif
            </td>

        </tr>

        @if(!$penjualan->pengiriman)
        {{-- Modal --}}
        <div class="modal fade" id="modalPengiriman{{ $penjualan->id }}" tabindex="-1" aria-labelledby="modalPengirimanLabel{{ $penjualan->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('pengiriman.store') }}" method="POST">
                    @csrf
                    
                    <input type="hidden" name="id_penjualan" value="{{ $penjualan->id }}">
                    <input type="hidden" name="kode_transaksi" value="{{ $penjualan->kode_transaksi }}">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalPengirimanLabel{{ $penjualan->id }}">ACC Kurir - {{ $penjualan->kode_transaksi }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nama Kurir</label>
                                <input type="text" class="form-control" style="background-color: #2A3038;" name="nama_kurir" value="{{ Auth::user()->name }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No. Telepon Kurir</label>
                                <input type="text" class="form-control @error('telpon_kurir') is-invalid @enderror" name="telpon_kurir" required>
                                @error('telpon_kurir')
                                <div class="invalid-feedback">{{ old('telpon_kurir') }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Pengiriman</label>
                                <input type="date" class="form-control @error('tgl_kirim') is-invalid @enderror" name="tgl_kirim" required>
                                @error('tgl_kirim')
                                <div class="invalid-feedback">{{ old('tgl_kirim')}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Buat</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif

        @empty
        <tr>
            <td colspan="9" class="text-center">Tidak ada pesanan menunggu pengambilan.</td>
        </tr>
        @endforelse
    </tbody>
</table>
</div>
<!-- filter berdasarkan status -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const statusFilter = document.getElementById("statusFilter");
    const tableRows = document.querySelectorAll("table tbody tr");

    statusFilter.addEventListener("change", function () {
      const selected = this.value.toLowerCase();

      tableRows.forEach(row => {
        const statusCell = row.querySelector(".status-text");

        if (!statusCell) return;

        const statusText = statusCell.textContent.toLowerCase();

        if (selected === "") {
          row.style.display = "";
        } else if (selected === "belum diambil" && statusText.includes("belum diambil")) {
          row.style.display = "";
        } else if (selected === "sudah diambil" && statusText.includes("sudah diambil")) {
          row.style.display = "";
        } else {
          row.style.display = "none";
        }
      });
    });
  });
</script>
