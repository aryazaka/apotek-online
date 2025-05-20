<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Penjualan;
use Illuminate\Support\Facades\Auth;
use App\Models\Pelanggan;

class ProfilePelangganController extends Controller
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

        return view('fe.profile.index', [
            'title' => 'Profile',
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
    $pelanggan = Pelanggan::findOrFail($id);

    $request->validate([
        'nama_pelanggan' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'no_telp' => 'required|string|max:20',
        'alamat1' => 'required|string|max:255',
        'kodepos1' => 'required|string|max:10',
        'propinsi1' => 'required|string|max:100',
        'kota1' => 'required|string|max:100',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'url_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $data = $request->except(['foto', 'url_ktp']);

    if ($request->hasFile('foto')) {
        $data['foto'] = $request->file('foto')->store('foto-pelanggan', 'public');
    }
    if ($request->hasFile('url_ktp')) {
        $data['url_ktp'] = $request->file('url_ktp')->store('foto-ktp', 'public');
    }

    $pelanggan->update($data);

    return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
