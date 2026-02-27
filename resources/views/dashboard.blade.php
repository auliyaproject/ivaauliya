@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-200 via-pink-100 to-purple-200 p-4 md:p-6">
    <div class="main-content">
        <div class="container mx-auto">

            {{-- Judul --}}
            <h1 class="text-2xl md:text-3xl font-bold mb-6 text-[#b690a3]">
                Selamat Datang Admin
            </h1>

            {{-- Statistik --}}
            <div class="stats-grid grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="stat-card p-6 rounded-2xl shadow-lg text-center transition-transform hover:-translate-y-1"
                     style="background-color: #fa92c1;">
                    <h2 class="text-lg font-semibold text-black">💸 Laporan Transaksi Hari Ini</h2>
                    <p class="text-3xl font-bold text-black">{{ $transaksiHariIni }}</p>
                </div>

                <div class="stat-card p-6 rounded-2xl shadow-lg text-center transition-transform hover:-translate-y-1"
                     style="background-color: #f7a1d1;">
                    <h2 class="text-lg font-semibold text-black">👥 Pelanggan Baru</h2>
                    <p class="text-3xl font-bold text-black">{{ $pelangganBaru }}</p>
                </div>

                <div class="stat-card p-6 rounded-2xl shadow-lg text-center transition-transform hover:-translate-y-1"
                     style="background-color: #f08ac4;">
                    <h2 class="text-lg font-semibold text-black">💰 Laporan Pendapatan</h2>
                    <p class="text-3xl font-bold text-black">
                        Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            {{-- Konten utama --}}
            <div class="flex flex-col lg:flex-row gap-8 items-start mb-10">

                {{-- Produk terjual --}}
                <div class="w-full lg:w-1/3 bg-pink-500 text-white p-6 rounded-2xl shadow-xl">
                    <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                        🛍️ Laporan Produk Terjual
                    </h2>

                    <div class="space-y-2">
                        @foreach($produkTerjualData as $produk)
                            @if($produk->terjual > 0)
                                <p class="text-lg font-medium border-b border-pink-400 pb-1">
                                    {{ $produk->nama }}
                                    <span class="float-right">= {{ $produk->terjual }}</span>
                                </p>
                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- Tabel laporan --}}
                <div class="w-full lg:w-2/3">
                    <h2 class="text-xl md:text-2xl font-bold mb-4 text-pink-600">
                        Laporan Penjualan - {{ ucfirst($periode) }}
                    </h2>

                    {{-- ✅ overflow-x-auto UNTUK HP --}}
                    <div class="overflow-x-auto bg-white rounded-2xl shadow-xl p-4">
                        <table class="min-w-full border-collapse">
                            <thead>
                                <tr class="bg-pink-100 text-black">
                                    @if($periode === 'hari')
                                        <th class="border-b-2 p-3 text-left">Tanggal</th>
                                    @elseif($periode === 'minggu')
                                        <th class="border-b-2 p-3 text-left">Tahun</th>
                                        <th class="border-b-2 p-3 text-left">Minggu</th>
                                    @else
                                        <th class="border-b-2 p-3 text-left">Tahun</th>
                                        <th class="border-b-2 p-3 text-left">Bulan</th>
                                    @endif
                                    <th class="border-b-2 p-3 text-right">Total Penjualan</th>
                                </tr>
                            </thead>

                            <tbody class="text-black">
                                @foreach($penjualanData as $item)
                                    <tr class="hover:bg-pink-50 transition-colors">
                                        @if($periode === 'hari')
                                            <td class="p-3 border-b">{{ $item->tanggal }}</td>
                                        @elseif($periode === 'minggu')
                                            <td class="p-3 border-b">{{ $item->tahun }}</td>
                                            <td class="p-3 border-b">{{ $item->minggu }}</td>
                                        @else
                                            <td class="p-3 border-b">{{ $item->tahun }}</td>
                                            <td class="p-3 border-b">{{ $item->bulan }}</td>
                                        @endif
                                        <td class="p-3 border-b text-right font-semibold">
                                            Rp{{ number_format($item->total,0,',','.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr class="bg-pink-50 text-black font-bold">
                                    <td colspan="{{ $periode === 'hari' ? 1 : 2 }}"
                                        class="p-3 text-right">
                                        Total Keseluruhan
                                    </td>
                                    <td class="p-3 text-right text-pink-600 text-xl">
                                        Rp{{ number_format($totalPeriode,0,',','.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Grafik --}}
            <div class="bg-white p-4 md:p-6 rounded-2xl shadow-xl my-10">
                <h2 class="text-xl md:text-2xl font-bold mb-6 text-pink-600 flex items-center gap-2">
                    📊 Grafik Produk Terjual
                </h2>

                <div class="relative h-[300px] md:h-[400px]">
                    <canvas id="chartProdukTerjual"></canvas>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Chart JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('chartProdukTerjual').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($namaProduk) !!},
            datasets: [{
                label: 'Jumlah Terjual',
                data: {!! json_encode($jumlahTerjual) !!},
                backgroundColor: 'rgba(236, 72, 153, 0.6)',
                borderColor: 'rgba(236, 72, 153, 1)',
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>
@endsection