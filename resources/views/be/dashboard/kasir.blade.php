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
        <h2 class="section-title">📊 Statistik Obat & Penjualan</h2>
        <hr class="w-25 mx-auto border-success">
    </div>

    <div class="row mb-4 justify-content-center">

        <!-- Total Obat -->
        <div class="col-md-4 mb-3">
            <div class="card border-start border-4 border-success shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-pills fa-2x text-success mb-2"></i>
                    <h5 class="card-title">Total Produk Obat</h5>
                    <h3 class="text-success">{{ $jumlahObat }}</h3>
                </div>
            </div>
        </div>

        <!-- Total Pembelian (ditengah) -->
        <div class="col-md-4 mb-3">
            <div class="card border-start border-4 border-success shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-shopping-cart fa-2x text-success mb-2"></i>
                    <h5 class="card-title">Total Penjualan</h5>
                    <h3 class="text-success">{{ $jumlahPenjualan }}</h3>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
