@extends('be/partial/master')

@section('navbar')
@include('be/partial/navbar')
@endsection

@section('sidebar')
@include('be/partial/sidebar')
@endsection

@section('footer')
@include('be/partial/footer')
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mx-4 my-4">
  <h2 class="section-title">Data Penjualan</h2>
</div>

<div class="row g-3 align-items-end mx-4 mb-3">
  <div class="col-auto">
    <label class="form-label mb-0">Dari Tanggal</label>
    <input type="date" id="filterAwal" class="form-control">
  </div>
  <div class="col-auto">
    <label class="form-label mb-0">Sampai Tanggal</label>
    <input type="date" id="filterAkhir" class="form-control">
  </div>
</div>

<div class="table-responsive px-4">
  <table class="table table-bordered align-middle shadow-sm">
    <thead class="table-dark text-center">
      <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Kode Transaksi</th>
        <th>Pelanggan</th>
        <th>Status</th>
        <th>Keterangan</th>
        <th>Total</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($penjualans as $idx => $penjualan)
      <tr>
        <td class="text-center">{{ $idx + 1 }}</td>
        <td>{{ \Carbon\Carbon::parse($penjualan->tgl_penjualan)->format('d M Y') }}</td>
        <td>{{ $penjualan->kode_transaksi }}</td>
        <td>{{ $penjualan->pelanggan->nama_pelanggan }}</td>
        <td class="text-center">
          @switch($penjualan->status_order)
          @case('Menunggu Konfirmasi')
          <span class="badge bg-warning text-dark">{{ $penjualan->status_order }}</span>
          @break
          @case('Diproses')
          <span class="badge bg-info text-dark">{{ $penjualan->status_order }}</span>
          @break
          @case('Menunggu Kurir')
          <span class="badge bg-primary">{{ $penjualan->status_order }}</span>
          @break
          @case('Selesai')
          <span class="badge bg-success">{{ $penjualan->status_order }}</span>
          @break
          @case('Bermasalah')
          @case('Dibatalkan Penjual')
          <span class="badge bg-danger">{{ $penjualan->status_order }}</span>
          @break
          @default
          <span class="badge bg-secondary">{{ $penjualan->status_order }}</span>
          @endswitch
        </td>
        <td>{{ $penjualan->keterangan_status }}</td>
        <td>Rp{{ number_format($penjualan->total_bayar, 0, ',', '.') }}</td>
        <td class="text-center">
          <!-- Tombol Detail -->
          <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $penjualan->id }}">
            Detail
          </button>

          @if($penjualan->status_order !== 'Dibatalkan Pembeli')
          <!-- Tombol Ubah Status -->
          <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalStatus{{ $penjualan->id }}">
            Ubah Status
          </button>
          @endif
        </td>

      </tr>
      @endforeach
    </tbody>
  </table>
</div>

@foreach($penjualans as $penjualan)
<!-- Modal Detail Produk -->
<div class="modal fade" id="modalDetail{{ $penjualan->id }}" tabindex="-1" aria-labelledby="detailLabel{{ $penjualan->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content shadow rounded-4 border-0">
      <div class="modal-header bg-info text-white rounded-top-4">
        <h5 class="modal-title" id="detailLabel{{ $penjualan->id }}">
          Detail Penjualan - {{ $penjualan->kode_transaksi }}
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body px-4 py-3">
        <div class="mb-3">
          <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($penjualan->tgl_penjualan)->format('d M Y') }}</p>
          <p><strong>Pelanggan:</strong> {{ $penjualan->pelanggan->nama_pelanggan }}</p>
          <p><strong>Status:</strong> {{ $penjualan->status_order }}</p>
          <p><strong>Keterangan:</strong> {{ $penjualan->keterangan_status }}</p>
        </div>

        <h6 class="fw-bold mb-3">Detail Produk</h6>
        <div class="table-responsive">
          <table class="table table-sm table-bordered border-light">
            <thead class="table-light text-center">
              <tr>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
              </tr>
            </thead>
            <tbody>
              @foreach($penjualan->detailPenjualan as $detail)
              <tr class="text-center align-middle">
                <td class="text-start">{{ $detail->Obat->nama_obat }}</td>
                <td>Rp{{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                <td>{{ $detail->jumlah_beli }}</td>
                <td>Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer bg-black text-white rounded-bottom-4">
        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Ubah Status -->
<div class="modal fade" id="modalStatus{{ $penjualan->id }}" tabindex="-1" aria-labelledby="statusLabel{{ $penjualan->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content shadow rounded-4 border-0">
      <div class="modal-header bg-primary text-white rounded-top-4">
        <h5 class="modal-title" id="statusLabel{{ $penjualan->id }}">
          Ubah Status - <span class="fw-semibold">{{ $penjualan->kode_transaksi }}</span>
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('penjualan.updateStatus', $penjualan->id) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="modal-body px-4 py-3">
          <div class="mb-3">
            <label class="form-label fw-semibold">Pilih Status Baru</label>
            <select name="status_order" class="form-select rounded shadow-sm border-primary" required>
              <option value="" disabled selected>-- Pilih Status --</option>
              <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
              <option value="Diproses">Diproses</option>
              <option value="Menunggu Kurir">Menunggu Kurir</option>
              <option value="Selesai">Selesai</option>
              <option value="Bermasalah">Bermasalah</option>
              <option value="Dibatalkan Penjual">Dibatalkan Penjual</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Keterangan Status</label>
            <textarea name="keterangan_status" class="form-control shadow-sm border-primary rounded" rows="3" placeholder="Tulis keterangan tambahan jika diperlukan..."></textarea>
          </div>
        </div>

        <div class="modal-footer bg-black text-white rounded-bottom-4">
          <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endforeach

<!-- filter tanggal -->
<script>
  const filterAwal = document.getElementById('filterAwal');
  const filterAkhir = document.getElementById('filterAkhir');
  const rows = document.querySelectorAll('table tbody tr');

  function formatTanggal(tgl) {
    // Format: yyyy-mm-dd
    const parts = tgl.split(' ');
    const bulanMap = {
      Jan: '01',
      Feb: '02',
      Mar: '03',
      Apr: '04',
      May: '05',
      Jun: '06',
      Jul: '07',
      Aug: '08',
      Sep: '09',
      Oct: '10',
      Nov: '11',
      Dec: '12'
    };
    return `${parts[2]}-${bulanMap[parts[1]]}-${parts[0]}`;
  }

  function filterTanggal() {
    const awal = filterAwal.value;
    const akhir = filterAkhir.value;

    rows.forEach(row => {
      const tglText = row.children[1].textContent.trim(); // kolom Tanggal
      const tglFormat = formatTanggal(tglText);

      if ((awal && tglFormat < awal) || (akhir && tglFormat > akhir)) {
        row.style.display = 'none';
      } else {
        row.style.display = '';
      }
    });
  }

  filterAwal.addEventListener('change', filterTanggal);
  filterAkhir.addEventListener('change', filterTanggal);
</script>

@endsection