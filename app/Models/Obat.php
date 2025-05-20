<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\JenisObat;

class Obat extends Model
{
    /** @use HasFactory<\Database\Factories\ObatFactory> */
    use HasFactory;
    protected $table = "obat";

    protected $fillable = [
        'nama_obat',
        'id_jenis_obat',
        'harga_jual',
        'margin',
        'deskripsi_obat',
        'foto1',
        'foto2',
        'foto3',
        'stok'
    ];

    public function jenisObat()
    {
        return $this->belongsTo(JenisObat::class, 'id_jenis_obat', 'id');
    }

public function detailPembelian()
{
    return $this->hasOne(DetailPembelian::class, 'id_obat')->latestOfMany();
}
};
