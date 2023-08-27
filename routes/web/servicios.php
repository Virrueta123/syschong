<?php

use Illuminate\Support\Facades\Route;

Route::post('/crear_servicio', [App\Http\Controllers\servicios_controller::class, 'store_vue'])->name('crear_servicio.vue'); 

Route::get('/servicios/importar', [App\Http\Controllers\servicios_controller::class, 'importar'])->name('servicios.importar'); 

Route::post('/importar_servicios', [App\Http\Controllers\servicios_controller::class, 'importar_servicioss'])->name('servicios.importar_servicioss'); 

Route::post('/search_servicios', [App\Http\Controllers\servicios_controller::class, 'search_servicios'])->name('servicios.search_servicios'); 

