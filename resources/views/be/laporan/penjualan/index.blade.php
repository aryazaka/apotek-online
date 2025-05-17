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

<div class="d-flex justify-content-between align-items-center px-4 mb-3">
  <div class="d-flex gap-2 align-items-center">
    <input type="date" id="from-date" value="{{ request('from') }}" class="form-control" />
    <span class="mx-1">s.d.</span>
    <input type="date" id="to-date" value="{{ request('to') }}" class="form-control" />
  </div>

  <div class="d-flex gap-2">
    <a id="download-pdf" href="{{ route('penjualan.export.pdf', request()->only(['from', 'to'])) }}" class="btn btn-danger">Unduh PDF</a>
    <a id="download-excel" href="{{ route('penjualan.export.excel', request()->only(['from', 'to'])) }}" class="btn btn-success">Unduh Excel</a>
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


@endforeach

<script>
  const fromInput = document.getElementById('from-date');
  const toInput = document.getElementById('to-date');
  const pdfBtn = document.getElementById('download-pdf');
  const excelBtn = document.getElementById('download-excel');

  function updateFilter() {
    const from = fromInput.value;
    const to = toInput.value;

    const params = new URLSearchParams(window.location.search);
    if (from) params.set('from', from);
    else params.delete('from');

    if (to) params.set('to', to);
    else params.delete('to');

    // Update tombol unduh
    pdfBtn.href = `{{ route('penjualan.export.pdf') }}?${params.toString()}`;
    excelBtn.href = `{{ route('penjualan.export.excel') }}?${params.toString()}`;

    // Reload halaman dengan filter baru
    window.location.search = params.toString();
  }

  function handleDateChange() {
  const from = fromInput.value;
  const to = toInput.value;

  if (from && to) {
    updateFilter();
  }
}

  fromInput.addEventListener('change', handleDateChange);
  toInput.addEventListener('change', handleDateChange);
</script>

@endsection