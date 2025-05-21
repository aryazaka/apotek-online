<div class="card mb-4 shadow-sm border">
    <div class="card-header bg-white">
        <h5 class="fw-bold text-primary mb-2">Order ID: {{ $pengiriman->kode_transaksi }}</h5>
        <h6 class="mb-0 fw-bold text-secondary">
            Tanggal Pengiriman: {{ \Carbon\Carbon::parse($pengiriman->pengiriman->tanggal_kirim)->format('d M Y') }}
        </h6>
    </div>

    <div class="card-body">
        @foreach($pengiriman->detailPenjualan as $detail)
        <div class="row g-3 mb-4 pb-3 border-bottom">
            <!-- Foto Produk -->
            <div class="col-md-4">
                <img src="{{ $detail->obat->foto1 ? asset('storage/' . $detail->obat->foto1) : asset('img/default.png') }}"
                    class="img-fluid rounded w-100" alt="{{ $detail->obat->nama_obat }}">
            </div>

            <!-- Info Produk -->
            <div class="col-md-8 d-flex flex-column justify-content-between">
                <div>
                    <h5 class="fw-bold text-primary">{{ $detail->obat->nama_obat }}</h5>
                    <p class="mb-1 text-muted small">Jumlah: {{ $detail->jumlah_beli }} item</p>
                    <p class="fw-bold text-success mb-1">
                        Total Harga: Rp{{ number_format($detail->jumlah_beli * $detail->harga_beli, 0, ',', '.') }}
                    </p>
                    <p class="mb-1 fw-medium">
                        Status: <span class="text-info">{{ $pengiriman->pengiriman->status_kirim }}</span>
                    </p>

                    {{-- Alamat Tujuan --}}
                    <div class="mb-2">
                        <small class="text-muted">Alamat Tujuan:</small>
                        <div class="fw-semibold">
                            @php
                                $pelanggan = $pengiriman->pelanggan;
                                $alamatLengkap = '-';
                                if ($pelanggan) {
                                    for ($i = 1; $i <= 3; $i++) {
                                        $alamat = $pelanggan->{"alamat$i"};
                                        if ($alamat) {
                                            $alamatLengkap = $alamat . ', ' .
                                            $pelanggan->{"kota$i"} . ', ' .
                                            $pelanggan->{"propinsi$i"} . ', ' .
                                            $pelanggan->{"kodepos$i"};
                                            break;
                                        }
                                    }
                                }
                            @endphp
                            {{ $alamatLengkap }}
                        </div>
                    </div>

                    @if($pengiriman->pengiriman->keterangan)
                    <p class="small text-muted fst-italic mb-0">
                        {{ $pengiriman->pengiriman->keterangan }}
                    </p>
                    @endif
                </div>

                <div class="mt-2">
                    <button class="btn btn-outline-primary btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#modalPengiriman{{ $detail->id }}">
                        <i class="fa-solid fa-circle-info me-1 small"></i> Detail
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Detail Produk -->
        <div class="modal fade" id="modalPengiriman{{ $detail->id }}" tabindex="-1"
            aria-labelledby="modalLabel{{ $detail->id }}" aria-hidden="true">
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

                                <div class="mb-2">
                                    <small class="text-muted">Informasi Kurir:</small>
                                    <div class="fw-semibold">
                                        Nama Kurir: {{ $pengiriman->pengiriman->nama_kurir ?? '-' }}<br>
                                        No Telepon: {{ $pengiriman->pengiriman->telpon_kurir ?? '-' }}
                                    </div>
                                </div>

                                <ul class="list-group list-group-flush mt-3">
                                    <li class="list-group-item">
                                        Harga Satuan:
                                        <span class="fw-semibold">Rp{{ number_format($detail->harga_beli, 0, ',', '.') }}</span>
                                    </li>
                                    <li class="list-group-item">
                                        Jumlah:
                                        <span class="fw-semibold">{{ $detail->jumlah_beli }} item</span>
                                    </li>
                                    <li class="list-group-item">
                                        Total Harga:
                                        <span class="fw-bold text-success">Rp{{ number_format($detail->jumlah_beli * $detail->harga_beli, 0, ',', '.') }}</span>
                                    </li>
                                    <li class="list-group-item">
                                        Status:
                                        <span class="text-info">{{ $pengiriman->pengiriman->status_kirim }}</span>
                                    </li>
                                    @if($pengiriman->pengiriman->keterangan)
                                    <li class="list-group-item text-muted fst-italic">
                                        {{ $pengiriman->pengiriman->keterangan }}
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
