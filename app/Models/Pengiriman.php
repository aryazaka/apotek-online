<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    /** @use HasFactory<\Database\Factories\PengirimanFactory> */
    use HasFactory;

    protected $table = "pengiriman";

    protected $fillable = [
        'id_penjualan',
        'no_invoice',
        'tgl_kirim',
        'tgl_tiba',
        'status_kirim', 
        'nama_kurir',
        'telepon_kurir',
        'bukti_foto',
        'keterangan',
    ];

}
