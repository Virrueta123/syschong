<?php

use Illuminate\Support\Facades\Route;

Route::post('/reporte_ventas', [App\Http\Controllers\reportes_vue_controller::class, 'reporte_ventas'])->name('reporte_ventas'); 
 