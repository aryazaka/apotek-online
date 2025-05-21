<!-- Card -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>


<div class="card mb-4 shadow-sm border">
    <!-- Card Header with nice styling -->
    <div class="card-header bg-white">
        <h5 class="mb-0 fw-bold text-primary">Order ID: {{ $belumBayar->kode_transaksi }}</h5>
    </div>

    <!-- Card Body -->
    <div class="card-body">
        <div class="row">
            <!-- Order Info -->
            <div class="col-md-8 mb-3 mb-md-0">
                <div class="d-flex align-items-center mb-2">
                    <span class="badge rounded-pill me-2 
                            {{ $belumBayar->status_order == 'Menunggu Konfirmasi' ? 'bg-warning' : 
                            ($belumBayar->status_order == 'Diproses' ? 'bg-info' : 
                            ($belumBayar->status_order == 'Selesai' ? 'bg-success' : 'bg-secondary')) }}">
                        &nbsp;
                    </span>
                    <p class="mb-0 fw-medium">Status:
                        <span class="
                                {{ $belumBayar->status_order == 'Menunggu Konfirmasi' ? 'text-warning' : 
                                ($belumBayar->status_order == 'Diproses' ? 'text-info' : 
                                ($belumBayar->status_order == 'Selesai' ? 'text-success' : 'text-secondary')) }}">
                            {{ $belumBayar->status_order }}
                        </span>
                    </p>
                </div>

                <div class="mb-2">
                    <small class="text-muted">Alamat Tujuan:</small>
                    <div class="fw-semibold">
                        @php
                        $pelanggan = $belumBayar->pelanggan;
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


                @if($belumBayar->keterangan_status)
                <p class="small text-muted mb-2 fst-italic">{{ $belumBayar->keterangan_status }}</p>
                @endif

                <p class="fs-5 fw-bold text-success mt-3">
                    Rp{{ number_format($belumBayar->total_bayar, 0, ',', '.') }}
                </p>

                <p class="small text-muted mb-1">
                    Tanggal Pembelian: {{ \Carbon\Carbon::parse($belumBayar->tgl_penjualan)->format('d M Y') }}
                </p>

                <!-- Item Count -->
                <p class="small text-muted">
                    {{ count($belumBayar->detailPenjualan) }} item(s)
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="col-md-4 d-flex flex-column gap-2">
                <button class="btn btn-outline-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#modalDetail{{ $belumBayar->id }}">
                    <i class="fa-solid fa-circle-info me-1 small"></i>
                    Detail
                </button>

                @isset($showBayar)
                <button type="button" class="btn btn-success w-100" onclick="bayarSekarang('{{ $belumBayar->snap_token }}')">
                    <i class="fa-solid fa-credit-card me-1 small"></i>
                    Bayar Sekarang
                </button>
                <form action="{{ route('pesanan.batalkan', $belumBayar->id) }}" method="POST" id="cancelOrderForm" class="w-100">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="fa-solid fa-xmark me-1 small"></i>
                        Batal Bayar
                    </button>
                </form>

                @endisset
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="modalDetail{{ $belumBayar->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $belumBayar->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalLabel{{ $belumBayar->id }}">
                    <i class="fa-solid fa-file-invoice me-1 text-primary"></i>
                    Detail Pesanan - {{ $belumBayar->kode_transaksi }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Order Status Section -->
                <div class="bg-light p-3 mb-4 rounded">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-1 text-muted small">Status</h6>
                                    <p class="card-text fw-semibold 
                                            {{ $belumBayar->status_order == 'Belum Bayar' ? 'text-warning' : 
                                            ($belumBayar->status_order == 'Diproses' ? 'text-info' : 
                                            ($belumBayar->status_order == 'Selesai' ? 'text-success' : 'text-secondary')) }}">
                                        {{ $belumBayar->status_order }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-1 text-muted small">Total Pembayaran</h6>
                                    <p class="card-text fw-semibold text-success">Rp{{ number_format($belumBayar->total_bayar, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>

                        @if($belumBayar->keterangan_status)
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-1 text-muted small">Keterangan</h6>
                                    <p class="card-text">{{ $belumBayar->keterangan_status }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Product List Section -->
                <!-- List Produk -->
<div class="mt-3">
    <h6 class="fw-bold">Daftar Produk:</h6>
    <ul class="list-group list-group-flush">
        @foreach($belumBayar->detailPenjualan as $detail)
@php
    $produk = $detail->obat; // Pastikan relasi 'obat' tersedia
@endphp
<div class="d-flex mb-3 border rounded p-2 bg-white shadow-sm">
    <img src="{{ $produk->foto1 ? asset('storage/' . $produk->foto1) : asset('images/default.png') }}"
        alt="{{ $produk->nama_obat }}"
        class="me-3 rounded"
        style="width: 80px; height: 80px; object-fit: cover;">

    <div class="flex-grow-1">
        <h6 class="mb-1">{{ $produk->nama_obat }}</h6>
        <p class="mb-0 small text-muted">Jumlah: {{ $detail->jumlah_beli }} x Rp{{ number_format($detail->harga_beli, 0, ',', '.') }}</p>
        <p class="mb-0 fw-semibold text-success">Subtotal: Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</p>
    </div>
</div>
@endforeach

    </ul>
</div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>

                @isset($showBayar)
                <button type="button" class="btn btn-success w-100" onclick="bayarSekarang('{{ $belumBayar->snap_token }}')">
                    <i class="fa-solid fa-credit-card me-1 small"></i>
                    Bayar Sekarang
                </button>
                <form action="{{ route('pesanan.batalkan', $belumBayar->id) }}" method="POST" id="cancelOrderFormDetail" class="w-100">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="fa-solid fa-xmark me-1 small"></i>
                        Batal Bayar
                    </button>
                </form>

                @endisset
            </div>
        </div>
    </div>
</div>

<!-- <script>
        function bayarSekarang(snapToken) {
            if (!snapToken) {
                alert('Token pembayaran tidak tersedia.');
                return;
            }
            snap.pay(snapToken, {
                onSuccess: function(result) {
                    window.location.href = '{{ route("pesanan.update-status", $belumBayar->id) }}';
                },
                onPending: function(result) {
                    alert('Menunggu pembayaran...');
                },
                onError: function(result) {
                    alert('Pembayaran gagal.');
                }
            });
        }
    </script> -->

<script>
    function bayarSekarang(snapToken) {
        if (!snapToken) {
            Swal.fire({
                title: 'Gagal!',
                text: 'Token pembayaran tidak tersedia.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        snap.pay(snapToken, {
            onSuccess: function(result) {
                // Kirim data ke backend untuk memperbarui status pesanan
                fetch("{{ route('pesanan.update-status', $belumBayar->id) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            order_id: result.order_id,
                            payment_type: result.payment_type,
                            transaction_status: result.transaction_status,
                            va_numbers: result.va_numbers ?? [],
                            transaction_id: result.transaction_id,
                            gross_amount: result.gross_amount
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Periksa jika update berhasil
                        if (data.success) {
                            // Tampilkan SweetAlert
                            Swal.fire({
                                title: 'Berhasil!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                // Setelah klik OK, reload halaman
                                window.location.reload();
                            });
                        } else {
                            // Jika update gagal
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Gagal memperbarui status pesanan.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(error => {
                        // Jika terjadi error saat mengirim data ke server
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat mengirim data ke server.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
            },
            onPending: function(result) {
                Swal.fire('Menunggu Pembayaran', 'Pembayaran sedang diproses.', 'info');
            },
            onError: function(result) {
                // Kirim status bermasalah ke server
                fetch("{{ route('pesanan.update-status', $belumBayar->id) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            order_id: result.order_id,
                            payment_type: result.payment_type,
                            transaction_status: result.transaction_status ?? 'error',
                            va_numbers: result.va_numbers ?? [],
                            transaction_id: result.transaction_id,
                            gross_amount: result.gross_amount
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire('Error', 'Transaksi gagal atau bermasalah.', 'error');
                    })
                    .catch(error => {
                        Swal.fire('Error', 'Gagal memproses transaksi bermasalah.', 'error');
                    });
            }
        });
    }
</script>

<!-- batal bayar -->
<script>
    document.getElementById('cancelOrderForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah form submit otomatis

        // Tampilkan konfirmasi SweetAlert2
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Pesanan ini akan dibatalkan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Batalkan!',
            cancelButtonText: 'Tidak, Kembali',
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user mengonfirmasi, kirimkan form
                this.submit();
            }
        });
    });

    document.getElementById('cancelOrderFormDetail').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah form submit otomatis

        // Tampilkan konfirmasi SweetAlert2
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Pesanan ini akan dibatalkan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Batalkan!',
            cancelButtonText: 'Tidak, Kembali',
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user mengonfirmasi, kirimkan form
                this.submit();
            }
        });
    });
</script>


@if(session()->has('successPembayaran'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        title: 'Berhasil!',
        text: "{{ session('successPembayaran') }}",
        icon: 'success',
        confirmButtonText: 'OK'
    }).then(() => {
        window.location.reload();
    });
</script>
@endif