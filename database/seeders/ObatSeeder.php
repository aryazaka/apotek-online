<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\JenisObat;
use App\Models\Obat;


class ObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fotoTolakAngin1 = 'tolak angin.jpeg';
        $fotoTolakAngin2 = 'tolak angin 2.jpg';
        $fotoTolakAngin3 = 'tolak angin 3.jpg';
        $jenisObatBebas = JenisObat::where('jenis', 'Obat Bebas')->first();

        // Simpan gambar ke folder 'public/jenis-obat'
        $tolakAngin1 = 'foto-obat/' . Str::random(10) . '_' . $fotoTolakAngin1;
        Storage::disk('public')->put($tolakAngin1, file_get_contents(database_path('seeders/images/' . $fotoTolakAngin1)));

        $tolakAngin2 = 'foto-obat/' . Str::random(10) . '_' . $fotoTolakAngin2;
        Storage::disk('public')->put($tolakAngin2, file_get_contents(database_path('seeders/images/' . $fotoTolakAngin2)));

        $tolakAngin3 = 'foto-obat/' . Str::random(10) . '_' . $fotoTolakAngin3;
        Storage::disk('public')->put($tolakAngin3, file_get_contents(database_path('seeders/images/' . $fotoTolakAngin3)));

        $fotoBetadine1 = 'betadine.jpg';
        $fotoBetadine2 = 'betadine 2.jpg';
        $fotoBetadine3 = 'betadine 3.jpg';
        $jenisObatBebasTerbatas = JenisObat::where('jenis', 'Obat Bebas Terbatas')->first();

        // Simpan gambar ke folder 'public/jenis-obat'
        $betadine1 = 'foto-obat/' . Str::random(10) . '_' . $fotoBetadine1;
        Storage::disk('public')->put($betadine1, file_get_contents(database_path('seeders/images/' . $fotoBetadine1)));

        $betadine2 = 'foto-obat/' . Str::random(10) . '_' . $fotoBetadine2;
        Storage::disk('public')->put($betadine2, file_get_contents(database_path('seeders/images/' . $fotoBetadine2)));

        $betadine3 = 'foto-obat/' . Str::random(10) . '_' . $fotoBetadine3;
        Storage::disk('public')->put($betadine3, file_get_contents(database_path('seeders/images/' . $fotoBetadine3)));

        $fotoMefanat1 = 'asam mefanat.jpg';
        $fotoMefanat2 = 'asam mefanat 2.jpg';
        $fotoMefanat3 = 'asam mefanat 3.jpg';
        $jenisObatKeras = JenisObat::where('jenis', 'Obat Keras')->first();

        // Simpan gambar ke folder 'public/jenis-obat'
        $mefanat1 = 'foto-obat/' . Str::random(10) . '_' . $fotoMefanat1;
        Storage::disk('public')->put($mefanat1, file_get_contents(database_path('seeders/images/' . $fotoMefanat1)));

        $mefanat2 = 'foto-obat/' . Str::random(10) . '_' . $fotoMefanat2;
        Storage::disk('public')->put($mefanat2, file_get_contents(database_path('seeders/images/' . $fotoMefanat2)));

        $mefanat3 = 'foto-obat/' . Str::random(10) . '_' . $fotoMefanat3;
        Storage::disk('public')->put($mefanat3, file_get_contents(database_path('seeders/images/' . $fotoMefanat3)));

        Obat::create([
            'nama_obat' => 'Tolak Angin',
            'id_jenis_obat' => $jenisObatBebas->id,
            'harga_jual' => 5000,
            'deskripsi_obat' => 'Tolak Angin Cair mengandung kombinasi dari beberapa bahan herbal, seperti buah adas, kayu ules, daun cengkeh, jahe, daun mint, dan madu.',
            'foto1' => $tolakAngin1,
            'foto2' => $tolakAngin2,
            'foto3' => $tolakAngin3,
            'stok' => 10
        ]);

        Obat::create([
            'nama_obat' => 'Betadine',
            'id_jenis_obat' => $jenisObatBebasTerbatas->id,
            'harga_jual' => 10000,
            'deskripsi_obat' => 'BETADINE SOLUTION merupakan antiseptik luka dengan kandungan Povidone Iodine 10% untuk membunuh kuman penyebab infeksi.',
            'foto1' => $betadine1,
            'foto2' => $betadine2,
            'foto3' => $betadine3,
            'stok' => 10
        ]);

        Obat::create([
            'nama_obat' => 'Asam Mefanat',
            'id_jenis_obat' => $jenisObatKeras->id,
            'harga_jual' => 15000,
            'deskripsi_obat' => 'Asam mefenamat adalah obat penghilang nyeri. Obat ini dapat digunakan untuk meredakan nyeri haid, sakit gigi, nyeri otot, sakit kepala, hingga nyeri yang timbul setelah operasi.',
            'foto1' => $mefanat1,
            'foto2' => $mefanat2,
            'foto3' => $mefanat3,
            'stok' => 10
        ]);
    }
}
