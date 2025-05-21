<!-- Filter Controls -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="startDate" class="form-label text-muted fw-semibold">Tanggal Kirim</label>
                <input type="date" id="startDate" class="form-control border-0 shadow-sm">
            </div>
            <div class="col-md-3">
                <label for="endDate" class="form-label text-muted fw-semibold">Tanggal Tiba</label>
                <input type="date" id="endDate" class="form-control border-0 shadow-sm">
            </div>
            <div class="col-md-3">
                <button id="clearFilter" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-redo-alt me-2"></i>Reset Filter
                </button>
            </div>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead>
            <tr>
                <th class="px-3 py-3 text-center" width="5%">No</th>
                <th class="px-3 py-3 text-center">No Invoice</th>
                <th class="px-3 py-3 text-center">Alamat</th>
                <th class="px-3 py-3 text-center">Tgl Kirim</th>
                <th class="px-3 py-3 text-center">Tgl Tiba</th>
                <th class="px-3 py-3 text-center">Status</th>
                <th class="px-3 py-3 text-center">Keterangan</th>
                <th class="px-3 py-3 text-center">Bukti Foto</th>
                <th class="px-3 py-3 text-center" width="15%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengirimans as $idx => $item)
            <tr>
                <td class="text-center px-3 py-3">
                    <span class="badge bg-light text-dark fw-normal">{{ $idx + 1 }}</span>
                </td>
                <td class="px-3 py-3">
                    <span class="fw-semibold text-primary">{{ $item->no_invoice }}</span>
                </td>

                <td class="px-3 py-3">
                    @php
                    $alamat = null;
                    for ($i=1; $i <= 3; $i++) {
                        $a=$penjualan->pelanggan->{"alamat$i"} ?? null;
                        if ($a) {
                        $alamat = $a . ', ' .
                        ($penjualan->pelanggan->{"kota$i"} ?? '') . ', ' .
                        ($penjualan->pelanggan->{"propinsi$i"} ?? '') . ', ' .
                        ($penjualan->pelanggan->{"kodepos$i"} ?? '');
                        break;
                        }
                        }
                        @endphp
                        {{ $alamat ?? 'Alamat tidak tersedia' }}
                </td>

                <td class="text-center px-3 py-3">
                    <small class="text-muted">{{ date('d M Y', strtotime($item->tgl_kirim)) }}</small>
                </td>
                <td class="text-center px-3 py-3">
                    <small class="text-muted">
                        {{ $item->tgl_tiba ? date('d M Y', strtotime($item->tgl_tiba)) : '-' }}
                    </small>
                </td>
                <td class="text-center px-3 py-3">
                    <span class="badge {{ $item->status_kirim === 'Tiba Di Tujuan' ? 'bg-success' : 'bg-warning text-dark' }} status-text">
                        {{ $item->status_kirim }}
                    </span>
                </td>
                <td class="text-center px-3 py-3">
                    <span class="text-muted">{{ $item->keterangan ?? '-' }}</span>
                </td>
                <td class="text-center px-3 py-3">
                    @if($item->bukti_foto)
                    <div class="position-relative">
                        <img src="{{ asset('storage/' . $item->bukti_foto) }}"
                            class="img-thumbnail popup-image shadow-sm"
                            style="width: 50px; height: 50px; object-fit: cover; cursor: pointer; border-radius: 8px;"
                            alt="Bukti Foto">
                        <i class="fas fa-search-plus"></i>
                        </span>
                    </div>
                    @else
                    <span class="text-muted">-</span>
                    @endif
                </td>
                <td class="text-center px-3 py-3">
                    <div class="btn-group-vertical gap-1" role="group">
                        @if($item->status_kirim !== 'Tiba di Tujuan')
                        <button class="btn btn-sm btn-success shadow-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#ubahStatusModal{{ $item->id }}">
                            <i class="fas fa-edit me-1"></i>Ubah Status
                        </button>
                        @endif
                        <button class="btn btn-sm btn-info shadow-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#detailModal{{ $item->id }}">
                            <i class="fas fa-eye me-1"></i>Detail
                        </button>
                    </div>
                </td>
            </tr>

            <!-- Enhanced Modal Ubah Status -->
            <div class="modal fade" id="ubahStatusModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <form action="{{ route('pengiriman.ubahStatus') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_pengiriman" value="{{ $item->id }}">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header border-bottom-0">
                                <h5 class="modal-title text-gray-700">
                                    <i class="fas fa-edit text-success me-2"></i>
                                    Ubah Status Pengiriman
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="status_kirim{{ $item->id }}" class="form-label fw-semibold">Status Pengiriman</label>
                                        <select name="status_kirim" id="status_kirim{{ $item->id }}" class="form-select status-select shadow-sm" required>
                                            <option value="">-- Pilih Status --</option>
                                            <option value="Sedang Dikirim" {{ $item->status_kirim == 'Sedang Dikirim' ? 'selected' : '' }}>
                                                Sedang Dikirim
                                            </option>
                                            <option value="Tiba Di Tujuan" {{ $item->status_kirim == 'Tiba Di Tujuan' ? 'selected' : '' }}>
                                                Tiba D i Tujuan
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <label for="tgl_tiba{{ $item->id }}" class="form-label fw-semibold">Tanggal Tiba</label>
                                        <input type="date" class="form-control shadow-sm"
                                            id="tgl_tiba{{ $item->id }}"
                                            name="tgl_tiba"
                                            value="{{ $item->tgl_tiba ? \Carbon\Carbon::parse($item->tgl_tiba)->format('Y-m-d') : '' }}">
                                    </div>

                                    <div class="col-12">
                                        <label for="keterangan{{ $item->id }}" class="form-label fw-semibold">Keterangan</label>
                                        <textarea class="form-control shadow-sm"
                                            id="keterangan{{ $item->id }}"
                                            name="keterangan"
                                            rows="3"
                                            placeholder="Tambahkan keterangan (opsional)">{{ $item->keterangan }}</textarea>
                                    </div>

                                    <div class="col-12 bukti-foto-group" style="display: none;">
                                        <label class="form-label fw-semibold">Ambil Bukti Foto</label>
                                        <div class="d-grid gap-2">
                                            <button type="button" class="btn btn-outline-primary"
                                                onclick="document.getElementById('fotoDepan{{ $item->id }}').click()">
                                                <i class="fas fa-camera me-2"></i>Kamera Depan
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="document.getElementById('fotoBelakang{{ $item->id }}').click()">
                                                <i class="fas fa-camera me-2"></i>Kamera Belakang
                                            </button>
                                        </div>

                                        <input type="file" name="bukti_foto_depan" id="fotoDepan{{ $item->id }}"
                                            style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); border: 0;"
                                            accept="image/*" capture="user">

                                        <input type="file" name="bukti_foto_belakang" id="fotoBelakang{{ $item->id }}"
                                            style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); border: 0;"
                                            accept="image/*" capture="environment">

                                        @if ($item->bukti_foto)
                                        <div class="mt-2 p-2 rounded">
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Bukti sebelumnya:
                                                <a href="{{ asset('storage/' . $item->bukti_foto) }}" target="_blank" class="text-primary">Lihat Foto</a>
                                            </small>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-top-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1"></i>Batal
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Enhanced Modal Detail -->
            <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header border-bottom-0">
                            <h5 class="modal-title text-gray-700">
                                <i class="fas fa-file-invoice text-info me-2"></i>
                                Detail Penjualan - {{ $item->no_invoice }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card border-0 h-100">
                                        <div class="card-body">
                                            <h6 class="card-title text-muted mb-3">Informasi Transaksi</h6>
                                            <div class="mb-2">
                                                <small class="text-muted">Kode Transaksi</small>
                                                <div class="fw-semibold">{{ $item->penjualan->kode_transaksi }}</div>
                                            </div>
                                            <div class="mb-2">
                                                <small class="text-muted">Tanggal Penjualan</small>
                                                <div class="fw-semibold">{{ $item->penjualan->tgl_penjualan }}</div>
                                            </div>
                                            <div class="mb-2">
                                                <small class="text-muted">Status Order</small>
                                                <div>
                                                    <span class="badge bg-success">{{ $item->penjualan->status_order }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 h-100">
                                        <div class="card-body">
                                            <h6 class="card-title text-muted mb-3">Informasi Pelanggan</h6>
                                            <div class="mb-2">
                                                <small class="text-muted">Nama Pelanggan</small>
                                                <div class="fw-semibold">{{ $item->penjualan->pelanggan->nama_pelanggan ?? '-' }}</div>
                                            </div>
                                            <div class="mb-2">
                                                <small class="text-muted">Total Bayar</small>
                                                <div class="fw-bold text-success fs-5">
                                                    Rp{{ number_format($item->penjualan->total_bayar, 0, ',', '.') }}
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <small class="text-muted">Metode Bayar</small>
                                                <div class="fw-semibold">{{ $item->penjualan->metodeBayar->metode_pembayaran ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <tr>
                <td colspan="9" class="text-center py-5">
                    <div class="text-muted">
                        <i class="fas fa-box-open fa-3x mb-3 opacity-25"></i>
                        <p class="mb-0">Belum ada data pengiriman.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>


<!-- Enhanced Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title">
                    <i class="fas fa-image text-primary me-2"></i>
                    Bukti Foto Pengiriman
                </h5>
            </div>
            <div class="modal-body text-center p-0">
                <img src="" id="modalImage" class="img-fluid w-100" alt="Foto Detail" style="max-height: 70vh; object-fit: contain;">
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Enhanced Date Filter
        const startDateInput = document.getElementById("startDate");
        const endDateInput = document.getElementById("endDate");
        const statusFilter = document.getElementById("statusFilter");
        const clearFilter = document.getElementById("clearFilter");
        const tableRows = document.querySelectorAll("table tbody tr:not(.empty-state)");

        function filterRows() {
            const startDateValue = startDateInput.value;
            const endDateValue = endDateInput.value;
            const statusValue = statusFilter.value.toLowerCase();

            tableRows.forEach(row => {
                let showRow = true;

                // Date filtering
                if (startDateValue || endDateValue) {
                    const tglKirimText = row.children[2].textContent.trim();
                    const tglTibaText = row.children[3].textContent.trim();

                    const tglKirim = new Date(tglKirimText);
                    const tglTiba = (tglTibaText && tglTibaText !== '-') ? new Date(tglTibaText) : null;

                    const startDate = startDateValue ? new Date(startDateValue) : null;
                    const endDate = endDateValue ? new Date(endDateValue) : null;

                    if (startDate && endDate) {
                        const pengirimanEnd = tglTiba || tglKirim;
                        showRow = (tglKirim <= endDate) && (startDate <= pengirimanEnd);
                    } else if (startDate) {
                        showRow = tglKirim >= startDate;
                    } else if (endDate) {
                        const pengirimanEnd = tglTiba || tglKirim;
                        showRow = pengirimanEnd <= endDate;
                    }
                }

                // Status filtering
                if (showRow && statusValue) {
                    const statusCell = row.querySelector(".status-text");
                    if (statusCell) {
                        const statusText = statusCell.textContent.toLowerCase();
                        showRow = statusText.includes(statusValue.replace('-', ' '));
                    }
                }

                row.style.display = showRow ? "" : "none";
            });

            // Show/hide empty state based on visible rows
            const visibleRows = Array.from(tableRows).filter(row => row.style.display !== "none");
            const emptyState = document.querySelector("table tbody tr td[colspan='8']")?.parentElement;

            if (emptyState) {
                emptyState.style.display = visibleRows.length === 0 ? "" : "none";
            }
        }

        // Event listeners for filters
        startDateInput.addEventListener("change", filterRows);
        endDateInput.addEventListener("change", filterRows);
        statusFilter.addEventListener("change", filterRows);

        clearFilter.addEventListener("click", () => {
            startDateInput.value = "";
            endDateInput.value = "";
            statusFilter.value = "";
            tableRows.forEach(row => (row.style.display = ""));

            const emptyState = document.querySelector("table tbody tr td[colspan='8']")?.parentElement;
            if (emptyState) {
                emptyState.style.display = "none";
            }
        });

        // Enhanced Camera functionality
        document.querySelectorAll('.status-select').forEach(select => {
            const modal = select.closest('.modal');
            const fotoGroup = modal.querySelector('.bukti-foto-group');

            const toggleFotoInput = () => {
                if (select.value === 'Tiba Di Tujuan') {
                    fotoGroup.style.display = 'block';
                    const kameraDepan = fotoGroup.querySelector('input[capture="user"]');
                    if (kameraDepan) {
                        kameraDepan.required = false;
                        kameraDepan.setAttribute('aria-required', 'true');
                    }
                } else {
                    fotoGroup.style.display = 'none';
                    const inputs = fotoGroup.querySelectorAll('input[type="file"]');
                    inputs.forEach(input => {
                        input.required = false;
                        input.removeAttribute('aria-required');
                    });
                }
            };

            select.addEventListener('change', toggleFotoInput);
            toggleFotoInput();
        });

        // Enhanced Camera input handling
        document.querySelectorAll('.bukti-foto-group').forEach(group => {
            const depan = group.querySelector('input[capture="user"]');
            const belakang = group.querySelector('input[capture="environment"]');

            const tombolDepan = group.querySelector('button[onclick*="' + depan.id + '"]');
            const tombolBelakang = group.querySelector('button[onclick*="' + belakang.id + '"]');

            if (depan && belakang && tombolDepan && tombolBelakang) {
                [depan, belakang].forEach(input => {
                    input.addEventListener('change', function() {
                        if (this.files.length > 0) {
                            // Sembunyikan tombol yang satunya
                            if (this === depan) {
                                tombolBelakang.style.display = 'none';
                            } else {
                                tombolDepan.style.display = 'none';
                            }

                            // Update tombol yang dipilih
                            const tombol = this === depan ? tombolDepan : tombolBelakang;
                            const fileName = this.files[0].name;
                            tombol.innerHTML = `<i class="fas fa-check text-success me-2"></i>${fileName}`;
                            tombol.classList.add('btn-success');
                            tombol.classList.remove('btn-outline-primary', 'btn-outline-secondary');
                        } else {
                            // Jika batal pilih, tampilkan semua tombol dan reset tampilan tombol
                            tombolDepan.style.display = 'inline-block';
                            tombolBelakang.style.display = 'inline-block';

                            tombolDepan.innerHTML = `<i class="fas fa-camera me-2"></i>Kamera Depan`;
                            tombolDepan.classList.remove('btn-success');
                            tombolDepan.classList.add('btn-outline-primary');

                            tombolBelakang.innerHTML = `<i class="fas fa-camera me-2"></i>Kamera Belakang`;
                            tombolBelakang.classList.remove('btn-success');
                            tombolBelakang.classList.add('btn-outline-secondary');
                        }
                    });
                });
            }
        });
        // Enhanced Image popup
        document.querySelectorAll('.popup-image').forEach(img => {
            img.addEventListener('click', function() {
                const modalImg = document.getElementById('modalImage');
                modalImg.src = this.src;
                modalImg.alt = this.alt;

                const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
                imageModal.show();
            });
        });

        // Loading states for forms
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const modal = form.closest('.modal');
                const statusSelect = modal?.querySelector('.status-select');
                const statusValue = statusSelect?.value;

                if (statusValue === 'Tiba Di Tujuan') {
                    const fotoGroup = modal.querySelector('.bukti-foto-group');
                    const depan = fotoGroup.querySelector('input[capture="user"]');
                    const belakang = fotoGroup.querySelector('input[capture="environment"]');

                    if ((!depan.files || depan.files.length === 0) && (!belakang.files || belakang.files.length === 0)) {
                        e.preventDefault();
                        swal("Invalid Data", "Silakan unggah minimal satu bukti foto (depan atau belakang)", "error");
                        return;
                    }
                }

                // Lanjutkan loading state
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Memproses...';
                }
            });
        });


        // Auto-dismiss alerts after 5 seconds
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                alert.classList.add('fade');
                setTimeout(() => alert.remove(), 150);
            }, 5000);
        });
    });
</script>