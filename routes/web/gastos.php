<?php

use Illuminate\Support\Facades\Route;

Route::post('/crear_gasto', [App\Http\Controllers\gastos_controller::class, 'crear_gasto'])->name('crear_gasto'); 
 