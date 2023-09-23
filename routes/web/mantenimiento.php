<?php

use Illuminate\Support\Facades\Route;

Route::post('/create_vue_mantenimiento', [App\Http\Controllers\mantenimiento_controller::class, 'create_vue_mantenimiento'])->name('create_vue_mantenimiento');
 
Route::get('/mantenimiento/{id}/view', [App\Http\Controllers\mantenimiento_controller::class, 'view_mantenimiento'])->name('view_mantenimiento');
