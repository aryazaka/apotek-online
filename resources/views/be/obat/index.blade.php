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
    <h2 class="section-title">Produk Obat</h2>
    <a href="{{ route('obat.create') }}"><button type="button" class="btn btn-primary"> <i class="mdi mdi-plus-circle-outline"></i> Tambah produk</button></a>
</div>

<!-- Filter dan Pencarian -->
<div class="d-flex justify-content-between align-items-center mx-4 mb-4">
    <div class="d-flex align-items-center">
        <label for="filterJenis" class="form-label me-2 fw-bold">Jenis Obat:</label>
        <select id="filterJenis" class="form-select shadow-sm" style="width: 300px;">
            <option value="all">Semua</option>
            @foreach ($jenis_obat as $nmr => $jenis)
            <option value="{{ strtolower(trim($jenis['jenis'])) }}">{{ $jenis['jenis'] }}</option>
            @endforeach
        </select>

    </div>
    <div class="d-flex align-items-center">
        <input type="text" id="searchInput" class="form-control shadow-sm" placeholder="Cari nama obat..." style="width: 300px;">
    </div>
</div>
<!-- Tabel -->
<table class="table table-bordered mx-4">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Obat</th>
            <th>Jenis Obat</th>
            <th>Harga</th>
            <th>Deskripsi</th>
            <th>Stok</th>
            <th>Foto 1</th>
            <th>Foto 2</th>
            <th>Foto 3</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody id="productTable">
        @foreach ($datas as $nmr => $data)
        <tr>
            <td scope="row">{{ $nmr + 1 }}</td>
            <td class="tooltip-custom" data-tooltip="{{ $data['nama_obat'] }}">
                @if(strlen($data['nama_obat']) > 20)
                {{ substr($data['nama_obat'], 0, 20) . '...' }}
                @else
                {{ $data['nama_obat'] }}
                @endif
            </td>
            <td
                class="tooltip-custom"
                data-tooltip="{{ $data->jenisObat->jenis ?? '-' }}"
                data-jenis="{{ strtolower(trim($data->jenisObat->jenis ?? '-')) }}">
                @if(strlen($data->jenisObat->jenis ?? '-') > 20)
                {{ substr($data->jenisObat->jenis ?? '-', 0, 20) . '...' }}
                @else
                {{ $data->jenisObat->jenis ?? '-' }}
                @endif
            </td>

            <td class="tooltip-custom" data-tooltip="{{ $data['harga_jual'] }}">
                @if(strlen($data['harga_jual']) > 20)
                {{ 'Rp. ' . substr($data['harga_jual'], 0, 20) . '...' }}
                @else
                {{ 'Rp. ' . $data['harga_jual'] }}
                @endif
            </td>
            <td class="tooltip-custom" data-tooltip="{{ $data['deskripsi_obat'] }}">
                @if(strlen($data['deskripsi_obat']) > 20)
                {{ substr($data['deskripsi_obat'], 0, 20) . '...' }}
                @else
                {{ $data['deskripsi_obat'] }}
                @endif
            </td>
            <td class="tooltip-custom" data-tooltip="{{ $data['stok'] }}">
                @if(strlen($data['stok']) > 20)
                {{ substr($data['stok'], 0, 20) . '...' }}
                @else
                {{ $data['stok'] }}
                @endif
            </td>
            <td style="text-align: center;">
                @if($data['foto1'])
                <img src="{{ asset('storage/' . $data['foto1']) }}"
                    class="img-thumbnail popup-image"
                    style="width:50px; height:auto; cursor:pointer;"
                    alt="Foto {{ $data['foto1'] }}">
                @endif
            </td>
            <td style="text-align: center;">
                @if($data['foto2'])
                <img src="{{ asset('storage/' . $data['foto2']) }}"
                    class="img-thumbnail popup-image"
                    style="width:50px; height:auto; cursor:pointer;"
                    alt="Foto {{ $data['foto2'] }}">
                @endif
            </td>
            <td style="text-align: center;">
                @if($data['foto3'])
                <img src="{{ asset('storage/' . $data['foto3']) }}"
                    class="img-thumbnail popup-image"
                    style="width:50px; height:auto; cursor:pointer;"
                    alt="Foto {{ $data['foto3'] }}">
                @endif
            </td>
            <td style="display: flex; gap: 8px; align-items: center; justify-content: center;">
                <a href="{{ route('obat.edit', $data['id']) }}" data-tooltip="Edit" class="tooltip-custom btn btn-warning btn-sm d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                    <i class="mdi mdi-grease-pencil" style="font-size: 20px; color: white;"></i>
                </a>

                <a
   data-tooltip="Margin Penjualan"
   class="tooltip-custom btn btn-info btn-sm d-flex align-items-center justify-content-center btn-margin"
   style="width: 35px; height: 35px;"
   data-harga-beli="{{ $data->detailPembelian->harga_beli ?? 0 }}"
   data-id="{{ $data['id'] }}">
   <i class="mdi mdi-chart-line" style="font-size: 20px; color: white;"></i>
