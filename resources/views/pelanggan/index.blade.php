@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-100 min-h-screen">
    <div class="max-w-5xl mx-auto">
        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-800"> Daftar Member Pelanggan </h1>
            </div>
            <a href="{{ route('pelanggan.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition-all duration-200">
               + Tambah Pelanggan
            </a>
        </div>

        {{-- Notifikasi sukses --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Search Bar (opsional, belum difungsikan) --}}
        <div class="mb-6">
           <form method="GET" action="{{ route('pelanggan.index') }}" class="mb-6">
    <input type="text"
           name="search"
           value="{{ request('search') }}"
           placeholder="Cari pelanggan..."
           class="w-full p-3 rounded-lg border border-pink-300 focus:outline-none focus:ring-2 focus:ring-pink-400">
</form>
        </div>

        {{-- Table --}}
      <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="min-w-full text-left">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="py-3 px-4">No</th>
                        <th class="py-3 px-4">Nama</th>
                        <th class="py-3 px-4">Alamat</th>
                        <th class="py-3 px-4">Telepon</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($pelanggans as $index => $p)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-4">{{ $index + 1 }}</td>
                            <td class="py-3 px-4 font-medium text-gray-800">{{ $p->nama_pelanggan }}</td>
                            <td class="py-3 px-4 text-gray-600">{{ $p->alamat }}</td>
                            <td class="py-3 px-4 text-gray-600">{{ $p->nomor_telepon }}</td>
                            <td class="py-3 px-4 text-center">
                                <a href="{{ route('pelanggan.edit', $p->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 font-semibold">Edit</a>
                                <form action="{{ route('pelanggan.destroy', $p->id) }}" 
                                      method="POST" 
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Yakin ingin menghapus pelanggan ini?')" 
                                            class="text-red-600 hover:text-red-800 font-semibold ml-2">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-400 py-4">
                                Belum ada data pelanggan 😕
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Footer --}}
        <p class="text-center text-sm text-gray-400 mt-8">
            © 2026
        </p>
    </div>
</div>
@endsection