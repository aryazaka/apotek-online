<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Keranjang;
use App\Models\Obat;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\MetodeBayar;
use Midtrans\Transaction;
use Midtrans\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PesananController extends Controller
{
    public function __construct()
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');  // Pastikan Anda menambahkan server key di .env
        Config::$isProduction = false;  // Atur sesuai dengan mode yang digunakan (sandbox/production)
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelanggan = Auth::guard('pelanggan')->check()
            ? Auth::guard('pelanggan')->user()
            : null;

        $belumBayar = Penjualan::with(['detailPenjualan.obat', 'pelanggan'])->where('id_pelanggan', $pelanggan->id)->get()->filter(fn($item) => $item->keterangan_status === 'Menunggu Konfirmasi Pembayaran');

        $diproses = Penjualan::with(['detailPenjualan.obat', 'pelanggan'])->where('id_pelanggan', $pelanggan->id)->get()->filter(
            fn($item) =>
            $item->status_order === 'Diproses' ||
                ($item->status_order === 'Menunggu Konfirmasi' && $item->keterangan_status === 'Tunggu Konfirmasi dari Admin') || $item->status_order === 'Menunggu Kurir'
        );

        $pengiriman = Penjualan::with(['detailPenjualan.obat', 'pengiriman', 'pelanggan'])
            ->where('id_pelanggan', $pelanggan->id)
            ->whereHas('pengiriman', function ($query) {
                $query->where('status_kirim', 'Sedang Dikirim');
            })
            ->get();

        $selesai = Penjualan::with(['detailPenjualan.obat', 'pengiriman', 'pelanggan'])
            ->where('id_pelanggan', $pelanggan->id)
            ->whereHas('pengiriman', function ($query) {
                $query->where('status_kirim', 'Tiba Di Tujuan');
            })
            ->get()->filter(
                fn($item) =>
                $item->status_order === 'Dalam Pengiriman' || ($item->status_order === 'Selesai')
            );
        $selesaiPengirimanCount = $selesai->filter(fn($item) => $item->status_order === 'Dalam Pengiriman')->count();

        $salah = Penjualan::with(['detailPenjualan.obat', 'pengiriman', 'pelanggan'])
            ->where('id_pelanggan', $pelanggan->id)
            ->whereIn('status_order', ['Bermasalah', 'Dibatalkan Pembeli', 'Dibatalkan Penjual'])
            ->get();

        $pesananAktif = Penjualan::where('id_pelanggan', $pelanggan->id)
            ->whereIn('status_order', ['Menunggu Konfirmasi', 'Diproses', 'Menunggu Kurir', 'Dalam Pengiriman'])
            ->exists();

        return view('fe.pesanan.index', [
            'title' => 'Pesanan',
            'user' => $pelanggan,
            'keranjangs' => Keranjang::where('id_pelanggan', $pelanggan->id)
                ->with('obat')
                ->get(),
            'belumBayars' => $belumBayar,
            'diprosess' => $diproses,
            'pengirimans' => $pengiriman,
            'selesais' => $selesai,
            'selesaiPengirimanCount' => $selesaiPengirimanCount,
            'salahs' => $salah,
            'pesananAktif' => $pesananAktif,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {

        $penjualan = Penjualan::with('detailPenjualan.obat')->findOrFail($id);
        Log::info('Update status data:', $request->all());
        try {
            $transactionStatus = $request->input('transaction_status');
            $paymentType = $request->input('payment_type');
            $vaNumbers = $request->input('va_numbers');
            $orderId = $id;

            if ($transactionStatus == 'settlement') {
                $metodeNama = str_replace('_', ' ', $paymentType);
                $tempatBayar = isset($vaNumbers[0]['bank']) ? strtoupper($vaNumbers[0]['bank']) : null;
                if ($paymentType == 'bank_transfer') {
                    $metodeBayar = MetodeBayar::firstOrCreate(
                        ['metode_pembayaran' => $metodeNama, 'tempat_bayar' => $tempatBayar],
                        [
                            'metode_pembayaran' => $metodeNama,
                            'tempat_bayar' => $tempatBayar,
                            'no_rekening' => $vaNumbers[0]['va_number'] ?? '-',
                            'url_logo' => '-',
                        ]
                    );
                } else if ($paymentType == 'qris') {
                    $metodeBayar = MetodeBayar::firstOrCreate(
                        ['metode_pembayaran' => $paymentType],
                        [
                            'metode_pembayaran' => $metodeNama,
                            'tempat_bayar' => $metodeNama,
                            'no_rekening' => $vaNumbers[0]['va_number'] ?? '-',
                            'url_logo' => '-',
                        ]
                    );
                } else if ($paymentType == 'cstore') {
                    $metodeBayar = MetodeBayar::firstOrCreate(
                        ['metode_pembayaran' => $paymentType],
                        [
                            'metode_pembayaran' => $metodeNama,
                            'tempat_bayar' => 'Alfamart/Indomart',
                            'no_rekening' => $vaNumbers[0]['va_number'] ?? '-',
                            'url_logo' => '-',
                        ]
                    );
                } else if ($paymentType == 'echannel') {
                    $metodeBayar = MetodeBayar::firstOrCreate(
                        ['metode_pembayaran' => $paymentType],
                        [
                            'metode_pembayaran' => $metodeNama,
                            'tempat_bayar' => $metodeNama,
                            'no_rekening' => $vaNumbers[0]['va_number'] ?? '-',
                            'url_logo' => '-',
                        ]
                    );
                }

                $penjualan->id_metode_bayar = $metodeBayar->id | null;
                $penjualan->status_order = 'Menunggu Konfirmasi';
                $penjualan->keterangan_status = 'Tunggu Konfirmasi dari Admin';
                $penjualan->save();

                foreach ($penjualan->detailPenjualan as $detail) {
                    $obat = $detail->obat;
                    $obat->stok -= $detail->jumlah_beli;
                    $obat->save();
                }

                Log::info('Pembayaran berhasil!');

                return response()->json([
                    'success' => true,
                    'message' => 'Pesanan berhasil dibayar.'
                ]);
            }

            // Tambahan kalau pending atau gagal
            if ($transactionStatus === 'pending') {
                $penjualan->status_order = 'Menunggu Konfirmasi';
                $penjualan->keterangan_status = 'Pembayaran masih dalam proses.';
            } elseif (in_array($transactionStatus, ['cancel', 'expire', 'deny', 'failure', 'error'])) {
                $penjualan->status_order = 'Bermasalah';
                $penjualan->keterangan_status = 'Pembayaran gagal atau dibatalkan.';
                Log::warning("Pembayaran gagal: Order ID $orderId, Status: $transactionStatus");
            } else {
                $penjualan->status_order = 'Bermasalah';
                $penjualan->keterangan_status = 'Status tidak diketahui dari Midtrans.';
                Log::warning("Status tidak dikenal: $transactionStatus untuk order $orderId");
            }

            $penjualan->save();
            return redirect()->route('pesanan.index')->with('successPembayaran', 'Pembayaran berhasil!');
            // return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Update status error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function batalkanPesanan($id)
    {
        $penjualan = Penjualan::findOrFail($id);

        // Ubah status menjadi dibatalkan
        $penjualan->status_order = 'Dibatalkan Pembeli';
        $penjualan->keterangan_status = 'Dibatalkan oleh pelanggan';
        $penjualan->save();

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function selesaikan($id)
    {
        $penjualan = Penjualan::findOrFail($id);

        // Pastikan status saat ini valid untuk diselesaikan
        if (
            $penjualan->status_order === 'Dalam Pengiriman' &&
            optional($penjualan->pengiriman)->status_kirim === 'Tiba Di Tujuan'
        ) {
            $penjualan->status_order = 'Selesai';
            $penjualan->keterangan_status = 'Pesanan diterima pelanggan';
            $penjualan->save();

            return back()->with('success', 'Pesanan sudah selesai.');
        }

        return back()->with('error', 'Pesanan tidak valid untuk diselesaikan.');
    }


    public function finish(Request $request)
    {
        if ($request->transaction_status == 'settlement') {
            return redirect()->route('pesanan.index')->with('successPembayaran', 'Pembayaran berhasil!');
        }

        return redirect()->route('pesanan.index');
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
