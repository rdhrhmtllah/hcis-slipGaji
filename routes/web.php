<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


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
    return view('welcome');
});

Route::get('/set/{id}', function ($id){
    $token = $id;
    $data = DB::table('N_HRIS_User_Session as a')
            ->join('N_HRIS_USER as b', 'a.No_HP','=','b.No_HP')
            ->where("a.token",$token)->first();
    dd($data);
    return view('resetPass', ['token' => $token]);
});

Route::post('/post-password', function(Request $request){
    dd($request->all());
    return back()->with('sukses', 'Sukses menyimpan password');
})->name('password.update');


Route::get('/test-db', function () {
try {
    // Coba paksa koneksi ke database default
    DB::connection()->getPdo();

    // Jika baris di atas tidak error, koneksi berhasil
    return '<h1 style="color:green;">✅ SUKSES! Koneksi ke database berjalan dengan baik.</h1>';

} catch (\Exception $e) {
    // Jika ada error saat koneksi, tampilkan pesannya
    return '<h1 style="color:red;">❌ GAGAL! Tidak bisa terhubung ke database.</h1><p>Error: ' . $e->getMessage() . '</p>';
}
});
