@extends('fe.partial.master')

@section('navbar')
@include('fe.partial.navbar')
@endsection

@section('footer')
@include('fe.partial.footer')
@endsection

@section('content')

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<!-- Page Add Section -->
<section class="page-add cart-page-add py-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Keranjang Saya</h2>
            <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </div>
</section>

<!-- Cart Page Section -->
<div class="cart-page pb-5">
    <div class="container">
        <form action="{{ route('keranjang.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="thead-light">
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($keranjangs as $item)
                        <tr>
                            <td><input type="checkbox" name="checkout_ids[]" value="{{ $item->id }}" class="item-checkbox"
                                    data-obat-keras="{{ strtolower($item->obat->jenisObat->jenis ?? '') === 'obat keras' ? '1' : '0' }}"></td>
                            <td class="text-start align-middle">
                                <div class="d-flex align-items-center" style="gap: 1rem; min-width: 240px;">
                                    <div style="width: 80px; height: 80px; flex-shrink: 0;">
                                        <img src="{{ asset('storage/' . $item->obat->foto1) }}"
                                            alt="{{ $item->obat->nama_obat }}"
                                            class="rounded shadow-sm"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div style="flex: 1;">
                                        <div class="fw-semibold" style="font-size: 1.1rem;">{{ $item->obat->nama_obat }}</div>
                                        <div class="text-muted small">Kategori: {{ $item->obat->jenisObat->jenis ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>


                            <td>Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>
                                <input
                                    type="number"
                                    name="jumlah_order[{{ $item->id }}]"
                                    class="form-control jumlah-input"
                                    value="{{ $item->jumlah_order }}"
                                    min="1"
                                    max="{{ $item->obat->stok }}"
                                    data-harga="{{ $item->harga }}"
                                    data-stok="{{ $item->obat->stok }}">
                                <small class="text-muted">Stok: {{ $item->obat->stok }}</small>
                            </td>
                            <td class="subtotal">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('keranjang.hapus', $item->id) }}" class="btn btn-sm btn-danger">Hapus</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Keranjang masih kosong.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(!$keranjangs->isEmpty())
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="id_jenis_kirim">Jenis Pengiriman</label>
                        <select name="id_jenis_kirim" id="id_jenis_kirim" class="form-control" required>
                            <option value="">-- Pilih Jenis Kirim --</option>
                            @foreach ($jenisKirimList as $jenis)
                            <option value="{{ $jenis->id }}">{{ ucfirst($jenis->jenis_kirim) }} (Rp{{ number_format($jenis->biaya, 0, ',', '.') }})</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="form-group mt-3" id="upload-resep-wrapper" style="display: none;">
                    <label for="url_resep">Upload Resep Dokter</label>
                    <input type="file" name="url_resep" id="url_resep" class="form-control" accept="image/*">
                    <small class="text-muted">Diperlukan jika memilih produk dengan kategori "Obat Keras"</small>
                </div>

                <input type="hidden" name="ongkos_kirim" id="input-ongkos-kirim" value="0">
                <input type="hidden" name="biaya_app" id="input-biaya-app" value="1000">
                <input type="hidden" name="total_bayar" id="input-total-bayar" value="0">

                <div class="mt-4 border-top pt-3">
                    <h5>Ringkasan Biaya</h5>
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Subtotal Produk</span>
                            <strong id="subtotal-produk">Rp0</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Ongkos Kirim</span>
                            <strong id="ongkos-kirim">Rp0</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Biaya Aplikasi</span>
                            <strong id="biaya-app">Rp1.000</strong> {{-- tetap, atau bisa dari config --}}
                        </li>
                        <li class="list-group-item d-flex justify-content-between fw-bold">
                            <span>Total Bayar</span>
                            <strong id="total-bayar">Rp0</strong>
                        </li>
                    </ul>
                </div>
                @endif

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" formaction="{{ route('checkout.post') }}" class="btn btn-primary" id="btn-checkout" disabled>Checkout Produk Terpilih</button>

                </div>
        </form>
    </div>
</div>

<script>
    // Select all checkbox
    document.getElementById('select-all')?.addEventListener('change', function() {
        document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = this.checked);
    });
    // Update subtotal realtime
    document.querySelectorAll('.jumlah-input').forEach(input => {
        document.querySelectorAll('.jumlah-input').forEach(input => {
            input.addEventListener('input', function() {
                const row = input.closest('tr');
                const harga = parseInt(input.dataset.harga);
                const max = parseInt(input.dataset.stok);
                let jumlah = parseInt(input.value);

                if (jumlah > max) {
                    jumlah = max;
                    input.value = max;
                }

                // Kirim ke server
                fetch("{{ route('keranjang.updateItem') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            id: input.name.match(/\d+/)[0],
                            jumlah: jumlah
                        })
                    }).then(res => res.json())
                    .then(res => {
                        if (res.status === 'success') {
                            row.querySelector('.subtotal').innerText = res.formatted_subtotal;
                            hitungTotalBayar();
                        } else {
                            alert(res.message);
                        }
                    }).catch(err => {
                        alert("Terjadi kesalahan saat memperbarui item");
                    });
            });
        });

        const subtotalCell = row.querySelector('.subtotal');
        const subtotal = harga * jumlah;
        subtotalCell.innerText = 'Rp' + subtotal.toLocaleString('id-ID');
    });
