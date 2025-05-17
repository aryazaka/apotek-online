@extends('fe.partial.master')

@section('body-class', 'auth-body')

@section('content')
<section class="contact-section spad" style="padding-top: 100px;">
    <div class="register-container">

    <div style="display: flex; justify-content: flex-end;">
            <a href="{{ route('home.index') }}" style="
                font-size: 2rem;
                text-decoration: none;
                color: #333;
                font-weight: bold;
            ">&times;</a>
        </div>
        
        <h2 class="text-center mb-4">Register</h2>
        
        <form action="{{ route('postRegister.pelanggan') }}" method="POST" enctype="multipart/form-data" id="formRegister">
            @csrf

            {{-- Identitas --}}
            <div class="form-group">
                <label for="nama_pelanggan">Nama Pelanggan <span class="text-danger">*</span></label>
                <input autocomplete="name" type="text" id="nama_pelanggan" name="nama_pelanggan" class="form-control" placeholder="Nama Pelanggan">
            </div>

            <div class="form-group">
                <label for="email">Email <span class="text-danger">*</span></label>
                <input autocomplete="email" type="email" id="email" name="email" class="form-control" placeholder="Email">
            </div>

            <div class="form-group">
                <label for="katakunci">Password <span class="text-danger">*</span></label>
                <input autocomplete="new-password" type="password" id="katakunci" name="katakunci" class="form-control" placeholder="Password">
            </div>

            <div class="form-group">
                <label for="no_telp">No. Telepon <span class="text-danger">*</span></label>
                <input autocomplete="tel" type="number" id="no_telp" name="no_telp" class="form-control" placeholder="No. Telepon">
            </div>

            <h5 class="mt-4">Alamat</h5>
            <div class="form-group">
                <label for="alamat1">Alamat 1 <span class="text-danger">*</span></label>
                <input type="text" id="alamat1" name="alamat1" class="form-control" placeholder="Alamat 1">
            </div>
            <div class="form-group">
                <label for="alamat2">Alamat 2</label>
                <input type="text" id="alamat2" name="alamat2" class="form-control" placeholder="Alamat 2">
            </div>
            <div class="form-group">
                <label for="alamat3">Alamat 3</label>
                <input type="text" id="alamat3" name="alamat3" class="form-control" placeholder="Alamat 3">
            </div>

            <h5 class="mt-4">Kota</h5>
            <div class="form-group">
                <label for="kota1">Kota 1 <span class="text-danger">*</span></label>
                <input type="text" id="kota1" name="kota1" class="form-control" placeholder="Kota 1">
            </div>
            <div class="form-group">
                <label for="kota2">Kota 2</label>
                <input type="text" id="kota2" name="kota2" class="form-control" placeholder="Kota 2">
            </div>
            <div class="form-group">
                <label for="kota3">Kota 3</label>
                <input type="text" id="kota3" name="kota3" class="form-control" placeholder="Kota 3">
            </div>

            <h5 class="mt-4">Provinsi</h5>
            <div class="form-group">
                <label for="propinsi1">Provinsi 1 <span class="text-danger">*</span></label>
                <input type="text" id="propinsi1" name="propinsi1" class="form-control" placeholder="Provinsi 1">
            </div>
            <div class="form-group">
                <label for="propinsi2">Provinsi 2</label>
                <input type="text" id="propinsi2" name="propinsi2" class="form-control" placeholder="Provinsi 2">
            </div>
            <div class="form-group">
                <label for="propinsi3">Provinsi 3</label>
                <input type="text" id="propinsi3" name="propinsi3" class="form-control" placeholder="Provinsi 3">
            </div>

            <h5 class="mt-4">Kode Pos</h5>
            <div class="form-group">
                <label for="kodepos1">Kode Pos 1 <span class="text-danger">*</span></label>
                <input type="text" id="kodepos1" name="kodepos1" class="form-control" placeholder="Kode Pos 1">
            </div>
            <div class="form-group">
                <label for="kodepos2">Kode Pos 2</label>
                <input type="text" id="kodepos2" name="kodepos2" class="form-control" placeholder="Kode Pos 2">
            </div>
            <div class="form-group">
                <label for="kodepos3">Kode Pos 3</label>
                <input type="text" id="kodepos3" name="kodepos3" class="form-control" placeholder="Kode Pos 3">
            </div>

            <div class="form-group">
                <label for="foto">Foto Profil</label>
                <input type="file" name="foto" id="foto" class="form-control-file" accept="image/*">
            </div>

            <div class="form-group">
                <label for="url_ktp">Upload KTP</label>
                <input type="file" name="url_ktp" id="url_ktp" class="form-control-file" accept="image/*,application/pdf">
            </div>

            <button type="submit" class="site-btn mt-3 w-100" id="btn-register">Daftar</button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('getLogin.pelanggan') }}">Sudah punya akun? Login</a>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const requiredFields = [
        'nama_pelanggan', 'email', 'katakunci', 'no_telp',
        'alamat1', 'kota1', 'propinsi1', 'kodepos1'
    ];

    const formRegister = document.getElementById('formRegister');

    formRegister.addEventListener('submit', function (e) {
        let isValid = true;

        // Reset error
        requiredFields.forEach(id => {
            const el = document.getElementById(id);
            el.classList.remove('is-invalid');
        });

        // Validasi field wajib
        for (const id of requiredFields) {
            const field = document.getElementById(id);
            if (!field || !field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
                Swal.fire('Form Tidak Lengkap', `${field.placeholder} harus diisi!`, 'error');
                field.focus();
                e.preventDefault();
                return;
            }
        }

        // Validasi panjang password setelah dipastikan tidak kosong
        const passwordField = document.getElementById('katakunci');
        if (passwordField.value.trim().length < 8) {
            isValid = false;
            passwordField.classList.add('is-invalid');
            Swal.fire('Password Terlalu Pendek', 'Password minimal harus 8 karakter!', 'error');
            passwordField.focus();
            e.preventDefault();
            return;
        }
    });
});
</script>


@endsection
