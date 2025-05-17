<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\Distributor;
use App\Models\DetailPembelian;
use App\Models\Obat;
use Illuminate\Support\Facades\DB;
use App\Exports\PembelianExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd(Pembelian::with('detailPembelian')->get());
        return view('be.pembelian.index', [
            'title' => 'Pembelian',
            'datas' => Pembelian::with('detailPembelian.obat')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('be.pembelian.create', [
            'title' => 'Pembelian',
            'datas' => Pembelian::all(),
            'distributors' => Distributor::all(),
            'obats' => Obat::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nonota' => 'required|unique:pembelian,nonota',
            'tgl_pembelian' => 'required|date',
            'id_distributor' => 'required|exists:distributor,id',
            'total_bayar' => 'required|numeric|min:0',
            'id_obat' => 'required|array',
            'jumlah_beli' => 'required|array',
            'harga_beli' => 'required|array',
            'subtotal' => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            // Simpan ke tabel pembelian
            $pembelian = Pembelian::create([
                'nonota' => $request->nonota,
                'tgl_pembelian' => $request->tgl_pembelian,
                'id_distributor' => $request->id_distributor,
                'total_bayar' => $request->total_bayar,
            ]);

            // Simpan ke detail_pembelian (loop semua array)
            foreach ($request->id_obat as $i => $id_obat) {
                DetailPembelian::create([
                    'id_pembelian' => $pembelian->id,
                    'id_obat' => $id_obat,
                    'jumlah_beli' => $request->jumlah_beli[$i],
                    'harga_beli' => $request->harga_beli[$i],
                    'subtotal' => $request->subtotal[$i],
                ]);
                $obat = Obat::findOrFail($id_obat);
                $obat->stok += $request->jumlah_beli[$i]; // Tambah stok
                $obat->harga_jual = $request->harga_beli[$i];  // Update harga beli
                $obat->save();
            }

            DB::commit();

            return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil disimpan');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
    public function edit(Pembelian $pembelian)
    {
        // dd($pembelian->detailPembelian);
        return view('be.pembelian.edit', [
            'title' => 'Pembelian',
            'data' =>  $pembelian,
            'detail' => $pembelian->detailPembelian,
            'distributors' => Distributor::all(),
            'obats' => Obat::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembelian $pembelian)
{
    $request->validate([
        'nonota' => 'required|unique:pembelian,nonota,' . $pembelian->id,
        'tgl_pembelian' => 'required|date',
        'id_distributor' => 'required|exists:distributor,id',
        'total_bayar' => 'required|numeric|min:0',
        'id_obat' => 'required|array',
        'jumlah_beli' => 'required|array',
        'harga_beli' => 'required|array',
        'subtotal' => 'required|array',
    ]);

    DB::beginTransaction();

    try {

          foreach ($pembelian->detailPembelian as $detail) {
            $obat = Obat::find($detail->id_obat);
            if ($obat) {
                $obat->stok -= $detail->jumlah_beli; 
                $obat->save();
            }
        }
     
        $pembelian->update([
            'nonota' => $request->nonota,
            'tgl_pembelian' => $request->tgl_pembelian,
            'id_distributor' => $request->id_distributor,
            'total_bayar' => $request->total_bayar,
        ]);

        // Hapus detail lama terlebih dahulu
        $pembelian->detailPembelian()->delete();

        // Simpan ulang detail pembelian
        foreach ($request->id_obat as $i => $id_obat) {
            DetailPembelian::create([
                'id_pembelian' => $pembelian->id,
                'id_obat' => $id_obat,
                'jumlah_beli' => $request->jumlah_beli[$i],
                'harga_beli' => $request->harga_beli[$i],
                'subtotal' => $request->subtotal[$i],
            ]);
            $obat = Obat::findOrFail($id_obat);
            $obat->stok += $request->jumlah_beli[$i]; 
            $obat->harga_jual = $request->harga_beli[$i];  
            $obat->save();
        }

        

        DB::commit();
        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil diperbarui');
    } catch (\Throwable $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembelian $pembelian)
{
    DB::beginTransaction();

    try {
        $pembelian = Pembelian::findOrFail($pembelian->id);

        // Hapus detail terlebih dahulu
        $pembelian->detailPembelian()->delete();

        // Hapus pembelian
        $pembelian->delete();

        DB::commit();
        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil dihapus');
    } catch (\Throwable $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Gagal menghapus pembelian: ' . $e->getMessage());
    }
}

 public function laporanIndex(Request $request)
{
    $pembelians = Pembelian::with(['distributor', 'detailPembelian.obat'])
        ->when($request->from, fn($q) => $q->whereDate('tgl_pembelian', '>=', $request->from))
        ->when($request->to, fn($q) => $q->whereDate('tgl_pembelian', '<=', $request->to))
        ->orderBy('tgl_pembelian', 'asc')
        ->get();

    return view('be.laporan.pembelian.index', [
        'title' => 'Laporan Pembelian',
        'pembelians' => $pembelians,
        'from' => $request->from,
        'to' => $request->to,
    ]);
}

public function exportExcel(Request $request)
{
    return Excel::download(new PembelianExport($request->from, $request->to), 'laporan_pembelian.xlsx');
}

public function exportPdf(Request $request)
{
    $pembelians = Pembelian::with(['distributor', 'detailPembelian.obat'])
        ->when($request->from, fn($q) => $q->whereDate('tgl_pembelian', '>=', $request->from))
        ->when($request->to, fn($q) => $q->whereDate('tgl_pembelian', '<=', $request->to))
        ->orderBy('tgl_pembelian', 'asc')
        ->get();

    $from = $pembelians->min('tgl_pembelian') ? \Carbon\Carbon::parse($pembelians->min('tgl_pembelian'))->format('Y-m-d') : 'Semua Data';
    $to = $pembelians->max('tgl_pembelian') ? \Carbon\Carbon::parse($pembelians->max('tgl_pembelian'))->format('Y-m-d') : 'Semua Data';

    $totalSeluruhPembelian = $pembelians->sum('total_bayar');

    $pdf = PDF::loadView('be.laporan.pembelian.pdf', [
        'pembelians' => $pembelians,
        'totalSeluruhPembelians' => $totalSeluruhPembelian,
        'from' => $from,
        'to' => $to,
    ])->setPaper('A4', 'landscape');

    return $pdf->download('laporan_pembelian.pdf');
}
}
