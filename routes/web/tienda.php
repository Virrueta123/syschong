<?php

use Illuminate\Support\Facades\Route;

Route::post('/search_tienda', [App\Http\Controllers\tiendas_controller::class, 'search_tienda'])->name('tienda.search_tienda'); 

Route::get('/factura_tienda/{id}', [App\Http\Controllers\tiendas_controller::class, 'factura'])->name('tienda.factura'); 

Route::post('/emitir_factura_tienda', [App\Http\Controllers\tiendas_controller::class, 'emitir_factura_tienda'])->name('emitir_factura_tienda'); 