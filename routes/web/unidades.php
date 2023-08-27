<?php

use Illuminate\Support\Facades\Route;

Route::post('/search_unidades', [App\Http\Controllers\unidades_controller::class, 'search'])->name('unidades.search');
Route::post('/store_vue_unidades', [App\Http\Controllers\unidades_controller::class, 'store_vue'])->name('unidades.store_vue');