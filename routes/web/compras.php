<?php

use Illuminate\Support\Facades\Route;

Route::post('/emitir_compra', [App\Http\Controllers\compras_controller::class, 'store'])->name('emitir_compra'); 
