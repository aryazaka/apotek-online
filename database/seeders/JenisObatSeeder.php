<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\JenisObat;


class JenisObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $jenis1 = 'obat bebas.png';
         $jenis2 = 'obat bebas terbatas.png';
         $jenis3 = 'obat keras.png';

        // Simpan gambar ke folder 'public/jenis-obat'
        $obatBebas = 'foto-jenis/' . Str::random(10) . '_' . $jenis1;
        Storage::disk('public')->put($obatBebas, file_get_contents(database_path('seeders/images/' . $jenis1)));

        $obatBebasTerbatas = 'foto-jenis/' . Str::random(10) . '_' . $jenis2;
        Storage::disk('public')->put($obatBebasTerbatas, file_get_contents(database_path('seeders/images/' . $jenis2)));

        $obatKeras = 'foto-jenis/' . Str::random(10) . '_' . $jenis3;
        Storage::disk('public')->put($obatKeras, file_get_contents(database_path('seeders/images/' . $jenis3)));

        // Simpan data ke database
        JenisObat::create([
            'jenis' => 'Obat Bebas',
            'deskripsi_jenis' => 'Obat Bebas adalah obat yang dijual bebas di pasaran dan dapat dibeli tanpa resep dokter.',
            'image_url' => $obatBebas,
        ]);

        JenisObat::create([
            'jenis' => 'Obat Bebas Terbatas',
            'deskripsi_jenis' => 'Obat Bebas Terbatas adalah obat yang dapat dibeli secara bebas tanpa menggunakan resep dokter, namun mempunyai peringatan khusus saat menggunakannya.',
            'image_url' => $obatBebasTerbatas,
        ]);

        JenisObat::create([
            'jenis' => 'Obat Keras',
            'deskripsi_jenis' => 'Obat Keras adalah obat yang hanya dapat diperoleh dengan resep dokter.',
            'image_url' => $obatKeras,
        ]);
    }
}
