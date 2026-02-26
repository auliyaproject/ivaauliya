<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Produk;
use App\Models\Pelanggan;

class PenjualanController extends Controller
{
    // Daftar semua penjualan
    public function index()
    {
        $penjualans = Penjualan::with('pelanggan', 'detailPenjualan.produk')->get();
        return view('penjualan.index', compact('penjualans'));
    }

    // Form tambah penjualan
    public function create()
    {
        $pelanggans = Pelanggan::all();
        $produks = Produk::all();
        return view('penjualan.create', compact('pelanggans', 'produks'));
    }

    // Simpan penjualan
    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'produk_id' => 'required|array',
            'qty' => 'required|array',
        ]);

        // Buat transaksi penjualan
        $penjualan = Penjualan::create([
            'pelanggan_id' => $request->pelanggan_id,
            'total' => 0, // nanti dihitung
        ]);

        $total = 0;

        foreach ($request->produk_id as $index => $produkId) {
            $produk = Produk::findOrFail($produkId);
            $jumlahBeli = $request->qty[$index];

            // Validasi stok
            if ($produk->stok < $jumlahBeli) {
                return redirect()->back()->with('error', "Stok $produk->nama tidak cukup!");
            }

            // Buat detail penjualan
            DetailPenjualan::create([
                'penjualan_id' => $penjualan->id,
                'produk_id' => $produk->id,
                'qty' => $jumlahBeli,
                'harga' => $produk->harga,
                'subtotal' => $produk->harga * $jumlahBeli,
            ]);

            // Kurangi stok
            $produk->stok -= $jumlahBeli;
            $produk->save();

            $total += $produk->harga * $jumlahBeli;
        }

        // Update total penjualan
        $penjualan->update(['total' => $total]);

        return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil disimpan!');
    }
}
