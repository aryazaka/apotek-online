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

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Buat Jenis Pengiriman</h4>
        <form class="forms-sample" method="POST" action="{{ route('jenis-kirim.store') }}" enctype="multipart/form-data" id="frmJenisKirim">

        @csrf

            <div class="form-group">
                <label for="ekspedisi">Nama Ekspedisi</label>
                <input type="text" class="form-control @error('ekspedisi') is-invalid @enderror" id="ekspedisi" name="nama_ekspedisi" placeholder="Nama Ekspedisi" value="{{ old('ekspedisi') }}">
                @error('nama_ekspedisi')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="ekspedisi">Harga</label>
                <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" placeholder="Harga" value="{{ old('harga') }}">
                @error('harga')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="jenis_kirim">Jenis Kirim</label>
                <select class="form-control @error('jenis_kirim') is-invalid @enderror" id="jenis_kirim" name="jenis_kirim">
                    <option selected value="">-- Pilih Jenis Kirim --</option>
                    <option value="ekonomi" {{ (old('jenis_kirim') == 'ekonomi') ? 'selected' : '' }}>Ekonomi</option>
                    <option value="kargo" {{ (old('jenis_kirim') == 'kargo') ? 'selected' : '' }}>Kargo</option>
                    <option value="regular" {{ (old('jenis_kirim') == 'regular') ? 'selected' : '' }}>Regular</option>
                    <option value="same day" {{ (old('jenis_kirim') == 'same day') ? 'selected' : '' }}>Same Day</option>
                    <option value="standar" {{ (old('jenis_kirim') == 'standar') ? 'selected' : '' }}>Standar</option>
                        
                </select>
                @error('jenis_kirim')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Logo Ekspedisi</label>
                <input type="file" name="logo_ekspedisi" id="logo" class="file-upload-default @error('logo') is-invalid @enderror">
                <div class="input-group col-xs-12">
                    <input type="text" class="form-control file-upload-info" id="labelLogo" disabled placeholder="Upload Logo">
                    <span class="input-group-append">
                        <button class="file-upload-browse btn btn-primary" id="btnLogo" type="button">Upload</button>
                    </span>
                </div>
                @error('logo_ekspedisi')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <button id="btn-simpan" type="button" class="btn btn-primary mr-2">Submit</button>
            <button id="btn-cancel" type="button" class="btn btn-dark">Cancel</button>
        </form>
    </div>
</div>

@if ($errors->has('nama_ekspedisi'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    swal("Warning", "Nama ekspedisi sudah ada, silakan gunakan nama lain.", "warning");
});
</script>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form         = document.getElementById('frmJenisKirim');
    const btnSave      = document.getElementById('btn-simpan');
    const btnCancel    = document.getElementById('btn-cancel');

    const fieldEkspedisi = document.getElementById('ekspedisi');
    const fieldJenis     = document.getElementById('jenis_kirim');
    const fieldHarga     = document.getElementById('harga');

    const fieldLogo    = document.getElementById('logo');
    const fileLabel    = document.getElementById('labelLogo');
    const btnBrowse    = document.getElementById('btnLogo');

    btnBrowse.addEventListener('click', function(){
        fieldLogo.click();
    });
    fieldLogo.addEventListener('change', function(){
        if (fieldLogo.files.length) {
            fileLabel.value = fieldLogo.files[0].name;
        }
    });

    btnCancel.addEventListener('click', function(){
        window.location = "{{ route('jenis-kirim.index') }}";
    });

    btnSave.addEventListener('click', function(event) {
        event.preventDefault();

        [
            fieldEkspedisi,
            fieldJenis,
            fieldLogo
        ].forEach(function(el){
            el.classList.remove('is-invalid');
        });

        if (!fieldEkspedisi.value.trim()) {
            fieldEkspedisi.classList.add('is-invalid');
            swal("Invalid Data", "Nama ekspedisi harus diisi!", "error")
                .then(function(){ fieldEkspedisi.focus(); });
            return;
        }

        if (!fieldJenis.value.trim()) {
            fieldJenis.classList.add('is-invalid');
            swal("Invalid Data", "Jenis kirim harus diisi!", "error")
                .then(function(){ fieldJenis.focus(); });
            return;
        }
        let harga = fieldHarga.value;
        if (!fieldHarga.value.trim() || fieldHarga.value <= 0) {
            fieldHarga.classList.add('is-invalid');
            swal("Invalid Data", "Harga harus diisi!", "error")
                .then(function(){ fieldHarga.focus(); });
            return;
        }
        if(harga.length > 20){
            fieldHarga.classList.add('is-invalid');
            swal("Invalid Data", "Harga tidak boleh lebih dari 20 digit!", "error")
                .then(function(){ fieldHarga.focus(); });
            return;
        }

        form.submit();
    });
});
</script>

@endsection
