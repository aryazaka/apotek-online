<div class="detail-item border p-3 mb-3 rounded">
    <div class="detail-number" style="margin-bottom:15px; color: grey; font-size: 1.5rem;"></div>
    <div class="form-group">
        <label>Obat</label>
        <select name="id_obat[]" class="form-control select-obat">
            <option value="">-- Pilih Obat --</option>
            @foreach ($obats as $obat)
                <option value="{{ $obat->id }}">{{ $obat->nama_obat }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Jumlah Beli</label>
        <input type="number" name="jumlah_beli[]" id="jumlah_beli" class="form-control jumlah" placeholder="0" value="{{ old('jumlah_beli[]', $detail['jumlah_beli'] ?? "") }} ">
    </div>
    <div class="form-group">
        <label>Harga Beli (Rp.)</label>
        <input type="number" name="harga_beli[]" id="harga_beli" class="form-control harga" placeholder="0" value="{{ old('harga_beli[]', $detail['harga_beli'] ?? "")}}">
    </div>
    <div class="form-group">
        <label>Subtotal (Rp.)</label>
        <input type="number" name="subtotal[]" id="subtotal" class="form-control subtotal" style="background-color: #2A3038;" value="{{ old('subtotal[]', $detail['subtotal'] ?? "") }}">
    </div>
    <button type="button" class="btn btn-danger btn-sm btn-remove-detail">Hapus</button>
</div>
