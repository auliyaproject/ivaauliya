@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-4">📋Daftar Produk</h1>

        <a href="{{ route('produk.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">+ Tambah Produk</a>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border">
        <thead>
    <tr class="bg-gray-200">
        <th class="border p-2">ID</th>
        <th class="border p-2">Nama Produk</th>
        <th class="border p-2">Harga</th>
        <th class="border p-2">Stok</th> <!-- Tambah ini -->
        <th class="border p-2">Aksi</th>
    </tr>
</thead>
<tbody>
    @foreach ($produks as $produk)
        <tr>
            <td class="border p-2">{{ $produk->id }}</td>
            <td class="border p-2">{{ $produk->nama }}</td>
            <td class="border p-2">Rp {{ number_format($produk->harga) }}</td>
            <td class="border p-2">{{ $produk->stok }}</td> <!-- Tambah ini -->
            <td class="border p-2 text-center">
                <a href="{{ route('produk.edit', $produk->id) }}" class="bg-yellow-400 text-white px-2 py-1 rounded">Edit</a>
                <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                </form>
            </td>
        </tr>
    @endforeach
</tbody>
        </table>
    </div>
 <p class="text-center text-sm text-gray-400 mt-8">
            © 2026 
        </p>
@endsection