<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123'), 
            'jabatan' => 'admin',     
        ]);

        User::factory()->create([
            'name' => 'karyawan',
            'email' => 'karyawan@gmail.com',
            'password' => Hash::make('123'), 
            'jabatan' => 'karyawan',     
        ]);

        User::factory()->create([
            'name' => 'apoteker',
            'email' => 'apoteker@gmail.com',
            'password' => Hash::make('123'), 
            'jabatan' => 'apoteker',     
        ]);

        User::factory()->create([
            'name' => 'kurir',
            'email' => 'kurir@gmail.com',
            'password' => Hash::make('123'), 
            'jabatan' => 'kurir',     
        ]);

        User::factory()->create([
            'name' => 'kasir',
            'email' => 'kasir@gmail.com',
            'password' => Hash::make('123'), 
            'jabatan' => 'kasir',     
        ]);

        User::factory()->create([
            'name' => 'Jaka',
            'email' => 'pemilik@gmail.com',
            'password' => Hash::make('123'), 
            'jabatan' => 'pemilik',     
        ]);
    }
}
