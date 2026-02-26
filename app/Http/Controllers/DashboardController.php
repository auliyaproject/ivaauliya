<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->input('periode', 'hari'); // default 'hari'

        // Statistik
        $transaksiHariIni = Penjualan::whereDate('created_at', now())->count();
        $totalPendapatan = Penjualan::sum('total');
        $pelangganBaru = Pelanggan::whereDate('created_at', now())->count();

        // Produk terjual (jumlah per produk)
        $produkTerjualData = Produk::withSum('details as terjual', 'qty')->get();
        $namaProduk = $produkTerjualData->pluck('nama');
        $jumlahTerjual = $produkTerjualData->pluck('terjual');

        // Tabel penjualan per periode
        if ($periode === 'hari') {
           $penjualanData = Penjualan::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(total) as total'))
    ->groupBy(DB::raw('DATE(created_at)'))
    ->orderBy('tanggal', 'desc')
    ->get();
        } elseif ($periode === 'minggu') {
           $penjualanData = Penjualan::select(
        DB::raw('YEAR(created_at) as tahun'), 
        DB::raw('WEEK(created_at) as minggu'), 
        DB::raw('SUM(total) as total')
    )
    ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('WEEK(created_at)'))
    ->orderBy('tahun', 'desc')
    ->orderBy('minggu', 'desc')
    ->get();
        } else {
         $penjualanData = Penjualan::select(
        DB::raw('YEAR(created_at) as tahun'), 
        DB::raw('MONTH(created_at) as bulan'), 
        DB::raw('SUM(total) as total')
    )
    ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
    ->orderBy('tahun', 'desc')
    ->orderBy('bulan', 'desc')
    ->get();

        }

        $totalPeriode = $penjualanData->sum('total');

        return view('dashboard', compact(
            'periode',
            'transaksiHariIni',
            'totalPendapatan',
            'pelangganBaru',
            'produkTerjualData',
            'namaProduk',
            'jumlahTerjual',
            'penjualanData',
            'totalPeriode'
        ));
    }

   // app/Http/Controllers/DashboardController.php
public function hapusPeriode(Request $request)
{
    $periode = $request->periode;

    // logic hapus data
    // contoh:
    // Penjualan::whereMonth('created_at', $periode)->delete();

    return redirect()->route('dashboard')
        ->with('success', 'Data periode berhasil dihapus');
}

}