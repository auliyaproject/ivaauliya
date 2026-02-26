<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\DetailPenjualan;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'pelanggan_id' => 'nullable|exists:pelanggans,id',
        'bayar'        => 'required|numeric|min:0',
        'produk_id'    => 'required|array',
        'qty'          => 'required|array',
        'harga'        => 'required|array',
    ]);

    return DB::transaction(function () use ($request) {

        // 1️⃣ Hitung total belanja
        $total = 0;
        foreach ($request->produk_id as $key => $id) {
            $total += $request->qty[$key] * $request->harga[$key];
        }

        $bayar = $request->bayar;

        // ❗ VALIDASI PENTING
        if ($bayar < $total) {
            abort(400, 'Uang bayar tidak mencukupi');
        }

        $kembali = $bayar - $total;

        // 2️⃣ Simpan penjualan
        $penjualan = Penjualan::create([
            'tanggal'      => now(),           // WIB otomatis
            'total'        => $total,
            'bayar'        => $bayar,
            'kembali'      => $kembali,
            'pelanggan_id' => $request->pelanggan_id,
            'kasir_id'     => auth()->id(),
            'status'       => 'selesai',
        ]);

        // 3️⃣ Simpan detail & kurangi stok
        foreach ($request->produk_id as $key => $id) {
            $qty   = $request->qty[$key];
            $harga = $request->harga[$key];

            DetailPenjualan::create([
                'penjualan_id' => $penjualan->id,
                'produk_id'    => $id,
                'qty'          => $qty,
                'harga'        => $harga,
                'subtotal'     => $qty * $harga,
            ]);

            $produk = Produk::lockForUpdate()->find($id);
            if ($produk) {
                $produk->stok -= $qty;
                $produk->save();
            }
        }

        // 4️⃣ Ambil data lengkap untuk struk
        $penjualan = Penjualan::with(['pelanggan', 'kasir', 'details.produk'])
            ->find($penjualan->id);

        // 5️⃣ Tampilkan struk
        return view('kasir.struk', compact('penjualan'));
    });
}
}