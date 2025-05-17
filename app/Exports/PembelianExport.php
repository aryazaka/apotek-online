<?php

namespace App\Exports;

use App\Models\Pembelian;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PembelianExport implements FromView
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
         $query = Pembelian::with(['distributor', 'detailPembelian.obat']);

        if ($this->from && $this->to) {
            $query->whereBetween('tgl_pembelian', [$this->from, $this->to]);
            $from = \Carbon\Carbon::parse($this->from)->translatedFormat('d F Y');
            $to = \Carbon\Carbon::parse($this->to)->translatedFormat('d F Y');
        } else {
            $first = Pembelian::min('tgl_pembelian');
            $last = Pembelian::max('tgl_pembelian');
            $query->whereBetween('tgl_pembelian', [$first, $last]);
            $from = \Carbon\Carbon::parse($first)->translatedFormat('d F Y');
            $to = \Carbon\Carbon::parse($last)->translatedFormat('d F Y');
        }

        $pembelians = $query->orderBy('tgl_pembelian', 'asc')->get();

        $totalSeluruhPembelian = $pembelians->sum('total_bayar');

        return view('be.laporan.pembelian.excel', [
            'pembelians' => $pembelians,
            'totalSeluruhPembelians' => $totalSeluruhPembelian,
            'from' => $from,
            'to' => $to,
        ]);
    }
}
