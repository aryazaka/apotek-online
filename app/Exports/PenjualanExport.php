<?php

namespace App\Exports;

use App\Models\Penjualan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class PenjualanExport implements FromView
{
    protected $from;
    protected $to;

    public function __construct($from = null, $to = null)
    {
        $this->from = $from;
        $this->to = $to;
    }
     public function view(): View
    {
        $query = Penjualan::with(['pelanggan', 'detailPenjualan.Obat']);

        if ($this->from && $this->to) {
            $query->whereBetween('tgl_penjualan', [$this->from, $this->to]);
            $from = \Carbon\Carbon::parse($this->from)->translatedFormat('d F Y');
            $to = \Carbon\Carbon::parse($this->to)->translatedFormat('d F Y');
        } else {
            $first = Penjualan::min('tgl_penjualan');
            $last = Penjualan::max('tgl_penjualan');
            $query->whereBetween('tgl_penjualan', [$first, $last]);
            $from = \Carbon\Carbon::parse($first)->translatedFormat('d F Y');
            $to = \Carbon\Carbon::parse($last)->translatedFormat('d F Y');
        }

        $penjualans = $query->orderBy('tgl_penjualan', 'asc')->get();

        $totalSeluruhPenjualan = $penjualans->sum('total_bayar');

        return view('be.laporan.penjualan.excel', [
            'penjualans' => $penjualans,
            'totalSeluruhPenjualan' => $totalSeluruhPenjualan,
            'from' => $from,
            'to' => $to,
        ]);
    }
}
