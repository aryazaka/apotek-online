<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class AuthPelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getLogin(){
        if (Auth::guard('pelanggan')->check()) {
            return back();
        }
        return view('fe.auth.login', [
            'title' => 'Login Pelanggan',
        ]);
    }

    public function getRegister(){
        return view('fe.auth.register', [
            'title' => 'Register Pelanggan',
        ]);
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    
    public function store(Request $request){

    }

    /**
     * Store a newly created resource in storage.
     */
    public function postRegister(Request $request)
    {
        if (Pelanggan::where('email', $request->email)->exists()) {
            // Menyimpan pesan di session jika email sudah digunakan
            return redirect()->back()->with('failed', 'Email sudah digunakan. Silakan gunakan email lain.');
        }
    $validated = $request->validate([
        'nama_pelanggan' => 'required|string|max:255',
        'email' => 'required|email|unique:pelanggan,email',
        'katakunci' => 'required|min:8',
        'no_telp' => 'required|string|max:20',

        // Alamat
        'alamat1' => 'required|string|max:255',
        'kota1' => 'required|string|max:100',
        'propinsi1' => 'required|string|max:100',
        'kodepos1' => 'required|string|max:20',

        'alamat2' => 'nullable|string|max:255',
        'kota2' => 'nullable|string|max:100',
        'propinsi2' => 'nullable|string|max:100',
        'kodepos2' => 'nullable|string|max:20',

        'alamat3' => 'nullable|string|max:255',
        'kota3' => 'nullable|string|max:100',
        'propinsi3' => 'nullable|string|max:100',
        'kodepos3' => 'nullable|string|max:20',

        'foto' => 'nullable|image|max:2048',
        'url_ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);
    // dd($validated);
   

    try {
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('foto-pelanggan', 'public');
        }
        if ($request->hasFile('url_ktp')) {
            $validated['url_ktp'] = $request->file('url_ktp')->store('foto-ktp', 'public');
        }
    
        // Hash password sebelum disimpan
        $validated['katakunci'] = Hash::make($validated['katakunci']);
    
        Log::info('Data validated', $validated);
    
        Pelanggan::create($validated);
    
        return redirect()->route('getLogin.pelanggan')->with('success', 'Registrasi berhasil. Silakan login.');
    } catch (\Exception $e) {
        Log::error('Gagal register: ' . $e->getMessage());
        return back()->with('error', 'Terjadi kesalahan saat registrasi');
    }
    
}

public function postLogin(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'katakunci' => 'required|string',
    ]);

    $pelanggan = Pelanggan::where('email', $request->email)->first();

    if (!$pelanggan) {
        return back()->withInput()->with('failed', 'Email tidak ditemukan.');
    }

    if (!Hash::check($request->katakunci, $pelanggan->katakunci)) {
        return back()->withInput()->with('failed', 'Password salah.');
    }

    // Simpan data pelanggan ke session manual
    Auth::guard('pelanggan')->login($pelanggan);

    return redirect()->route('home.index');
}

public function logout(Request $request)
{
    Auth::guard('pelanggan')->logout();

    $request->session()->forget('pelanggan');
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('getLogin.pelanggan');
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
