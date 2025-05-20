<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Str;
use App\Models\Keranjang;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        if ($request->hasFile('url_resep')) {
        $resepPath = $request->file('url_resep')->store('resep-obat', 'public');
    }


        // Simpan data ke tabel penjualan (status: pending)
        $penjualan = Penjualan::create([
            'kode_transaksi' => 'TRX-' . strtoupper(Str::random(10)),
            'id_pelanggan' => Auth::guard('pelanggan')->user()->id,
            'tgl_penjualan' => now(),
            'ongkos_kirim' => $request->ongkos_kirim,
            'biaya_app' => $request->biaya_app,
            'url_resep' => $resepPath ?? null,
            'total_bayar' => $request->total_bayar,
            'id_jenis_kirim' => $request->id_jenis_kirim,
            'id_metode_bayar' => null,
            'status_order' => 'Menunggu Konfirmasi',
            'keterangan_status' => 'Menunggu Konfirmasi Pembayaran',
        ]);

        // Upload resep jika ada
        foreach ($request->file('reseps', []) as $itemId => $file) {
            $path = $file->store('reseps', 'public');
            $penjualan->reseps()->create(['path' => $path]); // jika relasi one-to-many
        }

        // Simpan ke detail penjualan dan hapus item dari keranjang
        foreach ($request->checkout_ids as $keranjangId) {
            // Mencari item di keranjang
            $item = Keranjang::find($keranjangId);
        
            // Cek jika item ditemukan
            if (!$item) {
                // Jika item tidak ditemukan, log error atau berikan respon
                return back()->withErrors(['error' => 'Item keranjang tidak ditemukan!']);
            }
        
            // Menambahkan data ke tabel detail_penjualan
            DetailPenjualan::create([
                'id_penjualan' => $penjualan->id,  // ID penjualan yang baru saja dibuat
                'id_obat' => $item->id_obat,  // Mengakses id_obat
                'jumlah_beli' => $item->jumlah_order,
                'harga_beli' => $item->harga,
                'subtotal' => $item->jumlah_order * $item->harga,
            ]);
        
            // Menghapus item dari keranjang setelah checkout
            $item->delete();
        }


        

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Data transaksi untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $penjualan->kode_transaksi,
                'gross_amount' => (int) $penjualan->total_bayar,
            ],
            'customer_details' => [
                'first_name' => Auth::guard('pelanggan')->user()->nama_pelanggan,
                'email' => Auth::guard('pelanggan')->user()->email,
            ],
            'callbacks' => [
                'finish' => route('pesanan.finish'),
            ]
        ];

        // Mendapatkan token Snap Midtrans
        $snapToken = Snap::getSnapToken($params);
        $penjualan->snap_token = $snapToken;
        $penjualan->save();
        // dd($snapToken); 
        $idPelanggan = Auth::guard('pelanggan')->user()->id;

        // Mengembalikan view dengan SnapToken dan data penjualan
        return redirect()->route('pesanan.index');
    }
}
