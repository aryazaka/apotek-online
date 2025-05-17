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
        <h4 class="card-title">Buat Obat Baru</h4>
        <form class="forms-sample" method="POST" action="{{ route('obat.store') }}" enctype="multipart/form-data" id="frmObat">

        @csrf

            <div class="form-group">
                <label for="exampleInputName1">Nama Obat</label>
                <input type="text" class="form-control @error('nama_obat') is-invalid @enderror" id="nama_obat" name="nama_obat" placeholder="Nama Obat" value="{{ old('nama_obat') }}">
                @error('nama_obat')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="exampleSelectGender">Jenis Obat</label>
                <select class="form-control @error('jenis_obat') is-invalid @enderror" id="jenis_obat" name="id_jenis_obat">
                    <option selected value="">-- Pilih Jenis Obat --</option>
                    @foreach ($jenis_obat as $jo)
                        <option value="{{ $jo->id }}" {{ (old('id_jenis_obat', $jo->id) == $jo->id) ? '' : '' }}>
                            {{ $jo->jenis }}
                        </option>
                    @endforeach
                </select>
                @error('jenis_obat')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="exampleInputPassword4">Harga (Rp.)</label>
                <input type="number" class="form-control @error('harga_jual') is-invalid @enderror" id="harga_jual" name="harga_jual" placeholder="Masukkan harga" value="{{old("harga_jual")}}" >
                @error('harga_jual')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="exampleInputEmail3">Deskripsi</label>
                <textarea class="form-control @error('deskripsi_obat') is-invalid @enderror" id="deskripsi_obat" name="deskripsi_obat" rows="4">{{old("deskripsi_obat")}}</textarea>
                @error('deskripsi_obat')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="exampleInputCity1">Stok</label>
                <input type="number" class="form-control @error('stok') is-invalid @enderror" id="stok" name="stok" placeholder="Masukkan stok awal" value="{{old("stok")}}">
                @error('stok')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label>Foto1</label>
                <input type="file" name="foto1" id="foto1" class="file-upload-default @error('foto1') is-invalid @enderror">
                <div class="input-group col-xs-12">
                    <input type="text" class="form-control file-upload-info" id="labelFoto1" disabled placeholder="Upload Image">
                    <span class="input-group-append">
                        <button class="file-upload-browse btn btn-primary" id="btnFoto1" type="button">Upload</button>
                    </span>
                </div>
                @error('foto1')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Foto2</label>
                <input type="file" name="foto2" id="foto2" class="file-upload-default @error('foto2') is-invalid @enderror">
                <div class="input-group col-xs-12">
                    <input type="text" class="form-control file-upload-info" id="labelFoto2" disabled placeholder="Upload Image">
                    <span class="input-group-append">
                        <button class="file-upload-browse btn btn-primary" id="btnFoto2" type="button">Upload</button>
                    </span>
                </div>
                @error('foto2')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label>Foto3</label>
                <input type="file" name="foto3" id="foto3" class="file-upload-default @error('foto3') is-invalid @enderror">
                <div class="input-group col-xs-12">
                    <input type="text" class="form-control file-upload-info" id="labelFoto3" disabled placeholder="Upload Image">
                    <span class="input-group-append">
                        <button class="file-upload-browse btn btn-primary" id="btnFoto3" type="button">Upload</button>
                    </span>
                </div>
                @error('foto3')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <button id="btn-simpan" type="button" class="btn btn-primary mr-2">Submit</button>
            <button id="btn-cancel" type="button" class="btn btn-dark">Cancel</button>
        </form>
    </div>
</div>

@if ($errors->has('nama_obat'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    swal("Warning", "Nama obat Sudah Ada, silahkan gunakan Nama lain", "warning");
});
</script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
  // ambil elemen
  let form       = document.getElementById('frmObat');
  let btnSave    = document.getElementById('btn-simpan');
  let btnCancel  = document.getElementById('btn-cancel');

  let fieldNama  = document.getElementById('nama_obat');
  let fieldJenis = document.getElementById('jenis_obat');
  let fieldHarga = document.getElementById('harga_jual');
  let fieldStok  = document.getElementById('stok');
  let fieldDesk  = document.getElementById('deskripsi_obat');

  let fieldFile1  = document.getElementById('foto1');
  let fileLabel1  = document.getElementById('labelFoto1');
  let btnBrowse1  = document.getElementById('btnFoto1');
  let fieldFile2  = document.getElementById('foto2');
  let fileLabel2  = document.getElementById('labelFoto2');
  let btnBrowse2  = document.getElementById('btnFoto2');
  let fieldFile3  = document.getElementById('foto3');
  let fileLabel3  = document.getElementById('labelFoto3');
  let btnBrowse3  = document.getElementById('btnFoto3');


  btnBrowse1.addEventListener('click', function(){
    fieldFile1.click();
  });
  fieldFile1.addEventListener('change', function(){
    if (fieldFile1.files.length) {
      fileLabel1.value = fieldFile1.files[0].name;
    }
  });

  btnBrowse2.addEventListener('click', function(){
    fieldFile2.click();
  });
  fieldFile2.addEventListener('change', function(){
    if (fieldFile2.files.length) {
      fileLabel2.value = fieldFile2.files[0].name;
    }
  });

  btnBrowse3.addEventListener('click', function(){
    fieldFile3.click();
  });
  fieldFile3.addEventListener('change', function(){
    if (fieldFile3.files.length) {
      fileLabel3.value = fieldFile3.files[0].name;
    }
  });

  btnCancel.addEventListener('click', function(){
    window.location = "{{ route('obat.index') }}";
  });

  btnSave.addEventListener('click', function(event) { 
    event.preventDefault();

    [
        fieldNama,
        fieldJenis,
        fieldDesk,
        fieldStok,
        fieldHarga,
        fieldFile1,
        fieldFile2,
        fieldFile3
    ].forEach(function(el){
      el.classList.remove('is-invalid');
    });

    if (!fieldNama.value.trim()) {
      fieldNama.classList.add('is-invalid');
      swal("Invalid Data", "Nama Obat harus diisi!", "error")
        .then(function(){ fieldNama.focus(); });
      return;
    }

    if (!fieldJenis.value.trim()) {
      fieldJenis.classList.add('is-invalid');
      swal("Invalid Data", "Jenis Obat harus diisi!", "error")
        .then(function(){ fieldJenis.focus(); });
      return;
    }

    let harga = fieldHarga.value.trim();
    if (parseInt(fieldHarga.value) <= 0 || isNaN(parseInt(fieldHarga.value))) {
      fieldHarga.classList.add('is-invalid');
      swal("Invalid Data", "Harga harus diisi!", "error")
        .then(function(){ fieldHarga.focus(); });
      return;
    }
    if (harga.length > 11) {
      fieldHarga.classList.add('is-invalid');
      swal("Invalid Data", "Harga tidak boleh lebih dari 11 digit!", "error")
        .then(function(){ fieldHarga.focus(); });
      return;
    }

    let stok = fieldStok.value.trim();
    if (parseInt(fieldStok.value) <= 0 || isNaN(parseInt(fieldStok.value))) {
      fieldStok.classList.add('is-invalid');
      swal("Invalid Data", "Stok harus diisi!", "error")
        .then(function(){ fieldStok.focus(); });
      return;
    }
    if (stok.length > 11) {
      fieldHarga.classList.add('is-invalid');
      swal("Invalid Data", "Stok tidak boleh lebih dari 11 digit!", "error")
        .then(function(){ fieldStok.focus(); });
      return;
    }

    form.submit();
});

});
</script>

@endsection