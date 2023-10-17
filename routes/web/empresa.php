<?php

use Illuminate\Support\Facades\Route;
 

Route::get('/empresa', [App\Http\Controllers\empresa_controller::class, 'edit'])->name('empresa.edit'); 
Route::put('empresa/{empresa}', [App\Http\Controllers\empresa_controller::class, 'update'])->name('empresa.update');