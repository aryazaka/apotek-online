@extends('fe.partial.master')

@section('navbar')
@include('fe.partial.navbar')
@endsection

@section('footer')
@include('fe.partial.footer')
@endsection

@section('content')

<div class="container py-4">
    <!-- Search and Filter -->
    <div class="row mb-4">
        <div class="col-md-4 mb-2">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari produk...">
        </div>
        <div class="col-md-8 d-flex flex-wrap gap-2">
            <button class="btn btn-outline-dark filter-btn active" data-kategori="all">Semua</button>
            @foreach ($categories as $jenis)
                <button class="btn btn-outline-dark filter-btn" data-kategori="{{ $jenis->id }}">{{ $jenis->jenis }}</button>
            @endforeach
        </div>
    </div>

    <!-- Katalog Produk -->
    <div class="row" id="produkContainer">
        @foreach ($products as $item)
        <div class="col-md-3 mb-4 produk-item" data-nama="{{ strtolower($item->nama_obat) }}" data-kategori="{{ $item->id_jenis_obat }}">
            <div class="card h-100 shadow-sm border-0">
                <a href="{{ route('produk.show', ['id' => $item->id]) }}" class="text-decoration-none text-dark">
                    <img src="{{ asset('storage/' . $item->foto1) }}" class="card-img-top" alt="{{ $item->nama_obat }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h6 class="card-title">{{ $item->nama_obat }}</h6>
                        <p class="card-text text-muted">Stok: {{ $item->stok }}</p>
                        <p class="card-text fw-semibold text-success">Rp{{ number_format($item->harga_jual, 0, ',', '.') }}</p>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
    <nav>
         <ul class="pagination justify-content-center" id="paginationContainer"></ul>
    </nav>
</div>

<style>
    .filter-btn.active {
        background-color: #343a40;
        color: #fff !important;
    }

    .card:hover {
        transform: translateY(-5px);
        transition: 0.2s ease;
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const filterButtons = document.querySelectorAll('.filter-btn');
        const produkItems = Array.from(document.querySelectorAll('.produk-item'));
        const paginationContainer = document.getElementById('paginationContainer');

        let currentPage = 1;
        const itemsPerPage = 8;

        function filterProduk() {
            const keyword = searchInput.value.toLowerCase();
            const activeKategori = document.querySelector('.filter-btn.active').dataset.kategori;

            return produkItems.filter(item => {
                const nama = item.dataset.nama;
                const kategori = item.dataset.kategori;
                return nama.includes(keyword) && (activeKategori === 'all' || kategori === activeKategori);
            });
        }

        function renderProdukPage(filteredItems) {
            // Hide all
            produkItems.forEach(item => item.style.display = 'none');

            const startIndex = (currentPage - 1) * itemsPerPage;
            const paginatedItems = filteredItems.slice(startIndex, startIndex + itemsPerPage);

            paginatedItems.forEach(item => item.style.display = 'block');
        }

        function renderPagination(filteredItems) {
            const totalPages = Math.ceil(filteredItems.length / itemsPerPage);
            paginationContainer.innerHTML = '';

            if (totalPages <= 1) return;

            for (let i = 1; i <= totalPages; i++) {
                const li = document.createElement('li');
                li.className = `page-item ${i === currentPage ? 'active' : ''}`;
                li.innerHTML = `<button class="page-link">${i}</button>`;
                li.addEventListener('click', () => {
                    currentPage = i;
                    renderProdukPage(filteredItems);
                    renderPagination(filteredItems);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
                paginationContainer.appendChild(li);
            }
        }

        function applyFilterAndPaginate() {
            currentPage = 1; // Reset ke halaman pertama setiap filter berubah
            const filtered = filterProduk();
            renderProdukPage(filtered);
            renderPagination(filtered);
        }

        searchInput.addEventListener('input', applyFilterAndPaginate);

        filterButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                filterButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                applyFilterAndPaginate();
            });
        });

        // Inisialisasi awal
        applyFilterAndPaginate();
    });
</script>

@endsection
