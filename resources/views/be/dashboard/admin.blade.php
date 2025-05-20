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
        <h2 class="section-title">📊 Statistik Pengguna</h2>
        <hr class="w-25 mx-auto border-success">
    </div>

    <!-- Sekat: Ringkasan Umum -->
    <h4 class="mx-4 mb-3 text-success">🟢 Ringkasan Umum</h4>
    <div class="row mb-4">
        <!-- Management -->
        <div class="col-md-6 mb-3">
            <div class="card border-start border-4 border-success shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-user-tie fa-2x text-success mb-2"></i>
                    <h5 class="card-title">Total Pengguna Management</h5>
                    <h3 class="text-success">{{ $jumlahManagement }}</h3>
                </div>
            </div>
        </div>
        <!-- Pelanggan -->
        <div class="col-md-6 mb-3">
            <div class="card border-start border-4 border-success shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-2x text-success mb-2"></i>
                    <h5 class="card-title">Total Pelanggan</h5>
                    <h3 class="text-success">{{ $jumlahPelanggan }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Sekat: Statistik per Role -->
    <h4 class="mx-4 mb-3 text-warning">🟡 Pengguna Berdasarkan Role</h4>
    <div class="row mb-4">
        @php
            $roles = [
                ['label' => 'Admin', 'jumlah' => $jumlahAdmin, 'icon' => 'fa-user-shield'],
                ['label' => 'Kurir', 'jumlah' => $jumlahKurir, 'icon' => 'fa-motorcycle'],
                ['label' => 'Karyawan', 'jumlah' => $jumlahKaryawan, 'icon' => 'fa-briefcase'],
                ['label' => 'Apoteker', 'jumlah' => $jumlahApoteker, 'icon' => 'fa-prescription-bottle-alt'],
                ['label' => 'Kasir', 'jumlah' => $jumlahKasir, 'icon' => 'fa-cash-register'],
                ['label' => 'Pemilik', 'jumlah' => $jumlahPemilik->count(), 'icon' => 'fa-user-crown']
            ];
        @endphp

        @foreach ($roles as $role)
        <div class="col-md-4 mb-3">
            <div class="card border-start border-4 border-warning shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas {{ $role['icon'] }} fa-2x text-warning mb-2"></i>
                    <h5 class="card-title">Total Pengguna {{ $role['label'] }}</h5>
                    <h3 class="text-warning">{{ $role['jumlah'] }}</h3>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
