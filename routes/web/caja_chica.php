<?php

use Illuminate\Support\Facades\Route;
 
Route::put('/caja_chica/{id}/cerrar', [App\Http\Controllers\caja_chica_controller::class, 'cerrar'])->name('caja.cerrar'); 

 

 