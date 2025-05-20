<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penjualan;
use App\Models\Pengiriman;
use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Obat;
use App\Models\Distributor;
use App\Models\Pembelian;   
use App\Models\JenisObat;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        switch (Auth::user()->jabatan) {
            case 'admin':
                 // Pengguna berdasarkan role
        $jumlahAdmin = User::where('jabatan', 'admin')->count();
        $jumlahKurir = User::where('jabatan', 'kurir')->count();
        $jumlahKaryawan = User::where('jabatan', 'karyawan')->count();
        $jumlahApoteker = User::where('jabatan', 'apoteker')->count();
        $jumlahKasir = User::where('jabatan', 'kasir')->count();
        $jumlahPemilik = User::where('jabatan', 'pemilik')->get();
        $jumlahManagement = User::all()->count();
        $jumlahPelanggan = Pelanggan::all()->count();

                return view(
                    'be.dashboard.admin',
                    [
                        'title' => 'Dashboard',
                        'jumlahManagement' => $jumlahManagement,
                        'jumlahPelanggan' => $jumlahPelanggan,
                        'jumlahAdmin' => $jumlahAdmin,
                        'jumlahKurir' => $jumlahKurir,
                        'jumlahKaryawan' => $jumlahKaryawan,
                        'jumlahApoteker' => $jumlahApoteker,
                        'jumlahKasir' => $jumlahKasir,
                        'jumlahPemilik' => $jumlahPemilik,
                    ]
                );
            case 'karyawan':
                $jumlahPenjualan = Penjualan::whereIn('status_order', ['Diproses', 'Menunggu Kurir', 'Dibatalkan Pembeli', 'Dibatalkan Penjual', 'Bermasalah', 'Selesai'])->count();
                $jumlahObat = Obat::all()->count();
                
                return view(
                    'be.dashboard.karyawan',
                    [
                        'title' => 'Dashboard',
                        'jumlahPenjualan' => $jumlahPenjualan,
                        'jumlahObat' => $jumlahObat,
                        
                    ]
                );
            case 'apoteker':
                $jumlahObat = Obat::all()->count();
                $jumlahDistributor = Distributor::all()->count();
                $jumlahJenisObat = JenisObat::all()->count();
                $jumlahPembelian = Pembelian::all()->count();
                return view(
                    'be.dashboard.apoteker',
                    [
                        'title' => 'Dashboard',
                        'jumlahObat' => $jumlahObat,
                        'jumlahDistributor' => $jumlahDistributor,
                        'jumlahPembelian' => $jumlahPembelian,
                        'jumlahJenisObat' => $jumlahJenisObat,
                    ]
                );
            case 'kasir':
                $jumlahObat = Obat::all()->count();
                $jumlahPenjualan = Penjualan::whereIn('status_order', ['Diproses', 'Menunggu Konfirmasi', 'Dibatalkan Pembeli', 'Dibatalkan Penjual', 'Bermasalah', 'Selesai'])->count();
                return view(
                    'be.dashboard.kasir',
                    [
                        'title' => 'Dashboard',
                        'jumlahObat' => $jumlahObat,
                        'jumlahPenjualan' => $jumlahPenjualan
                    ]
                );
            case 'kurir':
                $kurir = Auth::user()->name;
                $belumDiambil = Penjualan::with(['pelanggan', 'pengiriman'])
                    ->where('status_order', 'Menunggu Kurir')
                    ->get();

                $sedangDikirim = Pengiriman::with('penjualan')
                    ->where('status_kirim', 'Sedang Dikirim')
                    ->where('nama_kurir', $kurir)
                    ->get();

                $tibaDitujuan = Pengiriman::with('penjualan')
                    ->where('status_kirim', 'Tiba Di Tujuan')
                    ->where('nama_kurir', $kurir)
                    ->get();
                return view(
                    'be.dashboard.kurir',
                    [
                        'title' => 'Dashboard',
                        'totalPengiriman' => Pengiriman::where('nama_kurir', $kurir)->count(),
                        'jumlahBelumDiambil' => $belumDiambil->count(),
                        'jumlahDalamPengiriman' => $sedangDikirim->count(),
                        'jumlahSampai' => $tibaDitujuan->count(),
                    ]
                );
            case 'pemilik':
                $jumlahPembelian = Pembelian::all()->count();
                $jumlahPenjualan = Penjualan::all()->count();
                $jumlahPelanggan = Pelanggan::all()->count();
                return view(
                    'be.dashboard.pemilik',
                    [
                        'title' => 'Dashboard',
                        'jumlahPembelian' => $jumlahPembelian,
                        'jumlahPenjualan' => $jumlahPenjualan,
                        'jumlahPelanggan' => $jumlahPelanggan
                    ]
                );
        }
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
