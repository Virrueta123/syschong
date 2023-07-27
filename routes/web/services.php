<?php

use Illuminate\Support\Facades\Route;

Route::post('/consulta_dni_api', [App\Http\Controllers\servicesController::class, 'consulta_dni_api'])->name('consulta_dni_api');
Route::post('/consulta_ruc_api', [App\Http\Controllers\servicesController::class, 'consulta_ruc_api'])->name('consulta_ruc_api');
