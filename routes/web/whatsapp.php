<?php

use Illuminate\Support\Facades\Route;

Route::post('/webhook', [App\Http\Controllers\whatsapp_api::class, 'handle'])->name('webhook');
 