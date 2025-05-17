<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisObat extends Model
{
    /** @use HasFactory<\Database\Factories\JenisObatFactory> */
    use HasFactory;
    protected $table = 'jenis_obat';

    protected $fillable = [
        'jenis',
        'deskripsi_jenis',
        'image_url',
    ];


    public function obats()
{
    return $this->hasMany(Obat::class, 'id_jenis_obat');
}
}
