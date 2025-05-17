@extends('be/partial/master')

@section('navbar')
@include('be/partial/navbar')
@endsection

@section('sidebar')
@include('be/partial/sidebar')
@endsection

@section('footer')
@include('be/partial/footer')
@endsection

@section('content')

<div class="card">
  <div class="card-body">
    <h4 class="card-title">Buat Pembelian Baru</h4>
    <form class="forms-sample" method="POST" action="{{ route('pembelian.store') }}" enctype="multipart/form-data" id="frmPembelian">
      @csrf

      <div class="form-group">
        <label for="nonota">No Nota</label>
        <input type="text" class="form-control @error('nonota') is-invalid @enderror" id="nonota" name="nonota" placeholder="No Nota" value="{{ old('nonota') }}">
        @error('nonota')
        <div class="invalid-feedback">{{$message}}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="id_distributor">Distributor</label>
        <select class="form-control @error('id_distributor') is-invalid @enderror" id="id_distributor" name="id_distributor">
          <option value="">-- Pilih Distributor --</option>
          @foreach($distributors as $distributor)
          <option value="{{ $distributor->id }}" {{ old('id_distributor') == $distributor->id ? 'selected' : '' }}>
            {{ ucfirst($distributor->nama_distributor) }}
          </option>
          @endforeach
        </select>
        @error('id_distributor')
        <div class="invalid-feedback">{{$message}}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="tgl_pembelian">Tanggal Pembelian</label>
        <input type="date" class="form-control @error('tgl_pembelian') is-invalid @enderror"
          id="tgl_pembelian" name="tgl_pembelian" value="{{ old('tgl_pembelian') }}">


        @error('tgl_pembelian')
        <div class="invalid-feedback">{{$message}}</div>
        @enderror
      </div>

      <div class="form-group">
        <hr style="background-color: white">
        <h6>Detail Pembelian</h6>
        <div id="detail-wrapper">

        </div>
        <div class="d-flex justify-content-end">
          <button type="button" class="btn btn-success my-2" id="btn-add-detail">+ Tambah Detail</button>
        </div>

      </div>
      <hr style="background-color: white">

      <div class="form-group">
        <label for="total_bayar">Total Bayar (Rp.)</label>
        <input type="number" class="form-control @error('total_bayar') is-invalid @enderror" id="total_bayar" name="total_bayar" placeholder="0" value="{{ old('total_bayar') }}" style="background-color: #2A3038;">
        @error('total_bayar')
        <div class="invalid-feedback">{{$message}}</div>
        @enderror
      </div>


      <button id="btn-simpan" type="button" class="btn btn-primary mr-2">Submit</button>
      <button id="btn-cancel" type="button" class="btn btn-dark">Cancel</button>
    </form>
  </div>
</div>

<textarea id="detail-template" class="d-none">
{!! str_replace(["\n", "\r", "\t"], '', view('be.pembelian.detail-create', ['obats' => $obats])->render()) !!}
</textarea>

@if ($errors->has('nonota'))
<script>
  document.addEventListener('DOMContentLoaded', function() {
    swal("Warning", "No nota sudah ada, silakan masukkan no nota lain", "warning");
  });
</script>
@endif

