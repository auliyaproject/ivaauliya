<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;

class PelangganController extends Controller
{
    // =============================
    // TAMPILKAN DATA + SEARCH
    // =============================
    public function index(Request $request)
    {
        $search = $request->search;

        $pelanggans = Pelanggan::when($search, function ($query, $search) {
            $query->where('nama_pelanggan', 'like', "%{$search}%");
        })->get();

        return view('pelanggan.index', compact('pelanggans'));
    }

    // =============================
    // FORM TAMBAH
    // =============================
    public function create()
    {
        return view('pelanggan.create');
    }

    // =============================
    // SIMPAN DATA BARU
    // =============================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'alamat'         => 'nullable|string|max:255',
            'nomor_telepon'  => 'nullable|string|max:20',
        ]);

        Pelanggan::create($validated);

        return redirect()
            ->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    // =============================
    // FORM EDIT
    // =============================
    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan.edit', compact('pelanggan'));
    }

    // =============================
    // UPDATE DATA
    // =============================
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'alamat'         => 'nullable|string|max:255',
            'nomor_telepon'  => 'nullable|string|max:20',
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update($validated);

        return redirect()
            ->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    // =============================
    // HAPUS DATA
    // =============================
    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return redirect()
            ->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil dihapus!');
    }
}