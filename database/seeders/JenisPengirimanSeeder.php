<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisPengiriman;

class JenisPengirimanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $data = [
            [
                'jenis_kirim' => 'ekonomi',
                'nama_ekspedisi' => 'JNE',
                'harga' => 5000,
            ],
            [
                'jenis_kirim' => 'standar',
                'nama_ekspedisi' => 'J&T Express',
                'harga' => 8000,
            ],
            [
                'jenis_kirim' => 'same day',
                'nama_ekspedisi' => 'SiCepat',
                'harga' => 10000,
            ],
        ];

        foreach ($data as $item) {
            JenisPengiriman::create($item);
        }
    }
}
