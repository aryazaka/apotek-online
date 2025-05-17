<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PelangganExport;

class PelanggansController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('be.pelanggans.index', [
            'title' => 'Data Pelanggan',
            'datas' => Pelanggan::all(),
        ]); 
    }

    public function LaporanIndex(Request $request)
    {
         $query = Pelanggan::query();

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        $pelanggans = $query->get();
        return view('be.laporan.pelanggan.index', [
            'title' => 'Laporan Pelanggan',
            'datas' => $pelanggans,
        ]); 
    }

     public function exportExcel(Request $request)
        {
            return Excel::download(new PelangganExport($request->from, $request->to), 'Laporan_Data_Pelanggan.xlsx');
        }

        public function exportPdf(Request $request)
    {
        $pelanggans = Pelanggan::query()
        ->when($request->from, fn($q) => $q->whereDate('created_at', '>=', $request->from))  // Filter 
        ->when($request->to, fn($q) => $q->whereDate('created_at', '<=', $request->to))    // Filter 
        ->orderBy('created_at', 'asc')  
        ->get();

    $from = $pelanggans->min('created_at') ? \Carbon\Carbon::parse($pelanggans->min('created_at'))->format('Y-m-d') : 'Semua Data';
    $to = $pelanggans->max('created_at') ? \Carbon\Carbon::parse($pelanggans->max('created_at'))->format('Y-m-d') : 'Semua Data';


    $pdf = PDF::loadView('be.laporan.pelanggan.pdf', [
        'pelanggans' => $pelanggans,
        'from' => $from,
        'to' => $to,
    ])->setPaper('A4', 'portrait');

    return $pdf->download('Laporan_Data_Pelanggan.pdf');
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
