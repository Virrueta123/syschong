<?php

use Illuminate\Support\Facades\Route;
 
Route::get('/activaciones/importar', [App\Http\Controllers\activaciones_controller::class, 'importar'])->name('activaciones.importar'); 

Route::post('/search_activaciones', [App\Http\Controllers\activaciones_controller::class, 'search_activaciones'])->name('search_activaciones'); 

Route::get('/activaciones/{id}/cortesia', [App\Http\Controllers\activaciones_controller::class, 'cortesia'])->name('activaciones.cortesia'); 

Route::post('/activaciones/{id}/cortesia', [App\Http\Controllers\activaciones_controller::class, 'cortesia_store'])->name('activaciones.cortesia_store'); 

Route::get('/pdf_activacion/{activacion_id}', [App\Http\Controllers\activaciones_controller::class, 'pdf_activacion'])->name('pdf_activacion'); 

Route::post('/actualizar_otros', [App\Http\Controllers\activaciones_controller::class, 'actualizar_otros'])->name('actualizar_otros'); 

Route::post('/get_activacion', [App\Http\Controllers\activaciones_controller::class, 'get_activacion'])->name('get_activacion'); 

Route::post('/importar_activaciones', [App\Http\Controllers\activaciones_controller::class, 'importar_activaciones'])->name('activaciones.importar_activaciones'); 

 Route::post('/create_vue_cortesia', [App\Http\Controllers\activaciones_controller::class, 'create_vue_cortesia'])->name('create_vue_cortesia'); 

  Route::post('/create_vue_cortesia_orden', [App\Http\Controllers\activaciones_controller::class, 'create_vue_cortesia_orden'])->name('create_vue_cortesia_orden'); 

  Route::post('/create_vue_cortesia_orden_tercero', [App\Http\Controllers\activaciones_controller::class, 'create_vue_cortesia_orden_tercero'])->name('create_vue_cortesia_orden_tercero'); 

 Route::delete('/cortesia/{id}', [App\Http\Controllers\activaciones_controller::class, 'cortesia_destroy'])->name('cortesia.delete'); 

 

