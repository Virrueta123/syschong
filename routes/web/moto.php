<?php

use Illuminate\Support\Facades\Route;

Route::post('/search_moto_modelo', [App\Http\Controllers\moto_controller::class, 'search_moto_modelo'])->name('search_moto_modelo');
Route::post('/moto_search', [App\Http\Controllers\moto_controller::class, 'moto_search'])->name('moto_search');
Route::post('/get_moto', [App\Http\Controllers\moto_controller::class, 'get_moto'])->name('get_moto');

Route::post('/store_moto_vue', [App\Http\Controllers\moto_controller::class, 'store_moto_vue'])->name('store_moto_vue');