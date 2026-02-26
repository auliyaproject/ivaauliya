<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenjualanController;

/*
|--------------------------------------------------------------------------
| DEFAULT
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

/*
|--------------------------------------------------------------------------
| WAJIB LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PILIH ROLE
    |--------------------------------------------------------------------------
    */
    Route::get('/pilih-role', function () {
        return view('pilih_role');
    })->name('pilih.role');

    Route::post('/pilih-role', function (Request $request) {

        $request->validate([
            'role' => 'required|in:admin,kasir'
        ]);

        // reset verifikasi admin
        session()->forget('admin_verified');
        session(['role' => $request->role]);

        // KASIR LANGSUNG KE PENJUALAN
        if ($request->role === 'kasir') {
            return redirect('/kasir');
        }

        // ADMIN KE VERIFIKASI
        return redirect('/admin/verifikasi');

    })->name('pilih.role.post');

    /*
    |--------------------------------------------------------------------------
    | ADMIN VERIFIKASI
    |--------------------------------------------------------------------------
    */
    Route::get('/admin/verifikasi', function () {
        return view('admin_verifikasi');
    })->name('admin.verifikasi');

    Route::post('/admin/verifikasi', function (Request $request) {

        $request->validate([
            'password' => 'required'
        ]);

        if ($request->password === env('ADMIN_VERIFICATION_PASSWORD')) {

            session([
                'role' => 'admin',
                'admin_verified' => true
            ]);

            // ADMIN MASUK DASHBOARD
            return redirect('/dashboard');
        }

        return back()->with('error', 'Password admin salah!');

    })->name('admin.verifikasi.post');
});

/*
|--------------------------------------------------------------------------
| ================= ADMIN ONLY =================
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    Route::post('/dashboard/hapus-periode', [DashboardController::class, 'hapusPeriode'])
        ->name('dashboard.hapusPeriode');
    // ADMIN BOLEH PAKAI KASIR
    Route::get('/kasir', [KasirController::class, 'index']);
    Route::post('/kasir/simpan', [KasirController::class, 'simpan']);
    Route::get('/kasir/struk/{id}', [KasirController::class, 'cetakStruk']);

    Route::resource('pelanggan', PelangganController::class);
    Route::resource('produk', ProdukController::class);

    Route::resource('laporan', LaporanController::class)
        ->only(['index', 'destroy']);

    
});


/*
|--------------------------------------------------------------------------
| ================= KASIR ONLY =================
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'kasir'])->group(function () {

    Route::get('/kasir', [KasirController::class, 'index'])
        ->name('kasir.index');

    Route::post('/kasir/simpan', [KasirController::class, 'simpan'])
        ->name('kasir.simpan');

    Route::get('/kasir/struk/{id}', [KasirController::class, 'cetakStruk'])
        ->name('kasir.struk');

    Route::post('/penjualan', [PenjualanController::class, 'store'])
        ->name('penjualan.store');

    Route::resource('pelanggan', PelangganController::class);

   
});
