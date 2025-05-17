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
    <h4 class="card-title">Tambah Distributor Baru</h4>
    <form
      class="forms-sample"
      method="POST"
      action="{{ route('distributor.store') }}"
      enctype="multipart/form-data"
      id="frmDistributor"

    >
      @csrf

      <div class="form-group">
        <label for="distributor">Nama Distributor</label>
        <input
          type="text"
          class="form-control @error('nama_distributor') is-invalid @enderror"
          id="nama_distributor"
          name="nama_distributor"
          placeholder="Nama Distributor"
          value="{{ old('nama_distributor') }}"
        >
        @error('nama_distributor')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="distributor">No Telepon</label>
        <input
          type="number"
          class="form-control @error('telepon') is-invalid @enderror"
          id="telepon"
          name="telepon"
          placeholder="No telepon"
          value="{{ old('telepon') }}"
        >
        @error('telepon')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="distributor">Alamat</label>
        <input
          type="text"
          class="form-control @error('alamat') is-invalid @enderror"
          id="alamat"
          name="alamat"
          placeholder="Alamat"
          value="{{ old('alamat') }}"
        >
        @error('alamat')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <button type="button" class="btn btn-primary mr-2" id="btn-simpan">
        Create
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
  const form       = document.getElementById('frmDistributor');
  const btnSave    = document.getElementById('btn-simpan');
  const btnCancel  = document.getElementById('btn-cancel');
  const fieldNama = document.getElementById('nama_distributor');
  const fieldTelp = document.getElementById('telepon');
  const fieldAlamat = document.getElementById('alamat');


  btnCancel.addEventListener('click', function(){
    window.location = "{{ route('distributor.index') }}";
  });

  btnSave.addEventListener('click', function(event) { 
  event.preventDefault();
  
  // Hapus semua error class
  [fieldNama, fieldTelp, fieldAlamat].forEach(function(el){
    el.classList.remove('is-invalid');
  });

  // VALIDASI NAMA
  if (!fieldNama.value.trim()) {
    fieldNama.classList.add('is-invalid');
    swal("Invalid Data", "Nama Distributor harus diisi!", "error")
      .then(function(){ fieldNama.focus(); });
    return;
  }

  // VALIDASI NAMA panjang
  let nama = fieldNama.value.trim();
  if (nama.length > 50) {
    fieldNama.classList.add('is-invalid');
    swal("Invalid Data", "Nama Distributor tidak boleh lebih dari 50 karakter, termasuk spasi!", "error")
      .then(function(){ fieldNama.focus(); });
    return;
  }

  let alamat = fieldAlamat.value.trim();
  if (alamat.length > 255) {
    fieldAlamat.classList.add('is-invalid');
    swal("Invalid Data", "Alamat tidak boleh lebih dari 255 karakter, termasuk spasi!", "error")
      .then(function(){ fieldAlamat.focus(); });
    return;
  }

  // VALIDASI TELEPON
  let telepon = fieldTelp.value.trim();
  if (telepon.length > 15) {
    fieldTelp.classList.add('is-invalid');
    swal("Invalid Data", "No Telepon tidak boleh lebih dari 15 digit!", "error")
      .then(function(){ fieldTelp.focus(); });
    return;
  }

  

  // LANGSUNG SUBMIT
  form.submit();
});
  
  });
</script>
@endsection

