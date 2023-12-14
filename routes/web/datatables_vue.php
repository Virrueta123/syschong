<?php

use Illuminate\Support\Facades\Route;
  
Route::get('/tablas_activaciones_anterior_por_tienda/{id}', [App\Http\Controllers\datatables_controller::class, 'tablas_activaciones_anterior_por_tienda'])->name('tablas_activaciones_anterior_por_tienda');

Route::get('/data_ventas/{id}', [App\Http\Controllers\datatables_controller::class, 'data_ventas'])->name('data_ventas');

Route::get('/servicios_seleccionados_table', [App\Http\Controllers\datatables_controller::class, 'servicios_seleccionados_table'])->name('servicios_seleccionados_table');

Route::get('/data_compras/{id}', [App\Http\Controllers\datatables_controller::class, 'data_compras'])->name('data_compras');

Route::get('/tablas_cortesias_actual_por_tienda/{id}', [App\Http\Controllers\datatables_controller::class, 'tablas_cortesias_actual_por_tienda'])->name('tablas_cortesias_actual_por_tienda');

Route::get('/tablas_activaciones_actual_por_tienda/{id}', [App\Http\Controllers\datatables_controller::class, 'tablas_activaciones_actual_por_tienda'])->name('tablas_activaciones_actual_por_tienda');


Route::get('/factura_tienda_table/{id}', [App\Http\Controllers\datatables_controller::class, 'factura_tienda_table'])->name('factura_tienda_table');