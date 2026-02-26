@extends('layouts.app')

@section('content')
<div class="card p-6">
    <h1 class="text-2xl font-bold mb-4">🧾 Kasir Only</h1>

    <form action="{{ route('kasir.simpan') }}" method="POST" id="form-penjualan">
        @csrf

        <!-- Pilihan Pelanggan -->
        <label for="pelanggan_id" class="block font-semibold mb-1">Pilih Pelanggan</label>
        <div class="mb-4">
            <select name="pelanggan_id">
                <option value="">Umum</option>
                @foreach($pelanggans as $pelanggan)
                    <option value="{{ $pelanggan->id }}">{{ $pelanggan->nama_pelanggan }}</option>
                @endforeach
            </select>
        </div>

        <!-- Uang Bayar -->
        <label for="uang_bayar">Uang Bayar</label>
        <input type="number" name="uang_bayar" id="uang_bayar" required class="border p-2 w-full mb-4">

        <!-- Tanggal -->
        <label for="tanggal" class="block font-semibold mb-1">Tanggal</label>
        <input type="date" name="tanggal" id="tanggal" value="{{ date('Y-m-d') }}" readonly class="border rounded p-2 w-full mb-4">

        <!-- Tabel Produk -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 text-center">
                <thead class="bg-gray-100">
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
                            <select name="produk_id[]" required class="border rounded p-1 w-full">
                                <option value="">-- Pilih Produk --</option>
                                @foreach($produks as $produk)
                                    <option value="{{ $produk->id }}">{{ $produk->nama }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="border p-2"><input type="number" name="harga[]" value="0" readonly class="border rounded p-1 w-full"></td>
                        <td class="border p-2"><input type="number" name="qty[]" value="1" min="1" required class="border rounded p-1 w-full"></td>
                        <td class="border p-2"><input type="number" name="subtotal[]" value="0" readonly class="border rounded p-1 w-full"></td>
                        <td class="border p-2">
                            <button type="button" class="bg-red-500 text-white px-2 py-1 rounded" onclick="hapusBaris(this)">✖</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <button type="button" id="tambah-produk" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded shadow">+ Tambah Produk</button>

        <div class="mt-6 space-y-3">
            <div>
                <label for="subtotal" class="font-semibold">Subtotal:</label>
                <input type="number" id="subtotal" name="subtotal" readonly value="0" class="border rounded p-2 w-full" />
            </div>

            <div>
                <label for="kembali" class="font-semibold">Kembali:</label>
                <input type="number" id="kembali" readonly value="0" class="border rounded p-2 w-full" />
            </div>
        </div>

        <button type="submit" class="mt-6 bg-green-600 text-white px-5 py-2 rounded shadow font-semibold">
            💾 Simpan Transaksi
        </button>
    </form>
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
            const selectProduk = row.querySelector('select[name="produk_id[]"]');
            const hargaInput = row.querySelector('input[name="harga[]"]');
            const qtyInput = row.querySelector('input[name="qty[]"]');
            const subtotalCell = row.querySelector('input[name="subtotal[]"]');

            const produkId = selectProduk.value;
            const harga = hargaProduk[produkId] || 0;
            const qty = parseInt(qtyInput.value) || 0;

            hargaInput.value = harga;
            const subtotal = harga * qty;
            subtotalCell.value = subtotal;
            total += subtotal;
        });
        subtotalInput.value = total;
        updateKembali();
    }

    function updateKembali() {
        const bayar = parseInt(uangBayarInput.value) || 0;
        const total = parseInt(subtotalInput.value) || 0;
        const kembali = bayar - total;
        kembaliInput.value = kembali >= 0 ? kembali : 0;
    }

    function hapusBaris(button) {
        const row = button.closest('tr');
        if (produkBody.children.length > 1) {
            row.remove();
            updateSubtotal();
        } else {
            alert('Minimal 1 produk diperlukan!');
        }
    }

    document.getElementById('tambah-produk').addEventListener('click', () => {
        const newRow = produkBody.children[0].cloneNode(true);
        newRow.querySelectorAll('input').forEach(input => {
            input.value = input.name === 'qty[]' ? 1 : 0;
        });
        newRow.querySelector('select[name="produk_id[]"]').selectedIndex = 0;
        produkBody.appendChild(newRow);
        updateSubtotal();
    });

    produkBody.addEventListener('change', e => {
        if (['produk_id[]','qty[]'].includes(e.target.name)) updateSubtotal();
    });

    uangBayarInput.addEventListener('input', updateKembali);

    updateSubtotal();
</script>
@endsection
