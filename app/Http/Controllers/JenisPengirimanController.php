<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisPengiriman;
use Illuminate\Support\Facades\Storage;

class JenisPengirimanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = JenisPengiriman::all();
        return view('be.jenis-pengiriman.index', [
            'title' => 'Jenis Pengiriman',
            'datas' => $datas,
        ]);
    }

    public function create()
    {
        return view('be.jenis-pengiriman.create',[
            'title' => 'Jenis Pengiriman',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_kirim' => 'required|string|max:255',
            'nama_ekspedisi' => 'required|string|max:255',
            'logo_ekspedisi' => 'nullable|image|max:2048',
            'harga' => 'nullable|numeric',
        ]);

        if ($request->hasFile('logo_ekspedisi')) {
            $validated['logo_ekspedisi'] = $request->file('logo_ekspedisi')->store('logo-ekspedisi', 'public');
        }

        JenisPengiriman::create($validated);

        return redirect()->route('jenis-pengiriman.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit(JenisPengiriman $jenis_pengiriman)
    {
        return view('be.jenis-pengiriman.edit',  [
            'title' => 'Edit Jenis Pengiriman',
            'data' => $jenis_pengiriman,
        ]);
    }

    public function update(Request $request, JenisPengiriman $jenis_pengiriman)
    {
        $validated = $request->validate([
            'jenis_kirim' => 'required|string|max:255',
            'nama_ekspedisi' => 'required|string|max:255',
            'logo_ekspedisi' => 'nullable|image|max:2048',
            'harga' => 'nullable|numeric',
        ]);

        if ($request->hasFile('logo_ekspedisi')) {
            // Hapus lama jika ada
            if ($jenis_pengiriman->logo_ekspedisi) {
                Storage::disk('public')->delete($jenis_pengiriman->logo_ekspedisi);
            }
            $validated['logo_ekspedisi'] = $request->file('logo_ekspedisi')->store('logo-ekspedisi', 'public');
        }

        $jenis_pengiriman->update($validated);

        return redirect()->route('jenis-pengiriman.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(JenisPengiriman $jenis_pengiriman)
    {
        if ($jenis_pengiriman->logo_ekspedisi) {
            Storage::disk('public')->delete($jenis_pengiriman->logo_ekspedisi);
        }

        $jenis_pengiriman->delete();

        return redirect()->route('jenis-pengiriman.index')->with('success', 'Data berhasil dihapus.');
    }
}
