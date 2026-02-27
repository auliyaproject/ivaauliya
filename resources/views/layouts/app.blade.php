<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kasir App</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
</head>
<body>

<div class="app-wrapper">

    {{-- ================= SIDEBAR ================= --}}
    <aside class="sidebar">
        <h2 class="sidebar-logo">
             {{ session('role') === 'admin' ? 'Admin Kasir' : 'Kasir' }}
        </h2>

        <nav class="sidebar-nav">
            <ul>

                {{-- ================= ADMIN ================= --}}
                @if(session('role') === 'admin')

                    <li>
                        <a href="{{ route('dashboard') }}"
                           class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            🏠 Dashboard
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('kasir.index') }}"
                           class="{{ request()->routeIs('kasir.index') ? 'active' : '' }}">
                            🏷️ Penjualan
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('pelanggan.index') }}"
                           class="{{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
                            👥 Pelanggan
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('produk.index') }}"
                           class="{{ request()->routeIs('produk.*') ? 'active' : '' }}">
                            🛍️ Produk
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('laporan.index') }}"
                           class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                            📈 Laporan
                        </a>
                    </li>

                @endif



               {{-- ================= KASIR ================= --}}
@if(session('role') === 'kasir')

    {{-- Menu Kasir --}}
    <li>
        <a href="{{ route('kasir.index') }}"
           class="{{ request()->routeIs('kasir.index') ? 'active' : '' }}">
            🏷️ Penjualan
        </a>
    </li>

    <li>
        <a href="{{ route('pelanggan.index') }}"
           class="{{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
            👥 Pelanggan
        </a>
    </li>


@endif




{{-- ================= SWITCH ROLE ================= --}}
<li class="mt-4">
    <form action="{{ route('pilih.role') }}" method="POST">
        @csrf

        <select name="role"
            onchange="this.form.submit()"
            class="w-full px-3 py-2 rounded-lg bg-gray-100 border border-gray-300 text-sm
                   focus:outline-none focus:ring-2 focus:ring-blue-400">

            <option value="kasir"
                {{ session('role') === 'kasir' ? 'selected' : '' }}>
                🏪 Kasir
            </option>

            <option value="admin"
                {{ session('role') === 'admin' ? 'selected' : '' }}>
                👑 Admin
            </option>

        </select>
    </form>
</li>
        {{-- ================= LOGOUT ================= --}}
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button type="submit" class="logout-button">
                🔒 Logout
            </button>
        </form>

        <footer class="sidebar-footer">
            © 2026 
        </footer>
    </aside>

    {{-- ================= CONTENT ================= --}}
    <main class="main-content">
        @yield('content')
    </main>

</div>

</body>
</html>
