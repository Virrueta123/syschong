<?php

use Illuminate\Support\Facades\Route;

Route::post('/cliente_search', [App\Http\Controllers\clienteController::class, 'cliente_search'])->name('cliente_search');
Route::post('/cliente_search_pos', [App\Http\Controllers\clienteController::class, 'cliente_search_pos'])->name('cliente_search_pos');
Route::post('/store_vue_cliente', [App\Http\Controllers\clienteController::class, 'store_vue'])->name('store_vue');
Route::post('/update_vue_cliente', [App\Http\Controllers\clienteController::class, 'update_vue_cliente'])->name('update_vue_cliente');

Route::post('/update_vue_cli', [App\Http\Controllers\clienteController::class, 'update_vue_cli'])->name('update_vue_cli');

Route::post('/store_vue_cliente_ruc', [App\Http\Controllers\clienteController::class, 'store_vue_cliente_ruc'])->name('store_vue_cliente_ruc');
Route::post('/editar_ruc', [App\Http\Controllers\clienteController::class, 'editar_ruc'])->name('editar_ruc');
Route::post('/editar_celular', [App\Http\Controllers\clienteController::class, 'editar_celular'])->name('editar_celular');
 