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
        <h4 class="card-title">Edit User</h4>
        <form class="forms-sample" method="POST" action="{{ route('users.update', $data->id) }}" enctype="multipart/form-data" id="frmUser">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama User</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Name" value="{{ old('name', $data->name) }}">
                @error('name')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{ old('email', $data->email) }}">
                @error('email')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <select class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan">
                    <option value="">-- Pilih Jabatan --</option>
                    @foreach(['karyawan', 'apoteker', 'pemilik', 'kasir', 'admin'] as $jabatan)
                    <option value="{{ $jabatan }}" {{ old('jabatan', $data->jabatan) === $jabatan ? 'selected' : '' }}>
                        {{ ucfirst($jabatan) }}
                    </option>
                    @endforeach
                </select>
                @error('jabatan')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password">
                @error('password')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password</label>
                <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                @error('confirm_password')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <button id="btn-simpan" type="button" class="btn btn-primary mr-2">Update</button>
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
        const form = document.getElementById('frmUser');
        const btnSave = document.getElementById('btn-simpan');
        const btnCancel = document.getElementById('btn-cancel');

        const fieldNama = document.getElementById('name');
        const fieldEmail = document.getElementById('email');
        const fieldPassword = document.getElementById('password');
        const fieldConfirm = document.getElementById('confirm_password');
        const fieldJabatan = document.getElementById('jabatan');

        btnCancel.addEventListener('click', function() {
            window.location = "{{ route('users.index') }}";
        });

        btnSave.addEventListener('click', function(event) {
            event.preventDefault();

            [fieldNama, fieldEmail, fieldPassword, fieldConfirm, fieldJabatan].forEach(function(el) {
                el.classList.remove('is-invalid');
            });

            if (!fieldNama.value.trim()) {
                fieldNama.classList.add('is-invalid');
                swal("Invalid Data", "Nama harus diisi!", "error").then(() => fieldNama.focus());
                return;
            }

            if (!fieldEmail.value.trim()) {
                fieldEmail.classList.add('is-invalid');
                swal("Invalid Data", "Email harus diisi!", "error").then(() => fieldEmail.focus());
                return;
            }

            if (!fieldJabatan.value.trim()) {
                fieldJabatan.classList.add('is-invalid');
                swal("Invalid Data", "Jabatan harus dipilih!", "error").then(() => fieldJabatan.focus());
                return;
            }

            const password = fieldPassword.value.trim();
            const confirmPassword = fieldConfirm.value.trim();

            if (password || confirmPassword) {
                if (password.length < 8) {
                    fieldPassword.classList.add('is-invalid');
                    swal("Invalid Data", "Password minimal 8 karakter!", "error").then(() => fieldPassword.focus());
                    return;
                }

                if (password !== confirmPassword) {
                    fieldConfirm.classList.add('is-invalid');
                    swal("Invalid Data", "Konfirmasi Password tidak sesuai!", "error").then(() => fieldConfirm.focus());
                    return;
                }
            }

            form.submit();
        });
    });
</script>

@endsection