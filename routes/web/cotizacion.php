<?php

use Illuminate\Support\Facades\Route;

Route::get('/cotizacion', [App\Http\Controllers\cotizacion_controller::class, 'index'])->name('cotizacion.index'); 
Route::get('/cotizacion/{inventario_moto_id}', [App\Http\Controllers\cotizacion_controller::class, 'create'])->name('cotizacion.create'); 

Route::get('/cotizacion/{cotizacion}/pdf', [App\Http\Controllers\cotizacion_controller::class, 'pdf'])->name('cotizacion.pdf'); 

Route::post('/cotizacion', [App\Http\Controllers\cotizacion_controller::class, 'store'])->name('cotizacion.store'); 

