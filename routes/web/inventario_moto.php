<?php

use Illuminate\Support\Facades\Route;

Route::get('/imprimir_inventario_moto/{id}', [App\Http\Controllers\inventario_moto_controller::class, 'imprimir_inventario_moto'])->name('imprimir_inventario_moto'); 
 