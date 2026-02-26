<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;

class LaporanController extends Controller
{
    /**
     * Tampilkan halaman laporan penjualan
     */
    public function index(Request $request)
    {
        $tanggalMulai   = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');

        $query = Penjualan::with('pelanggan');

        if ($tanggalMulai && $tanggalSelesai) {
            $query->whereBetween('created_at', [
                $tanggalMulai . ' 00:00:00',
                $tanggalSelesai . ' 23:59:59',
            ]);
        }

        $penjualans = $query->orderBy('id', 'desc')->get();

        // Hitung total penjualan
        $total = $penjualans->sum('total');

        return view('laporan.index', compact('penjualans', 'total'));
    }

    /**
     * Hapus laporan penjualan
     */
    public function destroy($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $penjualan->delete();

        return redirect()
            ->route('laporan.index')
            ->with('success', 'Laporan berhasil dihapus!');
    }
}
