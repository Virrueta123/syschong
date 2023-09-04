<?php

use Illuminate\Support\Facades\Route;

Route::post('/crear_producto', [App\Http\Controllers\producto_controller::class, 'store'])->name('crear_producto.vue'); 

Route::post('/editar_producto/{id}', [App\Http\Controllers\producto_controller::class, 'editar_producto'])->name('editar_producto.vue'); 

Route::get('/producto/importar', [App\Http\Controllers\producto_controller::class, 'importar'])->name('producto.importar'); 

Route::post('/importar_productos', [App\Http\Controllers\producto_controller::class, 'importar_productos'])->name('producto.importar_productos'); 


Route::post('/search_repuesto', [App\Http\Controllers\producto_controller::class, 'search_repuesto'])->name('producto.search_repuesto'); 
