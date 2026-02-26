<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;

class PelangganController extends Controller
{
    // =============================
    // TAMPILKAN DATA
    // =============================
    public function index()
    {
        $search = request('search');

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
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'alamat'         => 'nullable|string|max:255',
            'nomor_telepon'        => 'nullable|string|max:20',
        ]);

        Pelanggan::create([
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat'         => $request->alamat,
            'nomor_telepon'        => $request->telepon,
        ]);

        return redirect()
            ->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    // =============================
    // 🔥 FORM EDIT (INI YANG HILANG)
    // =============================
    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan.edit', compact('pelanggan'));
    }

    // =============================
    // 🔥 UPDATE DATA
    // =============================
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'alamat'         => 'nullable|string|max:255',
            'nomor_telepon'        => 'nullable|string|max:20',
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update([
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat'         => $request->alamat,
            'nomor_telepon'        => $request->telepon,
        ]);

        return redirect()
            ->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil diperbarui!');
    }
}