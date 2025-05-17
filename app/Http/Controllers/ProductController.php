<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Obat;
use App\Models\JenisObat;
use App\Models\Keranjang;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Obat::with('jenisObat');

    if ($request->filled('search')) {
        $query->where('nama_obat', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('jenis_id')) {
        $query->where('id_jenis_obat', $request->jenis_id);
    }

    $products = $query->paginate(12)->appends($request->query()); 
    $categories = JenisObat::all();

    $idPelanggan = Auth::guard('pelanggan')->check() 
    ? Auth::guard('pelanggan')->user()->id 
    : null;

    return view('fe.product.index', [
        'title' => 'Produk',
        'user' => Auth::guard('pelanggan')->user(),
        'categories' => $categories,
        'products' => $products,
        'search' => $request->search,
        'selectedJenis' => $request->jenis_id,
        'keranjangs' => Keranjang::where('id_pelanggan', $idPelanggan)
                ->with('obat')
                ->get(),
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
        $produk = Obat::with('jenisObat')->findOrFail($id);

        $idPelanggan = Auth::guard('pelanggan')->check() 
        ? Auth::guard('pelanggan')->user()->id 
        : null;

        $relatedProducts = Obat::where('id_jenis_obat', $produk->id_jenis_obat)
            ->where('id', '!=', $produk->id)
            ->latest()
            ->take(4)
            ->get();
    
        return view('fe.detail-produk.index', [
            'title' => 'Detail Produk',
            'user' => Auth::guard('pelanggan')->user(),
            'produk' => $produk,
            'relatedProducts' => $relatedProducts,
            'keranjangs' => Keranjang::where('id_pelanggan', $idPelanggan)
                ->with('obat')
                ->get(),
        ]);
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
