<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
     protected $fillable = ['nama', 'harga', 'stok'];

    // Relasi ke DetailPenjualan
    public function details()
    {
        return $this->hasMany(\App\Models\DetailPenjualan::class, 'produk_id');
    }
}