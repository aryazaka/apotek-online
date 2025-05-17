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
        <h4 class="card-title">Buat User Baru</h4>
        <form class="forms-sample" method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data" id="frmUser">

        @csrf

            <div class="form-group">
                <label for="exampleInputName1">Nama User</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Name" value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="exampleInputName1">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="exampleSelectGender">Jabatan</label>
                <select class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan">
                    <option value="">-- Pilih Jabatan --</option>
                    @foreach(['karyawan', 'apoteker', 'pemilik', 'kasir', 'admin'] as $jabatan)
                        <option value="{{ $jabatan }}" {{ old('jabatan') === $jabatan ? 'selected' : '' }}>
                            {{ ucfirst($jabatan) }}
                        </option>
                    @endforeach

                </select>
                @error('jabatan')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="exampleInputName1">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password">
                @error('password')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="exampleInputName1">Konfirmasi Password</label>
                <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                @error('confirm_password')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>


            <button id="btn-simpan" type="button" class="btn btn-primary mr-2">Submit</button>
            <button id="btn-cancel" type="button" class="btn btn-dark">Cancel</button>
        </form>
    </div>
</div>

@if ($errors->has('email'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    swal("Warning", "Email Sudah Ada, silahkan gunakan email lain", "warning");
});
</script>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
  // ambil elemen form
  const form      = document.getElementById('frmUser');
  const btnSave   = document.getElementById('btn-simpan');
  const btnCancel = document.getElementById('btn-cancel');

  // ambil semua field
  const fieldNama     = document.getElementById('name');
  const fieldEmail    = document.getElementById('email');
  const fieldPassword = document.getElementById('password');
  const fieldConfirm  = document.getElementById('confirm_password');
  const fieldJabatan  = document.getElementById('jabatan');

  // tombol cancel
  btnCancel.addEventListener('click', function(){
    window.location = "{{ route('users.index') }}";
  });

  // tombol simpan
  btnSave.addEventListener('click', function(event) { 
    event.preventDefault();

    // reset error dulu
    [fieldNama, fieldEmail, fieldPassword, fieldConfirm, fieldJabatan].forEach(function(el){
      el.classList.remove('is-invalid');
    });

    // validasi Nama
    if (!fieldNama.value.trim()) {
      fieldNama.classList.add('is-invalid');
      swal("Invalid Data", "Nama harus diisi!", "error")
        .then(function(){ fieldNama.focus(); });
      return;
    }

    // validasi Email
    if (!fieldEmail.value.trim()) {
      fieldEmail.classList.add('is-invalid');
      swal("Invalid Data", "Email harus diisi!", "error")
        .then(function(){ fieldEmail.focus(); });
      return;
    }

    // validasi Jabatan
    if (!fieldJabatan.value.trim()) {
      fieldJabatan.classList.add('is-invalid');
      swal("Invalid Data", "Jabatan harus dipilih!", "error")
        .then(function(){ fieldJabatan.focus(); });
      return;
    }

    // validasi Password
    if (!fieldPassword.value.trim()) {
      fieldPassword.classList.add('is-invalid');
      swal("Invalid Data", "Password harus diisi!", "error")
        .then(function(){ fieldPassword.focus(); });
      return;
    }

    if(!fieldConfirm.value.trim()){
      fieldConfirm.classList.add('is-invalid');
      swal("Invalid Data", "Konfirmasi Password harus diisi!", "error")
        .then(function(){ fieldConfirm.focus(); });
      return;
    }

    if (fieldPassword.value.trim().length < 8) {
      fieldPassword.classList.add('is-invalid');
      swal("Invalid Data", "Password minimal 8 karakter!", "error")
        .then(function(){ fieldPassword.focus(); });
      return;
    }
    // validasi Confirm Password
    if (fieldConfirm.value.trim() !== fieldPassword.value.trim()) {
      fieldConfirm.classList.add('is-invalid');
      swal("Invalid Data", "Konfirmasi Password tidak sesuai!", "error")
        .then(function(){ fieldConfirm.focus(); });
      return;
    }

    // kalau semua valid, submit
    form.submit();
  });
});
</script>


@endsection