<?php

use Illuminate\Support\Facades\Route;

Route::get('/ventas_pdf/{id}', [App\Http\Controllers\ventas_controller::class, 'ventas_pdf'])->name('ventas_pdf');
Route::get('/notas_venta', [App\Http\Controllers\ventas_controller::class, 'notas_venta'])->name('ventas.notas_venta');

Route::get('/motivo_de_baja/{id}', [App\Http\Controllers\ventas_controller::class, 'motivo_de_baja'])->name('motivo_de_baja.notas_venta');


Route::delete('/ventas_baja/{id}', [App\Http\Controllers\ventas_controller::class, 'ventas_baja'])->name('ventas.baja');
