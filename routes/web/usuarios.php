<?php

use Illuminate\Support\Facades\Route;

Route::post('/search_mecanico', [App\Http\Controllers\user_controller::class, 'search_mecanico'])->name('search_mecanico');
