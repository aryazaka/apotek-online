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
    <h2 class="section-title">Distributor</h2>
    <a href="{{ route('distributor.create') }}">
        <button type="button" class="btn btn-primary">
            <i class="mdi mdi-plus-circle-outline"></i> Tambah Distributor
        </button>
    </a>
</div>

<div class="d-flex justify-content-between align-items-center mx-4 my-2">
<div class="d-flex align-items-center">
        <input type="text" id="searchInput" class="form-control shadow-sm" placeholder="Cari nama Distributor..." style="width: 300px;">
    </div>
    </div>
<!-- Tabel -->
<table class="table table-bordered mx-4">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Distributor</th>
            <th>No Telepon</th>
            <th>Alamat</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody id="distributorTable">
        @foreach($datas as $nmr => $data)
        <tr>
            <td>{{ $nmr + 1 }}</td>

            <td class="tooltip-custom" data-tooltip="{{ $data['nama_distributor'] }}">
                @if(strlen($data['nama_distributor']) > 20)
                {{ substr($data['nama_distributor'], 0, 20) . '...' }}
                @else
                {{ $data['nama_distributor'] }}
                @endif
            </td>

            <td class="tooltip-custom" data-tooltip="{{ $data['telepon'] }}">
                @if(strlen($data['telepon']) > 20)
                {{ substr($data['telepon'], 0, 20) . '...' }}
                @else
                {{ $data['telepon'] }}
                @endif
            </td>

            <td class="tooltip-custom" data-tooltip="{{ $data['alamat'] }}">
                @if(strlen($data['alamat']) > 20)
                {{ substr($data['alamat'], 0, 20) . '...' }}
                @else
                {{ $data['alamat'] }}
                @endif
            </td>

            <td style="display: flex; gap: 25px; align-items: center; justify-content: center;">
                <a href="{{ route('distributor.edit', $data['id']) }}"
                    data-tooltip="Edit"
                    class="tooltip-custom btn btn-warning btn-sm d-flex align-items-center justify-content-center"
                    style="width: 35px; height: 35px;">
                    <i class="mdi mdi-grease-pencil" style="font-size: 20px; color: white;"></i>
                </a>
                <a href="{{ route('distributor.destroy', $data['id']) }}"
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
    <!-- Script -->

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
                // submit form
                form.submit();
            }
        });
    }
    </script>

    <script>
         const searchInput = document.getElementById('searchInput');
         const rows = document.querySelectorAll('#distributorTable tr');

         
    function filterTable() {
        const searchValue = searchInput.value.toLowerCase();

        rows.forEach(row => {
            const jenis = row.cells[2].dataset.jenis || '';
            const nama = row.cells[1].textContent.trim().toLowerCase();

            const isSearchMatch = searchValue === '' || nama.includes(searchValue);

            if (isSearchMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterTable);

    </script>
@endsection