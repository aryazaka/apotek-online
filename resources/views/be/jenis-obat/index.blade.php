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
    <h2 class="section-title">Jenis Obat</h2>
    <a href="{{ route('jenis.create') }}">
        <button type="button" class="btn btn-primary">
            <i class="mdi mdi-plus-circle-outline"></i> Tambah Jenis
        </button>
    </a>
</div>

<!-- Tabel -->
<table class="table table-bordered mx-4">
    <thead>
        <tr>
            <th>No</th>
            <th>Jenis Obat</th>
            <th>Deskripsi</th>
            <th>Foto</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody id="productTable">
        @foreach($datas as $nmr => $data)
        <tr>
            <td>{{ $nmr + 1 }}</td>

            <td class="tooltip-custom" data-tooltip="{{ $data['jenis'] }}">
                @if(strlen($data['jenis']) > 20)
                {{ substr($data['jenis'], 0, 20) . '...' }}
                @else
                {{ $data['jenis'] }}
                @endif
            </td>

            <td class="tooltip-custom" data-tooltip="{{ $data['deskripsi_jenis'] }}">
                @if(strlen($data['deskripsi_jenis']) > 20)
                {{ substr($data['deskripsi_jenis'], 0, 20) . '...' }}
                @else
                {{ $data['deskripsi_jenis'] }}
                @endif
            </td>

            <td style=" text-align:center;">
                @if($data['image_url'])
                <img src="{{ asset('storage/' . $data['image_url']) }}"
                    class="img-thumbnail popup-image"
                    style="width:50px; height:auto; cursor:pointer;"
                    alt="Foto {{ $data['image_url'] }}">
                @endif
            </td>

            <td style="display: flex; gap: 25px; align-items: center; justify-content: center;">
                <a href="{{ route('jenis.edit', $data['id']) }}"
                    data-tooltip="Edit"
                    class="tooltip-custom btn btn-warning btn-sm d-flex align-items-center justify-content-center"
                    style="width: 35px; height: 35px;">
                    <i class="mdi mdi-grease-pencil" style="font-size: 20px; color: white;"></i>
                </a>
                <a href="{{ route('jenis.destroy', $data['id']) }}"
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

@endsection