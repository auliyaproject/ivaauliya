<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::all();
        return view('produk.index', compact('produks'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer|min:0',
        ]);
    
        Produk::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok,
        ]);
    
        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }
    
    public function edit($id)
{
    $produk = Produk::findOrFail($id);
    return view('produk.edit', compact('produk'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'nama' => 'required',
        'harga' => 'required|numeric',
        'stok'  => 'required|numeric',
    ]);

    $produk = Produk::findOrFail($id);
    $produk->update([
        'nama' => $request->nama,
        'harga' => $request->harga,
        'stok' => $request->stok,
    ]);

    return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');

}
public function destroy($id)
{
    $produk = Produk::findOrFail($id);
    $produk->delete();

    return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus');
}
}