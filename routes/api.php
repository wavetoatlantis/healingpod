<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get("/cek-perangkat/{sn_perangkat}", [\App\Http\Controllers\APIController::class, "cekPerangkat"]);
Route::get("/daftar-pasien-terapi/{sn_perangkat}", [\App\Http\Controllers\APIController::class, "daftarPasien"]);
Route::get("/set-history-terapi/{sn_perangkat}/{id_pasien}/{kode_game}/{point}/{waktu}/{jarak}", [\App\Http\Controllers\APIController::class, "setHistoryTerapi"]);
Route::get("/stop-terapi/{sn_perangkat}/{id_pasien}/{kode_game}", [\App\Http\Controllers\APIController::class, "stopTerapi"]);
