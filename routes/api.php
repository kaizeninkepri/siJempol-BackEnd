<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\izinControl;
use App\Http\Controllers\menuControl;
use App\Http\Controllers\opdControl;
use App\Http\Controllers\pdfControl;
use App\Http\Controllers\pendaftaranControl;
use App\Http\Controllers\permohonanControl;
use App\Http\Controllers\permohonanPersyaratanControl;
use App\Http\Controllers\perusahaanControl;
use App\Http\Controllers\skControl;
use App\Http\Controllers\suratpermintaan;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class,'register']);
Route::post('/login',  [AuthController::class,'login']);

Route::post('/user',  [AuthController::class, 'index']);
Route::get('/menu',  [menuControl::class,'menu']);
Route::post('/permohonan',  [permohonanControl::class, 'index']);
Route::post('/permohonan/persyaratan',  [permohonanPersyaratanControl::class, 'index']);
Route::post('/pendaftaran',  [pendaftaranControl::class, 'index']);
Route::post('/perusahaan',  [perusahaanControl::class, 'index']);
Route::post('/izin',  [izinControl::class, 'index']);
Route::post('/opd',  [opdControl::class, 'index']);
Route::get('/pdf',  [pdfControl::class, 'index']);
Route::get('/pdf/persyaratan',  [pdfControl::class, 'persyaratan']);
Route::post('/suratpermintaan',  [suratpermintaan::class, 'index']);
Route::post('/sk',  [skControl::class, 'index']);

Route::get('/izin',  [izinControl::class, 'index']);



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
