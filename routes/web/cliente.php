<?php

use Illuminate\Support\Facades\Route;

Route::post('/cliente_search', [App\Http\Controllers\clienteController::class, 'cliente_search'])->name('cliente_search');
Route::post('/store_vue_cliente', [App\Http\Controllers\clienteController::class, 'store_vue'])->name('store_vue');
Route::post('/editar_ruc', [App\Http\Controllers\clienteController::class, 'editar_ruc'])->name('editar_ruc');
