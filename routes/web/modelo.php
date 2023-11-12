<?php

use Illuminate\Support\Facades\Route;

Route::post('/search_modelo', [App\Http\Controllers\modelo_controller::class, 'search_modelo'])->name('modelo.search_modelo'); 

Route::post('/get_modelo', [App\Http\Controllers\modelo_controller::class, 'get_modelo'])->name('get_modelo'); 