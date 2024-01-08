<?php

use Illuminate\Support\Facades\Route;

Route::get('/cotizacion', [App\Http\Controllers\cotizacion_controller::class, 'index'])->name('cotizacion.index'); 

Route::get('/cotizacion/{inventario_moto_id}', [App\Http\Controllers\cotizacion_controller::class, 'create'])->name('cotizacion.create'); 

Route::get('/cotizacion/{cotizacion}/pdf', [App\Http\Controllers\cotizacion_controller::class, 'pdf'])->name('cotizacion.pdf'); 

Route::get('/cotizacion/{cotizacion}/cliente', [App\Http\Controllers\cotizacion_controller::class, 'cotizacion_show_cliente'])->name('cotizacion.cliente');
Route::get('/venta/{venta}/cliente', [App\Http\Controllers\cotizacion_controller::class, 'venta_show_cliente'])->name('venta.cliente');  
 
Route::post('/cotizacion', [App\Http\Controllers\cotizacion_controller::class, 'store'])->name('cotizacion.store'); 

Route::post('/cotizacion_enviada', [App\Http\Controllers\cotizacion_controller::class, 'cotizacion_enviada'])->name('cotizacion_enviada');

Route::post('/cotizacion_en_proceso', [App\Http\Controllers\cotizacion_controller::class, 'cotizacion_en_proceso'])->name('cotizacion_en_proceso');

Route::post('/pendiente_aprobacion', [App\Http\Controllers\cotizacion_controller::class, 'pendiente_aprobacion'])->name('pendiente_aprobacion');

Route::post('/avisado', [App\Http\Controllers\cotizacion_controller::class, 'avisado'])->name('avisado');

Route::post('/cerrado', [App\Http\Controllers\cotizacion_controller::class, 'cerrado'])->name('cerrado');

Route::post('/add_cotizacion_image', [App\Http\Controllers\cotizacion_controller::class, 'add_cotizacion_image'])->name('add_cotizacion_image');

Route::post('/edit_cotizacion_image', [App\Http\Controllers\cotizacion_controller::class, 'edit_cotizacion_image'])->name('edit_cotizacion_image');

Route::post('/cotizacion_enviada_whatsapp', [App\Http\Controllers\cotizacion_controller::class, 'cotizacion_enviada_whatsapp'])->name('cotizacion_enviada_whatsapp');  

Route::post('/cotizacion_aprobada', [App\Http\Controllers\cotizacion_controller::class, 'cotizacion_aprobada'])->name('cotizacion_aprobada'); 

Route::get('/cotizacion_table_vue/{progreso}', [App\Http\Controllers\cotizacion_controller::class, 'cotizacion_table_vue'])->name('cotizacion_table_vue'); 

Route::post('/moto_aprobada', [App\Http\Controllers\cotizacion_controller::class, 'moto_aprobada'])->name('moto_aprobada'); 

Route::post('/badge_cotizacion', [App\Http\Controllers\cotizacion_controller::class, 'badge'])->name('badge'); 

Route::post('/emitir_factura_cotizacion', [App\Http\Controllers\cotizacion_controller::class, 'emitir_factura_cotizacion'])->name('emitir_factura_cotizacion'); 

Route::post('/emitir_boleta_cotizacion', [App\Http\Controllers\cotizacion_controller::class, 'emitir_boleta_cotizacion'])->name('emitir_boleta_cotizacion'); 

Route::post('/send_correo_cotizacion', [App\Http\Controllers\cotizacion_controller::class, 'send_correo_cotizacion'])->name('send_correo_cotizacion');
