<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggans';

    // Kolom yang bisa diisi lewat mass assignment
    protected $fillable = [
        'nama_pelanggan',
        'alamat',
        'nomor_telepon',
    ];
}