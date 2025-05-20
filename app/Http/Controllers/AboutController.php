<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Penjualan;
use Illuminate\Support\Facades\Auth;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idPelanggan = Auth::guard('pelanggan')->check()
            ? Auth::guard('pelanggan')->user()->id
            : null;

        $pesananAktif = Penjualan::where('id_pelanggan', $idPelanggan)
            ->whereIn('status_order', ['Menunggu Konfirmasi', 'Diproses', 'Menunggu Kurir', 'Dalam Pengiriman'])
            ->exists();

        return view('fe.about.index', [
            'title' => 'About',
            'user' => Auth::guard('pelanggan')->user(),
            'keranjangs' => Keranjang::where('id_pelanggan', $idPelanggan)
                ->with('obat')
                ->get(),
            'pesananAktif' => $pesananAktif,
        ]);
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
