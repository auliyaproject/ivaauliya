@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-100 min-h-screen">
    <div class="max-w-lg mx-auto bg-white rounded-xl shadow p-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-800"> Edit Pelanggan</h2>

        <form action="{{ route('pelanggan.update', $pelanggan->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nama --}}
             <div class="mb-4">
                <label class="block font-semibold mb-1">Nama Pelanggan</label>
                <input type="text" name="nama_pelanggan"
                       class="w-full p-2 border rounded"
                       required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Alamat</label>
                <input type="text" name="alamat"
                       class="w-full p-2 border rounded">
            </div>

            <div class="mb-6">
                <label class="block font-semibold mb-1">Nomor Telepon</label>
                <input type="text" name="nomor_telepon"
                       class="w-full p-2 border rounded">
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