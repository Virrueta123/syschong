<?php

use Illuminate\Support\Facades\Route;

Route::post('/taller_data', [App\Http\Controllers\taller_controller::class, 'taller_data'])->name('taller_data');  




