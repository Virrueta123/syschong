<?php

use Illuminate\Support\Facades\Route;

Route::post('/ubigeo_search', [App\Http\Controllers\servicesController::class, 'ubigeo_search'])->name('ubigeo_search.vue'); 

 