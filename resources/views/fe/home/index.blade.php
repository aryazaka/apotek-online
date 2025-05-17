@extends('fe/partial/master')

@section('navbar')
@include('fe/partial/navbar')
@endsection

@section('slider')
@include('fe/partial/slider')
@endsection

@section('footer')
@include('fe/partial/footer')
@endsection

@section('content')
<section class="latest-products spad">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>Produk Terbaru</h2>
        </div>

        @foreach ($jenisList as $kategori)
            <h4 class="mb-4">{{ $kategori->jenis }}</h4>
            <div class="row justify-content-center mb-5">
                @foreach ($kategori->obats as $obat)
                    <div class="col-md-4 col-sm-6 mb-4">
                        <a href="{{ route('produk.show', ['id' => $obat->id]) }}" 
                           class="card product-card h-100 border-0 shadow-sm text-decoration-none text-dark">
                            <img src="{{ asset('storage/' . $obat->foto1) }}" 
                                 class="card-img-top" 
                                 alt="{{ $obat->nama_obat }}">
                            <div class="card-body text-center">
                                <h6 class="card-title">{{ $obat->nama_obat }}</h6>
                                <p class="card-text text-muted">Stok: {{ $obat->stok }}</p>
                                <p class="card-text fw-semibold text-success">Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</section>

<style>
    .product-card {
        transition: transform 0.3s, box-shadow 0.3s;
        display: block;
        border-radius: 10px;
    }

    .product-card:hover {
        transform: scale(1.05);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        z-index: 10;
    }

    .product-card img {
        object-fit: cover;
        height: 200px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .card-title {
        font-size: 1rem;
        font-weight: bold;
    }
</style>

@endsection
