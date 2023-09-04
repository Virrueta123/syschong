<?php

use Illuminate\Support\Facades\Route;

Route::post('/search_modelo', [App\Http\Controllers\modelo_controller::class, 'search_modelo'])->name('modelo.search_modelo'); 