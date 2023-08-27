<?php

use Illuminate\Support\Facades\Route;

Route::post('/search_zona', [App\Http\Controllers\zona_controller::class, 'search'])->name('zona.search');
Route::post('/store_vue_zona', [App\Http\Controllers\zona_controller::class, 'store_vue'])->name('zona.store_vue');