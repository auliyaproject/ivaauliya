@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-100 min-h-screen">
    <div class="max-w-lg mx-auto bg-white rounded-xl shadow p-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">𓂃🖊 Edit Pelanggan</h2>

        <form action="{{ route('pelanggan.update', $pelanggan->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Nama Pelanggan</label>
                <input 
                    type="text" 
                    name="nama_pelanggan" 
                    class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400" 
                    value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan) }}" 
                    required
                >
            </div>

            {{-- Alamat --}}
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Alamat</label>
                <textarea 
                    name="alamat" 
                    class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"
                >{{ old('alamat', $pelanggan->alamat) }}</textarea>
            </div>

            {{-- Telepon --}}
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Nomor Telepon</label>
                <input 
                    type="text" 
                    name="telepon" 
                    class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"
                    value="{{ old('telepon', $pelanggan->telepon ?? '') }}"
                >
            </div>

            {{-- Tombol --}}
            <div class="flex justify-between">
                <a href="{{ route('pelanggan.index') }}" class="text-gray-600 hover:underline">← Kembali</a>
                <button 
                    type="submit" 
                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700"
                >
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection