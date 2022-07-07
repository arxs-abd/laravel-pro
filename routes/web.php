<?php

use App\Http\Controllers\DaerahController;
use App\Http\Controllers\DapilController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [HomeController::class, 'index']);
Route::post('/dapil', [HomeController::class, 'dapil']);
Route::get('/testing', [HomeController::class, 'testing']);

// Search
Route::post('/api/search', [HomeController::class, 'search']);

// Api Dapil
Route::get('/api/dapil-pdpr', [DapilController::class, 'pdpr']);
Route::get('/api/dapil-pdprd1/{id}', [DapilController::class, 'pdprd1']);
Route::get('/api/dapil-pdprd2/{id}', [DapilController::class, 'pdprd2']);

// Api Daerah
Route::get('/api/provinsi', [DaerahController::class, 'provinsi']);
Route::get('/api/kabupaten-kota', [DaerahController::class, 'kabupaten_kota']);
// Route::get('/api_v2/kabupaten-kota', [DaerahController::class, 'kabupaten_kota_v2']);
Route::get('/api/kecamatan', [DaerahController::class, 'kecamatan']);
Route::get('/api/kelurahan-desa', [DaerahController::class, 'kelurahan_desa']);
