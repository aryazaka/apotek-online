<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Yoga Studio Template">
    <meta name="keywords" content="Yoga, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('fe/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('fe/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('fe/css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('fe/css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('fe/css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('fe/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('fe/css/style.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('fe/css/auth.css') }}" type="text/css">
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body 
    class="@yield('body-class')"
    id="{{ str_replace('.', '-', Route::currentRouteName()) }}"
    data-success="{{ session('success') }}" data-failed="{{ session('failed') }}"> 
   <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>
    
    <!-- Search model -->
	<div class="search-model">
		<div class="h-100 d-flex align-items-center justify-content-center">
			<div class="search-close-switch">+</div>
			<form class="search-model-form">
				<input type="text" id="search-input" placeholder="Search here.....">
			</form>
		</div>
	</div>
	<!-- Search model end -->
    @yield('navbar')
    <!-- Header End -->

    @yield('slider')

    @yield('content')

    @yield('footer')



    <!-- Js Plugins -->
    <script src="{{ asset('fe/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('fe/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('fe/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('fe/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('fe/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('fe/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('fe/js/mixitup.min.js') }}"></script>
    <script src="{{ asset('fe/js/main.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<script>
     document.addEventListener('DOMContentLoaded', function() {
        const id = document.body.id;
    const success = document.body.dataset.success;
    const failed = document.body.dataset.failed;

    if (success) {
        Swal.fire({
            title: 'Berhasil!',
            text: success,
            icon: 'success',
            confirmButtonText: 'OK'
        });
    }

    if (failed) {
        Swal.fire({
            title: 'Gagal!',
            text: failed,
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
});

</script>
</body>


</html>