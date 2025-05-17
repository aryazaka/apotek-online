<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Distributor;

class DistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('be.distributor.index', [
            'title' => 'Distributor',
            'datas' => Distributor::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('be.distributor.create', [
            'title' => 'Distributor',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_distributor' => 'required|string|max:50',
            'telepon' => 'max:50',
            'alamat' => 'max:255',
        ]);

        Distributor::create($validated);

        return redirect()->route('distributor.index')->with('success', 'Distributor berhasil ditambahkan.');
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
    public function edit(Distributor $distributor)
    {
        return view('be.distributor.edit',
        [
            'title' => 'Distributor',
            'data' => Distributor::find($distributor->id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Distributor $distributor , Request $request)
    {
        $validated = $request->validate([
            'nama_distributor' => 'required|string|max:50',
            'telepon' => 'max:50',
            'alamat' => 'max:255',
        ]);

        $distributor->update($validated);

        return redirect()->route('distributor.index')->with('success', 'Distributor berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Distributor $distributor)
    {
        $distributor->delete();

        return redirect()->route('distributor.index')->with('success', 'Distributor berhasil dihapus.');
    }
}
