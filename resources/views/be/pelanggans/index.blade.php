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
    <h2 class="section-title">Data Pelanggan</h2>
</div>

<!-- Filter dan Pencarian -->
<div class="d-flex justify-content-between align-items-center mx-4 mb-4">
   <div class="d-flex align-items-center">
    <input type="text" id="searchInput" class="form-control shadow-sm" placeholder="Cari nama pelanggan..." style="width: 300px;">
</div>
</div>

<table class="table table-bordered mx-4" id="pelangganTable">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $nmr => $data)
        <tr>
            <td>{{ $nmr + 1 }}</td>
            <td>{{ $data->nama_pelanggan }}</td>
            <td>{{ $data->email }}</td>
            <td>{{ $data->no_telp }}</td>
            <td class="d-flex justify-content-center gap-4">
                <button class="btn btn-info btn-sm btn-detail" data-pelanggan='@json($data)'>
                    <i class="mdi mdi-eye text-white"></i>
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal Detail Pelanggan -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-3 shadow-lg border-0">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="detailModalLabel">Detail Pelanggan</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <p><strong>Nama:</strong> <span id="modalNama"></span></p>
            <p><strong>Email:</strong> <span id="modalEmail"></span></p>
            <p><strong>Telepon:</strong> <span id="modalTelepon"></span></p>

            <hr>
            @for ($i = 1; $i <= 3; $i++)
              <p><strong>Alamat {{ $i }}:</strong> <span id="modalAlamat{{ $i }}"></span></p>
              <p><strong>Kode Pos {{ $i }}:</strong> <span id="modalKodepos{{ $i }}"></span></p>
              <p><strong>Kota {{ $i }}:</strong> <span id="modalKota{{ $i }}"></span></p>
              <p><strong>Provinsi {{ $i }}:</strong> <span id="modalProvinsi{{ $i }}"></span></p>
              <hr>
            @endfor
          </div>

          <div class="col-md-6 text-center">
            <p><strong>Foto Pelanggan:</strong></p>
            <img id="modalFoto" src="" alt="Foto Pelanggan" class="img-fluid rounded mb-3" style="max-height: 200px;">

            <p><strong>Foto KTP:</strong></p>
            <img id="modalFotoKTP" src="" alt="Foto KTP" class="img-fluid rounded" style="max-height: 200px;">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const detailButtons = document.querySelectorAll('.btn-detail');
        detailButtons.forEach(button => {
            button.addEventListener('click', function () {
                const pelanggan = JSON.parse(this.dataset.pelanggan);

                // Data Umum
                document.getElementById('modalNama').textContent = pelanggan.nama_pelanggan || '-';
                document.getElementById('modalEmail').textContent = pelanggan.email || '-';
                document.getElementById('modalTelepon').textContent = pelanggan.no_telp || '-';

                // Alamat 1-3
                for (let i = 1; i <= 3; i++) {
                    document.getElementById(`modalAlamat${i}`).textContent = pelanggan[`alamat${i}`] || '-';
                    document.getElementById(`modalKodepos${i}`).textContent = pelanggan[`kodepos${i}`] || '-';
                    document.getElementById(`modalKota${i}`).textContent = pelanggan[`kota${i}`] || '-';
                    document.getElementById(`modalProvinsi${i}`).textContent = pelanggan[`propinsi${i}`] || '-';
                }

                // Foto
                document.getElementById('modalFoto').src = pelanggan.foto ? `/storage/${pelanggan.foto}` : '';
                document.getElementById('modalFotoKTP').src = pelanggan.url_ktp ? `/storage/${pelanggan.url_ktp}` : '';

                new bootstrap.Modal(document.getElementById('detailModal')).show();
            });
        });
    });
</script>

<!-- pencarian pelanggan -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const rows = document.querySelectorAll('#pelangganTable tbody tr');

    function filterTable() {
        const searchValue = searchInput.value.toLowerCase();

        rows.forEach(row => {
            const nama = row.cells[1].textContent.trim().toLowerCase();  // Nama pelanggan di kolom kedua
            const email = row.cells[2].textContent.trim().toLowerCase();  // Email pelanggan di kolom ketiga
            const telepon = row.cells[3].textContent.trim().toLowerCase();  // Telepon pelanggan di kolom keempat

            const isSearchMatch = nama.includes(searchValue) || email.includes(searchValue) || telepon.includes(searchValue);

            if (isSearchMatch) {
                row.style.display = '';  // Tampilkan baris
            } else {
                row.style.display = 'none';  // Sembunyikan baris
            }
        });
    }

    // Setiap kali user mengetik di input pencarian, jalankan filterTable
    searchInput.addEventListener('input', filterTable);
});

</script>
@endsection
