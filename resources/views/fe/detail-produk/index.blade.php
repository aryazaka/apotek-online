@extends('fe.partial.master')

@section('navbar')
@include('fe.partial.navbar')
@endsection

@section('footer')
@include('fe.partial.footer')
@endsection

@section('content')


<link rel="stylesheet" href="{{ asset('fe/css/detail-produk.css') }}" type="text/css">

<section class="product-page">
    <div class="container">
        <div class="product-control mb-4">
            <a href="{{ route('produk.index') }}" class="btn-kembali"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="product-slider owl-carousel">
                    @if ($produk->foto1)
                    <div class="product-img">
                        <figure>
                            <img src="{{ asset('storage/' . $produk->foto1) }}" alt="{{ $produk->nama_obat }}" class="img-fluid">
                        </figure>
                    </div>
                    @endif

                    @if ($produk->foto2)
                    <div class="product-img">
                        <figure>
                            <img src="{{ asset('storage/' . $produk->foto2) }}" alt="{{ $produk->nama_obat }}" class="img-fluid">
                        </figure>
                    </div>
                    @endif

                    @if ($produk->foto3)
                    <div class="product-img">
                        <figure>
                            <img src="{{ asset('storage/' . $produk->foto3) }}" alt="{{ $produk->nama_obat }}" class="img-fluid">
                        </figure>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-6">
                <div class="product-content">
                    <h2>{{ $produk->nama_obat }}</h2>
                    <div class="pc-meta">
                        <h5>Rp{{ number_format($produk->harga_jual, 0, ',', '.') }}</h5>
                    </div>
                    <h5 style="margin-bottom:30px">{{ $produk->deskripsi_obat ?? 'Tidak ada deskripsi tersedia.' }}</h5>
                    <ul class="tags">
                        <li><span>Kategori:</span> {{ $produk->jenisObat->jenis }}</li>
                        <li><span>Stok:</span> {{ $produk->stok }}</li>
                    </ul>
    
                    <form action="{{ route('keranjang.tambah') }}" method="POST">
    @csrf
    <input type="hidden" name="id_obat" value="{{ $produk->id }}">
    <input type="hidden" name="harga" value="{{ $produk->harga_jual }}">
    <input type="hidden" name="id_pelanggan" value="{{ Auth::guard('pelanggan')->user()->id ?? '' }}">

    <div class="product-quantity mb-3">
        <div class="pro-qty" data-product-id="{{$produk->id}}" data-stok="{{ $produk->stok }}" >
            <input id="jumlah-beli" data-stok="{{ $produk->stok }}" type="number" name="jumlah_order" value="1" min="1" max="{{ $produk->stok }}">
        </div>
        @error('jumlah_order')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <button type="submit" class="btn-keranjang mt-3">
        <i class="fas fa-cart-plus me-2"></i> Tambah ke Keranjang
    </button>
</form>



                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Product Section -->
<section class="related-product spad">
    <div class="container">
        <div class="section-title text-center mb-4">
            <h2>Produk Terkait</h2>
        </div>
        <div class="row">
            @forelse ($relatedProducts as $item)
            <div class="col-lg-3 col-sm-6 mb-4">
                <a href="{{ route('produk.show', $item->id) }}">
                    <div class="single-product-item">
                        <figure>

                            <img src="{{ asset('storage/' . $item->foto1) }}" alt="{{ $item->nama_obat }}" class="img-fluid">

                            @if ($item->stok <= 5)
                                <div class="p-status sale">Terbatas
                    </div>
                </a>
                @else
                <div class="p-status">Tersedia</div>
                @endif
                </figure>
                <div class="product-text text-center">
                    <h6>{{ $item->nama_obat }}</h6>
                    <p>Rp{{ number_format($item->harga_jual, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        @empty
        <p class="text-center">Tidak ada produk terkait.</p>
        @endforelse
    </div>
    </div>
</section>

<script>
    const inputJumlah = document.getElementById('jumlah-beli');
    const maxStok = parseInt(inputJumlah.dataset.stok);
    const minStok = 1;

    // Cek input manual
    inputJumlah.addEventListener('input', function () {
        let val = parseInt(this.value);
        if (val > maxStok) this.value = maxStok;
        if (val < minStok || isNaN(val)) this.value = minStok;
    });

 
</script>


@endsection