</a>


                <a href="{{ route('obat.destroy', $data['id']) }}"
                    onclick="hapus(event, this)"
                    data-tooltip="Hapus"
                    class="tooltip-custom btn btn-danger btn-sm d-flex align-items-center justify-content-center btn-delete"
                    style="width: 35px; height: 35px;">
                    <i class="mdi mdi-delete" style="font-size: 20px; color: white;"></i>
                </a>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>


<!-- Modal untuk menampilkan margin penjualan -->
<div class="modal fade" id="marginModal" tabindex="-1" aria-labelledby="marginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
                <h5 class="modal-title" id="marginModalLabel">Hitung Margin Penjualan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
      <form action="{{ route('obat.updateMargin') }}" method="POST" id="formMargin">
        @csrf
        <input type="hidden" name="id" id="obatId">
        <div class="modal-body">
            <div class="mb-3">
                <label for="hargaBeli" class="form-label">Harga Beli (Rp.)</label>
                <input style="background-color: #2A3038;" type="number" name="harga_beli" id="hargaBeli" class="form-control">
            </div>
            <div class="mb-3">
                <label for="marginPersen" class="form-label">Margin (%)</label>
                <input type="number" name="margin" id="marginPersen" class="form-control" value="0">
            </div>
            <div class="mb-3">
                <label for="hargaJual" class="form-label">Harga Jual (Rp.)</label>
                <input style="background-color: #2A3038;" type="number" id="hargaJual" class="form-control" readonly>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>




<!-- Modal untuk menampilkan gambar besar -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="" id="modalImage" class="img-fluid" alt="Foto Detail">
            </div>
        </div>
    </div>
</div>

<form action="" id="formDelete" method="POST">
    @csrf
    @method('delete')
</form>
<!-- JavaScript untuk Filter dan Pencarian -->
<script>
    const filterJenis = document.getElementById('filterJenis');
    const searchInput = document.getElementById('searchInput');
    const rows = document.querySelectorAll('#productTable tr');

    function filterTable() {
        const filterValue = filterJenis.value.toLowerCase();
        const searchValue = searchInput.value.toLowerCase();

        rows.forEach(row => {
            const jenis = row.cells[2].dataset.jenis || '';
            const nama = row.cells[1].textContent.trim().toLowerCase();

            const isJenisMatch = filterValue === 'all' || jenis === filterValue;
            const isSearchMatch = searchValue === '' || nama.includes(searchValue);

            if (isJenisMatch && isSearchMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }


    filterJenis.addEventListener('change', filterTable);
    searchInput.addEventListener('input', filterTable);
</script>

<!-- script untuk hapus obat -->
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

<!-- script untuk modal margin penjualan -->
<script>

document.querySelectorAll('.btn-margin').forEach(button => {
    button.addEventListener('click', function () {
        const hargaBeli = parseFloat(this.dataset.hargaBeli);
        const obatId = this.dataset.id;

        document.getElementById('obatId').value = obatId;
        document.getElementById('hargaBeli').value = hargaBeli;
        document.getElementById('marginPersen').value = 0;
        document.getElementById('hargaJual').value = hargaBeli;

        document.getElementById('marginPersen').addEventListener('input', () => {
            const margin = parseFloat(document.getElementById('marginPersen').value) || 0;
            const hargaJual = hargaBeli + (hargaBeli * (margin / 100));
            document.getElementById('hargaJual').value = Math.round(hargaJual);
        });

        const modal = new bootstrap.Modal(document.getElementById('marginModal'));
        modal.show();
    });
});

</script>

@endsection