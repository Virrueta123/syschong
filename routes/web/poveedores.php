<?php

use Illuminate\Support\Facades\Route;
 

Route::get('/proveedores/importar', [App\Http\Controllers\proveedores_controller::class, 'importar'])->name('proveedores.importar'); 

Route::post('/importar_proveedores', [App\Http\Controllers\proveedores_controller::class, 'importar_proveedores'])->name('proveedores.importar_store'); 
 
Route::get('/proveedores/{id}/estado', [App\Http\Controllers\proveedores_controller::class, 'estado'])->name('proveedores.estado'); 

Route::post('proveedor_search', [App\Http\Controllers\proveedores_controller::class, 'proveedor_search'])->name('proveedor_search'); 

