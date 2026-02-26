<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'total',
        'uang_bayar',
        'kembali',
        'pelanggan_id',
        'kasir_id',
        'status',
    ];

    public function details()
    {
        return $this->hasMany(DetailPenjualan::class, 'penjualan_id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }
}
