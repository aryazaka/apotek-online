<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{$title}}</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('be/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('be/assets/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('be/assets/vendors/jvectormap/jquery-jvectormap.css') }}">
    <link rel="stylesheet" href="{{ asset('be/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('be/assets/vendors/owl-carousel-2/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('be/assets/vendors/owl-carousel-2/owl.theme.default.min.css') }}">

    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('be/assets/css/style.css') }}">
    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

{{-- jQuery & Select2 JS --}}

    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('be/assets/images/favicon.png') }}" />
  </head>
  <body 
  id="{{ str_replace('.', '-', Route::currentRouteName()) }}"
  data-success="{{ session('success') }}" data-failed="{{ session('failed') }}">
    <div class="container-scroller">
      
      @yield('sidebar')
      
      <div class="container-fluid page-body-wrapper">
        
      @yield('navbar')
      
        <div class="main-panel">
        <!-- Tambahkan wrapper untuk judul dan tombol -->
        @yield('content')
          
        @yield('footer')
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- plugins:js -->
    <script src="{{ asset('be/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('be/assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('be/assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
    <script src="{{ asset('be/assets/vendors/jvectormap/jquery-jvectormap.min.js') }}"></script>
    <script src="{{ asset('be/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('be/assets/vendors/owl-carousel-2/owl.carousel.min.js') }}"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('be/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('be/assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('be/assets/js/misc.js') }}"></script>
    <script src="{{ asset('be/assets/js/settings.js') }}"></script>
    <script src="{{ asset('be/assets/js/todolist.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{ asset('be/assets/js/dashboard.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
  
    <!-- End custom js for this page -->
    <script>
  document.addEventListener('DOMContentLoaded', function() {
    if (document.body.id === 'jenis-index') {
      let msg = document.body.dataset.success;
      if (msg) {
        swal("Berhasil!", msg, "success");
      }
    }

    if (document.body.id === 'obat-index') {
      let msg = document.body.dataset.success;
      if (msg) {
        swal("Berhasil!", msg, "success");
      }
    }

    if (document.body.id === 'dashboard-index') {
      let msg = document.body.dataset.success;
      if (msg) {
        swal("Berhasil!", msg, "success");
      }
    }

    if (document.body.id === 'distributor-index') {
      let msg = document.body.dataset.success;
      if (msg) {
        swal("Berhasil!", msg, "success");
      }
    }

    if (document.body.id === 'users-index') {
      let msg = document.body.dataset.success;
      if (msg) {
        swal("Berhasil!", msg, "success");
      }
    }

    if (document.body.id === 'pembelian-index') {
      let msg = document.body.dataset.success;
      if (msg) {
        swal("Berhasil!", msg, "success");
      }
    }

    if (document.body.id === 'jenis-pengiriman-index') {
      let msg = document.body.dataset.success;
      if (msg) {
        swal("Berhasil!", msg, "success");
      }
    }
    
    if (document.body.id === 'penjualan-index') {
      let msg = document.body.dataset.success;
      if (msg) {
        swal("Berhasil!", msg, "success");
      }
    }

     if (document.body.id === 'pengiriman-index') {
      let msg = document.body.dataset.success;
      if (msg) {
        swal("Berhasil!", msg, "success");
      }
    }

    if (document.body.id === 'auth-management-index') {
      let msg = document.body.dataset.failed;
      if (msg) {
        swal("Gagal!", msg, "error");
      }
    }

  });
</script>

<script>
        document.addEventListener('DOMContentLoaded', function() {
            var popupImages = document.querySelectorAll('.popup-image');
            var modalImage = document.getElementById('modalImage');

            popupImages.forEach(function(img) {
                img.addEventListener('click', function() {
                    var src = img.getAttribute('src');
                    modalImage.setAttribute('src', src);
                    var myModal = new bootstrap.Modal(document.getElementById('imageModal'));
                    myModal.show();
                });
            });
        });
    </script>



  </body>
</html>