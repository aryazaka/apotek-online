<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    /** @use HasFactory<\Database\Factories\DistributorFactory> */
    use HasFactory;

    protected $table = 'distributor';

    protected $fillable = [
        'nama_distributor',
        'telepon',
        'alamat',
    ];
}
