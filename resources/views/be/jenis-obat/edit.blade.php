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
    <h4 class="card-title">Edit Jenis Obat</h4>
    <form
      class="forms-sample"
      method="POST"
      action="{{ route('jenis.update', $data['id']) }}"
      enctype="multipart/form-data"
      id="frmJenis"

    >
      @csrf
      @method('PUT')

      <div class="form-group">
        <label for="jenis">Nama</label>
        <input
          type="text"
          class="form-control @error('jenis') is-invalid @enderror"
          id="jenis"
          name="jenis"
          placeholder="Nama Jenis Obat"
          value="{{ old('jenis', $data['jenis']) }}"
        >
        @error('jenis')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="deskripsi_jenis">Deskripsi</label>
        <textarea
          class="form-control @error('deskripsi') is-invalid @enderror"
          id="deskripsi_jenis"
          name="deskripsi_jenis"
          rows="4"
        >{{ old('deskripsi_jenis', $data['deskripsi_jenis']) }}</textarea>
        @error('deskripsi_jenis')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label>Foto</label>
        <input
          type="file"
          name="image_url"
          id="image_url"
          class="file-upload-default @error('image_url') is-invalid @enderror"
        >
        <div class="input-group col-xs-12">
          <input
            type="text"
            class="form-control file-upload-info"
            disabled
            placeholder="Upload Image"
            id="fileLabel"
          >
          <span class="input-group-append">
            <button
              class="file-upload-browse btn btn-primary"
              type="button"
              id="btnBrowse"
            >Upload</button>
          </span>
        </div>
        @error('image_url')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <button type="button" class="btn btn-primary mr-2" id="btn-simpan">
        Update
      </button>
      <button type="button" class="btn btn-dark" id="btn-cancel">
        Cancel
      </button>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // ambil elemen
  let form       = document.getElementById('frmJenis');
  let btnSave    = document.getElementById('btn-simpan');
  let btnCancel  = document.getElementById('btn-cancel');
  let fieldJenis = document.getElementById('jenis');
  let fieldDesk  = document.getElementById('deskripsi_jenis');
  let fieldFile  = document.getElementById('image_url');
  let fileLabel  = document.getElementById('fileLabel');
  let btnBrowse  = document.getElementById('btnBrowse');


  btnBrowse.addEventListener('click', function(){
    fieldFile.click();
  });
  fieldFile.addEventListener('change', function(){
    if (fieldFile.files.length) {
      fileLabel.value = fieldFile.files[0].name;
    }
  });

  btnCancel.addEventListener('click', function(){
    window.location = "{{ route('jenis.index') }}";
  });

  btnSave.addEventListener('click', function(event) { 
    event.preventDefault();

    [fieldJenis, fieldDesk, fieldFile].forEach(function(el){
      el.classList.remove('is-invalid');
    });

    if (!fieldJenis.value.trim()) {
      fieldJenis.classList.add('is-invalid');
      swal("Invalid Data", "Nama Jenis Obat harus diisi!", "error")
        .then(function(){ fieldJenis.focus(); });
      return;
    }

    form.submit();
  });
});
</script>
@endsection

