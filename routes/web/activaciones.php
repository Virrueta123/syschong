<?php

use Illuminate\Support\Facades\Route;
 
Route::get('/activaciones/importar', [App\Http\Controllers\activaciones_controller::class, 'importar'])->name('activaciones.importar'); 

Route::get('/activaciones/{id}/cortesia', [App\Http\Controllers\activaciones_controller::class, 'cortesia'])->name('activaciones.cortesia'); 

Route::post('/activaciones/{id}/cortesia', [App\Http\Controllers\activaciones_controller::class, 'cortesia_store'])->name('activaciones.cortesia_store'); 

Route::post('/actualizar_otros', [App\Http\Controllers\activaciones_controller::class, 'actualizar_otros'])->name('actualizar_otros'); 

Route::post('/importar_activaciones', [App\Http\Controllers\activaciones_controller::class, 'importar_activaciones'])->name('activaciones.importar_activaciones'); 

 Route::post('/create_vue_cortesia', [App\Http\Controllers\activaciones_controller::class, 'create_vue_cortesia'])->name('create_vue_cortesia'); 

 Route::delete('/cortesia/{id}', [App\Http\Controllers\activaciones_controller::class, 'cortesia_destroy'])->name('cortesia.delete'); 

