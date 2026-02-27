@extends('layouts.app')

@section('content')
    
<div class="p-8 bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto bg-white rounded-xl shadow p-6">
        <h2 class="text-2xl font-bold mb-4"> Laporan Penjualan</h2>

        <!-- WRAPPER RESPONSIF (TIDAK UBAH TAMPILAN) -->
        <div class="overflow-x-auto w-full">
            <table class="border-collapse w-full min-w-[800px]">
                <thead>
                    <tr>
                        <th class="border p-2">Tanggal</th>
                        <th class="border p-2">ID</th>
                        <th class="border p-2">Pelanggan</th>
                        <th class="border p-2">Produk</th>
                        <th class="border p-2">Total</th>
                        <th class="border p-2">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($penjualans as $penjualan)
                    <tr>
                        <td class="border p-2">{{ $penjualan->created_at->format('d/m/Y') }}</td>
                        <td class="border p-2">{{ $penjualan->id }}</td>
                        <td class="border p-2">
                            {{ $penjualan->pelanggan ? $penjualan->pelanggan->nama_pelanggan : '-' }}
                        </td>
                        <td class="border p-2">
                            <ul class="list-disc pl-4">
                                @foreach ($penjualan->details as $detail)
                                    <li>{{ $detail->produk->nama }} (x{{ $detail->qty }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="border p-2 text-right">
                            Rp{{ number_format($penjualan->total, 0, ',', '.') }}
                        </td>
                        <td class="border p-2 text-center">
                            <form action="{{ route('laporan.destroy', $penjualan->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus laporan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr class="bg-gray-100 font-bold">
                        <td colspan="4" class="border p-2 text-right">Total Penjualan</td>
                        <td class="border p-2 text-right">
                            Rp{{ number_format($total, 0, ',', '.') }}
                        </td>
                        <td class="border p-2 text-center">-</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- END WRAPPER -->

    </div>
</div>

@endsection