<?php

use Illuminate\Support\Facades\Route;

Route::get('/cotizacion', [App\Http\Controllers\cotizacion_controller::class, 'index'])->name('cotizacion.index'); 

Route::get('/cotizacion/{inventario_moto_id}', [App\Http\Controllers\cotizacion_controller::class, 'create'])->name('cotizacion.create'); 

Route::get('/cotizacion/{cotizacion}/pdf', [App\Http\Controllers\cotizacion_controller::class, 'pdf'])->name('cotizacion.pdf'); 

Route::post('/cotizacion', [App\Http\Controllers\cotizacion_controller::class, 'store'])->name('cotizacion.store'); 

Route::post('/cotizacion_enviada', [App\Http\Controllers\cotizacion_controller::class, 'cotizacion_enviada'])->name('cotizacion_enviada'); 

Route::post('/cotizacion_aprobada', [App\Http\Controllers\cotizacion_controller::class, 'cotizacion_aprobada'])->name('cotizacion_aprobada'); 

Route::get('/cotizacion_table_vue/{progreso}', [App\Http\Controllers\cotizacion_controller::class, 'cotizacion_table_vue'])->name('cotizacion_table_vue'); 

Route::post('/moto_aprobada', [App\Http\Controllers\cotizacion_controller::class, 'moto_aprobada'])->name('moto_aprobada'); 

Route::post('/badge_cotizacion', [App\Http\Controllers\cotizacion_controller::class, 'badge'])->name('badge'); 