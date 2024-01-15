<?php

use Illuminate\Support\Facades\Route;

Route::post('/load_numero_comprobante', [App\Http\Controllers\reporte_controller::class, 'load_numero_comprobante'])->name('load_numero_comprobante'); 


Route::get('/reportes', [App\Http\Controllers\reporte_controller::class, 'reportes'])->name('reportes.index'); 
Route::get('/reportes_documentos', [App\Http\Controllers\reporte_controller::class, 'documentos'])->name('reportes.documentos'); 
Route::get('/reportes_clientes', [App\Http\Controllers\reporte_controller::class, 'clientes'])->name('reportes.clientes'); 
Route::get('/reportes_producto_busqueda', [App\Http\Controllers\reporte_controller::class, 'producto_busqueda'])->name('reportes.producto_busqueda'); 
Route::get('/reportes_productos', [App\Http\Controllers\reporte_controller::class, 'productos'])->name('reportes.productos'); 
Route::get('/reportes_notas_venta', [App\Http\Controllers\reporte_controller::class, 'notas_venta'])->name('reportes.notas_venta'); 
  

Route::post('/descarga_pdf_reporte_documento', [App\Http\Controllers\reporte_controller::class, 'descarga_pdf_reporte_documento'])->name('descarga_pdf_reporte_documento');  
 Route::post('/send_correo_documento', [App\Http\Controllers\reporte_controller::class, 'send_correo_documento'])->name('send_correo_documento');  


Route::post('/load_data_dashboard', [App\Http\Controllers\reporte_controller::class, 'load_data_dashboard'])->name('load_data_dashboard'); 
 Route::post('/load_data_documento', [App\Http\Controllers\reporte_controller::class, 'load_data_documento'])->name('load_data_documento'); 
 