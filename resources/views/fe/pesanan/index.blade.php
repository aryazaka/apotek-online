@extends('fe.partial.master')
@section('navbar')
    @include('fe.partial.navbar')
@endsection

@section('content')

<div class="container mx-auto px-4 py-6">
    <h2 class="text-xl font-bold mb-4">Pesanan Saya</h2>

    <ul class="nav nav-tabs" id="pesananTab" role="tablist">
    <li class="nav-item">
        <button class="nav-link active" id="belum-bayar-tab" data-bs-toggle="tab" data-bs-target="#belum-bayar" type="button">
            Belum Bayar
            @if($belumBayars->count())
                <span class="badge bg-danger ms-1">{{ $belumBayars->count() }}</span>
            @endif
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" id="diproses-tab" data-bs-toggle="tab" data-bs-target="#diproses" type="button">
            Sedang Diproses
            @if($diprosess->count())
                <span class="badge bg-warning ms-1">{{ $diprosess->count() }}</span>
            @endif
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" id="pengiriman-tab" data-bs-toggle="tab" data-bs-target="#pengiriman" type="button">
            Pengiriman
            @if($pengirimans->count())
                <span class="badge bg-info ms-1">{{ $pengirimans->count() }}</span>
            @endif
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" id="selesai-tab" data-bs-toggle="tab" data-bs-target="#selesai" type="button">
            Selesai
            @if($selesaiPengirimanCount)
                <span class="badge bg-success ms-1">{{ $selesaiPengirimanCount }}</span>
            @endif
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" id="salah-tab" data-bs-toggle="tab" data-bs-target="#salah" type="button">
            Dibatalkan/Bermasalah
            @if($salahs->count())
                <span class="badge bg-danger ms-1">{{ $salahs->count() }}</span>
            @endif
        </button>
    </li>
</ul>


    <div class="tab-content mt-4" id="pesananTabContent">
        {{-- Belum Bayar --}}
        <div class="tab-pane fade show active" id="belum-bayar">
            @forelse ($belumBayars as $belumBayar)
                @include('fe.pesanan.belumbayar-card', ['belumBayar' => $belumBayar, 'showBayar' => true])
            @empty
                <p>Tidak ada pesanan.</p>
            @endforelse
        </div>

        {{-- Sedang Diproses --}}
        <div class="tab-pane fade" id="diproses">
            @forelse ($diprosess as $diproses)
                @include('fe.pesanan.diproses-card', ['diproses' => $diproses])
            @empty
                <p>Tidak ada pesanan.</p>
            @endforelse
        </div>

        {{-- Pengiriman --}}
        <div class="tab-pane fade" id="pengiriman">
            @forelse ($pengirimans as $pengiriman)
                @include('fe.pesanan.pengiriman-card', ['pengiriman' => $pengiriman])
            @empty
                <p>Tidak ada pesanan.</p>
            @endforelse
        </div>

        {{-- Selesai --}}
        <div class="tab-pane fade" id="selesai">
            @forelse ($selesais as $selesai)
                @include('fe.pesanan.selesai-card', ['selesai' => $selesai])
            @empty
                <p>Tidak ada pesanan.</p>
            @endforelse
        </div>

        {{-- Salah --}}
        <div class="tab-pane fade show" id="salah">
            @forelse ($salahs as $salah)
                @include('fe.pesanan.salah-card', ['salah' => $salah])
            @empty
                <p>Tidak ada pesanan.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection



