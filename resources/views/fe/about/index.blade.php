@extends('fe/partial/master')

@section('navbar')
@include('fe/partial/navbar')
@endsection

@section('footer')
@include('fe/partial/footer')
@endsection

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold text-black">Tentang Apotek Kami</h1>
        <p class="text-muted">
            Apotek online terpercaya yang menyediakan berbagai macam obat dan produk kesehatan dengan pelayanan cepat, aman, dan terpercaya.
        </p>
    </div>

    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <img src="{{ asset('fe/img/obat3.jpg') }}" alt="Tentang Apotek" class="img-fluid rounded shadow-sm">
        </div>
        <div class="col-md-6">
            <h3 class="fw-semibold text-black">Layanan Kami</h3>
            <p class="text-muted">
                Kami hadir untuk memudahkan Anda dalam memperoleh obat-obatan, baik resep maupun non-resep. ApotekKami menyediakan layanan pembelian obat secara daring yang mudah, cepat, dan terjamin keasliannya.
            </p>
            <ul class="list-unstyled">
                <li><i class="fa-solid fa-check text-success me-2"></i>Obat generik dan bermerek</li>
                <li><i class="fa-solid fa-check text-success me-2"></i>Produk kesehatan & suplemen</li>
                <li><i class="fa-solid fa-check text-success me-2"></i>Konsultasi dengan apoteker</li>
                <li><i class="fa-solid fa-check text-success me-2"></i>Pengiriman cepat & aman</li>
            </ul>
        </div>
    </div>

    <div class="row text-center">
        <div class="col-md-4 mb-4">
            <div class="border rounded p-4 shadow-sm h-100">
                <i class="fa-solid fa-user-shield fa-2x text-primary mb-3"></i>
                <h5 class="fw-bold">Aman & Terpercaya</h5>
                <p class="text-muted small">Kami menjamin keaslian produk dan keamanan transaksi Anda.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="border rounded p-4 shadow-sm h-100">
                <i class="fa-solid fa-truck-fast fa-2x text-primary mb-3"></i>
                <h5 class="fw-bold">Pengiriman Cepat</h5>
                <p class="text-muted small">Layanan kurir cepat menjangkau seluruh wilayah Indonesia.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="border rounded p-4 shadow-sm h-100">
                <i class="fa-solid fa-headset fa-2x text-primary mb-3"></i>
                <h5 class="fw-bold">Dukungan Pelanggan</h5>
                <p class="text-muted small">Tim kami siap membantu Anda setiap hari dengan ramah dan profesional.</p>
            </div>
        </div>
    </div>
</div>
@endsection