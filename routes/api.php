<?php

use App\Http\Controllers\AprobacionComercialController;
use Illuminate\Support\Facades\Route;

Route::prefix('fe')->group(function () {
    Route::post('/recepcion/api/ecf', [AprobacionComercialController::class, 'recepcion']);
    Route::post('/aprobacioncomercial/api/ecf', [AprobacionComercialController::class, 'aprobacion']);
});