@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="p-6">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Tambah Produk</h1>
        <a href="{{ route('produk.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Kembali
        </a>
    </div>

    {{-- Form Tambah Produk --}}
    <div class="bg-white shadow rounded p-6">
        @if ($errors->any())
            <div class="mb-4">
                <ul class="list-disc list-inside text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('produk.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block mb-1 font-medium">ID Produk</label>
                <input type="text" name="id" class="border px-3 py-2 w-full rounded" required value="{{ old('id') }}">
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Nama Produk</label>
                <input type="text" name="nama" class="border px-3 py-2 w-full rounded" required value="{{ old('nama') }}">
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Harga</label>
                <input type="number" name="harga" class="border px-3 py-2 w-full rounded" required value="{{ old('harga') }}">
            </div>

            <div class="mb-4">
    <label class="block mb-1 font-medium">Stok</label>
    <input type="number" name="stok" class="border px-3 py-2 w-full rounded" required value="{{ old('stok', 0) }}">
</div>


            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Simpan Produk
            </button>
        </form>
    </div>
</div>
@endsection
