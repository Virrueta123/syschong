<?php

use Illuminate\Support\Facades\Route;

Route::post('/crear_producto', [App\Http\Controllers\producto_controller::class, 'store'])->name('crear_producto.vue'); 

Route::post('/editar_producto/{id}', [App\Http\Controllers\producto_controller::class, 'editar_producto'])->name('editar_producto.vue'); 

Route::get('/producto/importar', [App\Http\Controllers\producto_controller::class, 'importar'])->name('producto.importar'); 

Route::post('/importar_productos', [App\Http\Controllers\producto_controller::class, 'importar_productos'])->name('producto.importar_productos'); 


Route::get('/datatables_productos', [App\Http\Controllers\producto_controller::class, 'datatables_vue'])->name('producto.datatables_vue');


Route::post('/search_repuesto', [App\Http\Controllers\producto_controller::class, 'search_repuesto'])->name('producto.search_repuesto'); 

/* ******** busqueda de repuestos para la compra de productos ************* */
Route::post('/search_repuesto_compra', [App\Http\Controllers\producto_controller::class, 'search_repuesto_compra'])->name('producto.search_repuesto_compra'); 
/* *********************** */


Route::get('/search_repuesto_datatable', [App\Http\Controllers\producto_controller::class, 'search_repuesto_datatable'])->name('producto.search_repuesto_datatable'); 

Route::get('/search_aceites', [App\Http\Controllers\producto_controller::class, 'search_aceites'])->name('producto.search_aceites'); 
  
Route::post('/get_producto', [App\Http\Controllers\producto_controller::class, 'get_producto'])->name('producto.get_producto'); 

Route::post('seleccionar_aceites', [App\Http\Controllers\producto_controller::class, 'seleccionar_aceites'])->name('seleccionar_aceites'); 


Route::get('/productos_seleccionados', [App\Http\Controllers\producto_controller::class, 'productos_seleccionados'])->name('productos.productos_seleccionados'); 

Route::post('/productos_defecto', [App\Http\Controllers\producto_controller::class, 'productos_defecto'])->name('productos.productos_defecto'); 