<?php

use Illuminate\Support\Facades\Route; 
Route::get('/forma_pago/{id}/estado', [App\Http\Controllers\forma_pago_controller::class, 'estado'])->name('forma_pago.estado'); 