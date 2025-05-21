<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Pengiriman;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PengirimanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penjualans = Penjualan::with(['pelanggan', 'pengiriman'])
            ->where('status_order', 'Menunggu Kurir')
            ->get();

        $pengirimanList = Pengiriman::with('penjualan.pelanggan')
            ->whereIn('status_kirim', ['Sedang Dikirim', 'Tiba Di Tujuan'])
            ->get();

        // Tambahkan alamat_lengkap ke setiap pelanggan
        $alamatPenjualans = $penjualans->map(function ($penjualan) {
            $pelanggan = $penjualan->pelanggan;

            if ($pelanggan) {
                for ($i = 1; $i <= 3; $i++) {
                    $alamat = $pelanggan->{"alamat$i"};
                    if ($alamat) {
                        return $alamat . ', ' .
                            $pelanggan->{"kota$i"} . ', ' .
                            $pelanggan->{"propinsi$i"} . ', ' .
                            $pelanggan->{"kodepos$i"};
                    }
                }
            }

            return null;
        });

        return view('be.pengiriman.index', [
            'title' => 'Pengiriman',
            'penjualans' => $penjualans,
            'pengirimanList' => $pengirimanList,
            'alamatPenjualans' => $alamatPenjualans,
        ]);
    }

    public function ubahStatus(Request $request)
    {
        $request->validate([
            'id_pengiriman' => 'required|exists:pengiriman,id',
            'status_kirim' => 'required',
            'tgl_tiba' => 'nullable|date',
            'keterangan' => 'nullable|string',
            'bukti_foto_depan' => 'nullable|image|max:2048',
            'bukti_foto_belakang' => 'nullable|image|max:2048',
        ]);

        $pengiriman = Pengiriman::findOrFail($request->id_pengiriman);
        $pengiriman->status_kirim = $request->status_kirim;
        $pengiriman->tgl_tiba = $request->tgl_tiba;
        $pengiriman->keterangan = $request->keterangan;

        if ($request->status_kirim === 'Tiba Di Tujuan') {
            $foto = $request->file('bukti_foto_depan') ?? $request->file('bukti_foto_belakang');

            if ($foto) {
                $path = $foto->store('bukti-pengiriman', 'public');
                $pengiriman->bukti_foto = $path;
            }
        }

        $pengiriman->save();

        return redirect()->route('pengiriman.index')->with('success', 'Status pengiriman berhasil diperbarui.');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_penjualan' => 'required|exists:penjualan,id',
            'telpon_kurir' => 'required|string|max:15',
            'tgl_kirim' => 'required|date',
            'kode_transaksi' => 'required|string',
        ]);

        // Cek apakah sudah ada pengiriman
        $existing = Pengiriman::where('id_penjualan', $request->id_penjualan)->first();
        if ($existing) {
            return redirect()->route('pengiriman.index')->with('error', 'Pesanan ini sudah diambil oleh kurir lain.');
        }

        Pengiriman::create([
            'id_penjualan' => $request->id_penjualan,
            'nama_kurir' => Auth::user()->name,
            'no_invoice' => $request->kode_transaksi,
            'telpon_kurir' => $request->telpon_kurir,
            'tgl_kirim' => $request->tgl_kirim,
            'status_kirim' => 'Sedang Dikirim',
        ]);

        Penjualan::where('id', $request->id_penjualan)->update([
            'status_order' => 'Dalam Pengiriman',
        ]);

        return redirect()->route('pengiriman.index')->with('success', 'Pesanan berhasil diproses untuk dikirim.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
