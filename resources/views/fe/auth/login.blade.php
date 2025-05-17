@extends('fe.partial.master')

<link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

@section('body-class', 'auth-body')

@section('content')
<section class="contact-section spad">

    <div class="login-container">
       
        <div style="display: flex; justify-content: flex-end;">
            <a href="{{ route('home.index') }}" style="
                font-size: 2rem;
                text-decoration: none;
                color: #333;
                font-weight: bold;
            ">&times;</a>
        </div>

        <h2>Login</h2>

        <form action="{{ route('postLogin.pelanggan') }}" method="POST" id="formLogin">
            {{-- Display error messages if any --}}
            @csrf
         
            <div class="form-group">
                <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}"/>
            </div>
            <div class="form-group">
                <input type="password" name="katakunci" id="katakunci" placeholder="Password"/>
            </div>
            <button type="submit" class="site-btn">Login</button>
        </form>

        <a href="{{ route('getRegister.pelanggan') }}">Belum punya akun? Register</a>
    </div>

    <script>
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('katakunci');
        const formLogin = document.getElementById('formLogin');

        document.addEventListener('DOMContentLoaded', function() {
            formLogin.addEventListener('submit', function(event) {
                event.preventDefault(); 
                if (emailInput.value.trim() === '') {
                    Swal.fire('Warning', "Email harus diisi!", 'warning');
                    emailInput.focus();
                    return;
                }

                if (passwordInput.value.trim() === '') {
                    Swal.fire('Warning', "Password harus diisi!", 'warning');
                    passwordInput.focus();
                    return;
                }

                formLogin.submit();
            });
        });
    </script>
</section>
@endsection


