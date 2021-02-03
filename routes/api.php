<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\menuControl;
use App\Http\Controllers\pdfControl;
use App\Http\Controllers\pendaftaranControl;
use App\Http\Controllers\permohonanControl;

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

Route::get('/menu',  [menuControl::class,'menu']);
Route::post('/permohonan',  [permohonanControl::class,'permohonanTable']);
Route::post('/permohonan',  [permohonanControl::class,'permohonanTable']);
Route::post('/pendaftaran   ',  [pendaftaranControl::class,'index']);
Route::post('/user   ',  [AuthController::class, 'index']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
