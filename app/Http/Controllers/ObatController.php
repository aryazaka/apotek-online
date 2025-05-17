<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Obat;
use App\Models\JenisObat;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('be/obat/index', [
            'title' => 'Apoteker',
            'datas' => Obat::with(['jenisObat', 'detailPembelian'])->get(),
            'jenis_obat' => JenisObat::all(), 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('be/obat/create', [
            'title' => 'Apoteker',
            'jenis_obat' => JenisObat::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255|unique:obat,nama_obat,',
            'id_jenis_obat' => 'required|exists:jenis_obat,id',
            'harga_jual' => 'required|integer',
            'stok' => 'required|integer',
            'deskripsi_obat' => 'nullable|string',
            'foto1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto1')) {
            $validated['foto1'] = $request->file('foto1')->store('foto-obat', 'public');
        }
        if ($request->hasFile('foto2')) {
            $validated['foto2'] = $request->file('foto2')->store('foto-obat', 'public');
        }
        if ($request->hasFile('foto3')) {
            $validated['foto3'] = $request->file('foto3')->store('foto-obat', 'public');
        }

        Obat::create($validated);

        return redirect()->route('obat.index')->with('success', 'Obat berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Obat $obat)
    {
        return view('be/obat/edit', [
            'title' => 'Apoteker',
            'data' => $obat,
            'jenis_obat' => JenisObat::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Obat $obat)
    {
        $selfObat = Obat::findOrFail($obat->id);
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255|unique:obat,nama_obat,' . $selfObat->id,
            'id_jenis_obat' => 'required|exists:jenis_obat,id',
            'harga_jual' => 'required|integer',
            'stok' => 'required|integer',
            'deskripsi_obat' => 'nullable|string',
            'foto1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto1')) {
            if ($obat->foto1) {
                Storage::disk('public')->delete($obat->foto1);
            }
            $validated['foto1'] = $request->file('foto1')->store('foto-obat', 'public');
        }

        if ($request->hasFile('foto2')) {
            if ($obat->foto2) {
                Storage::disk('public')->delete($obat->foto2);
            }
            $validated['foto2'] = $request->file('foto2')->store('foto-obat', 'public');
        }

        if ($request->hasFile('foto3')) {
            if ($obat->foto3) {
                Storage::disk('public')->delete($obat->foto3);
            }
            $validated['foto3'] = $request->file('foto3')->store('foto-obat', 'public');
        }

        $obat->update($validated);

        return redirect()->route('obat.index')->with('success', 'Obat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Obat $obat)
    {
    
        if ($obat->foto1) {
            Storage::disk('public')->delete($obat->foto1);
        }
        if ($obat->foto2) {
            Storage::disk('public')->delete($obat->foto2);
        }
        if ($obat->foto3) {
            Storage::disk('public')->delete($obat->foto3);
        }

        $obat->delete();

        return redirect()->route('obat.index')->with('success', 'Obat berhasil dihapus.');
    }

    public function updateMargin(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:obat,id',
            'margin' => 'required|numeric|min:0',
            'harga_beli' => 'required|numeric|min:0',
        ]);
    
        // Ambil data obat
        $obat = Obat::findOrFail($validated['id']);
    
        // Hitung dan simpan
        $obat->margin = $validated['margin'];
        $totalJual = $validated['harga_beli'] + $validated['harga_beli'] * $validated['margin'] / 100;
        $obat->harga_jual = $totalJual;
        $obat->save();
    
        return redirect()->back()->with('success', 'Margin penjualan berhasil diubah!');
    }
    
}
