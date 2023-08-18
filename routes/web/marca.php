<?php

use Illuminate\Support\Facades\Route;

Route::post('/marca_search', [App\Http\Controllers\marca_controller::class, 'marca_search'])->name('marca.search');
Route::post('/store_vue_marca', [App\Http\Controllers\marca_controller::class, 'marca_store_vue'])->name('marca.store_vue');