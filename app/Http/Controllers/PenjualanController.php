<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Pengiriman;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PenjualanExport;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $penjualans = Penjualan::with(['pelanggan', 'detailPenjualan.obat'])->get();

        return view('be.penjualan.index', [
            'title' => 'Penjualan',
            'penjualans' => $penjualans,
        ]);
    }

    public function show($id)
    {
        $penjualan = Penjualan::with(['detailPenjualan.obat', 'pelanggan'])->findOrFail($id);
        return view('be.penjualan.detail', [
            'title' => 'Detail Penjualan',
            'penjualan' => $penjualan,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {

        $penjualan = Penjualan::findOrFail($id);
        $penjualan->status_order = $request->status_order;
        $penjualan->keterangan_status = $request->keterangan_status;
        $penjualan->save();

        if ($request->status_order === 'Dalam Pengiriman' && !$penjualan->pengiriman) {
            Pengiriman::create([
                'id_penjualan' => $penjualan->id,
                'no_invoice' => 'INV-' . Str::upper(Str::random(8)),
                'tgl_kirim' => now(),
                'status_kirim' => 'Sedang Dikirim',
                'nama_kurir' => 'Belum Diinput',
                'telepon_kurir' => 'Belum Diinput',
                'keterangan' => 'Pengiriman otomatis dibuat saat status berubah ke Dalam Pengiriman'
            ]);
        }

        return redirect()->back()->with('success', 'Status penjualan berhasil diperbarui.');
    }

    public function laporanIndex(Request $request)
    {
         $query = Penjualan::with(['pelanggan', 'detailPenjualan.Obat']);

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tgl_penjualan', [$request->from, $request->to]);
        }

        $penjualans = $query->get();
        return view('be.laporan.penjualan.index', [
            'title' => 'Laporan Penjualan',
            'penjualans' => $penjualans,
        ]);
    }
        public function exportExcel(Request $request)
        {
            return Excel::download(new PenjualanExport($request->from, $request->to), 'data_penjualan.xlsx');
        }

    public function exportPdf(Request $request)
    {
        $penjualans = Penjualan::with(['detailPenjualan.obat', 'pelanggan'])
        ->when($request->from, fn($q) => $q->whereDate('tgl_penjualan', '>=', $request->from))  // Filter berdasarkan tgl_penjualan
        ->when($request->to, fn($q) => $q->whereDate('tgl_penjualan', '<=', $request->to))    // Filter berdasarkan tgl_penjualan
        ->orderBy('tgl_penjualan', 'asc')  // Urutkan berdasarkan tgl_penjualan
        ->get();

    $from = $penjualans->min('tgl_penjualan') ? \Carbon\Carbon::parse($penjualans->min('tgl_penjualan'))->format('Y-m-d') : 'Semua Data';
    $to = $penjualans->max('tgl_penjualan') ? \Carbon\Carbon::parse($penjualans->max('tgl_penjualan'))->format('Y-m-d') : 'Semua Data';

    $totalSeluruhPenjualan = $penjualans->sum('total_bayar');

    $pdf = PDF::loadView('be.laporan.penjualan.pdf', [
        'penjualans' => $penjualans,
        'totalSeluruhPenjualan' => $totalSeluruhPenjualan,
        'from' => $from,
        'to' => $to,
    ])->setPaper('A4', 'portrait');

    return $pdf->download('laporan_penjualan.pdf');
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
