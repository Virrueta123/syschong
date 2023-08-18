<?php

use Illuminate\Support\Facades\Route;

Route::post('/moto_search', [App\Http\Controllers\moto_controller::class, 'moto_search'])->name('moto_search');
Route::post('/get_moto', [App\Http\Controllers\moto_controller::class, 'get_moto'])->name('get_moto');