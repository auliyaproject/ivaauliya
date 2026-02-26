<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;

class KasirController extends Controller
{
    /**
     * Halaman kasir
     */
    public function index()
    {
        return view('kasir.index', [
            'produks'    => Produk::orderBy('nama')->get(),
            'pelanggans' => Pelanggan::orderBy('nama_pelanggan')->get(),
        ]);// atau kasir.penjualan
    }

    /**
     * Simpan transaksi
     */
    public function simpan(Request $request)
    {
        $request->validate([
            'produk_id'    => 'required|array',
            'qty'          => 'required|array',
            'pelanggan_id' => 'nullable|exists:pelanggans,id',
            'uang_bayar'   => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $total = 0;

            // Hitung total
            foreach ($request->produk_id as $key => $produkId) {
                $produk = Produk::findOrFail($produkId);
                $qty    = (int) $request->qty[$key];

                if ($produk->stok < $qty) {
                    throw new \Exception("Stok {$produk->nama} tidak mencukupi");
                }

                $total += $produk->harga * $qty;
            }

            // Hitung diskon (jika pelanggan)
            $diskon = 0;
            if ($request->pelanggan_id) {
                if ($total >= 200000) {
                    $diskon = $total * 0.10;
                } elseif ($total >= 100000) {
                    $diskon = $total * 0.05;
                } else {
                    $diskon = $total * 0.02;
                }
            }

            $totalBayar = $total - $diskon;
            $uangBayar  = $request->uang_bayar;

            if ($uangBayar < $totalBayar) {
                throw new \Exception('Uang bayar kurang');
            }

            $kembalian = $uangBayar - $totalBayar;

            // Simpan penjualan
            $penjualan = Penjualan::create([
                'tanggal'      => now(),
                'total'        => $totalBayar,
                'uang_bayar'   => $uangBayar,
                'kembalian'    => $kembalian,
                'diskon'       => $diskon,
                'pelanggan_id' => $request->pelanggan_id,
                'kasir_id'     => auth()->id(),
                'status'       => 'selesai',
            ]);

            // Simpan detail + kurangi stok
            foreach ($request->produk_id as $key => $produkId) {
                $produk = Produk::findOrFail($produkId);
                $qty    = (int) $request->qty[$key];

                DetailPenjualan::create([
                    'penjualan_id' => $penjualan->id,
                    'produk_id'    => $produk->id,
                    'qty'          => $qty,
                    'harga'        => $produk->harga,
                    'subtotal'     => $produk->harga * $qty,
                ]);

                $produk->decrement('stok', $qty);
            }

            DB::commit();

            return redirect()->route('kasir.struk', $penjualan->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Cetak / tampilkan struk
     */
    public function cetakStruk($id)
    {
        $penjualan = Penjualan::with(['details.produk', 'pelanggan', 'kasir'])
            ->findOrFail($id);

        return view('kasir.struk', compact('penjualan'));
    }
}
