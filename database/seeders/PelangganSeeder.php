<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        $fotoProfil = 'pp.jpg';
        $profil = 'foto-pelanggan/' . Str::random(10) . '_' . $fotoProfil;
        Storage::disk('public')->put($profil, file_get_contents(database_path('seeders/images/' . $fotoProfil)));

        $fotoKtp = 'kartu pelajar.jpg';
        $ktp = 'foto-pelanggan/' . Str::random(10) . '_' . $fotoKtp;
        Storage::disk('public')->put($ktp, file_get_contents(database_path('seeders/images/' . $fotoKtp)));


        Pelanggan::create([
            'nama_pelanggan' => 'aryazaka',
            'email' => 'jaka@gmail.com',
            'katakunci' => Hash::make('12345678'),
            'no_telp' => '081234567890',
            'alamat1' => 'Jl. BojongBaru No. 123',
            'kota1' => 'Bogor',
            'propinsi1' => 'Jawa Barat',
            'kodepos1' => '40123',
            'alamat2' => null,
            'kota2' => null,
            'propinsi2' => null,
            'kodepos2' => null,
            'alamat3' => null,
            'kota3' => null,
            'propinsi3' => null,
            'kodepos3' => null,
            'foto' => $profil,
            'url_ktp' => $ktp,
        ]);
    }
}
