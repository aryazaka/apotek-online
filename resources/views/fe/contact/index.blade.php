@extends('fe/partial/master')

@section('navbar')
@include('fe/partial/navbar')
@endsection

@section('footer')
@include('fe/partial/footer')
@endsection

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold text-black">Hubungi Kami</h1>
        <p class="text-muted">Kami siap membantu Anda. Silakan hubungi kami melalui formulir atau informasi kontak di bawah ini.</p>
    </div>

    <div class="row">
        <!-- Informasi Kontak -->
        <div class="col-md-5 mb-4">
            <div class="border rounded p-4 shadow-sm h-100">
                <h5 class="fw-bold text-black mb-3">Informasi Kontak</h5>
                <p class="mb-2">
                    <i class="fa-solid fa-location-dot me-2 text-danger"></i>
                    Jl. BojongBaru Kec. BojongGede
                </p>
                <p class="mb-2">
                    <i class="fa-solid fa-phone me-2 text-success"></i>
                    089630239411
                </p>
                <p class="mb-2">
                    <i class="fa-solid fa-envelope me-2 text-warning"></i>
                    aryapurnomo07@gmail.com
                </p>
                <p class="mb-0">
                    <i class="fa-brands fa-whatsapp me-2 text-success"></i>
                    0812-3456-7890 (Chat 24 Jam)
                </p>
            </div>
        </div>

        <!-- Formulir Kontak -->
        <div class="col-md-7">
            <div class="border rounded p-4 shadow-sm h-100">
                <h5 class="fw-bold text-black mb-3">Kirim Pesan</h5>
                <form action="#" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Anda</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="pesan" class="form-label">Pesan</label>
                        <textarea class="form-control" id="pesan" name="pesan" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-paper-plane me-1"></i> Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
