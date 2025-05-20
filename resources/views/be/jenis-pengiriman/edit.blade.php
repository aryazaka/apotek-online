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
        <h4 class="card-title">Edit Jenis Pengiriman</h4>

        <form class="forms-sample" method="POST" action="{{ route('jenis-kirim.update', $data->id) }}" enctype="multipart/form-data" id="frmJenisKirim">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="ekspedisi">Nama Ekspedisi</label>
                <input type="text" class="form-control @error('ekspedisi') is-invalid @enderror" name="nama_ekspedisi" value="{{ old('ekspedisi', $data->nama_ekspedisi) }}" placeholder="Nama Ekspedisi">
                @error('nama_ekspedisi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

             <div class="form-group">
                <label for="ekspedisi">Harga</label>
                <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" placeholder="Harga" value="{{ old('harga', $data->harga) }}">
                @error('harga')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="jenis_kirim">Jenis Kirim</label>
                <select class="form-control @error('jenis_kirim') is-invalid @enderror" id="jenis_kirim" name="jenis_kirim">
                    <option value="">-- Pilih Jenis Kirim --</option>
                    <option value="ekonomi" {{ old('jenis_kirim', $data->jenis_kirim) == 'ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                    <option value="kargo" {{ old('jenis_kirim', $data->jenis_kirim) == 'kargo' ? 'selected' : '' }}>Kargo</option>
                    <option value="regular" {{ old('jenis_kirim', $data->jenis_kirim) == 'regular' ? 'selected' : '' }}>Regular</option>
                    <option value="same day" {{ old('jenis_kirim', $data->jenis_kirim) == 'same day' ? 'selected' : '' }}>Same Day</option>
                    <option value="standar" {{ old('jenis_kirim', $data->jenis_kirim) == 'standar' ? 'selected' : '' }}>Standar</option>
                </select>
                @error('jenis_kirim')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Logo (Opsional)</label>
                <input type="file" name="logo_ekspedisi" id="logo" class="file-upload-default @error('logo') is-invalid @enderror">
                <div class="input-group col-xs-12">
                    <input type="text" class="form-control file-upload-info" id="labelLogo" disabled placeholder="Upload Logo">
                    <span class="input-group-append">
                        <button class="file-upload-browse btn btn-primary" type="button" id="btnLogo">Upload</button>
                    </span>
                </div>
                @error('logo_ekspedisi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @if ($data->logo_ekspedisi)
                    <small class="form-text text-muted mt-2">Logo saat ini: 
                        <img src="{{ asset('uploads/logo_ekspedisi/' . $data->logo_ekspedisi) }}" alt="Logo" style="height: 40px;">
                    </small>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('jenis-kirim.index') }}" class="btn btn-dark" id="btnCancel">Cancel</a>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fieldFile = document.getElementById('logo');
        const fileLabel = document.getElementById('labelLogo');
        const btnBrowse = document.getElementById('btnLogo');
        const btnCancel = document.getElementById('btnCancel');

        btnBrowse.addEventListener('click', function () {
            fieldFile.click();
        });

        fieldFile.addEventListener('change', function () {
            if (fieldFile.files.length) {
                fileLabel.value = fieldFile.files[0].name;
            }
        });

        btnCancel.addEventListener('click', function (e) {
            e.preventDefault();
            window.location = "{{ route('jenis-kirim.index') }}";
        });
    });
</script>

@endsection
