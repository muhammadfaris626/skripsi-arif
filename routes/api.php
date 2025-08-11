<?php

use App\Http\Controllers\Api\ApiDataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/get-regency/{id}', [ApiDataController::class, 'getRegency']);
Route::get('/get-district/{id}', [ApiDataController::class, 'getDistrict']);
Route::get('/get-village/{id}', [ApiDataController::class, 'getVillage']);
Route::get('/countCertificate/{username}', [ApiDataController::class, 'countCertificate']);
Route::get('/testingWA', [ApiDataController::class, 'testingWhatsapp']);
Route::post('/cek-kartu-keluarga', [ApiDataController::class, 'cekKartuKeluarga']);

