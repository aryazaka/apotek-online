<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    /** @use HasFactory<\Database\Factories\PembelianFactory> */
    use HasFactory;

    protected $table = 'pembelian';

    protected $fillable = [
        'nonota',
        'tgl_pembelian',
        'total_bayar',
        'id_distributor',
    ];

    public function distributor()
    {
        return $this->belongsTo(Distributor::class, 'id_distributor');
    }

    public function detailPembelian()
{
    return $this->hasMany(DetailPembelian::class, 'id_pembelian');
}
}
