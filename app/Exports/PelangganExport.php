<?php

namespace App\Exports;

use App\Models\Pelanggan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PelangganExport implements FromView
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
         $query = Pelanggan::query();

        if ($this->from && $this->to) {
            $query->whereBetween('created_at', [$this->from, $this->to]);
            $from = \Carbon\Carbon::parse($this->from)->translatedFormat('d F Y');
            $to = \Carbon\Carbon::parse($this->to)->translatedFormat('d F Y');
        } else {
            $first = Pelanggan::min('created_at');
            $last = Pelanggan::max('created_at');
            $query->whereBetween('created_at', [$first, $last]);
            $from = \Carbon\Carbon::parse($first)->translatedFormat('d F Y');
            $to = \Carbon\Carbon::parse($last)->translatedFormat('d F Y');
        }

        $pelanggans = $query->orderBy('created_at', 'asc')->get();


        return view('be.laporan.pelanggan.excel', [
            'pelanggans' => $pelanggans,
            'from' => $from,
            'to' => $to,
        ]);
    }
}
