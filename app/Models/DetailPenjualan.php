<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    /** @use HasFactory<\Database\Factories\DetailPenjualanFactory> */
    use HasFactory;
    protected $table = "detail_penjualan";

    protected $fillable = [
        'id_penjualan',
        'id_obat',
        'jumlah_beli',
        'harga_beli',
        'subtotal'
    ];

    public function obat()
{
    return $this->belongsTo(Obat::class, 'id_obat');
}

public function penjualan()
{
    return $this->belongsTo(Penjualan::class, 'id_penjualan');
}
}
