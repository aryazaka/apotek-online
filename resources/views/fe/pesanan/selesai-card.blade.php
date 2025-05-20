<div class="card mb-4 shadow-sm border">
    <div class="card-header bg-white">
        <h5 class="fw-bold text-primary mb-2">Order ID: {{ $selesai->kode_transaksi }}</h5>
        <h6 class="mb-0 fw-bold text-secondary">
            Tanggal Pembelian: {{ \Carbon\Carbon::parse($selesai->tgl_penjualan)->format('d M Y') }}
        </h6>
    </div>

@foreach($selesai->detailPenjualan as $detail)
<div class="row g-0 border-top align-items-center">
    <!-- Kolom Foto Produk -->
    <div class="col-md-3">
        <img src="{{ $detail->obat->foto1 ? asset('storage/' . $detail->obat->foto1) : asset('img/default.png') }}"
            class="img-fluid rounded-start object-fit-cover w-100 h-100" alt="{{ $detail->obat->nama_obat }}">
    </div>

    <!-- Kolom Informasi Produk -->
    <div class="col-md-6">
        <div class="card-body">
            <h5 class="card-title fw-bold text-primary">
                {{ $detail->obat->nama_obat }}
            </h5>

                @if ($selesai->status_order === 'Dalam Pengiriman')
                <div class="d-flex align-items-center mb-2">
                        <span class="badge rounded-pill bg-info me-2">&nbsp;</span>
                    <span class="text-info">{{ $selesai->pengiriman->status_kirim }}</span>
                    </div>
                @elseif($selesai->status_order === 'Selesai')
                <div class="d-flex align-items-center mb-2">
                        <span class="badge rounded-pill bg-success me-2">&nbsp;</span>
                    <span class="text-success">{{ $selesai->status_order }}</span>
                    </div>
                @endif
                
            </p>
            
             {{-- Alamat Pengiriman --}}
                    <div class="mb-2">
                        <small class="text-muted">Alamat Tujuan:</small>
                        <div class="fw-semibold">
                            @php
                            $pelanggan = $selesai->pelanggan;
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

            @if($selesai->status_order === 'Selesai')
            <p class="small text-muted fst-italic">
                {{ $selesai->keterangan_status }}
            </p>
            @elseif($selesai->status_order === 'Dalam Pengiriman')
            <p class="small text-muted fst-italic">
                {{ $selesai->pengiriman->keterangan }}
            </p>
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

    <!-- Kolom Bukti Foto Pengiriman -->
    @if($loop->first && $selesai->pengiriman->bukti_foto && $selesai->status_order === 'Dalam Pengiriman')
<div class="col-md-3 text-center p-2">
    <img src="{{ asset('storage/' . $selesai->pengiriman->bukti_foto) }}"
        alt="Bukti Pengiriman"
        class="img-thumbnail"
        style="max-width: 100%; max-height: 150px; object-fit: cover; cursor: pointer;"
        data-bs-toggle="modal"
        data-bs-target="#buktiModal{{ $selesai->id }}">
    <p class="small text-muted mt-1">Klik untuk lihat bukti</p>
</div>
@endif
</div>


     {{-- Modal Produk --}}
    <div class="modal fade" id="modalProduk{{ $detail->id }}" tabindex="-1" aria-labelledby="modalProdukLabel{{ $detail->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProdukLabel{{ $detail->id }}">
                        Detail Produk: {{ $detail->obat->nama_obat }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nama Obat:</strong> {{ $detail->obat->nama_obat }}</p>
                    <p><strong>Deskripsi:</strong> {{ $detail->obat->deskripsi_obat ?? 'Tidak ada deskripsi' }}</p>
                     <div class="mb-3">
                                <p><strong>Informasi Kurir:</strong></p>
                                <div class="fw-semibold">
                                    Nama Kurir: {{ $selesai->pengiriman->nama_kurir ?? '-' }} <br>
                                    No Telepon: {{ $selesai->pengiriman->telpon_kurir ?? '-' }}
                                </div>
                            </div>
                    <p><strong>Harga Satuan:</strong> Rp{{ number_format($detail->harga_beli, 0, ',', '.') }}</p>
                    <p><strong>Jumlah Beli:</strong> {{ $detail->jumlah_beli }}</p>
                    <p><strong>Total Harga:</strong> Rp{{ number_format($detail->jumlah_beli * $detail->harga_beli, 0, ',', '.') }}</p>
                    {{-- Bisa tambah info lain sesuai kebutuhan --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
      
    </div>
    @endforeach

    @if($selesai->pengiriman->bukti_foto)
<div class="modal fade" id="buktiModal{{ $selesai->id }}" tabindex="-1" aria-labelledby="buktiModalLabel{{ $selesai->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body p-0">
                <img src="{{ asset('storage/' . $selesai->pengiriman->bukti_foto) }}"
                    alt="Bukti Pengiriman"
                    class="img-fluid w-100">
            </div>
        </div>
    </div>
</div>
@endif

    {{-- Tombol Ubah Status Selesai --}}
    @if($selesai->status_order === 'Dalam Pengiriman')
    <div class="card-footer text-end bg-white">
        <form id="formSelesai{{ $selesai->id }}" action="{{ route('pesanan.selesai', $selesai->id) }}" method="POST" class="d-inline">
            @csrf
            @method('PATCH')
            <button type="button" class="btn btn-success btn-sm" onclick="konfirmasiSelesai('{{ $selesai->id }}')">
                Tandai Selesai
            </button>
        </form>
    </div>
@endif

</div>

<script>
    function konfirmasiSelesai(id) {
        Swal.fire({
            title: 'Tandai pesanan sebagai selesai?',
            text: "Pastikan pesanan sudah diterima dengan baik.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Selesai',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formSelesai' + id).submit();
            }
        })
    }
</script>