</script>

<!-- disable tombol checkout kalau belum dipilih -->
<script>
    function updateCheckoutButtonState() {
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
        const checkoutButton = document.getElementById('btn-checkout');

        if (checkoutButton) {
            checkoutButton.disabled = !anyChecked;
            checkoutButton.style.cursor = anyChecked ? 'pointer' : 'not-allowed';
            checkoutButton.style.opacity = anyChecked ? '1' : '0.6';
        }
    }

    // Inisialisasi state tombol saat pertama load
    updateCheckoutButtonState();

    // Toggle tombol saat checkbox diklik
    document.querySelectorAll('.item-checkbox').forEach(cb => {
        cb.addEventListener('change', updateCheckoutButtonState);
    });

    // Jika "select all" diubah, update juga tombolnya
    document.getElementById('select-all')?.addEventListener('change', updateCheckoutButtonState);
</script>

<!-- hitung total bayar -->
<script>
    const biayaApp = 1000;

    function formatRupiah(angka) {
        return 'Rp' + angka.toLocaleString('id-ID');
    }

    function hitungTotalBayar() {
        let subtotal = 0;

        // Hitung subtotal dari produk tercentang
        document.querySelectorAll('.item-checkbox:checked').forEach(cb => {
            const row = cb.closest('tr');
            const jumlahInput = row.querySelector('.jumlah-input');
            const harga = parseInt(jumlahInput.dataset.harga);
            const jumlah = parseInt(jumlahInput.value);
            subtotal += harga * jumlah;
        });

        // Ambil ongkos kirim dari jenis pengiriman terpilih
        const jenisSelect = document.getElementById('id_jenis_kirim');
        const ongkosKirim = parseInt(jenisSelect?.selectedOptions[0]?.dataset.biaya || 0);
        const total = subtotal + ongkosKirim + biayaApp;

        // Tampilkan di UI
        document.getElementById('subtotal-produk').innerText = formatRupiah(subtotal);
        document.getElementById('ongkos-kirim').innerText = formatRupiah(ongkosKirim);
        document.getElementById('total-bayar').innerText = formatRupiah(total);

        // Set value ke hidden input (untuk dikirim ke backend)
        document.getElementById('input-ongkos-kirim').value = ongkosKirim;
        document.getElementById('input-biaya-app').value = biayaApp;
        document.getElementById('input-total-bayar').value = total;
    }

    // Event listeners
    document.querySelectorAll('.item-checkbox, .jumlah-input').forEach(el => {
        el.addEventListener('change', hitungTotalBayar);
        el.addEventListener('input', hitungTotalBayar);
    });
    document.getElementById('id_jenis_kirim')?.addEventListener('change', hitungTotalBayar);

    // Jalankan pertama kali
    hitungTotalBayar();
</script>

<!-- resep obat dokter -->
<script>
    function updateResepVisibility() {
        const resepWrapper = document.getElementById('upload-resep-wrapper');
        let showResep = false;

        document.querySelectorAll('.item-checkbox:checked').forEach(cb => {
            if (cb.dataset.obatKeras === '1') {
                showResep = true;
            }
        });

        resepWrapper.style.display = showResep ? 'block' : 'none';
        document.getElementById('url_resep').required = showResep;

        if (!showResep) {
            document.getElementById('url_resep').value = '';
        }
    }

    function updateSelectAllCheckboxState() {
        const allCheckboxes = document.querySelectorAll('.item-checkbox');
        const selectAll = document.getElementById('select-all');
        const allChecked = Array.from(allCheckboxes).every(cb => cb.checked);
        selectAll.checked = allChecked;
    }

    function attachCheckboxListeners() {
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        itemCheckboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                updateCheckoutButtonState();
                updateResepVisibility();
                updateSelectAllCheckboxState();
                hitungTotalBayar();
            });
        });
    }

    // Select All functionality
    document.getElementById('select-all')?.addEventListener('change', function() {
        const isChecked = this.checked;
        document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = isChecked);
        updateCheckoutButtonState();
        updateResepVisibility();
        hitungTotalBayar();
    });

    // Inisialisasi awal
    window.addEventListener('DOMContentLoaded', () => {
        attachCheckboxListeners();
        updateCheckoutButtonState();
        updateResepVisibility();
        updateSelectAllCheckboxState();
        hitungTotalBayar();
    });
</script>

<!-- bayar midtrans -->
@if (isset($snapToken))
<script>
    // Otomatis menampilkan popup Midtrans saat halaman dimuat
    window.onload = function() {
        // Memanggil Midtrans Snap untuk menampilkan popup
        snap.pay("{{ $snapToken }}", {
            onSuccess: function(result) {
                alert("Pembayaran Berhasil! ID Transaksi: " + result.transaction_id);
                // Lakukan tindakan setelah pembayaran berhasil, misalnya update status transaksi
            },
            onPending: function(result) {
                alert("Pembayaran Tertunda! ID Transaksi: " + result.transaction_id);
                // Lakukan tindakan untuk pembayaran tertunda
            },
            onError: function(result) {
                alert("Pembayaran Gagal! Coba lagi.");
                // Lakukan tindakan jika pembayaran gagal
            }
        });
    };
</script>
@endif
@endsection