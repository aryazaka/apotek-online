<div class="card mb-4 shadow-sm border">
    <div class="card-header bg-white">
        <h5 class="fw-bold text-danger mb-2">Order ID: {{ $salah->kode_transaksi }}</h5>
        <h6 class="mb-0 fw-bold text-secondary">
            Tanggal Pembelian: {{ \Carbon\Carbon::parse($salah->tgl_penjualan)->format('d M Y') }}
        </h6>
        @if($salah->keterangan_status)
            <p class="mt-1 mb-0 text-muted"><i>Keterangan: {{ $salah->keterangan_status }}</i></p>
        @endif
    </div>

    @foreach($salah->detailPenjualan as $detail)
    <div class="row g-0 border-top align-items-center">
        <!-- Kolom Foto Produk -->
        <div class="col-md-3">
            <img src="{{ $detail->obat->foto1 ? asset('storage/' . $detail->obat->foto1) : asset('img/default.png') }}"
                class="img-fluid rounded-start object-fit-cover w-100 h-100" alt="{{ $detail->obat->nama_obat }}">
        </div>

        <!-- Kolom Informasi Produk -->
        <div class="col-md-9">
            <div class="card-body">
                <h5 class="card-title fw-bold text-primary">
                    {{ $detail->obat->nama_obat }}
                </h5>

                
                    @if($salah->status_order === 'Bermasalah')
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge rounded-pill bg-warning me-2">&nbsp;</span>
                        <p class="mb-1">Status:
                        <span class="text-warning">{{ $salah->status_order }}</span>
                        </p>
                        </div>
                    @elseif($salah->status_order === 'Dibatalkan Pembeli')
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge rounded-pill bg-danger me-2">&nbsp;</span>
                        <p class="mb-1">Status:
                        <span class="text-danger">{{ $salah->status_order }}</span>
                        </p>
                        </div>
                    @elseif($salah->status_order === 'Dibatalkan Penjual')
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge rounded-pill bg-danger me-2">&nbsp;</span>
                        <p class="mb-1">Status:
                        <span class="text-danger">{{ $salah->status_order }}</span>
                        </p>
                        </div>
                    @endif
                

                {{-- Alamat Pengiriman --}}
                    <div class="mb-2">
                        <small class="text-muted">Alamat Tujuan:</small>
                        <div class="fw-semibold">
                            @php
                            $pelanggan = $salah->pelanggan;
                            $alamatLengkap = '-';
                            if ($pelanggan) {
                            for ($i = 1; $i <= 3; $i++) {
                                $alamat=$pelanggan->{"alamat$i"};
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

                <p class="small text-muted mb-0">Jumlah: {{ $detail->jumlah_beli }} item</p>
                <p class="fw-bold text-danger mb-2">
                    Total Harga: Rp{{ number_format($detail->jumlah_beli * $detail->harga_beli, 0, ',', '.') }}
                </p>

                <button class="btn btn-outline-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#modalProdukSalah{{ $detail->id }}">
                    <i class="fa-solid fa-circle-info me-1 small"></i>
                    Detail
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Detail Produk -->
    <div class="modal fade" id="modalProdukSalah{{ $detail->id }}" tabindex="-1" aria-labelledby="modalProdukSalahLabel{{ $detail->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProdukSalahLabel{{ $detail->id }}">
                        Detail Produk: {{ $detail->obat->nama_obat }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nama Obat:</strong> {{ $detail->obat->nama_obat }}</p>
                    <p><strong>Deskripsi:</strong> {{ $detail->obat->deskripsi_obat ?? 'Tidak ada deskripsi' }}</p>
                    <p><strong>Harga Satuan:</strong> Rp{{ number_format($detail->harga_beli, 0, ',', '.') }}</p>
                    <p><strong>Jumlah Beli:</strong> {{ $detail->jumlah_beli }}</p>
                    <p><strong>Total Harga:</strong> Rp{{ number_format($detail->jumlah_beli * $detail->harga_beli, 0, ',', '.') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