<!-- pembelian dan submit-->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('frmPembelian');
    const btnSave = document.getElementById('btn-simpan');
    const btnCancel = document.getElementById('btn-cancel');

    const fieldNota = document.getElementById('nonota');
    const fieldDistributor = document.getElementById('id_distributor');
    const fieldTglPembelian = document.getElementById('tgl_pembelian');
    const fieldTotalBayar = document.getElementById('total_bayar');

    btnCancel.addEventListener('click', function() {
      window.location = "{{ route('pembelian.index') }}";
    });

    btnSave.addEventListener('click', function(event) {
      event.preventDefault();

      // Reset error
      [fieldNota, fieldDistributor, fieldTglPembelian].forEach(el => el.classList.remove('is-invalid'));

      // Validasi field utama (nonota, distributor, tgl)
      if (!fieldNota.value.trim()) {
        fieldNota.classList.add('is-invalid');
        swal("Invalid Data", "No Nota harus diisi!", "error").then(() => fieldNota.focus());
        return;
      }

      if (!fieldDistributor.value.trim()) {
        fieldDistributor.classList.add('is-invalid');
        swal("Invalid Data", "Distributor harus dipilih!", "error").then(() => fieldDistributor.focus());
        return;
      }

      if (!fieldTglPembelian.value.trim()) {
        fieldTglPembelian.classList.add('is-invalid');
        swal("Invalid Data", "Tanggal Pembelian harus diisi!", "error").then(() => fieldTglPembelian.focus());
        return;
      }

      let totalBayarLength = fieldTotalBayar.value.trim().length;
      if (totalBayarLength > 10) {
        fieldTotalBayar.classList.add('is-invalid');
        swal("Invalid Data", "Total bayar tidak boleh lebih dari 10 digit!", "error").then(() => fieldTotalBayar.focus());
        return;
      }

      // Validasi minimal satu detail pembelian
      const detailItems = document.querySelectorAll('.detail-item');
      if (detailItems.length === 0) {
        swal("Invalid Data", "Minimal satu detail pembelian harus ditambahkan!", "error");
        return;
      }

      // Validasi setiap detail
      for (let i = 0; i < detailItems.length; i++) {
        const item = detailItems[i];
        const selectObat = item.querySelector('.select-obat');
        const jumlah = item.querySelector('.jumlah');
        const harga = item.querySelector('.harga');
        const subtotal = item.querySelector('.subtotal');

        [selectObat, jumlah, harga, subtotal].forEach(el => el.classList.remove('is-invalid'));

        if (!selectObat.value) {
          selectObat.classList.add('is-invalid');
          swal("Invalid Data", `Obat pada detail #${i + 1} harus dipilih!`, "error").then(() => selectObat.focus());
          return;
        }

        let jumlahLength = jumlah.value.trim().length;
        if (jumlahLength > 11) {
          jumlah.classList.add('is-invalid');
            swal("Invalid Data", `Jumlah beli pada detail #${i + 1} tidak boleh lebih dari 11 digit!`, "error").then(() => jumlah.focus());
          return;
        }
        if (!jumlah.value || parseFloat(jumlah.value) <= 0) {
          jumlah.classList.add('is-invalid');
          swal("Invalid Data", `Jumlah beli pada detail #${i + 1} tidak boleh kosong atau nol!`, "error").then(() => jumlah.focus());
          return;
        }
        

        let hargaLength = harga.value.trim().length;
        if (hargaLength > 10) {
          harga.classList.add('is-invalid');
          swal("Invalid Data", `Harga beli pada detail #${i + 1} tidak boleh lebih dari 10 digit!`, "error").then(() => harga.focus());
          return;
        }
        if (!harga.value || parseFloat(harga.value) <= 0) {
          harga.classList.add('is-invalid');
          swal("Invalid Data", `Harga beli pada detail #${i + 1} tidak boleh kosong atau nol!`, "error").then(() => harga.focus());
          return;
        }

        let subtotalLength = subtotal.value.trim().length;
        if (subtotalLength > 10) {
          subtotal.classList.add('is-invalid');
          swal("Invalid Data", `Subtotal pada detail #${i + 1} tidak boleh lebih dari 10 digit!`, "error").then(() => subtotal.focus());
          return;
        }
        if (!subtotal.value || parseFloat(subtotal.value) <= 0) {
          subtotal.classList.add('is-invalid');
          swal("Invalid Data", `Subtotal pada detail #${i + 1} tidak valid!`, "error").then(() => subtotal.focus());
          return;
        }
      }

      // Semua valid -> submit form
      form.submit();
    });
  });
</script>

