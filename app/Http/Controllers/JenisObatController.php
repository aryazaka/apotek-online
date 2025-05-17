<?php

namespace App\Http\Controllers;

use App\Models\JenisObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JenisObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('be.jenis-obat.index', [
            'title' => 'Apoteker',
            'datas' => JenisObat::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('be.jenis-obat.create', [
            'title' => 'Apoteker',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis' => 'required|string|max:255',
            'deskripsi_jenis' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image_url')) {
            $validated['image_url'] = $request->file('image_url')->store('foto-jenis', 'public');
        }

        JenisObat::create($validated);

        return redirect()->route('jenis.index')->with('success', 'Jenis obat berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisObat $jeni)
    {
        return view('be.jenis-obat.edit',
        [
            'title' => 'Apoteker',
            'data' => JenisObat::find($jeni->id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisObat $jeni)
    {
        $validated = $request->validate([
            'jenis' => 'required|string|max:255',
            'deskripsi_jenis' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image_url')) {
            if ($jeni['image_url']) {
                Storage::disk('public')->delete($jeni['image_url']);
            }
            $validated['image_url'] = $request->file('image_url')->store('foto-jenis', 'public');
        }

        $jeni->update($validated);

        return redirect()->route('jenis.index')->with('success', 'Jenis obat berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisObat $jeni)
    {
        if ($jeni['image_url']) {
            Storage::disk('public')->delete($jeni['image_url']);
        }

        $jeni->delete();

        return redirect()->route('jenis.index')->with('success', 'Jenis obat berhasil dihapus.');
    }
}
