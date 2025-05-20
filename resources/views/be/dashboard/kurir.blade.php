@extends('be/partial/master')
@section('navbar')
@include('be/partial/navbar')
@endsection
@section('sidebar')
@include('be/partial/sidebar')
@endsection

@section('content')
<div class="px-4 mt-4">

    {{-- Header --}}
    <div class="text-center my-4">
        <h2 class="section-title">🚚 Statistik Pengiriman</h2>
        <hr class="w-25 mx-auto border-primary">
    </div>

    <!-- Ringkasan Statistik -->
    <div class="row mb-4">
        <!-- Total Pengiriman -->
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-start border-4 border-dark shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-box fa-2x text-dark mb-2"></i>
                    <h6 class="card-title">Total Pengiriman</h6>
                    <h3>{{ $totalPengiriman }}</h3>
                </div>
            </div>
        </div>
        <!-- Belum Diambil -->
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-start border-4 border-danger shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-2x text-danger mb-2"></i>
                    <h6 class="card-title">Belum Diambil</h6>
                    <h3 class="text-danger">{{ $jumlahBelumDiambil }}</h3>
                </div>
            </div>
        </div>
        <!-- Dalam Pengiriman -->
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-start border-4 border-warning shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-shipping-fast fa-2x text-warning mb-2"></i>
                    <h6 class="card-title">Dalam Pengiriman</h6>
                    <h3 class="text-warning">{{ $jumlahDalamPengiriman }}</h3>
                </div>
            </div>
        </div>
        <!-- Tiba di Tujuan -->
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-start border-4 border-primary shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x text-primary mb-2"></i>
                    <h6 class="card-title">Tiba di Tujuan</h6>
                    <h3 class="text-primary">{{ $jumlahSampai }}</h3>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
