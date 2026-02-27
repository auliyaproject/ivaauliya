@extends('layouts.app')

@section('content')
<div class="p-4 sm:p-8 bg-gray-100 min-h-screen">
    <div class="max-w-5xl mx-auto">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
            <h1 class="text-3xl font-extrabold text-gray-800">
                Daftar Member Pelanggan
            </h1>

            <a href="{{ route('pelanggan.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition-all duration-200 w-fit">
               + Tambah Pelanggan
            </a>
        </div>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Search --}}
        <form method="GET" action="{{ route('pelanggan.index') }}" class="mb-6">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari pelanggan..."
                   class="w-full p-3 rounded-lg border border-pink-300 focus:outline-none focus:ring-2 focus:ring-pink-400">
        </form>

        {{-- Table Wrapper (KUNCI RESPONSIF) --}}
        <div class="bg-white rounded-xl shadow overflow-x-auto">
            <table class="min-w-full text-left whitespace-nowrap">
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
                            <td class="py-3 px-4 font-medium text-gray-800">
                                {{ $p->nama_pelanggan }}
                            </td>
                            <td class="py-3 px-4 text-gray-600">
                                {{ $p->alamat }}
                            </td>
                            <td class="py-3 px-4 text-gray-600">
                                {{ $p->nomor_telepon }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                <a href="{{ route('pelanggan.edit', $p->id) }}"
                                   class="text-blue-600 hover:text-blue-800 font-semibold">
                                    Edit
                                </a>

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

    
@endsection