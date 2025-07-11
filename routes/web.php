<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\TokenController;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\TokenUsage;
use Illuminate\Support\Facades\Hash;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('setPass');
});

Route::post('/post-password', [TokenController::class, 'postPassword'])->name('password.update');

Route::get('/set/{token}', [TokenController::class, 'accessPasswordForm'])->name('access.token');
Route::get('/newUrl', [TokenController::class, 'newUrl'])->name('access.newUrl');


Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();

        return '<h1 style="color:green;">✅ SUKSES! Koneksi ke database berjalan dengan baik.</h1>';

    } catch (\Exception $e) {
        return '<h1 style="color:red;">❌ GAGAL! Tidak bisa terhubung ke database.</h1><p>Error: ' . $e->getMessage() . '</p>';
    }
});


Route::get('/test', [TokenController::class, 'HashPass'])->name('access.token2');


// // routes/web.php
// Route::get('/debug-password-reset', function() {
//     // Simulasikan session yang diperlukan
//     session(['temp_nohp' => '6285269805413', 'temp_nik' => '1111111111111111']);
//     return view('setPass', [
//         'datanik' => '1111111111111111',
//         'message' => 'Debug Mode'
//     ]);
// });

// Route::post('/debug-submit-password', [TokenController::class, 'postPassword']);
