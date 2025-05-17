@if($diproses->status_order == 'Diproses' ||
($diproses->status_order == 'Menunggu Konfirmasi' && $diproses->keterangan_status == 'Tunggu Konfirmasi dari Admin'))

<div class="card mb-4 shadow-sm border">
    <div class="card-header bg-white">
        <h5 class="fw-bold text-primary mb-2">Order ID: {{ $diproses->kode_transaksi }}</h5>
        <h6 class="mb-0 fw-bold text-secondary">
            Tanggal Pembelian: {{ \Carbon\Carbon::parse($diproses->tgl_penjualan)->format('d M Y') }}
        </h6>
    </div>



    @foreach($diproses->detailPenjualan as $detail)

    <div class="row g-0">
        <!-- Foto Produk -->
        <div class="col-md-4">
            <img src="{{ $detail->obat->foto1 ? asset('storage/' . $detail->obat->foto1) : asset('img/default.png') }}"
                class="img-fluid rounded-start h-100 object-fit-cover" alt="{{ $detail->obat->nama_obat }}">
        </div>

        <!-- Informasi Produk -->
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title fw-bold text-primary">
                    {{ $detail->obat->nama_obat }}
                </h5>

                <div class="d-flex align-items-center mb-2">
                    <span class="badge rounded-pill me-2 
                                    {{ $diproses->status_order == 'Menunggu Konfirmasi' ? 'bg-warning' : 'bg-info' }}">
                        &nbsp;
                    </span>
                    <p class="mb-0 fw-medium">Status:
                        <span class="{{ $diproses->status_order == 'Menunggu Konfirmasi' ? 'text-warning' : 'text-info' }}">
                            {{ $diproses->status_order }}
                        </span>
                    </p>
                </div>

                @if($diproses->keterangan_status)
                <p class="small text-muted fst-italic">{{ $diproses->keterangan_status }}</p>
                @endif

                <p class="small text-muted mb-0">Jumlah: {{ $detail->jumlah_beli }} item</p>
                <p class="fw-bold text-success mb-2">
                    Total Harga: Rp{{ number_format($detail->jumlah_beli * $detail->harga_beli, 0, ',', '.') }}
                </p>

                <button class="btn btn-outline-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#modalProduk{{ $detail->id }}">
                    <i class="fa-solid fa-circle-info me-1 small"></i>
                    Detail
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Produk -->
<div class="modal fade" id="modalProduk{{ $detail->id }}" tabindex="-1" aria-labelledby="modalProdukLabel{{ $detail->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    Detail Produk - {{ $detail->obat->nama_obat }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <img src="{{ $detail->obat->foto1 ? asset('storage/' . $detail->obat->foto1) : asset('img/default.png') }}"
                            class="img-fluid rounded" alt="{{ $detail->obat->nama_obat }}">
                    </div>
                    <div class="col-md-8">
                        <h5 class="fw-bold">{{ $detail->obat->nama_obat }}</h5>
                        <p class="text-muted small">
                            {{ $detail->obat->deskripsi_obat ? Str::limit($detail->obat->deskripsi_obat, 200) : 'Tidak ada deskripsi.' }}
                        </p>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                Harga Satuan: <span class="fw-semibold">Rp{{ number_format($detail->harga_beli, 0, ',', '.') }}</span>
                            </li>
                            <li class="list-group-item">
                                Jumlah: <span class="fw-semibold">{{ $detail->jumlah_beli }} item</span>
                            </li>
                            <li class="list-group-item">
                                Total Harga: <span class="fw-bold text-success">Rp{{ number_format($detail->jumlah_beli * $detail->harga_beli, 0, ',', '.') }}</span>
                            </li>
                            <li class="list-group-item">
                                Status Order:
                                <span class="{{ $diproses->status_order == 'Menunggu Konfirmasi' ? 'text-warning' : 'text-info' }}">
                                    {{ $diproses->status_order }}
                                </span>
                            </li>
                            @if($diproses->keterangan_status)
                            <li class="list-group-item text-muted fst-italic">
                                {{ $diproses->keterangan_status }}
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endif