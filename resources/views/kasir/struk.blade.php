<!DOCTYPE html>
<html>
<head>
    <title>Struk Penjualan</title>
    <style>
        :root {
            --pink-main: #ffffffff;
            --pink-soft: rgba(255, 255, 255, 1);
            --pink-accent: #4d072aff;
            --text-dark: #000000ff;
        }

        body {
            background: var(--pink-main);
            font-family: 'Poppins', sans-serif;
            padding: 20px;
        }

        .receipt {
            width: 360px;
            margin: auto;
            background: white;
            border-radius: 25px 25px 40px 40px;
            box-shadow: 0 10px 25px rgba(0,0,0,.15);
            overflow: hidden;
        }

        .receipt-header {
            background: var(--pink-soft);
            text-align: center;
            padding: 15px;
            border-bottom: 2px dashed var(--pink-accent);
        }

        .receipt-body {
            padding: 15px;
            color: var(--text-dark);
            font-size: 13px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
        }

        .items {
            background: #fce2f1ff;
            border-radius: 15px;
            padding: 10px;
            margin: 10px 0;
        }

        .line {
            border-top: 1px dashed var(--pink-accent);
            margin: 10px 0;
        }

        .right { text-align: right; min-width: 120px; }
        .bold { font-weight: bold; }
        .total { color: var(--pink-accent); font-size: 14px; }

        .receipt-footer {
            background: var(--pink-soft);
            text-align: center;
            padding: 10px;
            font-size: 11px;
            border-top: 2px dashed var(--pink-accent);
        }
    </style>
</head>
<body onload="window.print()">

@php
    $totalAsli = $penjualan->details->sum('subtotal');
    $diskon = 0; $persen = 0;

    if($penjualan->pelanggan_id){
        if($totalAsli >= 200000) $persen = 10;
        elseif($totalAsli >= 100000) $persen = 5;
        else $persen = 2;
        $diskon = $totalAsli * ($persen/100);
    }

    $totalBayar = $totalAsli - $diskon;
    $kembalian = $penjualan->uang_bayar - $totalBayar;
@endphp

<div class="receipt">
    <div class="receipt-header">
        <div class="content"> 💄  🎀 👑  🌷 🛍️ </div>
        
        <div class="bold">COSMETIC BEAUTY & SKINCARE</div>
        <small>Jl. Pleret No. 123, Yogyakarta</small><br>
        <small>Telp: 0878-4226-9539</small>
    </div>

    <div class="receipt-body">
        <div class="row">
    <span>Tanggal</span>
    <span>{{ \Carbon\Carbon::parse($penjualan->tanggal)->format('d-m-Y') }}</span>
</div>
        <div class="row"><span>Kasir</span><span>{{ $penjualan->kasir->name ?? 'Admin' }}</span></div>
        <div class="row"><span>Pelanggan</span><span>{{ $penjualan->pelanggan->nama_pelanggan ?? 'Umum' }}</span></div>

        <div class="line"></div>

        <div class="items">
            @foreach($penjualan->details as $d)
            <div class="row">
                <span>{{ $d->produk->nama }} x{{ $d->qty }}</span>
                <span class="right">Rp {{ number_format($d->subtotal,0,',','.') }}</span>
            </div>
            @endforeach
        </div>

        <div class="line"></div>

        <div class="row"><span>Total Item</span><span class="right">{{ $penjualan->details->sum('qty') }}</span></div>

        @if($penjualan->pelanggan_id)
        <div class="row">
            <span>Diskon Member ({{ $persen }}%)</span>
            <span class="right">- Rp {{ number_format($diskon,0,',','.') }}</span>
        </div>
        @endif

        <div class="row bold">
            <span>Total Bayar</span>
            <span class="right">Rp {{ number_format($totalBayar,0,',','.') }}</span>
        </div>

        <div class="row">
            <span>Uang Bayar</span>
            <span class="right">Rp {{ number_format($penjualan->uang_bayar,0,',','.') }}</span>
        </div>

        <div class="row bold total">
            <span>Kembalian</span>
            <span class="right">Rp {{ number_format($kembalian,0,',','.') }}</span>
        </div>
    </div>

    <div class="receipt-footer">
        ID Transaksi: {{ $penjualan->id }}<br>
        Terima kasih telah berbelanja 💖<br>
        Selamat datang kembali 😊
    </div>
</div>

</body>
</html>
