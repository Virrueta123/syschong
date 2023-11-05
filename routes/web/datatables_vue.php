<?php

use Illuminate\Support\Facades\Route;
  
Route::get('/tablas_activaciones_anterior_por_tienda/{id}', [App\Http\Controllers\datatables_controller::class, 'tablas_activaciones_anterior_por_tienda'])->name('tablas_activaciones_anterior_por_tienda');

Route::get('/tablas_activaciones_actual_por_tienda/{id}', [App\Http\Controllers\datatables_controller::class, 'tablas_activaciones_actual_por_tienda'])->name('tablas_activaciones_actual_por_tienda');

Route::get('/data_ventas/{id}', [App\Http\Controllers\datatables_controller::class, 'data_ventas'])->name('data_ventas');
Route::get('/data_compras/{id}', [App\Http\Controllers\datatables_controller::class, 'data_compras'])->name('data_compras');

Route::get('/tablas_cortesias_actual_por_tienda/{id}', [App\Http\Controllers\datatables_controller::class, 'tablas_cortesias_actual_por_tienda'])->name('tablas_cortesias_actual_por_tienda');
