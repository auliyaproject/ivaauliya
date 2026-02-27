@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 p-3 sm:p-6 overflow-y-auto">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow p-4 sm:p-6">

        <h1 class="text-xl sm:text-2xl font-bold mb-4 text-center">
        Kasir 
        </h1>

        <form action="{{ route('kasir.simpan') }}" method="POST" id="form-penjualan" class="space-y-4">
            @csrf

            <!-- Pelanggan -->
            <div>
                <label class="block font-semibold mb-1">Pilih Pelanggan</label>
                <select name="pelanggan_id" class="border rounded w-full p-2">
                    <option value="">Umum</option>
                    @foreach($pelanggans as $pelanggan)
                        <option value="{{ $pelanggan->id }}">{{ $pelanggan->nama_pelanggan }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Uang Bayar -->
            <div>
                <label class="block font-semibold mb-1">Uang Bayar</label>
                <input type="number" name="uang_bayar" id="uang_bayar"
                       class="border rounded w-full p-2" required>
            </div>

            <!-- Tanggal -->
            <div>
                <label class="block font-semibold mb-1">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal"
                       value="{{ date('Y-m-d') }}" readonly
                       class="border rounded w-full p-2 bg-gray-100">
            </div>

            <!-- Produk -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[600px] border border-gray-300 text-sm">
                    <thead class="bg-gray-100 text-center">
                        <tr>
                            <th class="border p-2">Produk</th>
                            <th class="border p-2">Harga</th>
                            <th class="border p-2">Qty</th>
                            <th class="border p-2">Subtotal</th>
                            <th class="border p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="produk-body">
                        <tr>
                            <td class="border p-2">
                                <select name="produk_id[]" required class="border rounded w-full p-1">
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach($produks as $produk)
                                        <option value="{{ $produk->id }}">{{ $produk->nama }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="border p-2">
                                <input type="number" name="harga[]" readonly
                                       class="border rounded w-full p-1 bg-gray-100">
                            </td>
                            <td class="border p-2">
                                <input type="number" name="qty[]" value="1" min="1"
                                       class="border rounded w-full p-1">
                            </td>
                            <td class="border p-2">
                                <input type="number" name="subtotal[]" readonly
                                       class="border rounded w-full p-1 bg-gray-100">
                            </td>
                            <td class="border p-2 text-center">
                                <button type="button"
                                        class="bg-red-500 text-white px-3 py-1 rounded"
                                        onclick="hapusBaris(this)">
                                    ✖
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Tambah Produk -->
            <button type="button" id="tambah-produk"
                    class="w-full sm:w-auto bg-blue-600 text-white px-4 py-2 rounded">
                + Tambah Produk
            </button>

            <!-- Total -->
            <div class="space-y-3">
                <div>
                    <label class="font-semibold">Subtotal</label>
                    <input type="number" id="subtotal" name="subtotal"
                           class="border rounded w-full p-2 bg-gray-100" readonly>
                </div>

                <div>
                    <label class="font-semibold">Kembali</label>
                    <input type="number" id="kembali"
                           class="border rounded w-full p-2 bg-gray-100" readonly>
                </div>
            </div>

            <!-- Submit -->
            <button type="submit"
                    class="w-full bg-green-600 text-white py-3 rounded font-semibold">
                💾 Simpan Transaksi
            </button>

        </form>
    </div>
</div>

<script>
const hargaProduk = @json($produks->pluck('harga','id')->toArray());
const produkBody = document.getElementById('produk-body');
const subtotalInput = document.getElementById('subtotal');
const uangBayarInput = document.getElementById('uang_bayar');
const kembaliInput = document.getElementById('kembali');

function updateSubtotal() {
    let total = 0;
    produkBody.querySelectorAll('tr').forEach(row => {
        const produk = row.querySelector('[name="produk_id[]"]');
        const harga = row.querySelector('[name="harga[]"]');
        const qty = row.querySelector('[name="qty[]"]');
        const subtotal = row.querySelector('[name="subtotal[]"]');

        const h = hargaProduk[produk.value] || 0;
        const q = parseInt(qty.value) || 0;

        harga.value = h;
        subtotal.value = h * q;
        total += h * q;
    });

    subtotalInput.value = total;
    updateKembali();
}

function updateKembali() {
    const bayar = parseInt(uangBayarInput.value) || 0;
    const total = parseInt(subtotalInput.value) || 0;
    kembaliInput.value = Math.max(bayar - total, 0);
}

function hapusBaris(btn) {
    if (produkBody.children.length > 1) {
        btn.closest('tr').remove();
        updateSubtotal();
    } else {
        alert('Minimal 1 produk!');
    }
}

document.getElementById('tambah-produk').onclick = () => {
    const row = produkBody.children[0].cloneNode(true);
    row.querySelectorAll('input').forEach(i => i.value = i.name === 'qty[]' ? 1 : 0);
    row.querySelector('select').selectedIndex = 0;
    produkBody.appendChild(row);
};

produkBody.addEventListener('change', updateSubtotal);
uangBayarInput.addEventListener('input', updateKembali);

updateSubtotal();
</script>
@endsection