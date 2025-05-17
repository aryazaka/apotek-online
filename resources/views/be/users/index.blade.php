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
    <h2 class="section-title">Management Users</h2>
    <a href="{{ route('users.create') }}"><button type="button" class="btn btn-primary"> <i class="mdi mdi-plus-circle-outline"></i> Tambah User</button></a>
</div>

<!-- Filter dan Pencarian -->
<div class="d-flex justify-content-between align-items-center mx-4 mb-4">
    <div class="d-flex align-items-center">
        <label for="filterJabatan" class="form-label me-2 fw-bold">Jabatan:</label>
        <select id="filterJenis" class="form-select shadow-sm" style="width: 300px;">
            <option value="all">Semua</option>
            <option value="karyawan">Karyawan</option>
            <option value="apoteker">Apoteker</option>
            <option value="pemilik">Pemilik</option>
            <option value="kasir">Kasir</option>
            <option value="admin">Admin</option>
        </select>
    </div>
    <div class="d-flex align-items-center">
        <input type="text" id="searchInput" class="form-control shadow-sm" placeholder="Cari nama user..." style="width: 300px;">
    </div>
</div>
<!-- Tabel -->
<table class="table table-bordered mx-4">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Jabatan</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody id="usersTable">
        @foreach ($datas as $nmr => $data)
        <tr>
            <td scope="row">{{ $nmr + 1 }}</td>
            <td class="tooltip-custom" data-tooltip="{{ $data['name'] }}">
                @if(strlen($data['name']) > 20)
                {{ substr($data['name'], 0, 20) . '...' }}
                @else
                {{ $data['name'] }}
                @endif
            </td>

            <td class="tooltip-custom" data-tooltip="{{ $data['email'] }}">
                @if(strlen($data['email']) > 20)
                {{ substr($data['email'], 0, 20) . '...' }}
                @else
                {{ $data['email'] }}
                @endif
            </td>

            <td class="tooltip-custom" data-tooltip="{{ $data['jabatan'] }}" data-jabatan="{{ $data['jabatan'] }}">
                @if(strlen($data['jabatan']) > 20)
                {{ substr($data['jabatan'], 0, 20) . '...' }}
                @else
                {{ $data['jabatan'] }}
                @endif
            </td>
           
            <td style="display: flex; gap: 8px; align-items: center; justify-content: center;">
                <a href="{{ route('users.edit', $data['id']) }}" class="btn btn-warning btn-sm d-flex align-items-center justify-content-center tooltip-custom" data-tooltip="Edit" style="width: 35px; height: 35px;">
                    <i class="mdi mdi-grease-pencil" style="font-size: 20px; color: white;"></i>
                </a>
                <a href="{{ route('users.destroy', $data['id']) }}"
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
    const filterJabatan = document.getElementById('filterJenis');
    const searchInput = document.getElementById('searchInput');
    const rows = document.querySelectorAll('#usersTable tr');

    function filterTable() {
        const filterValue = filterJabatan.value.toLowerCase();
        const searchValue = searchInput.value.toLowerCase();

        rows.forEach(row => {
            const Jabatan = row.cells[3].dataset.jabatan || '';
            const nama = row.cells[1].textContent.trim().toLowerCase();

            const isJabatanMatch = filterValue === 'all' || Jabatan === filterValue;
            const isSearchMatch = searchValue === '' || nama.includes(searchValue);

            if (isJabatanMatch && isSearchMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }


    filterJabatan.addEventListener('change', filterTable);
    searchInput.addEventListener('input', filterTable);
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

@endsection