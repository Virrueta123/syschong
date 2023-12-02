<?php

use Illuminate\Support\Facades\Route;
 
Route::put('/caja_chica/{id}/cerrar', [App\Http\Controllers\caja_chica_controller::class, 'cerrar'])->name('caja.cerrar'); 

Route::get('/caja_chica/{id}/reporte', [App\Http\Controllers\caja_chica_controller::class, 'reporte'])->name('caja.reporte'); 


 

 