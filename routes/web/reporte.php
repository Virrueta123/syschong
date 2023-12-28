<?php

use Illuminate\Support\Facades\Route;

Route::post('/load_numero_comprobante', [App\Http\Controllers\reporte_controller::class, 'load_numero_comprobante'])->name('load_numero_comprobante'); 
 