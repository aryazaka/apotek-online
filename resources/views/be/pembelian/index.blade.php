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
  <h2 class="section-title">Pembelian</h2>
  <a href="{{ route('pembelian.create') }}"><button type="button" class="btn btn-primary"> <i class="mdi mdi-plus-circle-outline"></i> Tambah Pembelian</button></a>
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

<table class="table table-bordered mx-4">
  <thead>
    <tr>
      <th>No</th>
      <th>No Nota</th>
      <th>Distributor</th>
      <th>Total Bayar</th>
      <th>Tanggal Pembelian</th>
      <th>#</th>
    </tr>
  </thead>
  <tbody id="usersTable">
    @foreach ($datas as $nmr => $data)
    <tr>
      <td scope="row">{{ $nmr + 1 }}</td>
      <td class="tooltip-custom" data-tooltip="{{ $data['nonota'] }}">
        @if(strlen($data['nonota']) > 20)
        {{ substr($data['nonota'], 0, 20) . '...' }}
        @else
        {{ $data['nonota'] }}
        @endif
      </td>

      <td class="tooltip-custom" data-tooltip="{{ $data->distributor->nama_distributor }}">
        @if(strlen($data->distributor->nama_distributor) > 20)
        {{ substr($data->distributor->nama_distributor, 0, 20) . '...' }}
        @else
        {{ $data->distributor->nama_distributor }}
        @endif
      </td>

      <td class="tooltip-custom" data-tooltip="{{ 'Rp. ' . $data['total_bayar'] }}" data-pembelian="{{ 'Rp. ' . $data['total_bayar'] }}">
        @if(strlen($data['total_bayar']) > 20)
        'Rp' {{ substr($data['total_bayar'], 0, 20) . '...' }}
        @else
        {{ 'Rp. ' . $data['total_bayar'] }}
        @endif
      </td>

      @php
      $formattedTanggal = \Carbon\Carbon::parse($data['tgl_pembelian'])->format('d M Y');
      @endphp

      <td class="tooltip-custom" data-tooltip="{{ $data['tgl_pembelian'] }}" data-pembelian="{{ $data['tgl_pembelian'] }}">
        {{ $formattedTanggal }}
      </td>

      <td style="display: flex; gap: 8px; align-items: center; justify-content: center;">
        <a
          class="btn btn-info btn-sm d-flex align-items-center justify-content-center btn-detail tooltip-custom"
          data-tooltip="Detail"
          style="width: 35px; height: 35px;" data-pembelian="{{ $data }}">
          <i class="mdi mdi-eye" style="font-size: 20px; color: white;"></i>
        </a>

        <a href="{{ route('pembelian.edit', $data['id']) }}" class="tooltip-custom btn-edit btn btn-warning btn-sm d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;"
          data-id="{{ $data->id }}"
          data-tooltip="Edit"
          data-nonota="{{ $data->nonota }}"
          data-tgl="{{ $data->tgl_pembelian }}"
          data-distributor="{{ $data->id_distributor }}"
          data-total="{{ $data->total_bayar }}"
          data-details='@json($data->detailPembelian)'>
          <i class="mdi mdi-grease-pencil" style="font-size: 20px; color: white;"></i>
        </a>

        <a href="{{ route('pembelian.destroy', $data['id']) }}"
          onclick="hapus(event, this)"
          class="btn btn-danger btn-sm d-flex align-items-center justify-content-center btn-delete tooltip-custom"
          data-tooltip="Hapus"
          style="width: 35px; height: 35px;">
          <i class="mdi mdi-delete" style="font-size: 20px; color: white;"></i>
        </a>
      </td>

    </tr>
    @endforeach
  </tbody>
</table>

<!-- Modal info Pembelian -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content rounded-3 shadow-lg border-0">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="detailModalLabel">Detail Pembelian</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <p><strong>No Nota:</strong> <span id="modalNoNota"></span></p>
            <p><strong>Distributor:</strong> <span id="modalDistributor"></span></p>
          </div>
          <div class="col-md-6">
            <p><strong>Tanggal:</strong> <span id="modalTanggal"></span></p>
            <p><strong>Total Bayar:</strong> <span id="modalTotalBayar"></span></p>
          </div>
        </div>

        <h6 class="mt-4 text-primary">Detail Barang:</h6>
        <table class="table table-striped table-bordered table-hover">
          <thead class="thead-dark">
            <tr>
              <th>Nama Obat</th>
              <th>Harga</th>
              <th>Jumlah</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody id="modalDetailTable"></tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>


<form action="" id="formDelete" method="POST">
  @csrf
  @method('delete')
</form>

<!-- simpan local storage untuk edit -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.btn-edit');

    editButtons.forEach(btn => {
      btn.addEventListener('click', function(e) {
        // Simpan data ke localStorage
        const data = {
          nonota: this.dataset.nonota,
          tgl_pembelian: this.dataset.tgl,
          id_distributor: this.dataset.distributor,
          total_bayar: this.dataset.total,
          details: JSON.parse(this.dataset.details || '[]')
        };

        localStorage.setItem('form_pembelian', JSON.stringify(data));
      });
    });
  });
</script>

<script>
  function hapus(event, el) {
    event.preventDefault();

    swal({
      title: "Apakah Anda yakin?",
      text: "Data ini akan dihapus secara permanen!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then(function(willDelete) {
      if (willDelete) {
        const form = document.getElementById('formDelete');
        form.setAttribute('action', el.getAttribute('href'));
        form.submit();
      }
    });
  }
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const infoButtons = document.querySelectorAll('.btn-detail');

    infoButtons.forEach(button => {
      button.addEventListener('click', function(event) {
        event.preventDefault();

        const pembelianRaw = this.dataset.pembelian;
        // Cari data pembelian berdasarkan ID
        const pembelian = JSON.parse(pembelianRaw);

        if (pembelian) {
          // Mengisi modal dengan data pembelian
          const modalNoNota = document.getElementById('modalNoNota');
          const modalDistributor = document.getElementById('modalDistributor');
          const modalTanggal = document.getElementById('modalTanggal');
          const modalTotalBayar = document.getElementById('modalTotalBayar');
          const modalDetails = document.getElementById('modalDetailTable');

          // Mengisi data pembelian
          modalNoNota.innerHTML = pembelian.nonota;
          modalDistributor.innerHTML = pembelian.distributor.nama_distributor;
          modalTanggal.innerHTML = pembelian.tgl_pembelian;
          modalTotalBayar.innerHTML = 'Rp. ' + parseFloat(pembelian.total_bayar).toFixed(2);

          // Mengisi detail barang
          modalDetails.innerHTML = ''; // Kosongkan tabel sebelum mengisinya
          if (pembelian.detail_pembelian) {
            pembelian.detail_pembelian.forEach(detail => {
              const row = document.createElement('tr');
              row.innerHTML = `
                            <td>${detail.obat ? detail.obat.nama_obat : 'Tidak Diketahui'}</td>
                            <td>Rp. ${parseFloat(detail.harga_beli).toFixed(2)}</td>
                            <td>${detail.jumlah_beli}</td>
                            <td>Rp. ${parseFloat(detail.subtotal).toFixed(2)}</td>
                        `;
              modalDetails.appendChild(row);
            });
          } else {
            modalDetails.innerHTML = '<tr><td colspan="4">Detail tidak ditemukan</td></tr>';
          }

          // Menampilkan modal
          const modal = new bootstrap.Modal(document.getElementById('detailModal'));
          modal.show();
        } else {
          console.error("Data pembelian tidak ditemukan!");
        }
      });
    });
  });
</script>

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
      const tglText = row.children[4].textContent.trim();
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