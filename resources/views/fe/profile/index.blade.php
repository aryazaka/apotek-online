@extends('fe/partial/master')
@section('navbar')
@include('fe.partial.navbar')
@endsection

@section('footer')
@include('fe.partial.footer')
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <a href="{{ route('home.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
            <h2 class="fw-bold text-black mb-4 mt-3">Edit Profil Pelanggan</h2>
            <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="border rounded p-4 shadow-sm bg-white">
                @csrf
                @method('PUT')


                <!-- Nama & Email -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nama_pelanggan" class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" value="{{ old('nama_pelanggan', $user->nama_pelanggan) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>

                <!-- No Telepon -->
                <div class="mb-3">
                    <label for="no_telp" class="form-label fw-semibold">Nomor Telepon</label>
                    <input type="text" class="form-control" id="no_telp" name="no_telp" value="{{ old('no_telp', $user->no_telp) }}">
                </div>

                <!-- Alamat 1 -->
                <h5 class="text-black mt-4 mb-2">Alamat Utama</h5>
                <div class="mb-3">
                    <label for="alamat1" class="form-label">Alamat Lengkap</label>
                    <input type="text" class="form-control" id="alamat1" name="alamat1" value="{{ old('alamat1', $user->alamat1) }}" required>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="kota1" class="form-label">Kota</label>
                        <input type="text" class="form-control" id="kota1" name="kota1" value="{{ old('kota1', $user->kota1) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="propinsi1" class="form-label">Provinsi</label>
                        <input type="text" class="form-control" id="propinsi1" name="propinsi1" value="{{ old('propinsi1', $user->propinsi1) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="kodepos1" class="form-label">Kode Pos</label>
                        <input type="text" class="form-control" id="kodepos1" name="kodepos1" value="{{ old('kodepos1', $user->kodepos1) }}" required>
                    </div>
                </div>

                <h5 class="text-black mt-4 mb-2">Alamat Kedua</h5>
                <div class="mb-3">
                    <label for="alamat2" class="form-label">Alamat Lengkap</label>
                    <input type="text" class="form-control" id="alamat2" name="alamat2" value="{{ old('alamat2', $user->alamat2) }}">
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="kota2" class="form-label">Kota</label>
                        <input type="text" class="form-control" id="kota2" name="kota2" value="{{ old('kota2', $user->kota2) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="propinsi2" class="form-label">Provinsi</label>
                        <input type="text" class="form-control" id="propinsi2" name="propinsi2" value="{{ old('propinsi1', $user->propinsi2) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="kodepos2" class="form-label">Kode Pos</label>
                        <input type="text" class="form-control" id="kodepos2" name="kodepos2" value="{{ old('kodepos1', $user->kodepos2) }}">
                    </div>
                </div>

                <h5 class="text-black mt-4 mb-2">Alamat Ketiga</h5>
                <div class="mb-3">
                    <label for="alamat3" class="form-label">Alamat Lengkap</label>
                    <input type="text" class="form-control" id="alamat3" name="alamat3" value="{{ old('alamat3', $user->alamat3) }}">
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="kota3" class="form-label">Kota</label>
                        <input type="text" class="form-control" id="kota3" name="kota3" value="{{ old('kota3', $user->kota3) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="propinsi3" class="form-label">Provinsi</label>
                        <input type="text" class="form-control" id="propinsi3" name="propinsi3" value="{{ old('propinsi3', $user->propinsi3) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="kodepos3" class="form-label">Kode Pos</label>
                        <input type="text" class="form-control" id="kodepos3" name="kodepos3" value="{{ old('kodepos3', $user->kodepos3) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Foto Profil</label>
                    @if ($user->foto)
                        <div class="mb-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#FotoModal">
    <i class="fa-solid fa-eye"></i> Lihat Foto
</button>
                        </div>
                    @endif
                    <input type="file" class="form-control" name="foto">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">KTP</label>
                    @if ($user->url_ktp)
                        <div class="mb-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#ktpModal">
    <i class="fa-solid fa-eye"></i> Lihat KTP
</button>
                        </div>
                    @endif
                    <input type="file" class="form-control" name="url_ktp">
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ktpModal" tabindex="-1" aria-labelledby="ktpModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ktpModalLabel">KTP Pelanggan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img src="{{ asset('storage/' . $user->url_ktp) }}" class="img-fluid" alt="KTP">
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="FotoModal" tabindex="-1" aria-labelledby="FotoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ktpModalLabel">Foto Pelanggan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img src="{{ asset('storage/' . $user->foto) }}" class="img-fluid" alt="KTP">
      </div>
    </div>
  </div>
</div>

@endsection