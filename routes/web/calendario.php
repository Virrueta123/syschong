<?php

use Illuminate\Support\Facades\Route;

Route::post('/calendario_cortesisas', [App\Http\Controllers\calendario_controller::class, 'calendario_cortesisas'])->name('calendario_cortesisas'); 
 