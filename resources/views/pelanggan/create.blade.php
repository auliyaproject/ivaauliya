@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-4">Tambah Pelanggan</h1>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('pelanggan.store') }}">
            @csrf

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

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold">
                Simpan
            </button>
        </form>
    </div>
</div>
@endsection