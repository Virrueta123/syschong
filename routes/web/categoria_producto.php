<?php

use Illuminate\Support\Facades\Route;

Route::post('/search_categoria_producto', [App\Http\Controllers\categoria_producto_controller::class, 'search'])->name('categoria_producto.search');
Route::post('/store_vue_categoria_producto', [App\Http\Controllers\categoria_producto_controller::class, 'store_vue'])->name('categoria_producto.store_vue');

Route::get('/categoria/{id}/estado', [App\Http\Controllers\categoria_producto_controller::class, 'estado'])->name('categorias.estado'); 