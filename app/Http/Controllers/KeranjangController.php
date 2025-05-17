<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Keranjang;
use App\Models\Obat;
use App\Models\JenisPengiriman;
use Midtrans\Snap;
use Midtrans\Transaction;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $snapToken = session('snapToken');
        $penjualan = session('penjualan');

        $idPelanggan = Auth::guard('pelanggan')->user()->id;
        return view('fe.keranjang.index', [
            'title' => 'Keranjang',
            'user' => Auth::guard('pelanggan')->user(),
            'keranjangs' => Keranjang::where('id_pelanggan', $idPelanggan)
                ->with('obat')
                ->get(),
            'jenisKirimList' => JenisPengiriman::all(),
            'snapToken' => $snapToken,
            'penjualan' => $penjualan,
        ]);
    }

    public function tambah(Request $request)
    {
        $obat = Obat::findOrFail($request->id_obat);
        $request->validate([
            'id_obat' => 'required|exists:obat,id',
            'jumlah_order' => ['required', 'integer', 'min:1', 'max:' . $obat->stok],
            'harga' => 'required|numeric',
            'id_pelanggan' => 'required|exists:pelanggan,id',
        ]);

        $existing = Keranjang::where('id_pelanggan', $request->id_pelanggan)
            ->where('id_obat', $request->id_obat)
            ->first();

        $jumlahTotal = $request->jumlah_order + ($existing->jumlah_order ?? 0);

        if ($jumlahTotal > $obat->stok) {
            return redirect()->back()->withInput()->with('error', 'Jumlah melebihi stok yang tersedia.');
        }

        $subtotal = $jumlahTotal * $request->harga;

        if ($existing) {
            $existing->jumlah_order = $jumlahTotal;
            $existing->subtotal = $subtotal;
            $existing->save();
        } else {
            Keranjang::create([
                'id_pelanggan' => $request->id_pelanggan,
                'id_obat' => $request->id_obat,
                'jumlah_order' => $request->jumlah_order,
                'harga' => $request->harga,
                'subtotal' => $request->jumlah_order * $request->harga,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request)
    {
        foreach ($request->jumlah_order as $id => $jumlah) {
            $keranjang = Keranjang::find($id);
            $stok = $keranjang->obat->stok;

            if ($jumlah > $stok) {
                return back()->with('error', "Jumlah untuk {$keranjang->obat->nama_obat} melebihi stok.");
            }

            $keranjang->jumlah_order = $jumlah;
            $keranjang->subtotal = $jumlah * $keranjang->harga;
            $keranjang->save();
        }

        return back()->with('success', 'Keranjang berhasil diperbarui.');
    }

    public function updateItem(Request $request)
{
    $keranjang = Keranjang::find($request->id);
    if (!$keranjang) {
        return response()->json(['status' => 'error', 'message' => 'Item tidak ditemukan'], 404);
    }

    $stok = $keranjang->obat->stok;
    if ($request->jumlah > $stok) {
        return response()->json(['status' => 'error', 'message' => "Jumlah melebihi stok ($stok)"], 400);
    }

    $keranjang->jumlah_order = $request->jumlah;
    $keranjang->subtotal = $keranjang->jumlah_order * $keranjang->harga;
    $keranjang->save();

    return response()->json([
        'status' => 'success',
        'subtotal' => $keranjang->subtotal,
        'formatted_subtotal' => 'Rp' . number_format($keranjang->subtotal, 0, ',', '.')
    ]);
}


    public function hapus($id)
    {
        Keranjang::findOrFail($id)->delete();
        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
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
        //
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
  

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
