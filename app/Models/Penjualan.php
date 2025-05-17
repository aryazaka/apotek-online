<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    /** @use HasFactory<\Database\Factories\PenjualanFactory> */
    use HasFactory;
    protected $table = "penjualan";

    protected $fillable = [
        'kode_transaksi',
        'snap_token',
        'id_metode_bayar',
        'tgl_penjualan',
        'url_resep',
        'ongkos_kirim',
        'biaya_app',
        'total_bayar',
        'status_order',
        'keterangan_status',
        'id_jenis_kirim',
        'id_pelanggan'
    ];

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_penjualan');
    }
    

public function pelanggan()
{
    return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
}

public function pengiriman()
{
    return $this->hasOne(Pengiriman::class, 'id_penjualan');
}


}