<!-- detail pembelian -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const detailWrapper = document.getElementById('detail-wrapper');
    const btnAddDetail = document.getElementById('btn-add-detail');
    const template = document.getElementById('detail-template').value;
    const totalBayarInput = document.getElementById('total_bayar');
    let index = 0;

    function updateSubtotal(group) {
      const jumlah = parseFloat(group.querySelector('.jumlah').value) || 0;
      const harga = parseFloat(group.querySelector('.harga').value) || 0;
      const subtotal = jumlah * harga;
      group.querySelector('.subtotal').value = subtotal;

      updateTotalBayar();
    }

    function updateTotalBayar() {
      let total = 0;
      document.querySelectorAll('.subtotal').forEach(el => {
        total += parseFloat(el.value) || 0;
      });
      totalBayarInput.value = total;
    }

    function updateNumbers() {
      const items = detailWrapper.querySelectorAll('.detail-item');
      items.forEach((item, index) => {
        item.querySelector('.detail-number').textContent = `#${index + 1}`;
      });
    }

    btnAddDetail.addEventListener('click', function() {
      let newDetail = template.replace(/__INDEX__/g, index);
      const wrapper = document.createElement('div');
      wrapper.innerHTML = newDetail;
      detailWrapper.appendChild(wrapper);
      index++;
      updateNumbers();
    });

    detailWrapper.addEventListener('input', function(e) {
      const group = e.target.closest('.detail-item');
      if (group && (e.target.classList.contains('jumlah') || e.target.classList.contains('harga'))) {
        updateSubtotal(group);
      }
    });

    detailWrapper.addEventListener('click', function(e) {
      if (e.target.classList.contains('btn-remove-detail')) {
        e.target.closest('.detail-item').remove();
        updateTotalBayar();
      }
    });
  });
</script>

<!-- simpan data sementara -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('frmPembelian');
  const totalBayar = document.getElementById('total_bayar');
  const btnCancel = document.getElementById('btn-cancel');

  // Restore nilai form dari localStorage
  const savedForm = localStorage.getItem('form_pembelian');
  if (savedForm) {
    const data = JSON.parse(savedForm);

    document.getElementById('nonota').value = data.nonota || '';
    document.getElementById('tgl_pembelian').value = data.tgl_pembelian || '';
    document.getElementById('id_distributor').value = data.id_distributor || '';
    totalBayar.value = data.total_bayar || '';

    if (data.details && data.details.length > 0) {
      const template = document.getElementById('detail-template').value;
      const detailWrapper = document.getElementById('detail-wrapper');

      detailWrapper.innerHTML = ''; // bersihkan dahulu
      data.details.forEach((detail, idx) => {
        let newDetail = template.replace(/__INDEX__/g, idx);
        const wrapper = document.createElement('div');
        wrapper.innerHTML = newDetail;
        const el = wrapper.querySelector('.detail-item');

        el.querySelector('[name="id_obat[]"]').value = detail.id_obat;
        el.querySelector('[name="jumlah_beli[]"]').value = detail.jumlah_beli;
        el.querySelector('[name="harga_beli[]"]').value = detail.harga_beli;
        el.querySelector('[name="subtotal[]"]').value = detail.subtotal;

        detailWrapper.appendChild(el);
      });
    }
  }

  // Simpan data ke localStorage setiap kali user input
  function saveFormToLocalStorage() {
    const details = [];
    document.querySelectorAll('.detail-item').forEach(item => {
      details.push({
        id_obat: item.querySelector('[name="id_obat[]"]').value,
        jumlah_beli: item.querySelector('[name="jumlah_beli[]"]').value,
        harga_beli: item.querySelector('[name="harga_beli[]"]').value,
        subtotal: item.querySelector('[name="subtotal[]"]').value,
      });
    });

    const formData = {
      nonota: document.getElementById('nonota').value,
      tgl_pembelian: document.getElementById('tgl_pembelian').value,
      id_distributor: document.getElementById('id_distributor').value,
      total_bayar: totalBayar.value,
      details: details
    };

    localStorage.setItem('form_pembelian', JSON.stringify(formData));
  }

  form.addEventListener('input', saveFormToLocalStorage);
  document.getElementById('btn-add-detail').addEventListener('click', saveFormToLocalStorage);
  document.getElementById('detail-wrapper').addEventListener('input', saveFormToLocalStorage);

  // Hapus dari localStorage setelah berhasil submit
  document.getElementById('btn-simpan').addEventListener('click', () => {
    localStorage.removeItem('form_pembelian');
  });

  btnCancel.addEventListener('click', function() {
    localStorage.removeItem('form_pembelian');
    });
});
</script>

@endsection