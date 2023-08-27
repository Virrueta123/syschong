<?php

use Illuminate\Support\Facades\Route;

Route::post('/marca_producto_search', [App\Http\Controllers\marca_producto_controller::class, 'marca_search'])->name('marca_producto.search');
Route::post('/store_vue_marca_producto', [App\Http\Controllers\marca_producto_controller::class, 'marca_producto_store_vue'])->name('marca_producto.store_vue');