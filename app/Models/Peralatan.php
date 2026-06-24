<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peralatan extends Model
{
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kondisi',
        'qr_code',
    ];

    public function kerusakan()
    {
        return $this->hasMany(
            Kerusakan::class
        );
    }
}
