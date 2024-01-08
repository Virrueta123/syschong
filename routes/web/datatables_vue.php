<?php

use Illuminate\Support\Facades\Route;
  
Route::get('/tablas_activaciones_anterior_por_tienda/{id}', [App\Http\Controllers\datatables_controller::class, 'tablas_activaciones_anterior_por_tienda'])->name('tablas_activaciones_anterior_por_tienda');

Route::get('/data_ventas/{id}', [App\Http\Controllers\datatables_controller::class, 'data_ventas'])->name('data_ventas');

Route::get('/servicios_seleccionados_table', [App\Http\Controllers\datatables_controller::class, 'servicios_seleccionados_table'])->name('servicios_seleccionados_table');

Route::get('/productos_seleccionados_table', [App\Http\Controllers\datatables_controller::class, 'productos_seleccionados_table'])->name('productos_seleccionados_table');

Route::get('/data_compras/{id}', [App\Http\Controllers\datatables_controller::class, 'data_compras'])->name('data_compras');

Route::get('/tablas_cortesias_actual_por_tienda/{id}', [App\Http\Controllers\datatables_controller::class, 'tablas_cortesias_actual_por_tienda'])->name('tablas_cortesias_actual_por_tienda');

Route::get('/tablas_activaciones_actual_por_tienda/{id}', [App\Http\Controllers\datatables_controller::class, 'tablas_activaciones_actual_por_tienda'])->name('tablas_activaciones_actual_por_tienda');

Route::post('/tablas_activaciones_actual_por_tienda_by_factura', [App\Http\Controllers\datatables_controller::class, 'tablas_activaciones_actual_por_tienda_by_factura'])->name('tablas_activaciones_actual_por_tienda_by_factura');

Route::post('/tablas_cortesias_actual_por_tienda_by_factura', [App\Http\Controllers\datatables_controller::class, 'tablas_cortesias_actual_por_tienda_by_factura'])->name('tablas_cortesias_actual_por_tienda_by_factura');

Route::get('/factura_tienda_table/{id}', [App\Http\Controllers\datatables_controller::class, 'factura_tienda_table'])->name('factura_tienda_table');

/* ******** datatable para activacion y cortesias para avisar ************* */
Route::get('/tablas_activaciones_de_hoy', [App\Http\Controllers\datatables_controller::class, 'tablas_activaciones_de_hoy'])->name('tablas_activaciones_de_hoy');

Route::get('/tablas_activaciones_pendiente', [App\Http\Controllers\datatables_controller::class, 'tablas_activaciones_pendiente'])->name('tablas_activaciones_pendiente');

Route::get('/tablas_cortesias_de_hoy', [App\Http\Controllers\datatables_controller::class, 'tablas_cortesias_de_hoy'])->name('tablas_cortesias_de_hoy');

Route::get('/tablas_cortesias_pendiente', [App\Http\Controllers\datatables_controller::class, 'tablas_cortesias_pendiente'])->name('tablas_cortesias_pendiente');

Route::get('/tablas_ventas', [App\Http\Controllers\datatables_controller::class, 'tablas_ventas'])->name('tablas_ventas');

Route::get('/spanish_datatable', [App\Http\Controllers\datatables_controller::class, 'spanish_datatable'])->name('spanish_datatable');

/* *********************** */

/* ******** tabla cotizacion para compras ************* */

Route::post('/cotizacion_by_compra', [App\Http\Controllers\datatables_controller::class, 'cotizacion_by_compra'])->name('cotizacion_by_compra');


/* *********************** */