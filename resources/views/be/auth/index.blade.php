@extends('be/partial/master')
@section('content')
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">
              <div class="card-body px-5 py-5">
                <h3 class="card-title text-left mb-3">Login</h3>

                <form method="POST" action="{{ route('auth-management.login') }}" enctype="multipart/form-data" id="frmLogin">
                    @csrf
                  <div class="form-group">
                    <label>Username or email *</label>
                    <input id="email" name="email" type="text" class="form-control p_input @error('email') is-invalid @enderror">
                  </div>
                  <div class="form-group">
                    <label>Password *</label>
                    <input id="password" name="password" type="password" class="form-control p_input @error('password') is-invalid @enderror">
                  </div>
                  <div class="form-group d-flex align-items-center justify-content-between">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input"> Remember me </label>
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="button" id="btn-login" class="btn btn-primary btn-block enter-btn">Login</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
      </div>

      <script>
document.addEventListener('DOMContentLoaded', function() {
  // ambil elemen
  const form       = document.getElementById('frmLogin');
  const btnLogin    = document.getElementById('btn-login');
  const fieldEmail = document.getElementById('email');
  const fieldPass  = document.getElementById('password');


  btnLogin.addEventListener('click', function(event){
    event.preventDefault();

    [fieldEmail, fieldPass].forEach(function(el){
      el.classList.remove('is-invalid');
    });

    if (!fieldEmail.value.trim()) {
      fieldEmail.classList.add('is-invalid');
      swal("Invalid Data", "Email harus diisi!", "error")
        .then(function(){ fieldEmail.focus(); });
      return;
    }
    if (!fieldPass.value.trim()) {
      fieldPass.classList.add('is-invalid');
      swal("Invalid Data", "Password harus diisi!", "error")
        .then(function(){ fieldPass.focus(); });
      return;
    }

    form.submit();
  });
});
</script>
@endsection