<?php

use Illuminate\Support\Facades\Route;

Route::get('/ventas_pdf/{id}', [App\Http\Controllers\ventas_controller::class, 'ventas_pdf'])->name('ventas_pdf');
 